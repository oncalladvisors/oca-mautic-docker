<?php
/**
 * Created by PhpStorm.
 * User: wordpress
 * Date: 8/31/15
 * Time: 10:09 AM
 */

namespace MauticAddon\ClientApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Mautic\CoreBundle\Entity\CommonEntity;

/**
 * Class ClientApi
 * @ORM\Table(name="client_apis")
 * @ORM\Entity(repositoryClass="MauticAddon\ClientApiBundle\Entity\ClientApiRepository")
 */
class ClientApi extends CommonEntity
{

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="text")
     */
    private $baseUrl;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    /*private $headerParameter;*/



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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     *
     * @return ClientApi
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     *
     * @return ClientApi
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getBaseUrl()
    {
        return $this->baseUrl;
    }

    /**
     * @param mixed $url
     *
     * @return ClientApi
     */
    public function setBaseUrl($url)
    {
        $this->baseUrl = $url;

        return $this;
    }

    /**
     * @return mixed
     */
    /*public function getHeaderParameter()
    {
        return $this->headerParameter;
    }*/

    /**
     * @param mixed $headerParameter
     *
     * @return ClientApi
     */
   /* public function setHeaderParameter($headerParameter)
    {
        $this->headerParameter = $headerParameter;

        return $this;
    }*/

    public function getPrimaryIdentifier()
    {

        return $this->getName();

    }

    public function  getFields(){

        $fields = array($this->getName(), $this->getDescription(), $this->getBaseUrl()/*, $this->getHeaderParameter()*/);
        return $fields;
    }

}