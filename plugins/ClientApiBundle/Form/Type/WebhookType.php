<?php
/**
 * Created by PhpStorm.
 * User: wordpress
 * Date: 9/1/15
 * Time: 11:36 AM
 */

namespace MauticAddon\ClientApiBundle\Form\Type;

use Mautic\CoreBundle\Factory\MauticFactory;
use Mautic\UserBundle\Form\DataTransformer as Transformers;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Class FilterType
 *
 * @package Mautic\LeadBundle\Form\Type
 */
class WebhookType extends AbstractType
{

    protected  $factory;

    public function __construct(MauticFactory $factory) {
        $this->factory    = $factory;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm (FormBuilderInterface $builder, array $options)
    {
        $model = $this->factory->getModel('addon.clientApi.clientApi');

        $allClientApis = $model->getEntities();

        $choices = [];
        foreach($allClientApis as $clientApi){
            $choices[$clientApi->getId()] = $clientApi->getName();
        }

        $builder->add('clientApi', 'choice', array(
            'label'      => 'addon.clientApi.clientApi.event.clientApis',
            'label_attr' => array('class' => 'control-label'),
            'attr'       => array('class' => 'form-control'),
            'choices'  => $choices
        ));

        $builder->add('apiMethod', 'text', array(
            'label'      => 'addon.clientApi.clientApi.event.apimethod',
            'label_attr' => array('class' => 'control-label'),
            'attr'       => array(
                'class'       => 'form-control',
                'placeholder' => 'addon.clientApi.clientApi.event.apimethod.placeholder'
            ),
            'constraints' => array(
                new NotBlank(
                    array('message' => 'You need to put method')
                )
            )
        ));

        $builder->add(
            $builder->create('headerParameters', 'parameters_type', array(
                'error_bubbling' => false,
                'mapped'         => true,
                'required'   => false
            ))
        );

        $builder->add("requestMethod", 'choice', array(
            'label'     => 'addon.clientApi.clientApi.event.methods',
            'label_attr' => array('class' => 'control-label'),
            'attr'       => array(
                'class'       => 'form-control'
            ),
            'choices' => ["POST" => "POST", "GET" => "GET", "PUT" => "PUT", "DELETE" => "DELETE"]
        ));


        $requestType = "form-data";
        $builder->add('requestType', 'button_group', array(
            'choices' => array(
                'form-data' => 'addon.clientApi.clientApi.event.requesttype.formdata',
                'json'      => 'addon.clientApi.clientApi.event.requesttype.json'
            ),
            'expanded'    => true,
            'multiple'    => false,
            'label_attr'  => array('class' => 'control-label'),
            'label'       => 'addon.clientApi.clientApi.event.requesttype',
            'empty_value' => false,
            'attr'        => array(
                'onchange' => 'toggleRequestType();'
            ),
            'data'        => $requestType
        ));

        $builder->add(
            $builder->create('parameters', 'parameters_type', array(
                'error_bubbling' => false,
                'mapped'         => true,
            ))
        );

        $builder->add('jsonData', 'textarea', array(
            'label'      => 'addon.clientApi.clientApi.event.requesttype.jsontype',
            'label_attr' => array('class' => 'control-label'),
            'attr'       => array('class' => 'form-control', 'rows' => 4)
        ));

    }

    /**
     * @return string
     */
    public function getName ()
    {
        return "webhook_action";
    }
}