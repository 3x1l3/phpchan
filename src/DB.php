<?php
namespace PHPChan;

use SQLite3;

class DB
{
    private $_db;

    public function __construct()
    {
        $this->_db = new SQLite3('./phpchan.db');
        $this->_db->exec('CREATE TABLE IF NOT EXISTS threads (ID INTEGER, board STRING)');
    }
  /**
   * [insert description].
   *
   * @param  [type] $table      [description]
   * @param  array  $conditions array('ID'=>'123')
   *
   * @return [type]             [description]
   */
  public function insert($table, array $conditions)
  {
      if (count($conditions) > 0) {
          $keys = implode(', ', array_keys($conditions));
          $values = "'".implode("', '", $conditions)."'";

          $this->_db->exec('INSERT INTO '.$table.' ('.$keys.') VALUES ( '.$values.' )');
      }
  }

  public function select($table, array $conditions = array()) {
      $results = array();
    if (count($conditions) > 0) {
      //  $keys = implode(', ', array_keys($conditions));
        $conditionStr = '';
        foreach ($conditions as $key => $val) {
            $conditionStr .= $key.' '.$val;
        }

        $result = $this->_db->query('SELECT * FROM '.$table.' WHERE '.$conditionStr);
    } else {
      $result = $this->_db->query('SELECT * FROM '.$table);


    }

    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $results[] = $row;
    }
    return $results;
  }

}
