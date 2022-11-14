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

    function get($params = null){
        $id = $params[':ID'];
        $opinion = $this->model->getOne($id);
        if($opinion){
            $this->view->response($opinion, 200);
        }else{
            $this->view->response("Opinion id $id, Not Found", 404);
        }
    }

    function add($params = null){
        $body = $this->getData();
        if(!empty($body)){
            $opinion = $body->opinion;
            $id_producto = $body->id_producto;
            $id = $this->model->add($opinion, $id_producto);
            $this->view->response("Opinión creada con éxito id: $id", 201);
        }else{
            $this->view->response("Debe completar todos los campos", 400); 
        }
    }

    function delete($params = null){
        $id = $params[':ID'];
        $opinion = $this->model->getOne($id);
        if($opinion){
            $this->model->delete($id);
            $this->view->response("Opinion id $id eliminada", 200);
        }else{
            $this->view->response("Opinion id $id, Not Found", 404);
        }
    }

    function update($params = null){
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
    }

    

}