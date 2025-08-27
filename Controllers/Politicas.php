<?php
    require_once("Models/CategoryTrait.php");
    class Politicas extends Controllers{
        use CategoryTrait;
        public function __construct(){
            session_start();
            parent::__construct();
            sessionCookie();
        }
        public function privacidad(){
            $company=getCompanyInfo();
            $data['page'] = $this->getPageT("privacidad");
            $data['page_tag'] = $company['name'];
            $data['page_name'] = "Privacy";
            $data['page_title'] ="Privacy | ".$company['name'];
            $this->views->getView($this,"politica",$data); 
        }
        public function terminos(){
            $company=getCompanyInfo();
            $data['page'] = $this->getPageT("terminos");
            $data['page_tag'] = $company['name'];
            $data['page_name'] = "Terms and conditions";
            $data['page_title'] ="Terms and conditions | ".$company['name'];
            $this->views->getView($this,"politica",$data); 
        }
    }
?>