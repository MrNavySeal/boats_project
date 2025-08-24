<?php
    require_once("Models/PaginaTrait.php");
    class Nosotros extends Controllers{
        use PaginaTrait;
        public function __construct(){
            session_start();
            parent::__construct();
            sessionCookie();
        }
        public function nosotros(){
            $company=getCompanyInfo();
            $data['page_tag'] = $company['name'];
            $data['page_name'] = "About us";
            $data['page_title'] ="About us | ".$company['name'];
            $this->views->getView($this,"nosotros",$data); 
        }
    }
?>