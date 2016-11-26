<?php

/**
 * Created by PhpStorm.
 * User: ruben_000
 * Date: 12/11/2016
 * Time: 17:25
 */
class ReservesDAO
{

//TODO: VAMOS POR AQUI

    const _CLASS = "Reserve";
    const _TABLE = "reserves";
    const ID = "id";

    const USER = "user";
    const DATE = "date";
    const NUMBER = "number";
    const TYPE = "type";
    const KART_TYPE = "kart_type";

    /**
     * CONSULTAS GENERALES
     */

    public function getAll()
    {

        $ds = new DataSource();
        $sql = sprintf("SELECT * from %s ", self::_TABLE);
        $reserve = $ds->fetchAllToClass($sql, self::_CLASS);
        $ds->close();

        return $reserve;

    }


    //Muestra ficheros dentro de directorio
    public function showList($userId)
    {


        $ds = new DataSource();
        $array = array($userId);
        $sql = sprintf("SELECT * from %s where %s=?", self::_TABLE, self::USER);

        $dirFileList = "<h2>Listado de Reservas</h2>";
        foreach ($ds->fetchAll($sql, $array) as $row) {
            $id = $row['id'];
            $dirFileList .= "- " . $id . "&nbsp;<a href='" . $_SERVER['PHP_SELF'] . "?section=reserves&delete=".$id." '>Borrar</a>&nbsp;|&nbsp;<a href='" . $_SERVER['PHP_SELF'] . "?section=reserves&watch=$id'>Ver</a>|&nbsp;<a href='" . $_SERVER['PHP_SELF'] . "?section=reserves&edit=$id'>Editar</a><br>";

        }

        $ds->close();

        return $dirFileList;
    }


    public function getDateQuery($date)
    {
        $hayCoincidencias = false;

        $ds = new DataSource();
        $sql = sprintf("SELECT * from %s where %s = $date", self::_TABLE, self::DATE);
        $result = $ds->query($sql);
        $ds->close();

        foreach ($result as $row) {
            $hayCoincidencias = true;
        }

        return $hayCoincidencias;

    }

    public function getDateFech($date)
    {
        $hayCoincidencias = false;

        $ds = new DataSource();
        $sql = sprintf("SELECT * from %s where %s = ?", self::_TABLE, self::DATE);
        $array = array($date);
        $result = $ds->fetch($sql, $array);
        $ds->close();

        if ($result)
            $hayCoincidencias = true;


        return $hayCoincidencias;

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

        $sql = sprintf("insert into %s (%s,%s,%s, %s, %s) 
                 values ( 
                    :user,
                    :date,
                    :number,
                    :type,
                    :kart_type                                                                            
                     )", self::_TABLE, self::USER, self::DATE, self::NUMBER, self::TYPE, self::KART_TYPE);

        $params = array(
            ":user" => $tableName->getUser(),
            ":date" => $tableName->getDate(),
            ":number" => $tableName->getNumber(),
            ":type" => $tableName->getType(),
            ":kart_type " => $tableName->getKartType()
        );

        $result = $ds->execute($sql, $params);
        $ds->close();

        return $result;
    }


    public function update($tableName, $id)
    {

        $ds = new DataSource();

        $sql = sprintf("update %s set 
                    user =:user,
                    date =:date,
                    number =:number,
                    type =:type,
                    kart_type =:kart_type    
                 where id=%s", self::_TABLE, $id);

        $params = array(
            ":user" => $tableName->getUser(),
            ":date" => $tableName->getDate(),
            ":number" => $tableName->getNumber(),
            ":type" => $tableName->getType(),
            ":kart_type " => $tableName->getKartType()
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