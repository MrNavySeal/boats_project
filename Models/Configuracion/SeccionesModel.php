<?php
    class SeccionesModel extends Mysql{
        private $intId;
		private $intEstado;
        private $strImagen;
        private $strDescripcion;
        private $strRespuesta;
        private $strPregunta;
        private $intPorPagina;
        private $intPaginaActual;
        private $intPaginaInicio;
        private $strBuscar;
        private $strPagina;
        private $strTitulo;
        private $strSubtitulo;
        private $strDescripcionCorta;

        public function __construct(){
            parent::__construct();
        }

        //Paginas
        public function updatePagina(string $strPagina,string $strTitulo,string $strSubtitulo,string $strDescripcionCorta,$strDescripcion="",string $strImagen,
        $strMision="",$strVision="",$strFilosofia="",$strTitulo2="",$strSubtitulo2="",$strMisionTitulo="",$strVisionTitulo="",$strFilosofiaTitulo=""){
            $this->strPagina = $strPagina;
            $this->strTitulo = $strTitulo;
            $this->strSubtitulo = $strSubtitulo;
            $this->strDescripcionCorta = $strDescripcionCorta;
            $this->strDescripcion = $strDescripcion;
            $this->strImagen = $strImagen;

            $sql = "UPDATE page SET title=?,subtitle=?,short_description=?, description=?,picture=?,mission=?,vision=?,philosophy=?,title2=?,subtitle2=? 
            ,mission_title=?,vision_title=?,philosophy_title=? WHERE type = '$this->strPagina'";
            $arrData = [
                $this->strTitulo,
                $this->strSubtitulo,
                $this->strDescripcionCorta,
                $this->strDescripcion,
                $this->strImagen,
                $strMision,
                $strVision,
                $strFilosofia,
                $strTitulo2,
                $strSubtitulo2,
                $strMisionTitulo,
                $strVisionTitulo,
                $strFilosofiaTitulo
            ];
            $request = $this->update($sql,$arrData);
            return $request;
        }
        public function selectPagina(string $strPagina){
            $this->strPagina = $strPagina;
            $sql = "SELECT * FROM page WHERE type = '$this->strPagina'";
            $request = $this->select($sql);
            return $request;
        }

        //Faqs
        public function selectFaqs($intPorPagina,$intPaginaActual, $strBuscar){
            $this->intPorPagina = $intPorPagina;
            $this->intPaginaActual = $intPaginaActual;
            $this->strBuscar = $strBuscar;
            $limit ="";
            $this->intPaginaInicio = ($this->intPaginaActual-1)*$this->intPorPagina;
            if($this->intPorPagina != 0){
                $limit = " LIMIT $this->intPaginaInicio,$this->intPorPagina";
            }
            $sql = "SELECT * FROM faq WHERE answer like '$this->strBuscar%' OR question like '$this->strBuscar%' ORDER BY id DESC $limit";  
            $sqlTotal = "SELECT count(*) as total FROM faq WHERE answer like '$this->strBuscar%' OR question like '$this->strBuscar%' ORDER BY id DESC";

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
        public function selectFaq($id){
            $this->intId = $id;
            $sql = "SELECT * FROM faq WHERE id = $this->intId";
            $request = $this->select($sql);
            return $request;
        }
        public function insertFaq(string $strPregunta,string $strRespuesta,int $intEstado){
			$this->strPregunta = $strPregunta;
			$this->strRespuesta = $strRespuesta;
            $this->intEstado = $intEstado;
            $sql  = "INSERT INTO faq(question,answer,status)  VALUES(?,?,?)";
            $arrData = array($this->strPregunta,$this->strRespuesta,$this->intEstado);
            $request = $this->insert($sql,$arrData);
	        return $request;
		}
        public function updateFaq(int $intId,string $strPregunta,string $strRespuesta,int $intEstado){
            $this->intId = $intId;
            $this->strPregunta = $strPregunta;
			$this->strRespuesta = $strRespuesta;
            $this->intEstado = $intEstado;
            $sql = "UPDATE faq SET question=?,answer=?,status=? WHERE id = $this->intId";
            $arrData = array($this->strPregunta,$this->strRespuesta,$this->intEstado);
            $request = $this->update($sql,$arrData);
			return $request;
		
		}
        public function deleteFaq($id){
            $this->intId = $id;
            $sql = "DELETE FROM faq WHERE id = $this->intId";
            $request = $this->delete($sql);
            return $request;
        }
    }
?>