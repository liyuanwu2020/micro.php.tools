<?php

use Medoo\Medoo;


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
interface DbInterface
{
    function insert();
    function delete();
    function update();
    function select();
}