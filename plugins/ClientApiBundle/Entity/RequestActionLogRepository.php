<?php
/**
 * Created by PhpStorm.
 * User: wordpress
 * Date: 9/4/15
 * Time: 2:41 PM
 */

namespace MauticAddon\ClientApiBundle\Entity;

use Mautic\CoreBundle\Entity\CommonRepository;

class RequestActionLogRepository extends CommonRepository
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
    public function getMaxRequestActionLogId()
    {
        $result = $this->_em->getConnection()->createQueryBuilder()
            ->select('max(id) as max_id')
            ->from(MAUTIC_TABLE_PREFIX.'request_action_log', 'l')
            ->execute()->fetchAll();

        return $result[0]['max_id'];
    }
}