<?php
/**
 * Created by PhpStorm.
 * User: wordpress
 * Date: 8/31/15
 * Time: 5:38 PM
 */

namespace MauticAddon\ClientApiBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class LeadListType
 *
 * @package Mautic\LeadBundle\Form\Type
 */
class ClientApiType extends AbstractType
{


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text', array(
            'label'      => 'addon.clientApi.clientApi.name',
            'label_attr' => array('class' => 'control-label'),
            'attr'       => array('class' => 'form-control')
        ));

        $builder->add('description', 'textarea', array(
            'label'      => 'addon.clientApi.clientApi.description',
            'label_attr' => array('class' => 'control-label'),
            'attr'       => array('class' => 'form-control editor'),
            'required'   => false
        ));

        $builder->add('baseUrl', 'url', array(
            'label'      => 'addon.clientApi.clientApi.baseUrl',
            'label_attr' => array('class' => 'control-label'),
            'attr'       => array('class' => 'form-control')
        ));


        /*$builder->add('headerParameter', 'hidden', array(
            'attr'       => array('onload' => 'parseValue()'),
        ));*/

        $builder->add('buttons', 'form_buttons');

        if (!empty($options["action"])) {
            $builder->setAction($options["action"]);
        }

    }

    /**
     * @param \Symfony\Component\OptionsResolver\OptionsResolver|\Symfony\Component\OptionsResolver\OptionsResolverInterface $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {

        $resolver->setDefaults(array(
            'data_class' => 'MauticAddon\ClientApiBundle\Entity\ClientApi'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return "clientapi";
    }
}