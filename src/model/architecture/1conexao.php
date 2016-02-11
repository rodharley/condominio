<?php

class Conexao
{
    private static $instance;
    public $connection;

    private function __construct()
    {
        $this->connection = new mysqli(SERVER,USERNAME,PASSWORD,DATABASE);
        //$this->connection->autocommit(false);
        //$this->connection->begin_transaction();
    }

    public static function init()
    {
        if(is_null(self::$instance))
        {
            self::$instance = new Conexao();
        }

        return self::$instance;
    }


    public function __call($name, $args)
    {
        if(method_exists($this->connection, $name))
        {
             return call_user_func_array(array($this->connection, $name), $args);
        } else {
             trigger_error('Unknown Method ' . $name . '()', E_USER_WARNING);
             return false;
        }
    }
}
