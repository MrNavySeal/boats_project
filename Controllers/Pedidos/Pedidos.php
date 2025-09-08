<?php
    class Pedidos extends Controllers{
        public function __construct(){
            session_start();
            if(empty($_SESSION['login'])){
                header("location: ".base_url());
                die();
            }
            parent::__construct();
        }

        public function pedidos(){
            if($_SESSION['permitsModule']['r']){
                $data['botones'] = [
                    "duplicar" => ["mostrar"=>true, "evento"=>"onclick","funcion"=>"mypop=window.open('".BASE_URL.$_SESSION['permitsModule']['route']."','','');mypop.focus();"],
                    "nuevo" => ["mostrar"=>$_SESSION['permitsModule']['w'], "evento"=>"onclick","funcion"=>"window.location.href='".BASE_URL."/orders/pos/'"],
                ];
                $data['page_tag'] = "{$_SESSION['permitsModule']['option']} | {$_SESSION['permitsModule']['module']}";
                $data['page_title'] = "{$_SESSION['permitsModule']['option']} | {$_SESSION['permitsModule']['module']}";
                $data['page_name'] = "{$_SESSION['permitsModule']['option']} | {$_SESSION['permitsModule']['module']}";
                $data['panelapp'] = "/Pedidos/functions_orders.js";
                $this->views->getView($this,"pedidos",$data);
            }else{
                header("location: ".base_url());
                die();
            }
        }
        public function detalle(){
            if($_SESSION['permitsModule']['r']){
                $data['botones'] = [
                    "atras" => ["mostrar"=>true,"evento"=>"onclick","funcion"=>"window.location.href='".BASE_URL."/orders/'"],
                    "duplicar" => ["mostrar"=>true, "evento"=>"onclick","funcion"=>"mypop=window.open('".BASE_URL.$_SESSION['permitsModule']['route']."','','');mypop.focus();"],
                    "nuevo" => ["mostrar"=>$_SESSION['permitsModule']['w'], "evento"=>"onclick","funcion"=>"window.location.href='".BASE_URL."/orders/pos/'"],
                ];
                $data['page_tag'] = implode(" | ",[$_SESSION['permitsModule']['option'],$_SESSION['permitsModule']['module']]);
                $data['page_title'] = implode(" | ",[$_SESSION['permitsModule']['option'],$_SESSION['permitsModule']['module']]);
                $data['page_name'] = strtolower($_SESSION['permitsModule']['option']);
                $data['panelapp'] = "/Pedidos/functions_orders_detail.js";
                $this->views->getView($this,"detalle",$data);
            }else{
                header("location: ".base_url());
                die();
            }
        }
        public function pdf($params){
            if($_SESSION['permitsModule']['r']){
                $data['page_title'] = " Factura de venta No. ".$params." | ".$_SESSION['permitsModule']['module'];
                $data['file_name'] = 'factura_venta_'.$params.'_'.rand()*10;
                $data['data'] = $this->model->selectOrder($params);
                $this->views->getView($this,"pedido-pdf",$data);
            }else{
                header("location: ".base_url());
                die();
            }
        }
        public function getOrders(){
            if($_SESSION['permitsModule']['r']){
                $idPersona = "";
                if($_SESSION['userData']['roleid'] == 2){
                    $idPersona = $_SESSION['idUser'];
                }
                $strSearch = strClean($_POST['search']);
                $intPerPage = intval($_POST['perpage']);
                $intPageNow = intval($_POST['page']);
                $strInitialDate = strClean($_POST['initial_date']);
                $strFinalDate = strClean($_POST['final_date']);
                $strStatusOrder = strClean($_POST['status_order']);
                $strStatusPayment = strClean($_POST['status_payment']);
                $intTotalAmount = 0;
                $intTotalPendent = 0;
                $arrData = $this->model->selectOrders($idPersona,$strSearch,$intPerPage,$intPageNow,$strInitialDate,$strFinalDate,$strStatusPayment);
                $request = $arrData['data'];
                $html ="";
                $htmlTotal="";
                if(count($request)>0){
                    for ($i=0; $i < count($request); $i++) { 
                        $btnView = '<button class="btn btn-info m-1 text-white" type="button" title="Ver" onclick="viewItem('.$request[$i]['idorder'].')"><i class="fas fa-eye"></i></button>';
                        $btnWpp="";
                        $btnPdf='<a href="'.base_url().'/pedidos/factura/'.$request[$i]['idorder'].'" target="_blank" class="btn btn-primary text-white m-1" type="button" title="Imprimir factura"><i class="fas fa-print"></i></a>';
                        $btnPaypal='';
                        $btnDelete ="";
                        $btnEdit ="";
                        $status="";
                        $statusOrder="";
                        
                        if($request[$i]['status'] =="pendent"){
                            $status = '<span class="badge bg-warning text-black">pendent</span>';
                        }else if($request[$i]['status'] =="approved"){
                            $status = '<span class="badge bg-success text-white">approved</span>';
                        }else if($request[$i]['status'] =="canceled"){
                            $status = '<span class="badge bg-danger text-white">canceled</span>';
                        }
                        
                        if($_SESSION['permitsModule']['d'] && $request[$i]['status'] !="canceled"){
                            $btnDelete = '<button class="btn btn-danger m-1 text-white" type="button" title="Anular" onclick="deleteItem('.$request[$i]['idorder'].')" ><i class="fas fa-trash-alt"></i></button>';
                        }
                        if($_SESSION['permitsModule']['u'] && $request[$i]['status'] !="canceled"){
                            $btnEdit = '<button class="btn btn-success text-white m-1" type="button" title="Editar" onclick="editItem('.$request[$i]['idorder'].')"><i class="fas fa-pencil-alt"></i></button>';
                        }
                        if($_SESSION['userData']['roleid'] != 2){
                            $btnWpp='<a href="https://wa.me/57'.$request[$i]['phone'].'?text=Buen%20dia%20'.$request[$i]['name'].'" class="btn btn-success text-white m-1" type="button" title="Whatsapp" target="_blank"><i class="fab fa-whatsapp"></i></a>';
                        }
                        $request[$i]['format_amount'] = formatNum($request[$i]['amount']);
                        $request[$i]['statusval'] =  $request[$i]['status'];
                        $request[$i]['status'] = $status;
                        $request[$i]['statusorderval'] =  $request[$i]['statusorder'];
                        $request[$i]['format_pendent'] = formatNum($request[$i]['total_pendent']);
                        $request[$i]['actual_user'] = $_SESSION['userData']['firstname']." ".$_SESSION['userData']['lastname'];
                        $request[$i]['id_actual_user'] = $_SESSION['userData']['idperson'];
                        $pro = $request[$i];
                        $html.='
                            <tr>
                                <td data-title="ID" class="text-center">'.$pro['idorder'].'</td>
                                <td data-title="Transaction" class="text-center">'.$pro['idtransaction'].'</td>
                                <td data-title="Date" class="text-center">'.$pro['date'].'</td>
                                <td data-title="Name">'.$pro['name'].'</td>
                                <td data-title="Email">'.$pro['email'].'</td>
                                <td data-title="Phone">'.$pro['phone'].'</td>
                                <td data-title="ID number">'.$pro['identification'].'</td>
                                <td data-title="Payment" class="text-center">'.$pro['type'].'</td>
                                <td data-title="Total" class="text-end">'.$pro['format_amount'].'</td>
                                <td data-title="Status" class="text-center">'.$status.'</td>
                                <td data-title="Options"><div class="d-flex">'.$btnView.$btnWpp.$btnDelete.'</div></td>
                            </tr>
                        ';
                    }
                    foreach ($arrData['full_data'] as $data) {
                        $intTotalPendent += $data['total_pendent'];
                        $intTotalAmount +=$data['amount'];
                    }
                    $htmlTotal='
                        <tr class="fw-bold text-end">
                            <td data-title="Total">'.formatNum($intTotalAmount).'</td>
                            <td data-title="Total pendiente">'.formatNum($intTotalPendent).'</td>
                        </tr>
                    ';
                }
                $arrData['html'] = $html;
                $arrData['html_total'] = $htmlTotal;
                $arrData['html_pages'] = getPagination($intPageNow,$arrData['start_page'],$arrData['total_pages'],$arrData['limit_page']);
                $arrData['data'] = $request;
                $arrData['total_amount']= $intTotalAmount;
                $arrData['total_pendent'] = $intTotalPendent;
                echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
            }
            die();
        }
        public function delOrder(){
            if($_SESSION['permitsModule']['d']){
                if($_POST){
                    if(empty($_POST['id'])){
                        $arrResponse=array("status"=>false,"msg"=>"Something went wrong");
                    }else{
                        $id = intval($_POST['id']);
                        $request = $this->model->deleteOrder($id);
                        if($request > 0){
                            $arrResponse = array("status"=>true,"msg"=>"The bill was disabled.");
                        }else{
                            $arrResponse = array("status"=>false,"msg"=>"Something went wrong.");
                        }
                    }
                    echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
                }
            }
            die();
        }
        /*******************Advance**************************** */
        public function setAdvance(){
            if($_SESSION['permitsModule']['u']){
                if($_POST){
                    if(empty($_POST['id'])){
                        $arrResponse=array("status"=>false,"msg"=>"Error de datos");
                    }else{
                        $id = intval($_POST['id']);
                        $data = json_decode($_POST['data'],true);
                        $isSuccess = intval($_POST['is_success']);
                        if(is_array($data)){
                            $request = $this->model->insertAdvance($id,$data,$isSuccess);
                            if($request>0){
                                $arrResponse = array("status"=>true,"msg"=>"La factura ha sido abonada correctamente.");
                            }else{
                                $arrResponse = array("status"=>false,"msg"=>"No es posible abonar, intenta de nuevo.");
                            }
                        }else{
                            $arrResponse = array("status"=>false,"msg"=>"El tipo de dato es incorrecto.");
                        }
                    }
                    echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
                }
            }
            die();
        }
    }
?>