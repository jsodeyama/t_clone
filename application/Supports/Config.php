<?php

namespace Application\Supports;

/**
 * Class Config
 *
 * @package Application\Supports
 */
class Config
{
    /**
     * loaded config
     * @var array
     */
    private static $loaded_config =[];

    /**
     * load config from path
     *
     * specify the directory that contains the config file
     *
     * @param string $config_container_path
     * @return void
     */
    public static function load(string $config_container_path)
    {
        $config_container_path = realpath($config_container_path);
        if (!is_dir($config_container_path)) {
            if ($config_container_path === false) {
                throw new \RuntimeException("[{$config_container_path}] is illegal path");
            }

            throw new \RuntimeException("No such directory [{$config_container_path}] ");
        }

        $environment = strtolower(getenv('APPLICATION_ENVIRONMENT'));
        if ($environment === '') {
            throw new \RuntimeException("APPLICATION_ENVIRONMENT is undefined");
        }

        $fully_qualified_path = $config_container_path . DIRECTORY_SEPARATOR . $environment;
        foreach ((new \DirectoryIterator($fully_qualified_path)) as $config_file) {
            $pathinfo = pathinfo($config_file);
            if ($pathinfo['extension'] === 'php') {
                /** @noinspection PhpIncludeInspection */
                self::$loaded_config[$pathinfo['filename']] = require_once $fully_qualified_path . DIRECTORY_SEPARATOR . $pathinfo['basename'];
            }
        }
    }

    /**
     * get value from loaded config
     *
     * @param string $key
     * @return mixed | false
     */
    public static function get(string $key)
    {
        $composition = explode('.', $key);
        $base = array_shift($composition);
        if (count($composition) === 0) {
            return self::$loaded_config[$base];
        }

        $value = self::$loaded_config[$base];
        foreach ($composition as $sub_key) {
            if (!isset($value[$sub_key])) {
                return false;
            }
            $value = $value[$sub_key];
        }

        return $value;
    }
}