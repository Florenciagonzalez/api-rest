<?php
require_once 'app/controllers/api-controller.php';
require_once './app/models/opinions.model.php';
require_once './app/models/products.model.php';
require_once './app/views/api-view.php';

class OpinionsController extends ApiController{
    private $modelProd;
    
    function __construct(){
        parent::__construct();
        $this->model = new OpinionsModel();
        $this->modelProd = new ProdModel();
        
    }
    
    function getAll(){
        try{
            $sort = $_GET['sort'] ?? null;
            $order = $_GET['order'] ?? null;
            $filterColumn = $_GET['filterColumn'] ?? null;
            $filterValue = $_GET['filterValue'] ?? null;

            $columns = array(
                "id_opinion",
                "opinion",
                "id_producto"    
            );

            $this->verifyIncomplete($sort, $order, $filterColumn, $filterValue);

            if($filterColumn == null && $filterValue == null && $sort == null && $order == null){
                $opinions = $this->model->getAll('id_producto', 'asc');
                $this->view->response($opinions, 200);

            }
            else if(($sort !=null && $order != null) && ($filterColumn == null && $filterValue == null)){
                if($this->verify($sort, $order, $filterColumn, $filterValue, $columns)){
                    $this->view->response("Bad request", 400);
                }else{
                    $opinions = $this->model->getAll($sort, $order);
                    if(empty($opinions)){
                        $this->view->response("Not Found", 404);
                    }else{
                        $this->view->response($opinions, 200);
                    }
                }
            }
            else if(($filterColumn !=null && $filterValue != null) && ($sort == null & $order == null)){
                if($this->verify($sort, $order, $filterColumn, $filterValue, $columns)){
                    $this->view->response("Bad request", 400);
                }else{
                    $opinions = $this->model->getFilteredAndSorted($filterColumn, $filterValue, 'id_producto', 'asc');
                    if(empty($opinions)){
                        $this->view->response("Not Found", 404);
                    }else{
                        $this->view->response($opinions, 200);
                    }
                } 
            }
            else if(($filterColumn != null && $filterValue != null) && ($sort != null && $order != null)){
                if($this->verify($sort, $order, $filterColumn, $filterValue, $columns)){
                    $this->view->response("Bad request", 400);
                }else{
                    $opinions = $this->model->getFilteredAndSorted($filterColumn, $filterValue, $sort, $order);
                    if(empty($opinions)){
                        $this->view->response("Not Found", 404);
                    }else{
                        $this->view->response($opinions, 200);
                    }
                }
            }
        }catch(Exception $exc){
            $this->view->response("Server Internal Error", 500);
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
            ($sort != null && !in_array(strtolower($sort), $columns))&& $order != null){
            return true;
        }
        else if($filterColumn !=null && !in_array(strtolower($filterColumn), $columns) && $filterValue != null){
            return true;
        }
        else if($order != null && strtolower($order) != 'asc' && strtolower($order) != 'desc' && $sort != null && !in_array(strtolower($sort), $columns)){
            return true;
        }
        else if($order != null && strtolower($order) != 'asc' && strtolower($order) != 'desc' && $sort != null && in_array(strtolower($sort), $columns)){
            return true;
        }
        else if($sort != null && !in_array(strtolower($sort), $columns) && $order != null && strtolower($order) == 'asc' && strtolower($order) == 'desc'){
            return true;
        }        
    }      
   

    function get($params = null){
        try{
            $id = $params[':ID'];
            $opinion = $this->model->getOne($id);
            if($opinion){
                $this->view->response($opinion, 200);
            }else{
                $this->view->response("Opinion id $id, Not Found", 404);
            }
        }catch(Exception $exc){
            $this->view->response("Server Internal Error", 500);
        }
    }

    function add($params = null){
        try{
            $body = $this->getData();
            if(!empty($body)){
                $opinion = $body->opinion;
                $id_producto = $body->id_producto;
                $id = $this->model->add($opinion, $id_producto);
                $this->view->response("Opinión creada con éxito id: $id", 201);
            }else{
                $this->view->response("Debe completar todos los campos", 400); 
            }
        }catch(Exception $exc){
            $this->view->response("Server Internal Error", 500);
        }
    }

    function delete($params = null){
        try{
            $id = $params[':ID'];
            $opinion = $this->model->getOne($id);
            if($opinion){
                $this->model->delete($id);
                $this->view->response("Opinion id $id eliminada", 200);
            }else{
                $this->view->response("Opinion id $id, Not Found", 404);
            }
        }catch(Exception $exc){
            $this->view->response("Server Internal Error", 500);
        }
    }

    function update($params = null){
        try{
            $id = $params[':ID'];
            $item = $this->model->getOne($id);
            if($item){
                $body = $this->getData();
                if(!empty($body)){
                    $opinion = $body->opinion;
                    $id_producto = $body->id_producto;
                    $this->model->update($id, $opinion, $id_producto);
                    $this->view->response("Opinión $id editada con éxito", 200);
                }
            }else{
                $this->view->response("Opinión $id Not Found", 404);
            }
        }catch(Exception $exc){
            $this->view->response("Server Internal Error", 500);
        }
    }

}