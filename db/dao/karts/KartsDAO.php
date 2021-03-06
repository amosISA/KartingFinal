<?php

/**
 * Created by PhpStorm.
 * User: ruben_000
 * Date: 12/11/2016
 * Time: 16:58
 */
class KartsDAO
{

    const _CLASS = "Kart";
    const _TABLE = "karts";
    const ID = "id";

    const NUMBER = "number";
    const TYPE = "type";
    const AVAILABLE = "available";


    /**
     * CONSULTAS GENERALES
     */

    public function getAll()
    {

        $ds = new DataSource();
        $sql = sprintf("SELECT * from %s ", self::_TABLE);
        $userlist = $ds->fetchAllToClass($sql, self::_CLASS);
        $ds->close();

        return $userlist;

    }


    public function getById($id)
    {

        $ds = new DataSource();
        $sql = sprintf("SELECT * from %s where %s=?", self::_TABLE, self::ID);
        $params = array($id);
        $user = $ds->fetchToClass($sql, self::_CLASS, $params);
        $ds->close();

        return $user;

    }


    /**
     * CRUD
     */

    public function insert($tableName)
    {

        $ds = new DataSource();

        $sql = sprintf("insert into %s (%s,%s,%s) 
                 values ( 
                    :number,
                    :type,
                    :available 
                  
                     )", self::_TABLE, self::NUMBER, self::TYPE, self::AVAILABLE);

        $params = array(
            ":number" => $tableName->getNumber(),
            ":type" => $tableName->getType(),
            ":available" => $tableName->getAvailable()
        );

        $result = $ds->execute($sql, $params);
        $ds->close();

        return $result;
    }


    public function update($tableName, $id)
    {

        $ds = new DataSource();

        $sql = sprintf("update %s set 
                number=:number,
                    type=:type,
                    avilable=:available
                 where id=%s", self::_TABLE, $id);

        $params = array(
            ":number" => $tableName->getNumber(),
            ":type" => $tableName->getType(),
            ":available" => $tableName->getAvailable()
        );

        $result = $ds->execute($sql, $params);
        $ds->close();

        return $result;
    }

    public function delete($id)
    {

        $ds = new DataSource();
        $sql = sprintf("DELETE from %s where %s=?", self::_TABLE, self::ID);
        $params = array($id);
        $result = $ds->execute($sql, $params);
        $ds->close();

        return $result;

    }
}