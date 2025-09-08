<?php
    
    require_once("Models/ProductTrait.php");
    require_once("Models/CategoryTrait.php");
    require_once("Models/CustomerTrait.php");
    require_once("Models/ServicioTrait.php");
    require_once("Models/LoginModel.php");
    class Tienda extends Controllers{
        use ProductTrait, CategoryTrait, CustomerTrait,ServicioTrait;
        private $login;
        public function __construct(){
            session_start();
            parent::__construct();
            sessionCookie();
            $this->login = new LoginModel();
        }

        /******************************Views************************************/
        public function tienda(){
            $pageNow = isset($_GET['p']) ? intval(strClean($_GET['p'])) : 1;
            $sort = isset($_GET['s']) ? intval(strClean($_GET['s'])) : 1;
            $company=getCompanyInfo();
            $data['page_tag'] = $company['name'];
            $data['page_title'] = "Shop | ".$company['name'];
            $data['page_name'] = "shop";
            $data['categories'] = $this->getCategoriesT();
            $productsPage =  $this->getProductsPageT($pageNow,$sort);
            $productsPage['productos'] = $this->bubbleSortPrice($productsPage['productos'],$sort);
            if($pageNow <= $productsPage['paginas']){
                $data['products'] = $productsPage;
                $data['app'] = "functions_shop.js";
                $this->views->getView($this,"tienda",$data);
            }else{
                header("location: ".base_url()."/error");
                die();
            }
        }
        public function categoria($params){
            $pageNow = isset($_GET['p']) ? intval(strClean($_GET['p'])) : 1;
            $sort = isset($_GET['s']) ? intval(strClean($_GET['s'])) : 1;
            $params = strClean($params);
            $arrParams = explode(",",$params);
            $title = count($arrParams) > 1 ? ucwords(str_replace("-"," ",$arrParams[1])): ucwords(str_replace("-"," ",$arrParams[0]));
            //dep($title);exit;
            $company=getCompanyInfo();
            $data['page_tag'] = $company['name'];
            $data['page_name'] = "category";
            $data['categories'] = $this->getCategoriesT();
            $data['ruta'] = count($arrParams) > 1 ? $arrParams[0]."/".$arrParams[1] : $arrParams[0];
            $productsPage =  $this->getProductsCategoryT($arrParams,$pageNow,$sort);
            $productsPage['productos'] = $this->bubbleSortPrice($productsPage['productos'],$sort);
            if($pageNow <= $productsPage['paginas']){
                $data['products'] = $productsPage;
                $data['page_title'] = $title." | ".$company['name'];
                $data['app'] = "functions_shop_category.js";
                $this->views->getView($this,"categoria",$data);
            }else{
                header("location: ".base_url()."/error");
                die();
            }

        }
        public function buscar(){
            $pageNow = isset($_GET['p']) ? intval(strClean($_GET['p'])) : 1;
            $sort = isset($_GET['s']) ? intval(strClean($_GET['s'])) : 1;
            $search = isset($_GET['b']) ? strClean($_GET['b']) : "";
            $company=getCompanyInfo();
            $data['page_tag'] = $company['name'];
            $data['page_title'] = "Shop | ".$company['name'];
            $data['page_name'] = "shop";
            $data['categories'] = $this->getCategoriesT();
            $productsPage =  $this->getProductsSearchT($pageNow,$sort,$search);
            $productsPage['paginas'] = $productsPage['paginas'] == 0 ? 1 : $productsPage['paginas'];
            $productsPage['total'] = $productsPage['total'] == 0 ? 1 : $productsPage['total'];
            $productsPage['productos'] = $this->bubbleSortPrice($productsPage['productos'],$sort);
            if($pageNow <= $productsPage['paginas']){
                $data['products'] = $productsPage;
                $data['app'] = "functions_shop_search.js";
                $this->views->getView($this,"buscar",$data);
            }else{
                header("location: ".base_url()."/error");
                die();
            }
        }
        public function producto($params){
            if($params!= ""){
                $params = strClean($params);
                $data['product'] = $this->getProductPageT($params);
                if(!empty($data['product'])){
                    $company=getCompanyInfo();
                    $data['page_tag'] = $company['name'];
                    $data['page_name'] = "product";
                    $data['products'] = $this->getProductsRelT($data['product']['idproduct'],$data['product']['categoryid'],$data['product']['subcategoryid'],20);
                    $data['page_title'] =$data['product']['name']." | ".$company['name'];
                    $data['app'] = "functions_product.js";
                    $data['modal'] = getFile("Template/Modal/modalReview",$data['product']['idproduct']);
                    $this->views->getView($this,"producto",$data); 
                }else{
                    header("location: ".base_url()."/error");
                    die();
                }
               
            }else{
                header("location: ".base_url()."/error");
                die();
            }
        }
        public function servicio($params){
            if($params!= ""){
                $params = strClean($params);
                $data['service'] = $this->getServicioPageT($params);
                if(!empty($data['service'])){
                    $company=getCompanyInfo();
                    $data['page_tag'] = $company['name'];
                    $data['productos'] = $this->getProductsT(8);
                    $data['page_name'] = "service";
                    $data['faq'] = $this->getFaqT();
                    $data['services'] = $this->getServicesT();
                    $data['gallery'] = $this->getGalleryT();
                    $data['page_title'] =$data['service']['name']." | ".$company['name'];
                    $data['app'] = "functions_service.js";
                    $this->views->getView($this,"servicio",$data); 
                }else{
                    header("location: ".base_url()."/error");
                    die();
                }
               
            }else{
                header("location: ".base_url()."/error");
                die();
            }
        }
        public function servicios(){
            $company=getCompanyInfo();
            $data['page_tag'] = $company['name'];
            $data['page_name'] = "services";
            $data['faq'] = $this->getFaqT();
            $data['services'] = $this->getServicesT();
            $data['gallery'] = $this->getGalleryT();
            $data['page_title'] ="Services | ".$company['name'];
            $data['app'] = "functions_service.js";
            $this->views->getView($this,"servicios",$data); 

        }
        public function galeria(){
            $company=getCompanyInfo();
            $data['page_tag'] = $company['name'];
            $data['page_name'] = "service";
            $data['gallery'] = $this->getGalleryT();
            $data['page_title'] ="Gallery | Shop";
            $this->views->getView($this,"galeria",$data); 
        }
        public function setSchedule(){
            if($_POST){
                $errors = validator()->validate([
                    "scheduleFirstname"=>"required;Name",
                    "schedulePhone"=>"required|numeric;Phone",
                    "scheduleEmail"=>"required|email;Email",
                    "scheduleDate"=>"required;Date",
                    "scheduleTime"=>"required;Time",
                    "scheduleService"=>"required|numeric;Service",
                ])->getErrors();
                if(empty($errors)){
                        $intPhone = strClean($_POST['schedulePhone']);
                        $strDate = strClean($_POST['scheduleDate']);
                        $strTime = strClean($_POST['scheduleTime']);
                        $intService = intval($_POST['scheduleService']);
                        $strName = ucwords(strClean($_POST['scheduleFirstname']));
                        $strEmail = strtolower(strClean($_POST['scheduleEmail']));
                        $strPassword =  hash("SHA256",bin2hex(random_bytes(4)));
                        $strPicture = "user.jpg";
                        $rolid = 2;
                        $request = $this->setCustomerT($strName,$strPicture,$strEmail,$strPassword,$rolid,$intPhone);
                        if(is_numeric($request) && $request > 0){
                            $_SESSION['idUser'] = $request;
                            $_SESSION['login'] = true;
                            $this->login->sessionLogin($_SESSION['idUser']);
                            $company = getCompanyInfo();
                            sessionUser($_SESSION['idUser']);
                            $data = array(
                                'nombreUsuario'=> $strName, 
                                'email_remitente' => $company['email'], 
                                'email_usuario'=>$strEmail, 
                                'company'=>$company,
                                'asunto' =>"Welcome to ".$company['name']);
                            sendEmail($data,"email_welcome");
                            $request = $this->setServiceT($intService,$request,$strTime,$strDate);
                            if(is_numeric($request) && $request > 0 ){
                                $arrResponse = array('status' => true, 'msg' => 'You have scheduled with us! We will contact you.');	
                            }else{
                                $arrResponse = array("status"=>false,"msg"=>"Something went wrong");
                            }
                        }else if($request =="exist"){
                            $arrCustomer = $this->selectCustomer($strEmail);
                            if(!empty($arrCustomer)){
                                $_SESSION['idUser'] = $arrCustomer['id'];
                                $_SESSION['login'] = true;
                                $this->login->sessionLogin($_SESSION['idUser']);
                                sessionUser($_SESSION['idUser']);
                                $request = $this->setServiceT($intService,$arrCustomer['id'],$strTime,$strDate);
                                if(is_numeric($request) && $request > 0 ){
                                    $arrResponse = array('status' => true, 'msg' => 'You have scheduled with us! We will contact you.');	
                                }else{
                                    $arrResponse = array("status"=>false,"msg"=>"Something went wrong");
                                }
                            }else{
                                $arrResponse = array("status"=>false,"msg"=>"Something went wrong");
                            }
                        }else{
                            $arrResponse = array("status"=>false,"msg"=>"Something went wrong");
                        }
                }else{
                    $arrResponse = array("status"=>false,"msg"=>"Please, check the fields.","errors"=>$errors);
                }
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            }
            die();
        }
        public function getServices(){
            echo json_encode($this->getServicesT(),JSON_UNESCAPED_UNICODE);
        }
        public function getSchedule(){
            if($_POST){
                $strDate = strClean($_POST['date']);
                $intType = intval($_POST['type']);
                $request = $this->getTime($intType,$strDate);
                echo json_encode($request,JSON_UNESCAPED_UNICODE);
            }
            die();
        }
        public function getImage(){
            if($_POST){
                $id = intval($_POST['id']);
                $request = $this->selectImageGalleryT($id);
                if(!empty($request)){
                    $url = media()."/images/uploads/".$request['picture'];
                    $arrResponse = ["status"=>true,"data"=>$url];
                }else{
                    $arrResponse = ["status"=>false,"msg"=>"Image has not found."];
                }
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            }
            die();
        }

        /******************************Customer methods************************************/
        public function validCustomer(){
            if($_POST){
				if(empty($_POST['txtSignName']) || empty($_POST['txtSignEmail']) || empty($_POST['txtSignPassword'])){
                    $arrResponse=array("status" => false, "msg" => "Error de datos");
                }else{
                    $strName = ucwords(strClean($_POST['txtSignName']));
                    $strEmail = strtolower(strClean($_POST['txtSignEmail']));
                    $company = getCompanyInfo();
                    $code = code(); 
                    $dataUsuario = array('nombreUsuario'=> $strName, 
                                        'email_remitente' => $company['email'], 
                                        'email_usuario'=>$strEmail, 
                                        'company' =>$company,
                                        'asunto' =>'Verification code - '.$company['name'],
                                        'codigo' => $code);
                    $_SESSION['code'] = $code;
                    $sendEmail = sendEmail($dataUsuario,'email_validData');
                    if($sendEmail){
                        $arrResponse = array("status"=>true,"msg"=>"A code has been sent to your email.");
                        
                    }else{
                        $arrResponse = array("status"=>false,"msg"=>"Something went wrong.");
                    }
                }
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);

			}
			die();
        }
		public function setCustomer(){
			if($_POST){
				if(empty($_POST['txtSignName']) || empty($_POST['txtSignEmail']) || 
                empty($_POST['txtSignPassword']) || empty($_POST['txtCode'])){
                    $arrResponse=array("status" => false, "msg" => "Error de datos");
                }else{
                    if($_POST['txtCode'] == $_SESSION['code']){
                        unset($_SESSION['code']);
                        $strName = ucwords(strClean($_POST['txtSignName']));
                        $strEmail = strtolower(strClean($_POST['txtSignEmail']));
                        $strPassword = hash("SHA256",$_POST['txtSignPassword']);
                        $strPicture = "user.jpg";
                        $rolid = 2;

                        $request = $this->setCustomerT($strName,$strPicture,$strEmail,$strPassword,$rolid);
                        
                        if(is_numeric($request) && $request > 0){
                            $_SESSION['idUser'] = $request;
                            $_SESSION['login'] = true;
                            $this->login->sessionLogin($_SESSION['idUser']);
                            $company = getCompanyInfo();
                            sessionUser($_SESSION['idUser']);
                            $arrResponse = array("status" => true,"msg"=>"You have been signed up.");
                            $data = array(
                                'nombreUsuario'=> $strName, 
                                'email_remitente' => $company['email'], 
                                'email_usuario'=>$strEmail, 
                                'company'=>$company,
                                'asunto' =>"Welcome to ".$company['name']);
                            sendEmail($data,"email_welcome");
                        }else if($request =="exist"){
                            $arrResponse = array("status" => false,"msg"=>"This user already exists, please log in.");
                        }else{
                            $arrResponse = array("status" => false,"msg"=>"Something went wrong.");
    
                        }
                    }else{
                        $arrResponse = array("status" => false,"msg"=>"Wrong code, try again.");
                    }

                }
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);

			}
			die();
		}
        public function setSuscriber(){
            if($_POST){
                if(empty($_POST['txtEmailSuscribe'])){
                    $arrResponse = array("status"=>false,"msg"=>"Error de datos");
                }else{
                    $strEmail = strClean(strtolower($_POST['txtEmailSuscribe']));
                    $request = $this->setSuscriberT($strEmail);
                    $company = getCompanyInfo();
                    if($request>0){
                        $request = $this->statusCouponSuscriberT();
                        $dataEmail = array('email_remitente' => $company['email'], 
                                                'email_usuario'=>$strEmail,
                                                'asunto' =>'Te has suscrito a '.$company['name'],
                                                "code"=>$request['code'],
                                                'company'=>$company,
                                                "discount"=>$request['discount']);
                        sendEmail($dataEmail,'email_suscriber');
                        $arrResponse = array("status"=>true,"msg"=>"Suscrito");
                    }else if($request=="exists"){
                        $arrResponse = array("status"=>false,"msg"=>"Ya se ha suscrito antes.");
                    }else{
                        $arrResponse = array("status"=>false,"msg"=>"Error, intenta de nuevo.");
                    }
                }
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            }
            die();
        }
        public function statusCouponSuscriber(){
            $request = $this->statusCouponSuscriberT();
            if(!empty($request)){
                $arrResponse = array("status"=>true,"discount"=>$request['discount']);
            }else{
                $arrResponse = array("status"=>false,"msg"=>"El cupón no existe o está inactivo");
            }
            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            die();
        }
        /******************************Product methods************************************/
        public function getProductVariant(){
            if($_POST){
                if(empty($_POST['id']) || empty($_POST['variant'])){
                    $arrResponse = array("status"=>false,"msg"=>"Error de datos");
                }else{
                    $id = openssl_decrypt($_POST['id'],METHOD,KEY);
                    $variant = strClean($_POST['variant']);
                    if(is_numeric($id)){
                        $request = $this->selectProductVariant($id,$variant);
                        $discount = 0;
                        $priceDiscount = 0;
                        $percent =0;
                        if($request['price_offer']>0){
                            $percent = floor((1-($request['price_offer']/$request['price_sell']))*100);
                        }
                        $arrResponse = array(
                            "status"=>true,
                            "is_stock"=>boolval($request['is_stock']),
                            "stock"=>$request['stock'],
                            "price"=>formatNum($request['price_sell'],false),
                            "pricediscount"=>formatNum($request['price_offer'],false),
                            "percent"=>$percent > 0 ? "-".$percent."%" : ""
                        );
                    }else{
                        $arrResponse = array("status"=>false,"msg"=>"Something went wrong");
                    }
                }
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            }
            die();
        }
        
        /******************************General shop methods************************************/
        public function getProduct(){
            if($_POST){
                $idProduct = openssl_decrypt($_POST['idProduct'],METHOD,KEY);
                if(is_numeric($idProduct)){
                    $request = $this->getProductT($idProduct);
                    $request['idproduct'] = $_POST['idProduct']; 
                    $request['priceDiscount']=$request['price']-($request['price']*($request['discount']*0.01));
                    $request['price'] = $request['price'];
                    $script = getFile("Template/Modal/modalQuickView",$request);
                    $data = array(
                        "name"=>$request['name'],
                        "url"=>base_url()."/tienda/producto/".$request['route'],
                        "img"=>$request['image'][0]['url'],
                        "stock"=>$request['stock']
                    );
                    $arrResponse= array("status"=>true,"script"=>$script,"data"=>$data);
                }else{
                    $arrResponse= array("status"=>false);
                }
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            }
            die();
            
        }
        function bubbleSortPrice($arr,$sort) {
            $n = count($arr);
            if($sort == 2){

                for ($i = 0; $i < $n - 1; $i++) {
                    for ($j = 0; $j < $n - $i - 1; $j++) {
                        if ($arr[$j]['price'] < $arr[$j + 1]['price']) {
                            // Intercambiar elementos si están en el orden incorrecto
                            $temp = $arr[$j];
                            $arr[$j] = $arr[$j + 1];
                            $arr[$j + 1] = $temp;
                        }
                    }
                }
            }else if($sort == 3){
                for ($i = 0; $i < $n - 1; $i++) {
                    for ($j = 0; $j < $n - $i - 1; $j++) {
                        if ($arr[$j]['price'] > $arr[$j + 1]['price']) {
                            // Intercambiar elementos si están en el orden incorrecto
                            $temp = $arr[$j];
                            $arr[$j] = $arr[$j + 1];
                            $arr[$j + 1] = $temp;
                        }
                    }
                }
            }
            return $arr;
        }
        /******************************wishlist methods************************************/
        public function addWishList(){
            if($_POST){
                if(isset($_SESSION['login'])){
                    $idProduct = openssl_decrypt($_POST['idProduct'],METHOD,KEY);
                    if(is_numeric($idProduct)){
                        $request = $this->addWishListT($idProduct,$_SESSION['idUser']);
                        if($request>0){
                            $arrResponse = array("status"=>true);
                        }else if("exists"){
                            $arrResponse = array("status"=>true);
                        }else{
                            $arrResponse = array("status"=>false);
                        }
                    }
                }else{
                    $arrResponse = array("status"=>false);
                }
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            }
            die();
        }
        public function delWishList(){
            if($_POST){
                if(isset($_SESSION['login'])){
                    $idProduct = openssl_decrypt($_POST['idProduct'],METHOD,KEY);
                    if(is_numeric($idProduct)){
                        $request = $this->delWishListT($idProduct,$_SESSION['idUser']);
                        if($request>0){
                            $arrResponse = array("status"=>true);
                        }else{
                            $arrResponse = array("status"=>false);
                        }
                    }
                }else{
                    $arrResponse = array("status"=>false);
                }
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            }
            die();
        }
    }
?>