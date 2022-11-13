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

    function getAll($params = null){
        $sort = $_GET['sort'] ?? null;
        $order = $_GET['order'] ?? null;
        $filterColumn = $_GET['filterColumn'] ?? null;
        $filterValue = $_GET['filterValue'] ?? null;

        $this->verify($sort, $order, $filterColumn, $filterValue);

        if(($filterColumn == null && $filterValue == null) && ($sort == null && $order == null)){
            $opinions = $this->model->getAll(); 
            $this->view->response($opinions, 200);
        }
        else if($sort !=null && $order != null){
            $opinions = $this->model->getOrder($sort, $order);
            $this->view->response($opinions, 200);
        }
        else if($filterColumn !=null && $filterValue != null){
            $opinions = $this->model->filter($filterColumn, $filterValue);
            $this->view->response($opinions, 200);
        }
    }


    function verify($sort, $order, $filterColumn, $filterValue){

    }


    function getAllFor($params = null){
        $id = $params[':ID'];
        $prod = $this->modelProd->getItem($id);
        if($prod){
           $opinions = $this->model->getAllFor($id);
           if($opinions){
                $this->view->response($opinions, 200);
           }
           else{
            $this->view->response("Opinion del producto $id, Not Found", 404);
           }
        }
        else{
            $this->view->response("Product id $id, Not Found", 404);

        }
    }

    function getOne($params = null){
        $id = $params[':ID'];
        $data = $this->model->getOne($id);
        if($data){
            $this->view->response($data, 200);
        }else{
            $this->view->response("Opinion id $id, Not Found", 404);
        }
    }

    function add($params = null){
        $body = $this->getData();
        if(!empty($body)){
            $opinion = $body->opinion;
            $id_producto = $body->id_producto;
            $item = $this->model->add($opinion, $id_producto);
            $this->view->response("Opinión creada con éxito", 201);
        }else{
            $this->view->response("Debe completar todos los campos", 400); 
        }
    }

    function delete($params = null){
        $id = $params[':IDOpinion'];
        $data = $this->model->getOne($id);
        if($data){
            $this->model->delete($id);
            $this->view->response("Opinion id $id eliminado", 200);
        }else{
            $this->view->response("Opinion id $id, Not Found", 404);
        }
    }

    function update($params = null){
        $id = $params[':ID'];
        $item = $this->model->getOne($id);
        if($item){
            $body = $this->getData();
            $opinion = $body->opinion;
            $id_producto = $body->id_producto;
            $this->model->update($id, $opinion, $id_producto);
            $this->view->response("Opinión $id editada con éxito", 200);
        }else{
            $this->view->response("Opinión $id Not Found", 404);
        }
    }

    

}