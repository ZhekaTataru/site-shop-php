<?php
class Database
{
    private static $instance;
    private $mysqli;

    private function __construct()
    {
        $this->mysqli = new mysqli("localhost", "root", "", "shop");
        $this->mysqli->query("SET NAMES 'utf-8'");
    }

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getMysqli()
    {
        return $this->mysqli;
    }
}
?>