<?php
/**
 * Created by PhpStorm.
 * User: wordpress
 * Date: 8/31/15
 * Time: 10:11 AM
 */
namespace MauticAddon\ClientApiBundle\Entity;

use Mautic\CoreBundle\Entity\CommonRepository;

class ClientApiRepository extends CommonRepository
{
    public function getEntities($args = array())
    {
        $q = $this->createQueryBuilder('w');

        $args['qb'] = $q;

        return parent::getEntities($args);
    }

    /**
     * Gets the ID of the latest ID
     */
    public function getMaxClientApiId()
    {
        $result = $this->_em->getConnection()->createQueryBuilder()
            ->select('max(id) as max_client_id')
            ->from(MAUTIC_TABLE_PREFIX.'client_apis', 'l')
            ->execute()->fetchAll();

        return $result[0]['max_client_id'];
    }
}