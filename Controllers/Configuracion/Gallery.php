<?php
    class Gallery extends Controllers{

        public function __construct(){
            session_start();
            if(empty($_SESSION['login'])){
                header("location: ".base_url());
                die();
            }
            parent::__construct();
        }
        
        public function gallery(){
            if($_SESSION['permitsModule']['r']){
                $data['botones'] = [
                    "duplicar" => ["mostrar"=>$_SESSION['permitsModule']['r'] ? true : false, "evento"=>"onClick","funcion"=>"mypop=window.open('".BASE_URL.$_SESSION['permitsModule']['route']."','','');mypop.focus();"],
                    "nuevo" => ["mostrar"=>$_SESSION['permitsModule']['w'] ? true : false, "evento"=>"onClick","funcion"=>"addItem()"],
                ];
                $data['page_tag'] = "{$_SESSION['permitsModule']['option']} | {$_SESSION['permitsModule']['module']}}";
                $data['page_title'] = "{$_SESSION['permitsModule']['option']} | {$_SESSION['permitsModule']['module']}";
                $data['page_name'] = "{$_SESSION['permitsModule']['option']} | {$_SESSION['permitsModule']['module']}";
                $data['data'] = $this->getBanners();
                $data['panelapp'] = "/Configuracion/functions_gallery.js";
                $this->views->getView($this,"gallery",$data);
            }else{
                header("location: ".base_url());
                die();
            }
        }
        /*************************Banners methods*******************************/
        public function getBanners($option=null,$params=null){
            if($_SESSION['permitsModule']['r']){
                $html="";
                $request="";
                if($option == 1){
                    $request = $this->model->searchc($params);
                }else if($option == 2){
                    $request = $this->model->sortc($params);
                }else{
                    $request = $this->model->selectBanners();
                }
                if(count($request)>0){
                    for ($i=0; $i < count($request); $i++) { 

                        $btnEdit="";
                        $btnDelete="";
                        $status="";
                        if($request[$i]['status']==1){
                            $status='<span class="badge me-1 bg-success">Active</span>';
                        }else{
                            $status='<span class="badge me-1 bg-danger">Inactive</span>';
                        }

                        if($_SESSION['permitsModule']['u']){
                            $btnEdit = '<button class="btn btn-success m-1" onclick="editItem('.$request[$i]['id'].')"><i class="fas fa-pencil-alt"></i></button>';
                        }
                        if($_SESSION['permitsModule']['d']){
                            $btnDelete = '<button class="btn btn-danger m-1" onclick="deleteItem('.$request[$i]['id'].')" name="btnDelete"><i class="fas fa-trash-alt"></i></button>';
                        }
                        $html.='
                            <tr class="item">
                                <td data-title="Portada">
                                    <img src="'.media()."/images/uploads/".$request[$i]['picture'].'"  class="img-thumbnail" style="width: 50px; height: 50px;">
                                </td>
                                <td data-label="Estado: ">'.$status.'</td>
                                <td class="item-btn">'.$btnEdit.$btnDelete.'</td>
                            </tr>
                        ';
                    }
                    $arrResponse = array("status"=>true,"data"=>$html);
                }else{
                    $html = '<tr><td colspan="11" class="text-center fw-bold">There are not data</td></tr>';
                    $arrResponse = array("status"=>false,"data"=>$html);
                }
            }else{
                header("location: ".base_url());
                die();
            }
            
            return $arrResponse;
        }
        public function getBanner(){
            if($_SESSION['permitsModule']['r']){
                if($_POST){
                    $idBanner = intval($_POST['idBanner']);
                    $request = $this->model->selectBanner($idBanner);
                    if(!empty($request)){
                        $request['picture'] = media()."/images/uploads/".$request['picture'];
                        $arrResponse = array("status"=>true,"data"=>$request);
                    }else{
                        $arrResponse = array("status"=>false,"msg"=>"Something went wrong"); 
                    }
                    
                    echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
                }
            }else{
                header("location: ".base_url());
                die();
            }
            die();
        }
        public function setBanner(){
            if($_SESSION['permitsModule']['r']){
                if($_POST){
                    $idBanner = intval($_POST['idBanner']);
                    $status = intval($_POST['statusList']);
                    $photo = "";
                    $photoCategory="";
                    if($idBanner == 0){
                        if($_SESSION['permitsModule']['w']){
                            $option = 1;

                            if($_FILES['txtImg']['name'] == ""){
                                $photoCategory = "category.jpg";
                            }else{
                                $photo = $_FILES['txtImg'];
                                $photoCategory = 'gallery_'.bin2hex(random_bytes(6)).'.png';
                            }

                            $request= $this->model->insertBanner($photoCategory,$status);
                        }
                    }else{
                        if($_SESSION['permitsModule']['u']){
                            $option = 2;
                            $request = $this->model->selectBanner($idBanner);
                            if($_FILES['txtImg']['name'] == ""){
                                $photoCategory = $request['picture'];
                            }else{
                                if($request['picture'] != "category.jpg"){
                                    deleteFile($request['picture']);
                                }
                                $photo = $_FILES['txtImg'];
                                $photoCategory = 'gallery_'.bin2hex(random_bytes(6)).'.png';
                            }
                            $request = $this->model->updateBanner( $idBanner, $photoCategory, $status );
                        }
                    }
                    if($request > 0 ){
                        if($photo!=""){
                            uploadImage($photo,$photoCategory);
                        }
                        if($option == 1){
                            $arrResponse = $this->getBanners();
                            $arrResponse['msg'] = 'Data saved.';
                        }else{
                            $arrResponse = $this->getBanners();
                            $arrResponse['msg'] = 'Data updated.';
                        }
                    }else if($request == 'exist'){
                        $arrResponse = array('status' => false, 'msg' => 'El banner ya existe, prueba con otro nombre.');		
                    }else{
                        $arrResponse = array("status" => false, "msg" => 'Something went wrong.');
                    }
                }
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            }
			die();
		}
        public function delBanner(){
            if($_SESSION['permitsModule']['d']){

                if($_POST){
                    if(empty($_POST['idBanner'])){
                        $arrResponse=array("status"=>false,"msg"=>"Error de datos");
                    }else{
                        $id = intval($_POST['idBanner']);

                        $request = $this->model->selectBanner($id);
                        if($request['picture']!="category.jpg"){
                            deleteFile($request['picture']);
                        }
                        
                        $request = $this->model->deleteBanner($id);

                        if($request=="ok"){
                            $arrResponse = array("status"=>true,"msg"=>"Deleted.","data"=>$this->getBanners()['data']);
                        }else{
                            $arrResponse = array("status"=>false,"msg"=>"Something went wrong.");
                        }
                    }
                    echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
                }
            }else{
                header("location: ".base_url());
                die();
            }
            die();
        }
    }
?>