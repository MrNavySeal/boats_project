<?php 
    class CitasModel extends Mysql{
        private $intId;
        private $intPorPagina;
        private $intPaginaActual;
        private $intPaginaInicio;
        private $strFecha;
        private $strBuscar;
        private $strMonedaBase;
        private $strMonedaObjetivo;
        private $intValorObjetivo;
        private $strTitulo;
        private $strDescripcion;
        private $intServicio;
        private $intCliente;
        private $strHora;
        private $intValorBase;
        private $strEstado;
        public function __construct(){
            parent::__construct();
        }
        public function selectSchedule(){
            $sql = "SELECT * FROM schedule";
            $request = $this->select_all($sql);
            return $request;
        }
        public function selectServicios($intPorPagina,$intPaginaActual, $strBuscar){
            $this->intPorPagina = $intPorPagina;
            $this->intPaginaActual = $intPaginaActual;
            $this->strBuscar = $strBuscar;
            $limit ="";
            $this->intPaginaInicio = ($this->intPaginaActual-1)*$this->intPorPagina;
            if($this->intPorPagina != 0){
                $limit = " LIMIT $this->intPaginaInicio,$this->intPorPagina";
            }
            $sql = "SELECT p.* FROM service p 
            WHERE p.status = 1 AND (p.name like '$this->strBuscar%' OR p.short_description like '$this->strBuscar%') ORDER BY p.id DESC $limit";  
            $sqlTotal = "SELECT count(*) as total FROM service p
            WHERE p.status = 1 AND (p.name like '$this->strBuscar%' OR p.short_description like '$this->strBuscar%' ) ORDER BY p.id DESC $limit"; 

            $totalRecords = $this->select($sqlTotal)['total'];
            $totalPages = intval($totalRecords > 0 ? ceil($totalRecords/$this->intPorPagina) : 0);
            $totalPages = $totalPages == 0 ? 1 : $totalPages;
            $request = $this->select_all($sql);

            $startPage = max(1, $this->intPaginaActual - floor(BUTTONS / 2));
            if ($startPage + BUTTONS - 1 > $totalPages) {
                $startPage = max(1, $totalPages - BUTTONS + 1);
            }
            $limitPages = min($startPage + BUTTONS, $totalPages+1);
            $arrData = array(
                "data"=>$request,
                "start_page"=>$startPage,
                "limit_page"=>$limitPages,
                "total_pages"=>$totalPages,
                "total_records"=>$totalRecords,
            );
            return $arrData;
        }
        public function selectClientes($intPorPagina,$intPaginaActual, $strBuscar){
            $this->intPorPagina = $intPorPagina;
            $this->intPaginaActual = $intPaginaActual;
            $this->strBuscar = $strBuscar;
            $limit ="";
            $this->intPaginaInicio = ($this->intPaginaActual-1)*$this->intPorPagina;
            if($this->intPorPagina != 0){
                $limit = " LIMIT $this->intPaginaInicio,$this->intPorPagina";
            }
            $sql = "SELECT p.*,p.idperson as id,p.image as picture,
            DATE_FORMAT(p.date, '%d/%m/%Y') as date,
            co.name as pais,
            st.name as departamento,
            ci.name as ciudad,
            p.phone as telefono
            FROM person p
            LEFT JOIN countries co ON p.countryid = co.id
            LEFT JOIN states st ON p.stateid = st.id
            LEFT JOIN cities ci ON p.cityid = ci.id
            WHERE p.status = 1 AND p.roleid = 2 AND (CONCAT(p.firstname,p.lastname) like '$this->strBuscar%' OR p.phone like '$this->strBuscar%' 
            OR p.address like '$this->strBuscar%' OR co.name like '$this->strBuscar%' OR st.name like '$this->strBuscar%' 
            OR ci.name like '$this->strBuscar%') 
            ORDER BY p.idperson DESC $limit";  

            $sqlTotal = "SELECT count(*) as total FROM person p
            LEFT JOIN countries co ON p.countryid = co.id
            LEFT JOIN states st ON p.stateid = st.id
            LEFT JOIN cities ci ON p.cityid = ci.id
            WHERE p.status = 1 AND p.roleid = 2 AND (CONCAT(p.firstname,p.lastname) like '$this->strBuscar%' OR p.phone like '$this->strBuscar%' 
            OR p.address like '$this->strBuscar%' OR co.name like '$this->strBuscar%' OR st.name like '$this->strBuscar%' 
            OR ci.name like '$this->strBuscar%')
            ORDER BY p.idperson DESC";

            $totalRecords = $this->select($sqlTotal)['total'];
            $totalPages = intval($totalRecords > 0 ? ceil($totalRecords/$this->intPorPagina) : 0);
            $totalPages = $totalPages == 0 ? 1 : $totalPages;
            $request = $this->select_all($sql);

            $startPage = max(1, $this->intPaginaActual - floor(BUTTONS / 2));
            if ($startPage + BUTTONS - 1 > $totalPages) {
                $startPage = max(1, $totalPages - BUTTONS + 1);
            }
            $limitPages = min($startPage + BUTTONS, $totalPages+1);
            $arrData = array(
                "data"=>$request,
                "start_page"=>$startPage,
                "limit_page"=>$limitPages,
                "total_pages"=>$totalPages,
                "total_records"=>$totalRecords,
            );
            return $arrData;
        }
        public function selectCasos($intPorPagina,$intPaginaActual, $strBuscar,$idUser){
            $this->intPorPagina = $intPorPagina;
            $this->intPaginaActual = $intPaginaActual;
            $this->strBuscar = $strBuscar;
            $limit ="";
            $this->intPaginaInicio = ($this->intPaginaActual-1)*$this->intPorPagina;
            if($this->intPorPagina != 0){
                $limit = " LIMIT $this->intPaginaInicio,$this->intPorPagina";
            }
            $whre="";
            if($idUser!="")$whre=" AND personid=$idUser";
            $sql = "SELECT ord.*,
            DATE_FORMAT(ord.date,'%d/%m/%Y') as date,
            co.name as pais,
            st.name as departamento,
            ci.name as ciudad,
            p.phone as telefono,
            serv.name as servicio,
            p.address,
            p.firstname,
            p.lastname,
            p.email,
            p.identification
            FROM orderdata ord
            LEFT JOIN person p ON p.idperson = ord.personid
            LEFT JOIN service serv ON ord.service_id = serv.id
            LEFT JOIN countries co ON p.countryid = co.id
            LEFT JOIN states st ON p.stateid = st.id
            LEFT JOIN cities ci ON p.cityid = ci.id
            WHERE (CONCAT(p.firstname,p.lastname) like '$this->strBuscar%' OR p.phone like '$this->strBuscar%' 
            OR p.address like '$this->strBuscar%' OR co.name like '$this->strBuscar%' OR st.name like '$this->strBuscar%' 
            OR ci.name like '$this->strBuscar%' OR serv.name like '$this->strBuscar%') AND type_order = 2 $whre  
            ORDER BY ord.idorder DESC $limit";  

            $sqlTotal = "SELECT count(*) as total FROM orderdata ord
            LEFT JOIN person p ON p.idperson = ord.personid
            LEFT JOIN service serv ON ord.service_id = serv.id
            LEFT JOIN countries co ON p.countryid = co.id
            LEFT JOIN states st ON p.stateid = st.id
            LEFT JOIN cities ci ON p.cityid = ci.id
            WHERE (CONCAT(p.firstname,p.lastname) like '$this->strBuscar%' OR p.phone like '$this->strBuscar%' 
            OR p.address like '$this->strBuscar%' OR co.name like '$this->strBuscar%' OR st.name like '$this->strBuscar%' 
            OR ci.name like '$this->strBuscar%' OR serv.name like '$this->strBuscar%')  AND type_order = 2 $whre
            ORDER BY ord.idorder";

            $totalRecords = $this->select($sqlTotal)['total'];
            $totalPages = intval($totalRecords > 0 ? ceil($totalRecords/$this->intPorPagina) : 0);
            $totalPages = $totalPages == 0 ? 1 : $totalPages;
            $request = $this->select_all($sql);
            foreach ($request as &$data) {
                $data['date'] = $data['date'] . ' ' . $data['time'];
            }
            $startPage = max(1, $this->intPaginaActual - floor(BUTTONS / 2));
            if ($startPage + BUTTONS - 1 > $totalPages) {
                $startPage = max(1, $totalPages - BUTTONS + 1);
            }
            $limitPages = min($startPage + BUTTONS, $totalPages+1);
            $arrData = array(
                "data"=>$request,
                "start_page"=>$startPage,
                "limit_page"=>$limitPages,
                "total_pages"=>$totalPages,
                "total_records"=>$totalRecords,
            );
            return $arrData;
        }
        public function selectCaso($intId){
            $this->intId = $intId;
            $sql = "SELECT *, DATE_FORMAT(date, '%Y-%m-%d') as date FROM orderdata WHERE idorder = $this->intId";
           
            $request = $this->select($sql);
            if(!empty($request)){
                $sqlCliente = "SELECT p.*,p.idperson as id,p.image as picture,
                DATE_FORMAT(p.date, '%d/%m/%Y') as date,
                co.name as pais,
                st.name as departamento,
                ci.name as ciudad,
                p.phone as telefono
                FROM person p
                LEFT JOIN countries co ON p.countryid = co.id
                LEFT JOIN states st ON p.stateid = st.id
                LEFT JOIN cities ci ON p.cityid = ci.id
                WHERE p.idperson = $request[personid] AND p.status = 1";

                $sqlServicio = "SELECT p.*
                FROM service p
                WHERE p.status = 1 AND p.id = $request[service_id]";
                $request['cliente'] = $this->select($sqlCliente);
                $request['servicio'] = $this->select($sqlServicio);
            }
            return $request;
        }
        public function insertCaso($intServicio,$intCliente,$strHora,$strFecha,$intValorBase,$strEstado){
            $this->intServicio = $intServicio;
            $this->intCliente = $intCliente;
            $this->strHora = $strHora;
            $this->strFecha = $strFecha;
            $this->intValorBase = $intValorBase;
            $this->strEstado = $strEstado;
            $sql = "SELECT * FROM orderdata WHERE type_order = 2 AND time = '$strHora' AND DATE(date) = '$strFecha'";
            $request = $this->select_all($sql);
            if(empty($request)){
                $sql = "INSERT INTO orderdata(service_id,personid,time,date,amount,status,statusorder,type_order)
                VALUES(?,?,?,?,?,?,?,?)";
                $arrData =[
                    $this->intServicio,
                    $this->intCliente, 
                    $this->strHora,
                    $this->strFecha, 
                    $this->intValorBase,
                    "pendent",
                    $this->strEstado,
                    2
                ];
                $request = $this->insert($sql,$arrData);
            }else{
                $request ="exists";
            }
            return $request;
        }
        public function updateCaso($intId,$intServicio,$intCliente,$strHora,$strFecha,$intValorBase,$strEstado){
            $this->intId = $intId;
            $this->intServicio = $intServicio;
            $this->intCliente = $intCliente;
            $this->strHora = $strHora;
            $this->strFecha = $strFecha;
            $this->intValorBase = $intValorBase;
            $this->strEstado = $strEstado;
            $sql = "SELECT * FROM orderdata WHERE type_order = 2 AND time = '$strHora' AND DATE(date) = '$strFecha' AND idorder != $intId";
            $request = $this->select_all($sql);
            if(empty($request)){

                $sql = "UPDATE orderdata SET service_id=?,personid=?,time=?,date=?,amount=?,statusorder=?
                WHERE idorder = $this->intId";
                $arrData =[
                    $this->intServicio,
                    $this->intCliente, 
                    $this->strHora,
                    $this->strFecha, 
                    $this->intValorBase,
                    $this->strEstado,
                ];
                $request = $this->update($sql,$arrData);
            }else{
                $request ="exists";
            }
            return $request;
        }
        public function deleteCaso($id){
            $this->intId = $id;
            $sql = "DELETE FROM orderdata WHERE idorder = $this->intId";
            $request = $this->delete($sql);
            return $request;
        }
    }
?>