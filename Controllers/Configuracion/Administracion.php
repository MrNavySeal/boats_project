<?php
    class Administracion extends Controllers{
        public function __construct(){
            session_start();
            if(empty($_SESSION['login'])){
                header("location: ".base_url());
                die();
            }
            parent::__construct();
        }

        /*************************Views*******************************/
        
        public function mensajes(){
            if($_SESSION['permitsModule']['r']){
                $data['botones'] = [
                    "duplicar" => ["mostrar"=>$_SESSION['permitsModule']['r'] ? true : false, "evento"=>"onClick","funcion"=>"mypop=window.open('".BASE_URL.$_SESSION['permitsModule']['route']."','','');mypop.focus();"],
                ];
                $data['tipo_pagina']=3;
                $data['page_tag'] = "{$_SESSION['permitsModule']['option']}";
                $data['page_title'] = "{$_SESSION['permitsModule']['option']}";
                $data['page_name'] = "{$_SESSION['permitsModule']['option']}";
                $data['panelapp'] = "/Configuracion/functions_contacto.js";
                $this->views->getView($this,"mensajes",$data);
            }else{
                header("location: ".base_url());
                die();
            }
        }
        public function message($params){
            if($_SESSION['permitsModule']['r']){
                if(is_numeric($params)){
                    $id = intval($params);
                    $data['botones'] = [
                        "atras" => ["mostrar"=>true, "evento"=>"onclick","funcion"=>"window.location.href='".BASE_URL.$_SESSION['permitsModule']['route']."'"],
                        "duplicar" => ["mostrar"=>true, "evento"=>"onClick","funcion"=>"mypop=window.open('".BASE_URL.$_SESSION['permitsModule']['route']."message/".$id."','','');mypop.focus();"],
                    ];
                    $data['tipo_pagina']=1;
                    $data['id'] = $id;
                    $data['page_tag'] = "Mensaje";
                    $data['page_title'] = "Mensaje";
                    $data['page_name'] = "mensaje";
                    $data['panelapp'] = "/Configuracion/functions_contacto.js";
                    $this->views->getView($this,"mensaje",$data);
                }else{
                    header("location: ".base_url()."/mensajes");
                    die();
                }
            }else{
                header("location: ".base_url());
                die();
            }
        }
        public function sent($params){
            if($_SESSION['permitsModule']['r']){
                if(is_numeric($params)){
                    $id = intval($params);
                    $data['botones'] = [
                        "atras" => ["mostrar"=>true, "evento"=>"onclick","funcion"=>"window.location.href='".BASE_URL.$_SESSION['permitsModule']['route']."'"],
                        "duplicar" => ["mostrar"=>true, "evento"=>"onClick","funcion"=>"mypop=window.open('".BASE_URL.$_SESSION['permitsModule']['route']."/sent/".$id."','','');mypop.focus();"],
                    ];
                    $data['message'] = $this->model->selectSentMail($id);
                    $data['page_tag'] = "Enviados";
                    $data['page_title'] = "Enviados";
                    $data['page_name'] = "enviados";
                    $this->views->getView($this,"enviado",$data);
                }else{
                    header("location: ".base_url()."/mensajes");
                    die();
                }
            }else{
                header("location: ".base_url());
                die();
            }
        }
        public function suscriptores(){
            if($_SESSION['permitsModule']['r']){
                $data['botones'] = [
                    "duplicar" => ["mostrar"=>true, "evento"=>"onclick","funcion"=>"mypop=window.open('".BASE_URL.$_SESSION['permitsModule']['route']."','','');mypop.focus();"],
                ];
                $data['page_tag'] = "Suscriptores";
                $data['page_title'] = "Suscriptores";
                $data['page_name'] = "suscriptores";
                $data['subscribers'] = $this->model->selectSubscribers();
                $this->views->getView($this,"suscriptores",$data);
            }else{
                header("location: ".base_url());
                die();
            }
        }
        public function envios(){
            if($_SESSION['permitsModule']['r']){
                $data['botones'] = [
                    "duplicar" => ["mostrar"=>true, "evento"=>"onclick","funcion"=>"mypop=window.open('".BASE_URL.$_SESSION['permitsModule']['route']."','','');mypop.focus();"],
                ];
                $data['page_tag'] = "{$_SESSION['permitsModule']['option']} | {$_SESSION['permitsModule']['module']}}";
                $data['page_title'] = "{$_SESSION['permitsModule']['option']} | {$_SESSION['permitsModule']['module']}";
                $data['page_name'] = "{$_SESSION['permitsModule']['option']} | {$_SESSION['permitsModule']['module']}";
                $data['countries'] = $this->model->selectCountries();
                $data['ShippingCities'] = $this->getShippingCities();
                $data['flat'] = $this->model->selectFlatRate();
                $data['panelapp'] = "/Configuracion/functions_shipping.js";
                $this->views->getView($this,"envios",$data);
            }else{
                header("location: ".base_url());
                die();
            }
        }
        
        /*************************Mailbox methods*******************************/
        
        public function getBuscar(){
            if($_SESSION['permitsModule']['r']){
                if($_POST){
                    $intPorPagina = intval($_POST['paginas']);
                    $intPaginaActual = intval($_POST['pagina']);
                    $strBuscar = clear_cadena(strClean($_POST['buscar']));
                    $strTipoBusqueda = strtolower(strClean($_POST['tipo_busqueda']));
                    if($strTipoBusqueda == "recibidos"){
                        $request = $this->model->selectMensajes($intPorPagina,$intPaginaActual, $strBuscar);
                    }else{
                        $request = $this->model->selectEnviados($intPorPagina,$intPaginaActual, $strBuscar);
                    }
                    if(!empty($request)){
                        foreach ($request['data'] as &$data) { 
                            if(isset($data['image'])){ $data['url'] = media()."/images/uploads/".$data['image'];}
                            $data['read'] = $_SESSION['permitsModule']['r'];
                            $data['edit'] = $_SESSION['permitsModule']['u'];
                            $data['delete'] = $_SESSION['permitsModule']['d'];
                        }
                    }
                    echo json_encode($request,JSON_UNESCAPED_UNICODE);
                }
            }
            die();
        }
        public function setMensaje(){
            if($_SESSION['permitsModule']['w']){
                if($_POST){
                    if((empty($_POST['mensaje']) ||  empty($_POST['correo'])) && $_POST['id'] == "0" ){
                        $arrResponse = array("status"=>false,"msg"=>"Something went wrong");
                    }else if(empty($_POST['mensaje'])  && $_POST['id'] == "0" ){
                        $arrResponse = array("status"=>false,"msg"=>"Something went wrong");
                    }else{
                        $intId = intval($_POST['id']);
                        $strMessage = strClean($_POST['mensaje']);
                        $strEmail = strClean(strtolower($_POST['correo']));
                        $strEmailCC = strClean(strtolower($_POST['correo_copia']));
                        $strSubject ="";
                        if($intId == 0){
                            $strSubject = $_POST['asunto'] !="" ? strClean(($_POST['asunto'])) : "You has sent a message.";
                            $request = $this->model->insertMessage($strSubject,$strEmail,$strMessage);
                        }else{
                            $strSubject = "Respondiendo tu mensaje.";
                            $arrMensaje =  $this->model->selectMail($intId);
                            $strEmail = $arrMensaje['email'];
                            $strEmailCC ="";
                            $request = $this->model->updateMessage($strMessage,$intId);
                        }
                        $company = getCompanyInfo();
                        if($request>0){
                            $dataEmail = array('email_remitente' => $company['email'], 
                                                    'email_copia'=>$strEmailCC,
                                                    'email_usuario'=>$strEmail,
                                                    'asunto' =>$strSubject,
                                                    'company'=>$company,
                                                    "message"=>$strMessage);
                            sendEmail($dataEmail,'email_sent');
                            $arrResponse = array("status"=>true,"msg"=>"Message has sent."); 
                        }else{
                            $arrResponse = array("status"=>false,"msg"=>"Something went wrong.");
                        }
                    }
                    echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
                }   
            }
            die();
        }
        public function getMensaje(){
            if($_SESSION['permitsModule']['r']){
                if($_POST){
                    $intId = intval($_POST['id']);
                    $request = $this->model->selectMail($intId);
                    if(!empty($request)){
                        $arrResponse = array("status"=>true,"data"=>$request);
                    }else{
                        $arrResponse = array("status"=>false,"msg"=>"Data did not found");
                    }
                    echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
                }
            }
            die();
        }
        public function delDatos(){
            if($_SESSION['permitsModule']['d']){
                if($_POST){
                    $id = intval($_POST['id']);
                    $option = strtolower(strClean($_POST['tipo_busqueda']));
                    
                    $request = $this->model->delEmail($id,$option);
                    
                    if($request=="ok"){
                        $arrResponse = array("status"=>true,"msg"=>"Message has been deleted."); 
                    }else{
                        $arrResponse = array("status"=>false,"msg"=>"Something went wrong.");
                    }
                }
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            }
            die();
        }
        /*************************Shipping methods*******************************/
        public function setShippingMode(){
            if($_SESSION['permitsModule']['u']){
                if($_POST){
                    $idShipping = intval($_POST['idShipping']);
                    if($idShipping == 2 && empty($_POST['intValue'])){
                        $arrResponse = array("status"=>false,"msg"=>"Error de datos");
                    }else{
                        $value = !empty($_POST['intValue']) ? intval($_POST['intValue']) : 0;
                        $request = $this->model->setShippingMode($idShipping, $value);
                        $arrResponse = array("status"=>true,"msg"=>"Se ha guardado la configuración de envío.");
                    }
                    echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
                }
            }
            die();
        }
        public function setShippingCity(){
            if($_SESSION['permitsModule']['w']){
                if($_POST){
                    if(empty($_POST['idCountry']) || empty($_POST['idState']) || empty($_POST['idCity']) || empty($_POST['value'])){
                        $arrResponse = array("status"=>false,"msg"=>"Error de datos");
                    }else{
                        $idCountry = intval($_POST['idCountry']);
                        $idState = intval($_POST['idState']);
                        $idCity = intval($_POST['idCity']);
                        $value = intval($_POST['value']);
                        $request = $this->model->setShippingCity($idCountry,$idState,$idCity,$value);
                        if($request>0){
                            $html = $this->getShippingCities();
                            $arrResponse = array("status"=>true,"html"=>$html);
                        }else if($request = "exists"){
                            $arrResponse = array("status"=>false,"msg"=>"Ya existe, intenta con otro."); 
                        }else{
                            $arrResponse = array("status"=>false,"msg"=>"Error, intenta de nuevo."); 
                        }
                    }
                    echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
                }
            }
            die();
        }
        public function getShippingCities(){
            if($_SESSION['permitsModule']['r']){
                $request = $this->model->selectShippingCities();
                //dep($request);exit;
                $html="";
                if(!empty($request)){
                    for ($i=0; $i < count($request); $i++) { 
                        $delete = "";
                        if($_SESSION['permitsModule']['d']){
                            $delete = '<td><button type="button" class="btn btn-sm btn-danger text-white" onclick="deleteCityShipp('.$request[$i]['id'].')"><i class="fas fa-trash-alt" aria-hidden="true"></i></button></td>';
                        }
                        $html.= '
                        <tr>
                            <td>'.$request[$i]['country'].'</td>
                            <td>'.$request[$i]['state'].'</td>
                            <td>'.$request[$i]['city'].'</td>
                            <td>'.formatNum($request[$i]['value']).'</td>
                            '.$delete.'
                        </tr>
                        ';
                    }   
                }
            }
            return $html;
        }
        public function getSelectCountry($id){
            $request = $this->model->selectStates($id);
            $html='<option selected value="0">Select</option>';
            for ($i=0; $i < count($request) ; $i++) { 
                $html.='<option value="'.$request[$i]['id'].'">'.$request[$i]['name'].'</option>';
            }
            echo json_encode($html,JSON_UNESCAPED_UNICODE);
            die();
        }
        public function delShippingCity($id){
            if($_SESSION['permitsModule']['d']){
                $id = intval($id);
                $request = $this->model->delShippingCity($id);
                if($request=="ok"){
                    $html = $this->getShippingCities();
                    $arrResponse = array("status"=>true,"html"=>$html); 
                }else{
                    $arrResponse = array("status"=>false,"msg"=>"Error, try again."); 
                }
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            }
            die();
        }
        public function getSelectState($id){
            $request = $this->model->selectCities($id);
            $html='<option selected value="0">Select</option>';
            for ($i=0; $i < count($request) ; $i++) { 
                $html.='<option value="'.$request[$i]['id'].'">'.$request[$i]['name'].'</option>';
            }
            echo json_encode($html,JSON_UNESCAPED_UNICODE);
            die();
        }

        /*************************Pages methods*******************************/
        public function updatePage(){
            if($_SESSION['permitsModule']['u']){
                if($_POST){
                    if(empty($_POST['txtDescription']) || empty($_POST['txtName'])){
                        $arrResponse = array("status"=>false,"msg"=>"Error de datos");
                    }else{
                        $id = intval($_POST['idPage']);
                        $strDescription = $_POST['txtDescription'];
                        $strName = strClean($_POST['txtName']);
                        $request = $this->model->updatePage($id,$strName,$strDescription);

                        if($request>0){
                            $arrResponse = array("status"=>true,"msg"=>"Página actualizada."); 
                        }else{
                            $arrResponse = array("status"=>false,"msg"=>"La página no se puede actualizar, inténtelo de nuevo.");
                        }
                    }
                    echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
                }
            }
            die();
        }
    }
?>