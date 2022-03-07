<?php

// An Singleton class, that maintains all the children classes's instance, 
// making sure only one instance of each is created across the application runtime
class AbstractService
{
    private static $instances = [];

    protected function __construct()
    {
    }

    public static function getInstance()
    {
        $actualClass = static::class;
        if (!isset(self::$instances[$actualClass])) {
            self::$instances[$actualClass] = new static();
        }
        return self::$instances[$actualClass];
    }
}
