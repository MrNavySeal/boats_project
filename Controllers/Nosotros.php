<?php
    require_once("Models/CategoryTrait.php");
    class Nosotros extends Controllers{
        use CategoryTrait;
        public function __construct(){
            session_start();
            parent::__construct();
            sessionCookie();
        }
        public function nosotros(){
            $company=getCompanyInfo();
            $data['page_tag'] = $company['name'];
            $data['gallery'] = $this->getGalleryT();
            $data['servicios'] = $this->getServicesT();
            $data['page_name'] = "About us";
            $data['page_title'] ="About us | ".$company['name'];
            $data['app'] = "functions_home.js";
            $this->views->getView($this,"nosotros",$data); 
        }
    }
?>