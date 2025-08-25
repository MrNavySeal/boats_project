<?php
    require_once("Models/CustomerTrait.php");
    require_once("Models/CategoryTrait.php");
    class Contacto extends Controllers{
        use CustomerTrait,CategoryTrait;
        public function __construct(){
            parent::__construct();
            session_start();
            sessionCookie();
        }

        public function contacto(){
            $company=getCompanyInfo();
            $data['page_tag'] = "Contact | ".$company['name'];
			$data['page_title'] = "Contact | ".$company['name'];
			$data['page_name'] = "Contact";
            $data['page'] = $this->getPageT("contacto");
            $data['app'] = "functions_contact.js";
            $this->views->getView($this,"contacto",$data);
        }
        public function setContact(){
            if($_POST){
                if(empty($_POST['txtContactName']) || empty($_POST['txtContactlastname']) || empty($_POST['txtContactEmail']) 
                    || empty($_POST['txtContactMessage']) || empty($_POST['txtContactPhone']) || empty($_POST['serviceList'])){
                    $arrResponse = array("status"=>false,"msg"=>"Data error");
                }else{
                    $strName = ucwords(strClean($_POST['txtContactName']));
                    $strLastname = ucwords(strClean($_POST['txtContactLastname']));
                    $strName = $strName." ".$strLastname;
                    $strEmail = strtolower(strClean($_POST['txtContactEmail']));
                    $strPhone = strClean($_POST['txtContactPhone']);
                    $strMessage = strClean($_POST['txtContactMessage']);
                    $intService = intval($_POST['serviceList']);
                    $company = getCompanyInfo();
                    $service = $this->getServiceT($intService);
                    $strSubject = "New message -".$service['name'];
                    $request = $this->setMessage($strName,$strPhone,$strEmail,$strSubject,$strMessage,$intService);
                    if($request > 0){
                        $dataEmail = array('email_remitente' => $company['email'], 
                                                'email_usuario'=>$strEmail, 
                                                'email_copia'=>$company['secondary_email'],
                                                'asunto' =>$strSubject,
                                                "message"=>$strMessage,
                                                "company"=>$company,
                                                "phone"=>$strPhone,
                                                'name'=>$strName);
                        try {
                            sendEmail($dataEmail,'email_contact');
                            $arrResponse = array("status"=>true,"msg"=>"Your message has been sent, we will contact you soon.");
                        } catch (Exception $e) {
                            $arrResponse = array("status"=>false,"msg"=>"Something went wrong, try again.");
                        }
                        
                    }else{
                        $arrResponse = array("status"=>false,"msg"=>"Something went wrong, try again.");
                    }
                }
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            }
            die();
        }
    }
?>