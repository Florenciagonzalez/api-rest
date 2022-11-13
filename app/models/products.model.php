<?php



class ProdModel{
    private $db;

    function __construct(){
       $this->db = new PDO('mysql:host=localhost;'.'dbname=db_cafeteria;charset=utf8', 'root', '');
    }

    function getAll(){
        $query = $this->db->prepare('SELECT a.*, b.* FROM productos a INNER JOIN categorias b ON a. id_categoria = b. id_categoria');
        $query->execute();
        $products = $query->fetchAll(PDO::FETCH_OBJ);

        return $products;
    }


    function getOrder($sort, $order){
        $query = "SELECT * FROM productos ORDER BY $sort $order";
        $querydb = $this->db->prepare($query);
        $querydb->execute();
        $products = $querydb->fetchAll(PDO::FETCH_OBJ);

        return $products;
    }

    function getItem($id){
        $query = $this->db->prepare('SELECT a.*, b.* FROM productos a INNER JOIN categorias b ON a. id_categoria = b. id_categoria WHERE id_producto = ?');
        $query->execute(array($id));
        $item = $query->fetch(PDO::FETCH_OBJ);

        return $item;
    }


    function filter($filterColumn, $filterValue){
        $query = "SELECT * FROM productos WHERE $filterColumn =?";
        $querydb = $this->db->prepare($query);
        $querydb->execute(array($filterValue));
        $products = $querydb->fetchAll(PDO::FETCH_OBJ);
       
        return $products;
    }
}