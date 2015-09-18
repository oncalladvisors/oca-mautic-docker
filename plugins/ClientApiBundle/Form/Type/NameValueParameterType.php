<?php
/**
 * Created by PhpStorm.
 * User: wordpress
 * Date: 9/3/15
 * Time: 12:10 PM
 */

namespace MauticAddon\ClientApiBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class FilterType
 *
 * @package Mautic\LeadBundle\Form\Type
 */
class NameValueParameterType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm (FormBuilderInterface $builder, array $options)
    {

        $builder->add('paramName', 'collection', array(
            'allow_add'    => true,
            'allow_delete' => true
        ));

        $builder->add('paramValue', 'collection', array(
            'allow_add'    => true,
            'allow_delete' => true
        ));
    }

    /**
     * @return string
     */
    public function getName ()
    {
        return "parameters_type";
    }
}
