<?php
    
    class Secciones extends Controllers{
        public function __construct(){
            session_start();
            if(empty($_SESSION['login'])){
                header("location: ".base_url());
                die();
            }
            parent::__construct();
        }
        public function paginas(){
            if($_SESSION['permitsModule']['r']){
                $data['botones'] = [
                    "duplicar" => ["mostrar"=>$_SESSION['permitsModule']['r'] ? true : false, "evento"=>"onClick","funcion"=>"mypop=window.open('".BASE_URL."/secciones/paginas"."','','');mypop.focus();"],
                    "guardar" => ["mostrar"=>$_SESSION['permitsModule']['w'] ? true : false, "evento"=>"@click","funcion"=>"setDatos()"],
                ];
                $data['page_tag'] = "{$_SESSION['permitsModule']['option']} | {$_SESSION['permitsModule']['module']}}";
                $data['page_title'] = "{$_SESSION['permitsModule']['option']} | {$_SESSION['permitsModule']['module']}";
                $data['page_name'] = "{$_SESSION['permitsModule']['option']} | {$_SESSION['permitsModule']['module']}";
                $data['panelapp'] = "/Configuracion/functions_secciones_paginas.js";
                $this->views->getView($this,"paginas",$data);
            }else{
                header("location: ".base_url());
                die();
            }
        }
        public function faq(){
            if($_SESSION['permitsModule']['r']){
                $data['botones'] = [
                    "duplicar" => ["mostrar"=>$_SESSION['permitsModule']['r'] ? true : false, "evento"=>"onClick","funcion"=>"mypop=window.open('".BASE_URL."/secciones/faq"."','','');mypop.focus();"],
                    "nuevo" => ["mostrar"=>$_SESSION['permitsModule']['w'] ? true : false, "evento"=>"@click","funcion"=>"showModal()"],
                ];
                $data['page_tag'] = "{$_SESSION['permitsModule']['option']} | {$_SESSION['permitsModule']['module']}}";
                $data['page_title'] = "{$_SESSION['permitsModule']['option']} | {$_SESSION['permitsModule']['module']}";
                $data['page_name'] = "{$_SESSION['permitsModule']['option']} | {$_SESSION['permitsModule']['module']}";
                $data['panelapp'] = "/Configuracion/functions_secciones_faq.js";
                $this->views->getView($this,"faq",$data);
            }else{
                header("location: ".base_url());
                die();
            }
        }
        public function setPagina(){
            if($_SESSION['permitsModule']['r']){
                if($_POST){
                    $strPagina = strtolower(strClean($_POST['nosotros_pagina']));
                    $strDescripcion = "";
                    $strDescripcionCorta ="";
                    $strTitulo = "";
                    $strSubtitulo ="";
                    $strImagen="";
                    $strImagenNombre="";
                    if($strPagina =="nosotros"){
                        $strImagen="";
                        $strMision=strClean($_POST['nosotros_mision']);
                        $strVision=strClean($_POST['nosotros_vision']);
                        $strFilosofia=strClean($_POST['nosotros_filosofia']);
                        $strDescripcion="";
                        $strDescripcionCorta=ucfirst(strClean($_POST['nosotros_descripcion_corta']));
                        $strTitulo=ucfirst(strClean($_POST['nosotros_titulo']));
                        $strSubtitulo=ucfirst(strClean($_POST['nosotros_subtitulo']));
                        $strTitulo2=ucfirst(strClean($_POST['nosotros_titulo2']));
                        $strSubtitulo2=ucfirst(strClean($_POST['nosotros_subtitulo2']));
                        $request = $this->model->selectPagina($strPagina);
                        if($_FILES['nosotros_imagen']['name'] == ""){
                            $strImagenNombre = $request['picture'];
                        }else{
                            if(!empty($request) && $request['picture'] != "category.jpg"){deleteFile($request['picture']);}
                            $strImagen = $_FILES['nosotros_imagen'];
                            $strImagenNombre = $strPagina.'_'.bin2hex(random_bytes(6)).'.png';
                        }
                        $request = $this->model->updatePagina($strPagina,$strTitulo,$strSubtitulo,$strDescripcionCorta,$strDescripcion,$strImagenNombre,$strMision,$strVision,$strFilosofia,$strTitulo2,$strSubtitulo2);
                        if($strImagen != ""){ uploadImage($strImagen,$strImagenNombre); }
                    }

                    $strPagina = strtolower(strClean($_POST['contacto_pagina']));
                    if($strPagina =="contacto"){
                        $strImagenNombre="";
                        $strTitulo=ucfirst(strClean($_POST['contacto_titulo']));
                        $strSubtitulo=ucfirst(strClean($_POST['contacto_subtitulo']));
                        $request = $this->model->selectPagina($strPagina);
                        $request = $this->model->updatePagina($strPagina,$strTitulo,$strSubtitulo,"","",$strImagenNombre);
                    }

                    $strPagina = strtolower(strClean($_POST['terminos_pagina']));
                    if($strPagina =="terminos"){
                        $strTitulo=ucfirst(strClean($_POST['terminos_titulo']));
                        $strDescripcion=$_POST['terminos_descripcion'];
                        $request = $this->model->updatePagina($strPagina,$strTitulo,"","",$strDescripcion,"");
                    }

                    $strPagina = strtolower(strClean($_POST['privacidad_pagina']));
                    if($strPagina =="privacidad"){
                        $strTitulo=ucfirst(strClean($_POST['privacidad_titulo']));
                        $strDescripcion=$_POST['privacidad_descripcion'];
                        $request = $this->model->updatePagina($strPagina,$strTitulo,"","",$strDescripcion,"");
                    }
                    if($request > 0 ){
                        $arrResponse = array('status' => true, 'msg' => 'Datos guardados');	
                    }else{
                        $arrResponse = array("status" => false, "msg" => 'No es posible guardar los datos.');
                    }
                    
                    echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
                }
            }
            die();
        }
        public function setFaq(){
            if($_SESSION['permitsModule']['r']){
                if($_POST){
                    if(empty($_POST['respuesta']) || empty($_POST['pregunta'])){
                        $arrResponse = array("status" => false, "msg" => 'Error de datos');
                    }else{ 
                        $intId = intval($_POST['id']);
                        $strRespuesta = ucfirst(strClean($_POST['respuesta']));
                        $strPregunta = ucfirst(strClean($_POST['pregunta']));
                        $intEstado = intval($_POST['estado']);
                        if($intId == 0){
                            if($_SESSION['permitsModule']['w']){
                                $option = 1;
                                $request= $this->model->insertFaq($strPregunta,$strRespuesta,$intEstado);
                            }
                        }else{
                            if($_SESSION['permitsModule']['u']){
                                $option = 2;
                                $request = $this->model->updateFaq($intId,$strPregunta,$strRespuesta,$intEstado);
                            }
                        }
                        if($request > 0 ){
                            if($option == 1){ $arrResponse = array('status' => true, 'msg' => 'Datos guardados');	
                            }else{ $arrResponse = array('status' => true, 'msg' => 'Datos actualizados'); }
                        }else{
                            $arrResponse = array("status" => false, "msg" => 'No es posible guardar los datos.');
                        }
                    }
                    echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
                }
            }
			die();
		}
        public function getBuscar(){
            if($_SESSION['permitsModule']['r']){
                if($_POST){
                    $intPorPagina = intval($_POST['paginas']);
                    $intPaginaActual = intval($_POST['pagina']);
                    $strBuscar = clear_cadena(strClean($_POST['buscar']));
                    $strTipoBusqueda = clear_cadena(strClean($_POST['tipo_busqueda']));
                    if($strTipoBusqueda == "banners"){
                        $request = $this->model->selectBanners($intPorPagina,$intPaginaActual, $strBuscar);
                    }else if($strTipoBusqueda == "testimonios"){
                        $request = $this->model->selectTestimonios($intPorPagina,$intPaginaActual, $strBuscar);
                    }else if($strTipoBusqueda == "faq"){
                        $request = $this->model->selectFaqs($intPorPagina,$intPaginaActual, $strBuscar);
                    }else if($strTipoBusqueda == "equipo"){
                        $request = $this->model->selectEquipos($intPorPagina,$intPaginaActual, $strBuscar);
                    }
                    if(!empty($request)){
                        foreach ($request['data'] as &$data) { 
                            if(isset($data['picture'])){ $data['url'] = media()."/images/uploads/".$data['picture'];}
                            $data['edit'] = $_SESSION['permitsModule']['u'];
                            $data['delete'] = $_SESSION['permitsModule']['d'];
                        }
                    }
                    echo json_encode($request,JSON_UNESCAPED_UNICODE);
                }
            }
            die();
        }
        public function getDatos(){
            if($_SESSION['permitsModule']['r']){
                if($_POST){
                    $intId = intval($_POST['id']);
                    $strTipoBusqueda = clear_cadena(strClean($_POST['tipo_busqueda']));
                    if($strTipoBusqueda == "faq"){$request = $this->model->selectFaq($intId);}
                    else if($strTipoBusqueda == "paginas"){
                        $arrNosotros = $this->model->selectPagina("nosotros");
                        $arrContacto = $this->model->selectPagina("contacto");
                        $arrTerminos = $this->model->selectPagina("terminos");
                        $arrPrivacidad = $this->model->selectPagina("privacidad");
                        $arrNosotros['url'] = media()."/images/uploads/".$arrNosotros['picture'];
                        $arrContacto['url'] = media()."/images/uploads/".$arrContacto['picture'];
                        $request = array(
                            "nosotros"=>$arrNosotros,
                            "contacto"=>$arrContacto,
                            "terminos"=>$arrTerminos,
                            "privacidad"=>$arrPrivacidad,
                        );
                        
                    }
                    if(!empty($request)){
                        if(isset($request['picture'])){$request['url'] = media()."/images/uploads/".$request['picture'];}
                        $arrResponse = array("status"=>true,"data"=>$request);
                    }else{
                        $arrResponse = array("status"=>false,"msg"=>"Error, intenta de nuevo"); 
                    }
                    echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
                }
            }
            die();
        }
        public function delDatos(){
            if($_SESSION['permitsModule']['d']){
                if($_POST){
                    $intId = intval($_POST['id']);
                    $strTipoBusqueda = clear_cadena(strClean($_POST['tipo_busqueda']));
                    if($strTipoBusqueda == "banners"){ 
                        $request = $this->model->selectBanner($intId);
                        if($request['picture']!="category.jpg"){ deleteFile($request['picture']); }
                        $request = $this->model->deleteBanner($intId);
                    }else if($strTipoBusqueda == "testimonios"){
                        $request = $this->model->selectTestimonio($intId);
                        if($request['picture']!="category.jpg"){ deleteFile($request['picture']); }
                        $request = $this->model->deleteTestimonio($intId);
                    }else if($strTipoBusqueda == "faq"){
                        $request = $this->model->deleteFaq($intId);
                    }else if($strTipoBusqueda == "equipo"){
                        $request = $this->model->deleteEquipo($intId);
                    }
                    if($request > 0 || $request == "ok"){
                        $arrResponse = array("status"=>true,"msg"=>"Se ha eliminado correctamente.");
                    }else{
                        $arrResponse = array("status"=>false,"msg"=>"No es posible eliminar, intenta de nuevo.");
                    }
                    echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
                }
            }
            die();
        }
    }
?>