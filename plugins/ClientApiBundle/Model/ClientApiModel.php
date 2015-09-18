<?php
/**
 * Created by PhpStorm.
 * User: wordpress
 * Date: 8/31/15
 * Time: 2:20 PM
 */

namespace MauticAddon\ClientApiBundle\Model;

use Mautic\CoreBundle\Model\FormModel;
use MauticAddon\ClientApiBundle\Entity\ClientApi;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class ClientApiModel extends FormModel
{

    /**
     * @return bool|\Doctrine\ORM\EntityRepository|\Mautic\CoreBundle\Entity\CommonRepository
     */
    public function getRepository()
    {

        $repo = $this->em->getRepository('ClientApiBundle:ClientApi');

        return $repo;
    }

    /**
     * @param array $args
     * @return array|\Doctrine\ORM\Tools\Pagination\Paginator
     */
    public function getEntities(array $args = array())
    {
        //set the point trigger model in order to get the color code for the lead
        $repo = $this->getRepository();

        return parent::getEntities($args);
    }

    /**
     * @param null $id
     * @return ClientApi|null|object
     */
    public function getEntity($id = null)
    {
        if ($id === null) {
            return new ClientApi();
        }

        $repo = $this->getRepository();

        $entity = parent::getEntity($id);

        return $entity;
    }

    /**
     * @param $entity
     * @param bool $unlock
     */
    public function saveEntity($entity, $unlock = true)
    {
        $isNew = ($entity->getId()) ? false : true;
        $repo = $this->getRepository();
        $repo->saveEntity($entity);

    }

    /**
     * @param object $entity
     */
    public function deleteEntity($entity)
    {
        parent::deleteEntity($entity);
    }

    /**
     * @param $entity
     * @param $formFactory
     * @param null $action
     * @param array $options
     * @return mixed
     * @throws \Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException
     */
    public function createForm($entity, $formFactory, $action = null, $options = array())
    {
        if (!$entity instanceof ClientApi) {
            throw new MethodNotAllowedHttpException(array('ClientApi'), 'Entity must be of class ClientApi()');
        }
        $params = (!empty($action)) ? array('action' => $action) : array();
        return $formFactory->create('clientapi', $entity, $params);
    }

}