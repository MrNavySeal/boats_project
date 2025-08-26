<?php
    class ProductosCategorias extends Controllers{
        public function __construct(){
            session_start();
            if(empty($_SESSION['login'])){
                header("location: ".base_url());
                die();
            }
            parent::__construct();
        }
        public function categorias(){
            if($_SESSION['permitsModule']['r']){
                $data['botones'] = [
                    "duplicar" => ["mostrar"=>$_SESSION['permitsModule']['r'], "evento"=>"onClick","funcion"=>"mypop=window.open('".BASE_URL.$_SESSION['permitsModule']['route']."','','');mypop.focus();"],
                    "nuevo" => ["mostrar"=>$_SESSION['permitsModule']['w'], "evento"=>"@click","funcion"=>"openModal()"],
                ];
                $data['page_tag'] = "{$_SESSION['permitsModule']['option']} | {$_SESSION['permitsModule']['module']}";
                $data['page_title'] = "{$_SESSION['permitsModule']['option']} | {$_SESSION['permitsModule']['module']}";
                $data['page_name'] = "{$_SESSION['permitsModule']['option']} | {$_SESSION['permitsModule']['module']}";
                $data['script_type'] = "module";
                $data['panelapp'] = "/Productos/functions_categorias.js";
                $this->views->getView($this,"categorias",$data);
            }else{
                header("location: ".base_url());
                die();
            }
        }
        public function subcategorias(){
            if($_SESSION['permitsModule']['r']){
                $data['botones'] = [
                    "duplicar" => ["mostrar"=>$_SESSION['permitsModule']['r'], "evento"=>"onClick","funcion"=>"mypop=window.open('".BASE_URL.$_SESSION['permitsModule']['route']."','','');mypop.focus();"],
                    "nuevo" => ["mostrar"=>$_SESSION['permitsModule']['w'], "evento"=>"@click","funcion"=>"openModal()"],
                ];
                $data['page_tag'] = "{$_SESSION['permitsModule']['option']} | {$_SESSION['permitsModule']['module']}";
                $data['page_title'] = "{$_SESSION['permitsModule']['option']} | {$_SESSION['permitsModule']['module']}";
                $data['page_name'] = "{$_SESSION['permitsModule']['option']} | {$_SESSION['permitsModule']['module']}";
                $data['script_type'] = "module";
                $data['panelapp'] = "/Productos/functions_subcategorias.js";
                $this->views->getView($this,"subcategorias",$data);
            }else{
                header("location: ".base_url());
                die();
            }
        }
        public function getSelectCategorias(){
            $intPage = intval($_POST['page']);
            $intPerPage = intval($_POST['per_page']);
            $strSearch = strClean($_POST['search']);
            $request = $this->model->selectCategoriasSel($intPage,$intPerPage,$strSearch);
            echo json_encode($request,JSON_UNESCAPED_UNICODE);
            die();
        }
        public function getSelectSubcategories(){
            if($_POST){
                $idCategory = intval(strClean($_POST['idCategory']));
                $html='<option value="0" selected>Select</option>';
                $request = $this->model->getSelectSubcategories($idCategory);
                if(count($request)>0){
                    for ($i=0; $i < count($request); $i++) { 
                        $html.='<option value="'.$request[$i]['idsubcategory'].'">'.$request[$i]['name'].'</option>';
                    }
                    $arrResponse = array("data"=>$html);
                }else{
                    $arrResponse = array("data"=>"");
                }
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            }
            die();
        }
        /*************************Category methods*******************************/
        public function getCategorias(){
            if($_SESSION['permitsModule']['r']){
                $intPage = intval($_POST['page']);
                $intPerPage = intval($_POST['per_page']);
                $strSearch = strClean($_POST['search']);
                $request = $this->model->selectCategorias($intPage,$intPerPage,$strSearch);
                echo json_encode($request,JSON_UNESCAPED_UNICODE);
            }
            die();
        }
        public function getCategoria(){
            if($_SESSION['permitsModule']['r']){
                if($_POST){
                    if(empty($_POST)){
                        $arrResponse = array("status"=>false,"msg"=>"Please, fill the fields");
                    }else{
                        $idCategory = intval($_POST['id']);
                        $request = $this->model->selectCategoria($idCategory);
                        if(!empty($request)){
                            $request['is_visible'] = boolval($request['is_visible']);
                            $request['url'] = media()."/images/uploads/".$request['picture'];
                            $arrResponse = array("status"=>true,"data"=>$request);
                        }else{
                            $arrResponse = array("status"=>false,"msg"=>"Something went wrong"); 
                        }
                    }
                    echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
                }
            }
            die();
        }
        public function setCategoria(){
            if($_SESSION['permitsModule']['w']){
                if($_POST){
                    if(empty($_POST['name'])){
                        $arrResponse = array("status" => false, "msg" => 'Please fill the fields');
                    }else{ 
                        $idCategory = intval($_POST['id']);
                        $strName = ucwords(strClean($_POST['name']));
                        $strDescription = strClean($_POST['description']);
                        $isVisible = intval($_POST['visible']);
                        $status = intval($_POST['status']);
                        $route = clear_cadena($strName);
                        $route = strtolower(str_replace("¿","",$route));
                        $route = str_replace(" ","-",$route);
                        $route = str_replace("?","",$route);
                        $photo = "";
                        $photoCategory="";

                        if($idCategory == 0){
                            if($_SESSION['permitsModule']['w']){
                                $option = 1;

                                if($_FILES['image']['name'] == ""){
                                    $photoCategory = "category.jpg";
                                }else{
                                    $photo = $_FILES['image'];
                                    $photoCategory = 'category_'.bin2hex(random_bytes(6)).'.png';
                                }

                                $request= $this->model->insertCategoria(
                                    $photoCategory, 
                                    $strName,
                                    $status,
                                    $strDescription,
                                    $route,
                                    $isVisible
                                );
                            }
                        }else{
                            if($_SESSION['permitsModule']['u']){
                                $option = 2;
                                $request = $this->model->selectCategoria($idCategory);
                                if($_FILES['image']['name'] == ""){
                                    $photoCategory = $request['picture'];
                                }else{
                                    if($request['picture'] != "category.jpg"){
                                        deleteFile($request['picture']);
                                    }
                                    $photo = $_FILES['image'];
                                    $photoCategory = 'category_'.bin2hex(random_bytes(6)).'.png';
                                }
                                $request = $this->model->updateCategoria(
                                    $idCategory, 
                                    $photoCategory,
                                    $strName,
                                    $status,
                                    $strDescription,
                                    $route,
                                    $isVisible
                                );
                            }
                        }
                        if(is_numeric($request) && $request > 0){
                            if($photo!=""){
                                uploadImage($photo,$photoCategory);
                            }
                            if($option == 1){
                                $arrResponse = array("status"=>true,"msg"=>"Data saved.");
                            }else{
                                $arrResponse = array("status"=>true,"msg"=>"Data updated.");
                            }
                        }else if($request == 'exist'){
                            $arrResponse = array('status' => false, 'msg' => 'This category already exists, try a different one.');		
                        }else{
                            $arrResponse = array("status" => false, "msg" => 'Something went wrong.');
                        }
                    }
                    echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
                }
            }
			die();
		}
        public function delCategoria(){
            if($_SESSION['permitsModule']['d']){
                if($_POST){
                    $id = intval($_POST['id']);
                    $request = $this->model->selectCategoria($id);
                    if($request['picture']!="category.jpg"){
                        deleteFile($request['picture']);
                    }
                    
                    $request = $this->model->deleteCategoria($id);

                    if($request=="ok"){
                        $arrResponse = array("status"=>true,"msg"=>"It has been deleted.");
                    }else if($request =="exist"){
                        $arrResponse = array("status"=>false,"msg"=>"This category has a subcategory set, it can not be deleted.");
                    }else{
                        $arrResponse = array("status"=>false,"msg"=>"Something went wrong.");
                    }
                    echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
                }
            }
            die();
        }
        /*************************SubCategory methods*******************************/
        public function getSubcategorias(){
            if($_SESSION['permitsModule']['r']){
                $intPage = intval($_POST['page']);
                $intPerPage = intval($_POST['per_page']);
                $strSearch = strClean($_POST['search']);
                $request = $this->model->selectSubcategorias($intPage,$intPerPage,$strSearch);
                echo json_encode($request,JSON_UNESCAPED_UNICODE);
            }
            die();
        }
        public function getSubcategoria(){
            if($_SESSION['permitsModule']['r']){
                if($_POST){
                    $idCategory = intval($_POST['id']);
                    $request = $this->model->selectSubcategoria($idCategory);
                    if(!empty($request)){
                        $arrResponse = array("status"=>true,"data"=>$request);
                    }else{
                        $arrResponse = array("status"=>false,"msg"=>"Something went wrong"); 
                    }
                    echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
                }
            }
            die();
        }
        public function setSubcategoria(){
            if($_SESSION['permitsModule']['w']){
                if($_POST){
                    $errors = validator()->validate([
                        "name"=>"required",
                        "category"=>"required|numeric"
                    ])->getErrors();
                    if(!empty($errors)){
                        $arrResponse = array("status" => false, "errors" => $errors,"msg"=>"Please, check the fields.");
                    }else{ 
                        $idSubCategory = intval($_POST['id']);
                        $strName = ucwords(strClean($_POST['name']));
                        $status = intval($_POST['status']);
                        $idCategory = intval(strClean($_POST['category']));
                        $route = clear_cadena($strName);
                        $route = strtolower(str_replace("¿","",$route));
                        $route = str_replace(" ","-",$route);
                        $route = str_replace("?","",$route);
                        if($idSubCategory == 0){
                            if($_SESSION['permitsModule']['w']){

                                $option = 1;
                                $request= $this->model->insertSubcategoria($idCategory,$strName,$status, $route);
                            }
                        }else{
                            if($_SESSION['permitsModule']['u']){
                                $option = 2;
                                $request = $this->model->updateSubcategoria($idSubCategory,$idCategory, $strName,$status, $route);
                            }
                        }
                        if(is_numeric($request)){
                            if($option == 1){
                                $arrResponse=array("status"=>true,"msg"=>"Data saved");
                            }else{
                                $arrResponse=array("status"=>true,"msg"=>"Data updated");
                            }
                        }else if($request == 'exist'){
                            $arrResponse = array('status' => false, 'msg' => 'This subcategory already exists, try a different one',"errors" => []);		
                        }else{
                            $arrResponse = array("status" => false, "msg" => 'Something went wrong',"errors" => []);
                        }
                    }
                    echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
                }
            }
			die();
		}
        public function delSubcategoria(){
            if($_SESSION['permitsModule']['d']){
                if($_POST){
                    $id = intval($_POST['id']);
                    $request = $this->model->selectSubcategoria($id);
                    if(!empty($request)){
                        $request = $this->model->deleteSubcategoria($id);
                        if($request=="ok"){
                            $arrResponse = array("status"=>true,"msg"=>"It has been deleted.");
                        }else if($request=="exist"){
                            $arrResponse = array("status"=>false,"msg"=>"The subcategory already has products set. It can not be deleted");
                        }
                        else{
                            $arrResponse = array("status"=>false,"msg"=>"Something went wrong.");
                        }
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