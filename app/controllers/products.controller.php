<?php

require_once './app/models/products.model.php';
require_once './app/views/api-view.php';

class ProdController{
    private $model;
    private $view;
    
    function __construct(){
        $this->model = new ProdModel();
        $this->view = new ApiView();
       
    }

    function getAll(){
        $sort = $_GET['sort'] ?? null;
        $order = $_GET['order'] ?? null;
        $filterColumn = $_GET['filterColumn'] ?? null;
        $filterValue = $_GET['filterValue'] ?? null;

        $this->verify($sort, $order, $filterColumn, $filterValue);

        if(($filterColumn == null && $filterValue == null) && ($sort == null && $order == null)){
            $products = $this->model->getAll(); 
            $this->view->response($products, 200);
        }
        else if($sort !=null && $order != null){
            $products = $this->model->getOrder($sort, $order);
            $this->view->response($products, 200);
        }
        else if($filterColumn !=null && $filterValue != null){
            $products = $this->model->filter($filterColumn, $filterValue);
            $this->view->response($products, 200);
        }
    } 

   function verify($sort, $order, $filterColumn, $filterValue){

   
        $columns = array(
            
        );

        
   }

}
