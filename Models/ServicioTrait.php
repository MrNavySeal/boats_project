<?php
    require_once("Libraries/Core/Mysql.php");
    trait ServicioTrait{
        public function getServicioPageT($params){
            $con = new Mysql();
            $sql = "SELECT * FROM service WHERE route = '$params' AND status = 1";
            $request = $con->select($sql);
            return $request;
        }
    }
?>
