<?php

namespace Application\Service;

use Zend\Crypt\Exception\NotFoundException;

class ServiceManager
{
    /** @var array */
    private $instances = [];

    /** @var array */
    private $fabrics = [];

    /** @var array */
    private $aliases = [];

    /** @var array */
    private $shared = [];

    /**
     * @param array $config
     * @return $this
     */
    public function configure(array $config): self
    {
        if(isset($config['services'])){
            foreach ($config['services'] as $service => $fabric){
                $this->fabrics[$service] = $fabric;
            }
        }
        if(isset($config['shared'])){
            foreach ($config['shared'] as $service => $isShared){
                $this->shared[$service] = $isShared;
            }
        }
        if(isset($config['aliases'])){
            foreach ($config['aliases'] as $alias => $service){
                $this->aliases[$alias] = $service;
            }
        }
        return $this;
    }

    /**
     * @param string $serviceName
     * @return mixed
     */
    public function get(string $serviceName)
    {
        $serviceName = $this->getServiceName($serviceName);
        $isShared = $this->checkIfShared($serviceName);

        if ($isShared && key_exists($serviceName, $this->instances)) {
            return $this->instances[$serviceName];
        }

        $factory = $this->fabrics[$serviceName];
        if (is_string($factory) && class_exists($factory)) {
            $factory = new $factory();
        }
        if (is_callable($factory)) {
            $service = $factory('testServiceCreate');
            $this->instances[$serviceName] = $service;
            return $service;
        }
        throw new NotFoundException('fabric is incorrect!');
    }

    /**
     * @param string $serviceName
     * @return mixed|string
     */
    private function getServiceName(string $serviceName):?string
    {
        if (isset($this->aliases[$serviceName])) {
            $serviceName = $this->aliases[$serviceName];
        }
        if (isset($this->fabrics[$serviceName])) {
            return $serviceName;
        }
        throw new NotFoundException('service not found');
    }

    /**
     * @param string $serviceName
     * @return bool
     */
    private function checkIfShared(string $serviceName): bool
    {
        $shared = true;
        if (isset($this->shared[$serviceName])) {
            $shared = $this->shared[$serviceName];
        }
        return $shared;
    }
}