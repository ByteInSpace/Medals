<?php
namespace Medal\Model;

abstract class ModelBase
{
    private static $pdo;
    /**
     * Get the connection. This will open a connection, if does not exist yet.
     *
     * @return \PDO
     */
    public function getPdo()
    {
        if (self::$pdo === null) {
            self::$pdo = new \PDO('mysql:host=localhost;dbname=medalsforever', 'medalmaster', 'medalmaster29072018');
        }
        return self::$pdo;
    }
    /**
     * @param int|array $options
     *
     * @return static
     */
    public static function findFirst($options)
    {
        $model = new static();
        $table = $model->getSource();
        /** @var \PDO $pdo */
        $pdo = $model->getPdo();
        if (is_int($options)) {
            // we are looking for an ID
            $stmt = $pdo->prepare('SELECT * FROM `'.$table.'` WHERE id = ? LIMIT 1');
            $stmt->execute([$options]);
        } elseif (is_array($options) && isset($options['criteria'])) {
            $stmt = $pdo->prepare('SELECT * FROM `'.$table.'` WHERE '.$options['criteria'].' LIMIT 1');
            $stmt->execute($options['bind']);
        } else {
            throw new \UnexpectedValueException('you need to specify the criteria');
        }
        return $stmt->fetchObject(get_class($model));
    }
    /**
     * @param array $options
     *
     * @return static
     */
    public static function find(array $options)
    {
        $model = new static();
        $table = $model->getSource();
        /** @var \PDO $pdo */
        $pdo = $model->getPdo();
        if (!isset($options['criteria'])) {
            throw new \UnexpectedValueException('you need to specify the criteria');
        }
        $stmt = $pdo->prepare('SELECT * FROM `'.$table.'` WHERE '.$options['criteria']);
        $stmt->execute($options['bind']);
        return $stmt->fetchAll(\PDO::FETCH_CLASS, get_class($model));
    }
    
    public static function findAll($criteria)
    {
        $model = new static();
        $table = $model->getSource();
        /** @var \PDO $pdo */
        $pdo = $model->getPdo();
        $sql = 'SELECT * FROM '.$table . " WHERE Deleted=0";
        if (!empty($criteria))
        {
            $sql = $sql . " AND " . $criteria;
        }
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll(\PDO::FETCH_CLASS, get_class($model));
    }
    
    
    public function save()
    {
        $table = $this->getSource();
        /** @var \PDO $pdo */
        $pdo = $this->getPdo();
        if ($this->id === null) {
            // new entry
            if (method_exists($this, 'beforeCreate')) {
                $this->beforeCreate();
            }
            if (!$pdo->exec('INSERT INTO `'.$table.'` SET '.implode(',', $this->getFields()))) {
                throw new \RuntimeException('Could not crate '.get_class($this).': '.$pdo->errorInfo()[2]);
            }
            // fill the id
            $this->id = $pdo->lastInsertId();
        } else {
            // update entry
            if (method_exists($this, 'beforeUpdate')) {
                $this->beforeUpdate();
            }
            if ($pdo->exec('UPDATE `'.$table.'` SET '.implode(',', $this->getFields()).' WHERE `id` = '.((int)$this->id)) === false) {
                throw new \RuntimeException('Could not update '.get_class($this).': '.$pdo->errorInfo()[2]);
            }
        }
    }
    
    /**
     * Function will NOT in fact delete entry from database, only set DELETED = Flag to true.
     * For real delete use delete_hard()
     */
    public function delete($id)
    {
        $model = new static();
        $table = $model->getSource();
        /** @var \PDO $pdo */
        $pdo = $model->getPdo();
        $sql = 'UPDATE '.$table . " SET Deleted=1 WHERE ID=" . $id;
        if ($pdo->exec($sql) === false) {
            throw new \RuntimeException('Could not delete entry $id from $table');
        }
        
    }
    
    public function delete_hard()
    {
        
    }
    
    /**
     * Build fields data.
     *
     * @return array
     */
    private function getFields()
    {
        $pdo = $this->getPdo();
        $fields = [];
        foreach ($this as $name => $val) {
            if ($val === null) {
                $fields[] = "`$name`=null";
            } elseif (is_int($val)) {
                $fields[] = "`$name`=".$val;
            } else {
                $fields[] = "`$name`=".$pdo->quote($val);
            }
        }
        return $fields;
    }
    /**
     * The table name of the model.
     *
     * @return string
     */
    abstract public function getSource();
} 