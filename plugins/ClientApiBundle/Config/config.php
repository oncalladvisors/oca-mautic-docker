<?php
/**
 * Created by PhpStorm.
 * User: wordpress
 * Date: 8/31/15
 * Time: 9:34 AM
 */
return array(
    'name'          => 'Client Api',
    'description'   => 'Build and manage multiple client Api\'s',
    'version'       => '1.0',
    'author'        => 'RT Softwaregroup',
    'routes'        => array(
        'main'    => array(
            'client_api_index'        => array(
                'path'       => '/client-apis/{page}',
                'controller' => 'ClientApiBundle:ClientApi:index'
            ),
            'client_api_action'           => array(
                'path'       => '/client-apis/{objectAction}/{objectId}',
                'controller' => 'ClientApiBundle:ClientApi:execute'
            ),
            'mautic_client_api_action'    => array(
                'path'       => '/client-apis/{objectAction}/{objectId}',
                'controller' => 'ClientApiBundle:ClientApi:execute'
            )
        )
    ),
    'services' => array(
        'forms' => array(
            'clientApi.form.type.clientapi' => array(
                'class'     => 'MauticAddon\ClientApiBundle\Form\Type\ClientApiType',
                'arguments' => 'mautic.factory',
                'alias'     => 'clientapi'
            ),
            'clientApi.form.type.webhook_action' => array(
                'class'     => 'MauticAddon\ClientApiBundle\Form\Type\WebhookType',
                'arguments' => 'mautic.factory',
                'alias'     => 'webhook_action'
            ),
            'clientApi.form.type.parameters_type' => array(
                'class'     => 'MauticAddon\ClientApiBundle\Form\Type\NameValueParameterType',
                'arguments' => 'mautic.factory',
                'alias'     => 'parameters_type'
            )
        ),

        'events' => array(
            'addon.clientApi.campaignbundle.subscriber' => array(
                'class' => 'MauticAddon\ClientApiBundle\EventListener\CampaignSubscriber'
            )
        )
    ),

    'menu'     => array(
        'main' => array(
            'priority' => 4,
            'items'    => array(
                'addon.clientApi.clientApi.menu' => array(
                    'id'        => 'addon_client_api_index',
                    'iconClass' => 'fa-globe',
                    'access'    =>  array('lead:leads:viewown', 'lead:leads:viewother'),
                    'children'  => array(
                        'addon.clientApi.clientApi.menu.manage_clientApis'     => array(
                            'route' => 'client_api_index'
                        )
                    )
                )
            )
        )
    )
);