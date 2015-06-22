<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Concerto\Util;

/**
 * Description of Config
 *
 * @author samuel
 */
class Config {
    
    public static $configData;


    public static function load($config_dir) {
        
        self::$configData = new \stdClass();

        $mainConfig = file_get_contents("$config_dir/main.json");
        self::$configData->main = json_decode($mainConfig);
        
        $env = self::$configData->main->env;
        $envConfig = file_get_contents("$config_dir/$env.json");
        self::$configData->env = json_decode($envConfig);
        
        $routingConfig = file_get_contents("$config_dir/routing.json");
        self::$configData->routes = json_decode($routingConfig, true);
        
    }
    
    public static function get($key) {
        
        if ($key == 'routes') {
            return self::$configData->routes;
        }
        
        if (isset(self::$configData->main->{$key})) {
            return self::$configData->main->{$key};
        }
        
        if (isset(self::$configData->env->{$key})) {
            return self::$configData->env->{$key};
        }
        
        return null;
        
    }
    
    public static function objectToArray($object) {
        
        if (is_object($object)) {
            $object = get_object_vars($object);
            return array_map('self::objectToArray', $object);
        }
        
        return $object;
        
    }
    
}
