<?php
// This file was copied (then modified) from https://github.com/mautic/docker-mautic
/*
 * This file will read from the container_environment variables (https://github.com/phusion/baseimage-docker#environment_variables)
 *  and any env variable that starts with mautic_ (nOT CasE SenSiTIve) it will add a `getenv('envVarNam')` to
 *  parameters_local.php.  This will override anything in the local.php and keep your sensitive data out of the local.php file
 *
 */


$stderr = fopen('php://stderr', 'w');

fwrite($stderr, "\nWriting Mautic config\n");

// Get all environment variables
$envVars = json_decode(file_get_contents('/etc/container_environment.json'));

// Set some initial defaults
$parameters = array(
    'db_port' => 3306,
    'install_source' => 'Docker'
);

foreach ($envVars as $key => $value){
    // if it starts with mautic_ (not case sensitive), add it to the parameters
    if(startsWith(strtolower($key), 'mautic_')){
        // write getenv('keyname') in the config, don't write put the actual value b/c I don't want to
        //     store sensitive data inside the container.
        $parameters[str_replace('mautic_', '', strtolower($key))] = "getenv('$key')";
    }
}

$path     = '/app/app/config/parameters_local.php';
$rendered = render($parameters);

$status = file_put_contents($path, $rendered);

if ($status === false) {
    fwrite($stderr, "\nCould not write configuration file to $path, you can create this file with the following contents:\n\n$rendered\n");
}

/**
 * Renders parameters as a string.
 *
 * @param array $parameters
 *
 * @return string
 */
function render(array $parameters)
{
    $string = "<?php\n";
    $string .= "\$parameters = array(\n";

    foreach ($parameters as $key => $value)
    {
        if ($value !== '')
        {
            if (is_string($value))
            {
                if(startsWith($value, 'getenv(')){
                    $value = "$value";
                }else {
                    $value = "'" . addslashes($value) . "'";
                }
            }
            elseif (is_bool($value))
            {
                $value = ($value) ? 'true' : 'false';
            }
            elseif (is_null($value))
            {
                $value = 'null';
            }
            elseif (is_array($value))
            {
                $value = renderArray($value);
            }

            $string .= "\t'$key' => $value,\n";
        }
    }

    $string .= ");\n";

    return $string;
}

/**
 * Renders an array of parameters as a string.
 *
 * @param array $array
 * @param bool  $addClosingComma
 *
 * @return string
 */
function renderArray(array $array, $addClosingComma = false)
{
    $string = "array(";
    $first  = true;

    foreach ($array as $key => $value)
    {
        if (!$first)
        {
            $string .= ',';
        }

        if (is_string($key))
        {
            $string .= '"' . $key . '" => ';
        }

        if (is_array($value))
        {
            $string .= $this->renderArray($value, true);
        }
        else
        {
            $string .= '"' . addslashes($value) . '"';
        }

        $first = false;
    }

    $string .= ")";

    if ($addClosingComma)
    {
        $string .= ',';
    }

    return $string;
}


function startsWith($haystack, $needle) {
    // search backwards starting from haystack length characters from the end
    return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== FALSE;
}