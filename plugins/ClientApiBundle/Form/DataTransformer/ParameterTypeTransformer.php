<?php
/**
 * Created by PhpStorm.
 * User: wordpress
 * Date: 9/1/15
 * Time: 3:58 PM
 */
namespace MauticAddon\ClientApiBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;

class ParameterTypeTransformer implements DataTransformerInterface
{


    public function transform($rawFilters)
    {

        if (!is_array($rawFilters)) {
            return array();
        }

        foreach ($rawFilters as $k => $f) {
            if ($f['type']  == 'datetime') {
                $dt = new DateTimeHelper($f['filter'], 'Y-m-d H:i');
                $rawFilters[$k]['filter'] = $dt->toLocalString();
            }
        }
        return $rawFilters;
    }

    public function reverseTransform($rawFilters)
    {

        if (!is_array($rawFilters)) {
            return array();
        }

        $str ="";
        foreach ($rawFilters as $k => $f) {
           $str .= $f['paramName'] . "=>" . $f['paramValue'];
        }

        return $str;
    }
}