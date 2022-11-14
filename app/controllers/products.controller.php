<?php
require_once 'app/controllers/api-controller.php';
require_once './app/models/products.model.php';
require_once './app/views/api-view.php';

class ProdController extends ApiController{
    
    function __construct(){
        parent::__construct();
        $this->model = new ProdModel();
    }

    function getAll(){
        try{
            $sort = $_GET['sort'] ?? null;
            $order = $_GET['order'] ?? null;
            $filterColumn = $_GET['filterColumn'] ?? null;
            $filterValue = $_GET['filterValue'] ?? null;

            $this->verify($sort, $order, $filterColumn, $filterValue);

            if($filterColumn == null && $filterValue == null && $sort == null && $order == null){
                $products = $this->model->getAll('id_producto', 'asc');
            }
            else if(($sort !=null && $order != null) && ($filterColumn == null && $filterValue == null)){
                $products = $this->model->getAll($sort, $order);
            }
            else if(($filterColumn !=null && $filterValue != null) && ($sort == null & $order == null)){
                $products = $this->model->getFilteredAndSorted($filterColumn, $filterValue, 'id_producto', 'asc');
            }
            else if(($filterColumn != null && $filterValue != null) && ($sort != null && $order != null)){
                $products = $this->model->getFilteredAndSorted($filterColumn, $filterValue, $sort, $order);
            }

            if(!empty($products)){
                $this->view->response($products, 200);
            }else{
                $this->view->response("Not found", 404);
            }

        }catch(Exception $exc){
            $this->view->response("Internal Server Error", 500);
        }

    } 

   function verify($sort, $order, $filterColumn, $filterValue){
        $columns = array(
            "id_producto",
            "producto",
            "descripcion",
            "id_categoria",
            "categoria"    
        );

        if($sort != null && !in_array(strtolower($sort), $columns)){
            $this->view->response("Bad request", 400);
        }

        if($order != null && strtolower($order) != 'asc' && strtolower($order) != 'desc'){
            $this->view->response("Bad request", 400);
        }

        if($filterColumn !=null && !in_array(strtolower($filterColumn), $columns) && $filterValue == null){
            $this->view->response("Bad request", 400);
        }
  
   }

   
}



