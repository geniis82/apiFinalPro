<?php
use Ripcord\Ripcord;
use Spejder\Odoo\Odoo;

class Database
{

    public static $conn;

    // get the database connection


    public static function getConnection(): Odoo
    {

        $client = new Odoo(Constants::DB_HOST, Constants::DB_NAME, Constants::DB_USER, Constants::DB_PASSWORD);
        // $client->create('res.users', ['name' => 'pepe1', 'email' => 'pepe1@test.com']);
        // logAPI($client->read('res.users', [2], ['name', 'email']));
        return $client;
    }
}
