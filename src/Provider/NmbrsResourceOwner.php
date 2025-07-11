<?php

namespace Spits\OAuth2\Client\Provider;

use League\OAuth2\Client\Provider\ResourceOwnerInterface;
use League\OAuth2\Client\Tool\ArrayAccessorTrait;

class NmbrsResourceOwner implements ResourceOwnerInterface
{
    use ArrayAccessorTrait;

    protected $response;

    public function __construct(array $response = array())
    {
        $this->response = $response;
    }

    public function getId()
    {
        return $this->getValueByKey($this->response, 'id');
    }


    public function toArray()
    {
        return $this->response;
    }
}