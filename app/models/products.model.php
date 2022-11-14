<?php

class ProdModel{
    private $db;

    function __construct(){
       $this->db = new PDO('mysql:host=localhost;'.'dbname=db_cafeteria;charset=utf8', 'root', '');
    }

    function getAll($sort, $order){
        $query = "SELECT a.*, b.* FROM productos a INNER JOIN categorias b ON a. id_categoria = b. id_categoria ORDER BY $sort $order";
        $querydb = $this->db->prepare($query);
        $querydb->execute();
        $products = $querydb->fetchAll(PDO::FETCH_OBJ);

        return $products;
    }

    
    function getFilteredAndSorted($filterColumn, $filterValue, $sort, $order){
        $query = "SELECT * FROM productos WHERE $filterColumn =? ORDER BY $sort $order";
        $querydb = $this->db->prepare($query);
        $querydb->execute(array($filterValue));
        $products = $querydb->fetchAll(PDO::FETCH_OBJ);
       
        return $products;
    }

    function getItem($id){
        $query = $this->db->prepare('SELECT a.*, b.* FROM productos a INNER JOIN categorias b ON a. id_categoria = b. id_categoria WHERE id_producto = ?');
        $query->execute(array($id));
        $item = $query->fetch(PDO::FETCH_OBJ);

        return $item;
    }
}