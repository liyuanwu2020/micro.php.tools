<?php

namespace Mszlu\Tools;

abstract class ORM
{
    protected $db;

    public function __construct()
    {
        $this->db = new \Medoo\Medoo([
            'database_type' => 'mysql',
            'database_name' => 'my_database',
            'server' => 'localhost',
            'username' => 'root',
            'password' => '123456'
        ]);
    }

    abstract public function find($id);

    abstract public function all();

    abstract public function create(array $data);

    abstract public function update(array $data, $id);

    abstract public function delete($id);
}