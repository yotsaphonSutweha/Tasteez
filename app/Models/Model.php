<?php
namespace Tasteez\Models;

class Model
{
  protected $db;

  function __construct($db)
  {
    $this->db = $db;
  }

  public function getTableName()
  {
    $className = substr(get_called_class(), strrpos(get_called_class(), '\\') + 1);
    return strtolower($className) . "s";
  }

  public function findAll()
  {
    $query = "SELECT * FROM " . $this->getTableName();
    $tableName = $this->getTableName();

    return $this->db->query("SELECT * FROM ${tableName}")->fetchAll();
  }

  public function findById($id)
  {
    $query = "SELECT * FROM ".$this->getTableName()." WHERE id=".$id;

    return $this->db->query('SELECT * FROM meals')->fetchAll();
  }

  public function query($query) {
    return $this->db->query($query)->fetchAll();
  }


}
