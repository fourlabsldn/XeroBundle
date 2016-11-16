<?php

namespace FL\XeroBundle\XeroPHP;

use XeroPHP\Application;
use XeroPHP\Application\PartnerApplication;
use XeroPHP\Application\PrivateApplication;
use XeroPHP\Application\PublicApplication;

class ApplicationFactory
{
    const TYPE_PUBLIC = 'public';
    const TYPE_PRIVATE = 'private';
    const TYPE_PARTNER = 'partner';

    /**
     * @var string
     */
    private $type;

    /**
     * @var array
     */
    private $config;

    /**
     * @param string $type   One of "public"; "private"; "partner"
     * @param array  $config The configuration for XeroPHP
     */
    public function __construct(string $type, array $config)
    {
        $this->type = $type;
        $this->config = $config;
    }

    /**
     * @return Application
     */
    public function createApplication()
    {
        if ($this->type === static::TYPE_PUBLIC) {
            return new PublicApplication($this->config);
        }

        if ($this->type === static::TYPE_PRIVATE) {
            return new PrivateApplication($this->config);
        }

        if ($this->type === static::TYPE_PARTNER) {
            return new PartnerApplication($this->config);
        }
    }
}
