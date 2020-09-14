<?php

namespace MVC\Service;

class Environment
{
    private string $environment;

    /**
     * Environment constructor.
     * @param $environment
     */
    public function __construct(string $environment = 'dev')
    {
        $this->environment = $environment;
    }

    /**
     * @return string
     */
    public function getEnvironment(): string
    {
        return $this->environment;
    }

    /**
     * @param string $environment
     */
    public function setEnvironment(string $environment): void
    {
        $this->environment = $environment;
        $this->setSession();
    }

    public function setSession(): void
    {
        $_SESSION['environment'] = $this->environment;
    }
}