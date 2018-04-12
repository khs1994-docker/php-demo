<?php

namespace Example\Support;

class Config
{
    protected $config;

    public function __construct(array $config = [])
    {
        $this->config = $config;
    }

    public function get($name)
    {
        return $this->config[$name] ?? [];
    }
}
