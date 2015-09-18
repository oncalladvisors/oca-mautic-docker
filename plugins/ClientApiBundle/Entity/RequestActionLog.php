<?php
/**
 * Created by PhpStorm.
 * User: wordpress
 * Date: 9/4/15
 * Time: 2:34 PM
 */

namespace MauticAddon\ClientApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Mautic\CoreBundle\Entity\CommonEntity;

/**
 * Class RequestActionLog
 * @ORM\Table(name="request_action_log")
 * @ORM\Entity(repositoryClass="MauticAddon\ClientApiBundle\Entity\RequestActionLogRepository")
 */
class RequestActionLog extends CommonEntity
{

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $responseCode;

    /**
     * @ORM\Column(type="text")
     */
    private $responseBody;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getResponseCode()
    {
        return $this->responseCode;
    }

    /**
     * @param mixed $responseCode
     *
     * @return RequestActionLog
     */
    public function setResponseCode($responseCode)
    {
        $this->responseCode = $responseCode;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getResponseBody()
    {
        return $this->responseBody;
    }

    /**
     * @param mixed $responseBody
     *
     * @return RequestActionLog
     */
    public function setResponseBody($responseBody)
    {
        $this->responseBody = $responseBody;

        return $this;
    }
}