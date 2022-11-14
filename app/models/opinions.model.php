<?php

class OpinionsModel{
    private $db;

    function __construct(){
       $this->db = new PDO('mysql:host=localhost;'.'dbname=db_cafeteria;charset=utf8', 'root', '');
    }

    function getAll($sort, $order){
        $query = "SELECT * FROM opiniones ORDER BY $sort $order";
        $querydb = $this->db->prepare($query);
        $querydb->execute();
        $opinions = $querydb->fetchAll(PDO::FETCH_OBJ);

        return $opinions;
    }

    function getFilteredAndSorted($filterColumn, $filterValue, $sort, $order){
        $query = "SELECT * FROM opiniones WHERE $filterColumn =? ORDER BY $sort $order";
        $querydb = $this->db->prepare($query);
        $querydb->execute(array($filterValue));
        $opinions = $querydb->fetchAll(PDO::FETCH_OBJ);
       
        return $opinions;
    }

    function getOne($id){
        $query = $this->db->prepare('SELECT a.*, b.* FROM opiniones a INNER JOIN productos b ON a. id_producto = b. id_producto WHERE id_opinion = ?');
        $query->execute([$id]);
        $item = $query->fetch(PDO::FETCH_OBJ);

        return $item;
    }

    function add($opinion, $id_producto){
        $query = $this->db->prepare('INSERT INTO opiniones(opinion, id_producto) VALUES(?,?)');
        $query->execute(array($opinion, $id_producto));

        return $this->db->lastInsertId();
    }

    function delete($id){
        $query = $this->db->prepare('DELETE FROM opiniones WHERE id_opinion =?');
        $query->execute(array($id));
    }

    function update($id, $opinion, $id_producto){
        $query = $this->db->prepare('UPDATE opiniones SET opinion =?, id_producto =? WHERE id_opinion =?');
        $query->execute(array($opinion, $id_producto, $id)); 
    }

}