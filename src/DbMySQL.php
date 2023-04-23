<?php

namespace Mszlu\Tools;


/**
 *
 * @method static mixed get($join = null, $columns = null, $where = null)
 * @method static int count($join = null, $column = null, $where = null)
 * @method static bool has($join, $where = null)
 * @method static string max($join, $column = null, $where = null)
 * @method static string min($join, $column = null, $where = null)
 * @method static string sum($join, $column = null, $where = null)
 * @method static string avg($join, $column = null, $where = null)
 * @method static array rand($join, $column = null, $where = null)
 * @method static void action(callable $actions)
 * @method static string id(string $name = null)
 * @method static array log()
 * @method static string last()
 */
class DbMySQL extends ORM
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'user';
    }

    public function find($id)
    {
        return $this->db->get($this->table, '*', ['id' => $id]);
    }

    public function all()
    {
        return $this->db->select($this->table, '*');
    }

    public function create(array $data)
    {
        $this->db->insert($this->table, $data);
    }

    public function update(array $data, $id)
    {
        $this->db->update($this->table, $data, ['id' => $id]);
    }

    public function delete($id)
    {
        $this->db->delete($this->table, ['id' => $id]);
    }
}