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

            $columns = array(
                "id_producto",
                "producto",
                "descripcion",
                "id_categoria",
                "categoria"    
            );

            $this->verifyIncomplete($sort, $order, $filterColumn, $filterValue, $columns);

            if($filterColumn == null && $filterValue == null && $sort == null && $order == null){
                $products = $this->model->getAll('id_producto', 'asc');
                $this->isEmpty($products);
            }
            else if(($sort !=null && $order != null) && ($filterColumn == null && $filterValue == null)){
                if($this->verify($sort, $order, $filterColumn, $filterValue, $columns)){
                    $products = $this->model->getAll($sort, $order);
                    $this->isEmpty($products);
                }   
            }
            else if(($filterColumn !=null && $filterValue != null) && ($sort == null & $order == null)){
                if($this->verify($sort, $order, $filterColumn, $filterValue, $columns)){
                    $products = $this->model->getFilteredAndSorted($filterColumn, $filterValue, 'id_producto', 'asc');
                    $this->isEmpty($products);
                }
            }
            else if(($filterColumn != null && $filterValue != null) && ($sort != null && $order != null)){
                if($this->verify($sort, $order, $filterColumn, $filterValue, $columns)){
                    $products = $this->model->getFilteredAndSorted($filterColumn, $filterValue, $sort, $order);
                    $this->isEmpty($products);
                }
            }
        }catch(Exception $exc){
            $this->view->response("Server Internal Error", 500);
        }
    } 

    function isEmpty($products){
        if(!empty($products)){
            $this->view->response($products, 200);
        }else{
            $this->view->response("Not found", 404);
        }
    }

    function verifyIncomplete($sort, $order, $filterColumn, $filterValue){
        if(($sort != null && $order == null) || ($sort == null && $order != null) &&
            ($filterColumn != null && $filterValue == null) || ($filterColumn == null && $filterValue != null)){
            $this->view->response("Bad request", 400);
        }
        else if(($sort != null && $order == null) || ($sort == null && $order != null)){
            $this->view->response("Bad request", 400);
        }
        else if(($filterColumn != null && $filterValue == null) || ($filterColumn == null && $filterValue != null)){
            $this->view->response("Bad request", 400);
        } 
   }

   function verify($sort, $order, $filterColumn, $filterValue, $columns){
        if(($filterColumn !=null && !in_array(strtolower($filterColumn), $columns) && $filterValue != null) &&
           ($order != null && strtolower($order) != 'asc' && strtolower($order) != 'desc' && $sort != null && !in_array(strtolower($sort), $columns))||
           ($order != null && strtolower($order) != 'asc' && strtolower($order) != 'desc' && $sort != null && in_array(strtolower($sort), $columns))||
           ($order != null && strtolower($order) == 'asc' || strtolower($order) == 'desc' && $sort != null && !in_array(strtolower($sort), $columns))){
            $this->view->response("Bad request", 400);
        }
        else if($filterColumn !=null && !in_array(strtolower($filterColumn), $columns) && $filterValue != null){
            $this->view->response("Bad request", 400);
        }
        else if($order != null && strtolower($order) != 'asc' && strtolower($order) != 'desc' && $sort != null && !in_array(strtolower($sort), $columns)){
            $this->view->response("Bad request", 400);
        }
        else if($order != null && strtolower($order) != 'asc' && strtolower($order) != 'desc' && $sort != null && in_array(strtolower($sort), $columns)){
            $this->view->response("Bad request", 400);
        }
        else if($order != null && strtolower($order) == 'asc' || strtolower($order) == 'desc' && $sort != null && !in_array(strtolower($sort), $columns)){
            $this->view->response("Bad request", 400);
        }        
   }
  
}



