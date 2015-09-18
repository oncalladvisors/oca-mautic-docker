<?php
/**
 * Created by PhpStorm.
 * User: wordpress
 * Date: 9/2/15
 * Time: 4:11 PM
 */
namespace MauticAddon\ClientApiBundle\EventListener;

use Mautic\CoreBundle\EventListener\CommonSubscriber;
use Mautic\CampaignBundle\CampaignEvents;
use Mautic\CampaignBundle\Event\CampaignBuilderEvent;

class CampaignSubscriber extends CommonSubscriber
{
    /**
     * @return array
     */
    static public function getSubscribedEvents()
    {
        return array(
            CampaignEvents::CAMPAIGN_ON_BUILD => array('onCampaignBuild', 0)
        );
    }

    /**
     * Add event triggers and actions
     *
     * @param CampaignBuilderEvent $event
     */
    public function onCampaignBuild(CampaignBuilderEvent $event)
    {
        //Add actions
        $action = array(
            'label'       => 'addon.clientApi.clientApi.events.addwebhook',
            'description' => 'addon.clientApi.clientApi.events.addwebhookdesc',
            'formType'    => 'webhook_action',
            'formTheme'   => 'ClientApiBundle:FormTheme\ActionAddWebhook',
            'callback'    => '\MauticAddon\ClientApiBundle\Helper\CampaignEventHelper::makeRequest'
        );

        $event->addAction('clientApi.makerequest', $action);
    }
}