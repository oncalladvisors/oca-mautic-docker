<?php
/**
 * Created by PhpStorm.
 * User: wordpress
 * Date: 8/31/15
 * Time: 3:23 PM
 */

$view->extend('MauticCoreBundle:Default:content.html.php');
$view['slots']->set('mauticContent', 'client api');
$view['slots']->set("headerTitle", 'Client APIs');

$buttons = $preButtons = array();
//For now
$permissions['clientApi:clientApi:create'] = true;
$permissions['clientApi:clientApi:delete'] = true;


$view['slots']->set('actions', $view->render('MauticCoreBundle:Helper:page_actions.html.php', array(
    'templateButtons' => array(
        'new' => $permissions['clientApi:clientApi:create']
    ),
    'routeBase' => 'client_api',
    'langVar'   => 'clientApi.clientApi'
)));
?>

<div class="panel panel-default bdr-t-wdh-0 mb-0">
    <?php echo $view->render('MauticCoreBundle:Helper:list_toolbar.html.php', array(
        'searchValue' => $searchValue,
        'searchHelp'  => 'mautic.lead.lead.help.searchcommands',
        'action'      => $currentRoute,
        'langVar'     => 'clientApi.clientApi',
        'routeBase'   => 'client_api',
        'preCustomButtons' => array(
            array(
                'attr'      => array(
                    'class'   => 'btn btn-default btn-sm btn-nospin',
                    'href'    => 'javascript: void(0)',
                    'onclick' => 'Mautic.toggleLiveClientApiListUpdate();',
                    'id'      => 'liveModeButton',
                    'data-toggle' => false,
                    'data-max-id' => $maxLeadId
                ),
                'tooltip' => $view['translator']->trans('mautic.integration.clientApi.clientApi.live_update'),
                'iconClass' => 'fa fa-bolt'
            )
        ),
        'templateButtons' => array(
            'delete' => true
        )
    )); ?>
    <div class="page-list">
        <?php $view['slots']->output('_content'); ?>
    </div>
</div>
