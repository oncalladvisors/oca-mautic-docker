<?php
/**
 * Created by PhpStorm.
 * User: wordpress
 * Date: 8/31/15
 * Time: 12:57 PM
 */
?>
<?php foreach ($items as $item): ?>
    <?php /** @var \MauticAddon\ClientApiBundle\Entity\ClientApi $item */ ?>

    <tr<?php if (!empty($highlight)) echo ' class="warning"'; ?>>
        <td>
            <?php
            $hasEditAccess = true;

            echo $view->render('MauticCoreBundle:Helper:list_actions.html.php', array(
                'item'      => $item,
                'templateButtons' => array(
                    'edit'      => $hasEditAccess,
                    'delete'    => true,
                ),
                'routeBase' => 'client_api',
                'langVar'   => 'clientApi.clientApi',
            ));
            ?>
        </td>
        <td>
            <a href="<?php echo $view['router']->generate('mautic_client_api_action', array("objectAction" => "edit", "objectId" => $item->getId())); ?>" data-toggle="ajax">

                <div><?php echo $item->getPrimaryIdentifier(); ?></div>
            </a>
        </td>
        <td class="visible-md visible-lg"><?php echo $item->getDescription(); ?></td>
        <td class="visible-md visible-lg">
            <?php
                echo $item->getBaseUrl();
            ?>
            <div class="clearfix"></div>
        </td>

        <td class="visible-md visible-lg"><?php echo $item->getId(); ?></td>

    </tr>
<?php endforeach; ?>