<?php
    
    require_once("Models/ProductTrait.php");
    require_once("Models/CustomerTrait.php");
    require_once("Models/LoginModel.php");
    class Pago extends Controllers{
        use ProductTrait, CustomerTrait;
        private $login;
        public function __construct(){
            session_start();
            parent::__construct();
            sessionCookie();
            $this->login = new LoginModel();
        }

        /******************************Views************************************/
        public function servicio($params){
            $company=getCompanyInfo();
            if($params !=""){
                $intId = setDesencriptar($params);
                $request = $this->selectCaso($intId);
                if(!empty($request) && $request['status'] != "approved"){
                    $data['id_encrypt'] = $params;
                    $data['company'] = $company;
                    $data['page_tag'] = $company['name'];
                    $data['page_title'] = "Checkout | ".$company['name'];
                    $data['page_name'] = "Checkout";
                    $data['data'] = $request;
                    $data['app'] = "functions_pago.js";
                    $this->views->getView($this,"servicio",$data);
                }else{
                    header("location: ".BASE_URL."/errors");
                    die();
                }
            }else{
                header("location: ".BASE_URL."/errors");
                die();
            }
        }
        public function pago(){
            if(isset($_SESSION['login']) && isset($_SESSION['arrCart']) && !empty($_SESSION['arrCart'])){
                $company=getCompanyInfo();
                $data['page_tag'] = $company['name'];
                $data['page_title'] ="Pago | ".$company['name'];
                $data['page_name'] = "pago";
                $data['credentials'] = getCredentials();
                $data['company'] = getCompanyInfo();
                $data['shipping'] = $this->selectShippingMode();
                $data['app'] = "functions_checkout.js";
                if(isset($_GET['situ'])){
                    $situ = strtolower(strClean($_GET['situ']));
                    if($situ != "true" && $situ != "false"){
                        header("location: ".base_url()."/pago");
                        die();
                    }else if($situ =="true"){
                        $data['shipping'] = array("id"=>4,"value"=>0);
                    }else if($situ =="false"){
                        if($data['shipping']['id'] == 3 && !isset($_SESSION['shippingcity'])){
                            header("location: ".base_url()."/carrito");
                            die();
                        }
                    }
                }else if($data['shipping']['id'] == 3 && !isset($_SESSION['shippingcity'])){
                    header("location: ".base_url()."/carrito");
                     die();
                }
                
                if(isset($_GET['cupon'])){
                    $cupon = strtoupper(strClean($_GET['cupon']));
                    $cuponData = $this->selectCouponCode($cupon);
                    if(!empty($cuponData)){
                        $data['cupon'] = $cuponData;
                        $data['cupon']['check'] = $this->checkCoupon($_SESSION['idUser'],$data['cupon']['id']);
                    }else{
                        header("location: ".base_url()."/pago");
                        die();
                    }
                }
                
                $this->views->getView($this,"pago",$data); 
            }else{
                header("location: ".base_url());
                die();
            }
        }
        public function confirmar(){
            if(isset($_SESSION['orderDataInfo'])){
                $company=getCompanyInfo();
                $data['page_tag'] = $company['name'];
                $data['page_title'] ="Order approved | ".$company['name'];
                $data['page_name'] = "approved";
                $arrData = $_SESSION['orderDataInfo'];
                $arrData['transaction'] = strClean($_SESSION['orderDataInfo']['transaction']);
                $arrData['status'] = strClean($_GET['status']);
                $arrData['type'] = strClean($_GET['payment_type']);
                $orderData = $this->setOrder($arrData);
                $data['orderData'] = $orderData;
                unset($_SESSION['orderDataInfo']);
                $this->views->getView($this,"confirmar",$data); 
            }else{
                header("location: ".base_url());
                die();
            }
        }
        public function error(){
            $company=getCompanyInfo();
            $data['page_tag'] = $company['name'];
            $data['page_title'] ="Error | ".$company['name'];
            $data['page_name'] = "Error";
            $this->views->getView($this,"error",$data); 
        }
        public function getTotal(){
            $arrProducts = $_SESSION['arrCart'];
            $arrData = $this->calcTotalCart($arrProducts);
            echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
        }
        public function calcTotalCart($arrProducts,$code=null,$city=null,$situ=true){
            $arrShipping = $this->selectShippingMode();
            $total=0;
            $subtotal=0;
            $shipping =0;
            $cupon = 0;
            $status = true;
            $discount=0;
            $arrCupon = array();
            for ($i=0; $i < count($arrProducts) ; $i++) { 
                if($arrProducts[$i]['topic'] == 2){
                    if($arrProducts[$i]['producttype'] == 2){
                        $subtotal+=$arrProducts[$i]['qty']*$arrProducts[$i]['variant']['price'];
                    }else{
                        $subtotal+=$arrProducts[$i]['qty']*$arrProducts[$i]['price'];
                    }
                }else{
                    $subtotal += $arrProducts[$i]['price']*$arrProducts[$i]['qty']; 
                }
            }
            if($arrShipping['id'] != 3){
                $shipping = $arrShipping['value'];
            }
            $shipping = $situ == "true" ? 0 : $shipping;
            $total = $subtotal + $shipping;
            if($code != ""){
                $arrCupon = $this->selectCouponCode($code);
                $status = $this->checkCoupon($_SESSION['idUser'],$arrCupon['id']);
                if(!$status){
                    $discount=$subtotal*($arrCupon['discount']/100);
                    $cupon = $subtotal-$discount;
                    $total =$cupon + $shipping;
                    $this->setCoupon($arrCupon['id'],$_SESSION['idUser'],$code);
                }else{
                    $arrCupon = array();
                }
            }
            $arrData = array("total"=>$total,"discount"=>$discount,"cupon"=>$cupon,"arrcupon"=>$arrCupon,"subtotal"=>$subtotal,"status"=>$status);
            return $arrData;
        }
        public function calculateShippingCity(){
            if($_POST){
                $arrProducts = $_SESSION['arrCart'];
                $city = intval($_POST['city']);
                $code = strClean($_POST['cupon']);
                $arrData = $this->calcTotalCart($arrProducts,$code,$city);
                $arrData['subtotal'] = formatNum($arrData['subtotal']);
                $arrData['total'] = formatNum($arrData['total']);
                $arrData['cupon'] = formatNum($arrData['cupon']); 
                echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
            }
            die();
        }
        /******************************Checkout methods************************************/
        public function checkInfo(){
            if($_POST){
                if(empty($_POST['txtNameOrder']) || empty($_POST['txtLastNameOrder']) || empty($_POST['txtEmailOrder'])
                || empty($_POST['txtPhoneOrder']) || empty($_POST['txtAddressOrder']) || empty($_POST['listCountry']) ||
                empty($_POST['listState']) || empty($_POST['listCity']) || empty($_POST['txtDocument'])){
                    $arrResponse = array("status"=>false,"msg"=>"Error de datos");
                }else{
                    $objPaypal = json_decode($_POST['data']);
                    if(is_object($objPaypal)){
                        $strName = strClean(ucwords($_POST['txtNameOrder']));
                        $strLastName = strClean(ucwords($_POST['txtLastNameOrder']));
                        $strEmail = strClean(strtolower($_POST['txtEmailOrder']));
                        $strPhone = strClean($_POST['txtPhoneOrder']);
                        $strAddress = strClean($_POST['txtAddressOrder']);
                        $strCountry = strClean($_POST['country']);
                        $strState = strClean($_POST['state']);
                        $strCity = strClean($_POST['city']);
                        $cupon = strtoupper(strClean($_POST['cupon']));
                        $strPostal = strClean($_POST['txtPostCodeOrder']);
                        $strNote = strClean($_POST['txtNote']);
                        $strDocument = strClean($_POST['txtDocument']);
                        $situ = strtolower(strClean($_POST['situ']));
                        $strAddress = $strAddress.", ".$strCity."/".$strState."/".$strCountry." ".$strPostal;
                        $strName = $strName." ".$strLastName;
                        $strTransaccion = $objPaypal->purchase_units[0]->payments->captures[0]->id;
    
                        $_SESSION['orderDataInfo'] = array(
                            "name"=>$strName,
                            "email"=>$strEmail,
                            "phone"=>$strPhone,
                            "address"=>$strAddress,
                            "note"=>$strNote,
                            "cupon"=>$cupon,
                            "situ"=>$situ,
                            "document"=>$strDocument,
                            "city"=>$strCity,
                            "transaction"=>$strTransaccion
                        );
                        $arrResponse = array("status"=>true,"msg"=>"Datos guardados");
                    }else{
                        $arrResponse = array("status"=>false,"msg"=>"Something went wrong, please try again.");
                    }
                }
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            }
            die();
        }
        public function setOrder($arrData){
            $total = 0;
            $arrTotal = array();
            $idUser = $_SESSION['idUser'];
            $strName = $arrData['name'];
            $strDocument = $arrData['document'];
            $strEmail = $arrData['email'];
            $strPhone = $arrData['phone'];
            $strCity = $arrData['city'];
            $strAddress = $arrData['address'];
            $cupon = $arrData['cupon'];
            $strNote = $arrData['note'];
            $status = $arrData['status']!="" ? $arrData['status'] : "approved";
            $idTransaction =$arrData['transaction'];
            $type ="paypal";
            $situ = $arrData['situ'];
            $envio = 0;
            $statusOrder ="confirmado";
            $arrProducts = $_SESSION['arrCart'];
            $arrTotal = $this->calcTotalCart($arrProducts,$cupon,null,$situ);
            $cupon = $arrTotal['discount'];
            $total = $arrTotal['total'];

            if($type==""){
                $status = "approved";
            }

            $arrShipping = $this->selectShippingMode();
            if($arrShipping['id']<3){
                $envio = $arrShipping['value'];
            }else if($arrShipping['id']==3){
                $envio = $_SESSION['shippingcity'];
            }
            if($situ =="true"){
                $envio = 0;
            }
            //$total +=$envio;
            $request = $this->insertOrder($idUser, $idTransaction,$strName,$strDocument,$strEmail,$strPhone,$strAddress,$strNote,$cupon,$envio,$total,$status,$type,$statusOrder);          
            if($request>0){
                $arrOrder = array(
                    "idorder"=>$request,
                    "iduser"=>$_SESSION['idUser'],
                    "products"=>$_SESSION['arrCart'],
                    "city"=>$strCity,
                    "name"=>$strName
                );
                $requestDetail = $this->insertOrderDetail($arrOrder);
                $orderInfo = $this->getOrder($request);
                $company = getCompanyInfo();
                /* $dataEmailOrden = array(
                    'asunto' => "Se ha generado un pedido",
                    'email_usuario' => $strEmail, 
                    'email_remitente'=>$company['email'],
                    'company'=>$company,
                    'email_copia' => $company['secondary_email'],
                    'order' => $orderInfo);

                try {sendEmail($dataEmailOrden,'email_order');} catch (Exception $e) {} */
                $idOrder = openssl_encrypt($request,METHOD,KEY);
                $idTransaction = openssl_encrypt($orderInfo['order']['idtransaction'],METHOD,KEY);
                $orderData = array("order"=>$idOrder,"transaction"=>$idTransaction);
                unset($_SESSION['arrCart']);
                unset($_SESSION['shippingcity']);
            }
            return $orderData;
        }
        public function getCountries(){
            $request = $this->selectCountries();
            $html='
            <option value="0" selected>Select</option>
            <option value="'.$request['id'].'">'.$request['name'].'</option>
            ';
            echo json_encode($html,JSON_UNESCAPED_UNICODE);
            die();
        }
        public function getSelectCountry($id){
            $request = $this->selectStates($id);
            $html='<option value="0" selected>Select</option>';
            for ($i=0; $i < count($request) ; $i++) { 
                $html.='<option value="'.$request[$i]['id'].'">'.$request[$i]['name'].'</option>';
            }
            echo json_encode($html,JSON_UNESCAPED_UNICODE);
            die();
        }
        public function getSelectState($id){
            $request = $this->selectCities($id);
            $html='<option value="0" selected>Select</option>';
            for ($i=0; $i < count($request) ; $i++) { 
                $html.='<option value="'.$request[$i]['id'].'">'.$request[$i]['name'].'</option>';
            }
            echo json_encode($html,JSON_UNESCAPED_UNICODE);
            die();
        }
        public function getCaso($params){
            if($params !=""){
                $intId = setDesencriptar($params);
                $request = $this->selectCaso($intId);
                if(!empty($request)){
                    echo json_encode($request,JSON_UNESCAPED_UNICODE);
                }
            }
            die();
        }
        public function setCaso(){
            if($_POST){
                $objPaypal = json_decode($_POST['data']);
                if(is_object($objPaypal)){
                    $intId = setDesencriptar($_POST['id']);
                    $arrOrden = $this->selectCaso($intId);
                    if(!empty($arrOrden)){
                        $strTransaccion = $objPaypal->purchase_units[0]->payments->captures[0]->id;
                        $strStatus = strtolower($objPaypal->purchase_units[0]->payments->captures[0]->status);
                        $strStatus = $strStatus == "completed" ? "approved" : "pendent";
                        $request = $this->updateCaso($intId,$strTransaccion,$strStatus);
                        if($request > 0){
                            $company = getCompanyInfo();
                            $arrOrden['idorder'] = $intId;
                            $arrEmailOrden = array(
                                'asunto' => "Se ha generado un pago",
                                'email_usuario' => $arrOrden['cliente']['email'], 
                                'email_remitente'=>$company['email'],
                                'company'=>$company,
                                'email_copia' => $company['secondary_email'],
                                'order' => $arrOrden);
                            try {sendEmail($arrEmailOrden,'email_order');} catch (Exception $e) {}
                            $arrResponse = array("status"=>true,"msg"=>"Payment has been made successfully.");
                        }else{
                            $arrResponse = array("status"=>false,"msg"=>"Something went wrong, please try again.");
                        }
                    }else{
                        $arrResponse = array("status"=>false,"msg"=>"Something went wrong, please try again.");
                    }
                }else{
                    $arrResponse = array("status"=>false,"msg"=>"Something went wrong, please try again.");
                }
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            }
            die();
        }
    }
?>