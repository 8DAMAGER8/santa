<?php

namespace Services;
use mysqli;

class DatabaseService
{
    private mysqli $db;
    private static $instance;

    private function __construct()
    {
        $env = parse_ini_file(__DIR__ . '/../.env');

        self::$instance = $this;

        $this->db = new mysqli(
            $env['DB_HOST'],
            $env['DB_USERNAME'],
            $env['DB_PASSWORD'],
            $env['DB_DATABASE']
        );

        if ($this->db->connect_errno) {
            printf("Connect failed: %s\n", $this->db->connect_error);
            exit();
        }

        $this->db->query("SET NAMES '" . $env['DB_CHARSET'] . "'");
        $this->db->query("SET SQL_BIG_SELECTS=1");
    }

    public static function instance(): DatabaseService
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public static function getDb(): mysqli
    {
        return self::instance()->db;
    }
}
