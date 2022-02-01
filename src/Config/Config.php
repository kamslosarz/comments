<?php

namespace App\Config;

use Symfony\Component\Dotenv\Dotenv;

class Config
{
    const SYMFONY_DOTENV_VARS = 'SYMFONY_DOTENV_VARS';

    const HTTP_ENDPOINT = 'HTTP_ENDPOINT';
    const LOG_DIR = 'LOG_DIR';

    private array $parameters = [];

    public function __construct()
    {
        $this->load();
    }

    public function get(string $name, $default = null)
    {
        return $this->parameters[$name] ?? $default;
    }

    public function load(): void
    {
        $dotenv = new Dotenv();
        $dotenv->load(__DIR__.'/../../.env');

        $appVars = explode(',', $_ENV[self::SYMFONY_DOTENV_VARS]);

        $this->parameters = array_filter($_ENV, function ($varName) use ($appVars) {
            return in_array($varName, $appVars);
        }, ARRAY_FILTER_USE_KEY);
    }
}
