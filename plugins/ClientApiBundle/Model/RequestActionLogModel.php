<?php
/**
 * Created by PhpStorm.
 * User: wordpress
 * Date: 9/4/15
 * Time: 2:48 PM
 */

namespace MauticAddon\ClientApiBundle\Model;

use Mautic\CoreBundle\Model\FormModel;
use MauticAddon\ClientApiBundle\Entity\RequestActionLog;


class RequestActionLogModel extends FormModel
{

    /**
     * @return bool|\Doctrine\ORM\EntityRepository|\Mautic\CoreBundle\Entity\CommonRepository
     */
    public function getRepository()
    {

        $repo = $this->em->getRepository('ClientApiBundle:RequestActionLog');

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
     * @return RequestActionLog|null|object
     */
    public function getEntity($id = null)
    {
        if ($id === null) {
            return new RequestActionLog();
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

}