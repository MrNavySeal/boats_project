<?php
    class Citas extends Controllers{
        public function __construct(){
            session_start();
            if(empty($_SESSION['login'])){
                header("location: ".base_url());
                die();
            }
            parent::__construct();
        }

        public function citas(){
            if($_SESSION['permitsModule']['r']){
                $data['botones'] = [
                    "duplicar" => ["mostrar"=>$_SESSION['permitsModule']['r'] ? true : false, "evento"=>"onClick","funcion"=>"mypop=window.open('".BASE_URL."/casos"."','','');mypop.focus();"],
                    "nuevo" => ["mostrar"=>$_SESSION['permitsModule']['w'] ? true : false, "evento"=>"@click","funcion"=>"showModal()"],
                ];
                $data['page_tag'] = "{$_SESSION['permitsModule']['option']} | {$_SESSION['permitsModule']['module']}}";
                $data['page_title'] = "{$_SESSION['permitsModule']['option']} | {$_SESSION['permitsModule']['module']}";
                $data['page_name'] = "{$_SESSION['permitsModule']['option']} | {$_SESSION['permitsModule']['module']}";
                $data['panelapp'] = "/Servicios/functions_citas.js";
                $this->views->getView($this,"citas",$data);
                //dep($data);exit;
            }else{
                header("location: ".base_url());
                die();
            }
        }
        public function transaccion($idTransaction){
            if($_SESSION['permitsModule']['r']){
                $idPerson ="";
                if($_SESSION['userData']['roleid'] == 2){
                    $idPerson= $_SESSION['idUser'];
                }
                $data['transaction'] = $this->model->selectTransaction($idTransaction,$idPerson);
                $data['page_tag'] = "Transacción";
                $data['page_title'] = "Transacción | Pedidos";
                $data['page_name'] = "transaccion";
                $data['panelapp'] = "functions_orders.js";
                $this->views->getView($this,"transaccion",$data);
                
            }else{
                header("location: ".base_url());
                die();
            }
        }
        public function pdf($params){
            if($_SESSION['permitsModule']['r']){
                $data['page_title'] = " Factura de venta No. ".$params." | "."Pedidos";
                $data['file_name'] = 'factura_venta_'.$params.'_'.rand()*10;
                $data['data'] = $this->model->selectOrder($params);
                $this->views->getView($this,"pedido-pdf",$data);
            }else{
                header("location: ".base_url());
                die();
            }
        }
        public function setCaso(){
            if($_SESSION['permitsModule']['r']){
                if($_POST){
                    if(empty($_POST['servicio']) || empty($_POST['cliente']) || empty($_POST['fecha']) || empty($_POST['hora']) || empty($_POST['valor_base'])){
                        $arrResponse = array("status" => false, "msg" => 'Los campos con (*) son obligatorios.');
                    }else{ 
                        
                        $intId = intval($_POST['id']);
                        $intServicio = intval($_POST['servicio']);
                        $intCliente = intval($_POST['cliente']);
                        $strHora = strClean($_POST['hora']);
                        $strFecha = strClean($_POST['fecha']);
                        $strEstado = strtolower(strClean($_POST['estado']));
                        $intValorBase = doubleval($_POST['valor_base']);
                        if($intId == 0){
                            if($_SESSION['permitsModule']['w']){
                                $option = 1;
                                $request= $this->model->insertCaso($intServicio,$intCliente,$strHora,$strFecha,$intValorBase,$strEstado);
                            }
                                
                        }else{
                            if($_SESSION['permitsModule']['u']){
                                $option = 2;
                                $request = $this->model->updateCaso($intId,$intServicio,$intCliente,$strHora,$strFecha,$intValorBase,$strEstado);
                            }
                        }

                        if($request > 0 ){
                            if($option == 1){ 
                                $arrResponse = array('status' => true, 'msg' => 'Datos guardados');	
                                $company = getCompanyInfo();
                                $arrCaso = $this->model->selectCaso($request);
                                $arrCaso['url'] =base_url()."/pago/pago/".setEncriptar($arrCaso['idorder']);
                                $arrCaso['total'] = $arrCaso['value_target'];
                                $arrEmailOrden = array(
                                    'asunto' => "Continua con el pago!",
                                    'email_usuario' => $arrCaso['cliente']['email'], 
                                    'email_remitente'=>$company['email'],
                                    'company'=>$company,
                                    'email_copia' => $company['secondary_email'],
                                    'order' => $arrCaso);
                                try {sendEmail($arrEmailOrden,'email_order_caso');} catch (Exception $e) {}
                            }else{ $arrResponse = array('status' => true, 'msg' => 'Datos actualizados'); }
                        }else{
                            $arrResponse = array("status" => false, "msg" => 'No es posible guardar los datos.');
                        }
                    }
                    echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
                }
            }
			die();
		}
        public function delDatos(){
            if($_SESSION['permitsModule']['d']){
                if($_POST){
                    $intId = intval($_POST['id']);
                    $request = $this->model->deleteCaso($intId);
                    if($request > 0 || $request == "ok"){
                        $arrResponse = array("status"=>true,"msg"=>"Se ha eliminado correctamente.");
                    }else{
                        $arrResponse = array("status"=>false,"msg"=>"No es posible eliminar, intenta de nuevo.");
                    }
                    echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
                }
            }
            die();
        }
        public function getDatos(){
            if($_SESSION['permitsModule']['r']){
                if($_POST){
                    $intId = intval($_POST['id']);
                    $request = $this->model->selectCaso($intId);
                    if(!empty($request)){
                        $arrResponse = array("status"=>true,"data"=>$request);
                    }else{
                        $arrResponse = array("status"=>false,"msg"=>"Error, intenta de nuevo"); 
                    }
                    echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
                }
            }
            die();
        }
        public function getBuscar(){
            if($_SESSION['permitsModule']['r']){
                if($_POST){
                    $intPorPagina = intval($_POST['paginas']);
                    $intPaginaActual = intval($_POST['pagina']);
                    $strBuscar = clear_cadena(strClean($_POST['buscar']));
                    $strTipoBusqueda = clear_cadena(strClean($_POST['tipo_busqueda']));
                    if($strTipoBusqueda == "casos"){
                        $request = $this->model->selectCasos($intPorPagina,$intPaginaActual, $strBuscar);
                    }else if($strTipoBusqueda == "servicios"){
                        $request = $this->model->selectServicios($intPorPagina,$intPaginaActual, $strBuscar);
                    }else if($strTipoBusqueda == "clientes"){
                        $request = $this->model->selectClientes($intPorPagina,$intPaginaActual, $strBuscar);
                    }
                    if(!empty($request)){
                        foreach ($request['data'] as &$data) { 
                            if(isset($data['picture'])){ $data['url'] = media()."/images/uploads/".$data['picture'];}
                            $data['id_encrypt'] = setEncriptar($data['idorder']);
                        }
                    }
                    echo json_encode($request,JSON_UNESCAPED_UNICODE);
                }
            }
            die();
        }
        public function getDatosIniciales(){
            if($_SESSION['permitsModule']['r']){
                echo json_encode(['currency'=>getCompanyInfo()['currency']['code'],"status"=>STATUS],JSON_UNESCAPED_UNICODE);
            }
            die();
        }
    }
?>