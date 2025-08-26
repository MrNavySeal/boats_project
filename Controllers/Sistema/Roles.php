<?php
    class Roles extends Controllers{
        public function __construct(){
            session_start();
            if(empty($_SESSION['login'])){
                header("location: ".base_url());
                die();
            }
            parent::__construct();
        }
        public function roles(){
            if($_SESSION['permitsModule']['r']){
                $data['botones'] = [
                    "duplicar" => ["mostrar"=>$_SESSION['permitsModule']['r'], "evento"=>"onClick","funcion"=>"mypop=window.open('".BASE_URL.$_SESSION['permitsModule']['route']."','','');mypop.focus();"],
                    "nuevo" => ["mostrar"=>$_SESSION['permitsModule']['w'], "evento"=>"@click","funcion"=>"openModal()"],
                ];
                $data['page_tag'] = "{$_SESSION['permitsModule']['option']} | {$_SESSION['permitsModule']['module']}}";
                $data['page_title'] = "{$_SESSION['permitsModule']['option']} | {$_SESSION['permitsModule']['module']}";
                $data['page_name'] = "{$_SESSION['permitsModule']['option']} | {$_SESSION['permitsModule']['module']}";
                $data['script_type'] = "module";
                $data['panelapp'] = "/Sistema/functions_roles.js";
                $this->views->getView($this,"roles",$data);
            }else{
                header("location: ".base_url());
                die();
            }
        }
        public function getPermisos(){
            if($_SESSION['permitsModule']['r']){
                if($_POST){
                    $intId = intval($_POST['id']);
                    $request = $this->model->selectPermisos($intId);
                    $arrResponse = [
                        "data"=>$request,
                        "r"=>!empty(array_filter($request,function($e){return $e['r'];})),
                        "w"=>!empty(array_filter($request,function($e){return $e['w'];})),
                        "u"=>!empty(array_filter($request,function($e){return $e['u'];})),
                        "d"=>!empty(array_filter($request,function($e){return $e['d'];})),
                    ];
                    echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
                }
            }
            die();
        }
        public function setPermisos(){
            if($_SESSION['permitsModule']['u']){
                if($_POST){
                    $arrData = json_decode($_POST['data'],true);
                    $intId = intval($_POST['id']);
                    $request = $this->model->insertPermisos($intId,$arrData);
                    if(is_numeric($request) && $request > 0){
                        $arrResponse = array("status"=>true,"msg"=>"Permissions have been set.");
                    }else{
                        $arrResponse = array("status"=>false,"msg"=>"Something went wrong.");
                    }
                    echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
                }
            }
            die();
        }
        public function setRol(){
            if($_SESSION['permitsModule']['r']){
                if($_POST){
                    if(empty($_POST['name'])){
                        $arrResponse = array("status"=>false,"msg"=>"Please, fill the fields.");
                    }else{
                        $strName = clear_cadena(strClean(ucfirst(strtolower($_POST['name']))));
                        $intId = intval($_POST['id']);
                        $option = "";
                        if($intId==0){
                            if($_SESSION['permitsModule']['w']){
                                $option = 1;
                                $request = $this->model->insertRol($strName);
                            }
                        }else{
                            if($_SESSION['permitsModule']['u']){
                                $option = 2;
                                $request = $this->model->updateRol($intId,$strName);
                            }
                        }
                        if(is_numeric($request) && $request > 0){
                            if($option == 1){
                                $arrResponse = array("status"=>true,"msg"=>"Data saved.");
                            }else{
                                $arrResponse = array("status"=>true,"msg"=>"Data updated.");
                            }
                        }else if($request=="existe"){
                            $arrResponse = array("status"=>false,"msg"=>"This role already exists.");
                        }else{
                            $arrResponse = array("status"=>false,"msg"=>"Something went wrong.");
                        }
                    }
                    echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
                }
                die();
            }
        }
        public function getRoles(){
            if($_SESSION['permitsModule']['r']){
                $intPage = intval($_POST['page']);
                $intPerPage = intval($_POST['per_page']);
                $strSearch = strClean($_POST['search']);
                $request = $this->model->selectRoles($intPage,$intPerPage,$strSearch);
                echo json_encode($request,JSON_UNESCAPED_UNICODE);
            }
            die();
        }
        public function getRol(){
             if($_SESSION['permitsModule']['r']){
                if($_POST){
                    $intId = intval($_POST['id']);
                    $request = $this->model->selectRol($intId);
                    if(!empty($request)){
                        $arrResponse = array("status"=>true,"data"=>$request);
                    }else{
                        $arrResponse = array("status"=>false,"msg"=>"Something went wrong.");
                    }
                    echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
                }
            }
            die();
        }
        public function delRol(){
            if($_SESSION['permitsModule']['d']){
                if($_POST){
                    $intId = intval($_POST['id']);
                    $request = $this->model->deleteRol($intId);
                    if($request =="ok"){
                        $arrResponse = array("status"=>true,"msg"=>"It has been deleted");
                    }else if($request=="existe"){
                        $arrResponse = array("status"=>false,"msg"=>"Role has users, it can not be deleted.");
                    }else{
                        $arrResponse = array("status"=>false,"msg"=>"Something went wrong.");
                    }
                    echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
                }
            }
            die();
        }
    }
?>