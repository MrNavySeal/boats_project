<?php
    class PedidosPos extends Controllers{
        private $objProduct;
        public function __construct(){
            
            session_start();
            if(empty($_SESSION['login'])){
                header("location: ".base_url());
                die();
            }
            parent::__construct();
        }
        public function venta(){
            if($_SESSION['permitsModule']['w']){
                $data['botones'] = [
                    "duplicar" => ["mostrar"=>true, "evento"=>"onclick","funcion"=>"mypop=window.open('".BASE_URL.$_SESSION['permitsModule']['route']."','','');mypop.focus();"],
                    "atras" => ["mostrar"=>true, "evento"=>"onclick","funcion"=>"window.location.href='".BASE_URL."/orders/'"],
                ];
                $data['page_tag'] = implode(" | ",[$_SESSION['permitsModule']['option'],$_SESSION['permitsModule']['module']]);
                $data['page_title'] = implode(" | ",[$_SESSION['permitsModule']['option'],$_SESSION['permitsModule']['module']]);
                $data['page_name'] = strtolower($_SESSION['permitsModule']['option']);
                $data['panelapp'] = "/Pedidos/functions_orders_venta.js";
                $this->views->getView($this,"venta",$data);
            }else{
                header("location: ".base_url());
                die();
            }
        }
        /*************************POS methods*******************************/
        public function getProduct(){
            if($_SESSION['permitsModule']['w']){
                if($_POST['id']){
                    $id = intval($_POST['id']);
                    $request = $this->model->selectProduct($id);
                    if(!empty($request)){
                        $arrResponse = array("status"=>true,"data"=>$request);
                    }else{
                        $arrResponse = array("status"=>false,"msg"=>"The product does not exist");
                    }
                }else{
                    $arrResponse = array("status"=>false,"msg"=>"Something went wrong");
                }
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            }
            die();
        }
        public function getProducts(){
            if($_SESSION['permitsModule']['r']){
                $strSearch = strClean($_POST['search']);
                $intPerPage = intval($_POST['perpage']);
                $intPageNow = intval($_POST['page']);
                $request = $this->model->selectProducts($strSearch,$intPerPage,$intPageNow);
                $arrProducts = $request['products'];
                $intTotalPages = $request['pages'];
                $total = $this->model->selectTotalInventory($strSearch);
                $arrData = array(
                    "html"=>$this->getInventoryHtml($arrProducts,$intTotalPages,$intPageNow),
                    "total_records"=>$total,
                    "data"=>$arrProducts
                );
                echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
            }
            die();
        }
        public function getInventoryHtml(array $data,int $pages,$page){
            $maxButtons = 4;
            $totalPages = $pages;
            $startPage = max(1, $page - floor($maxButtons / 2));
            if ($startPage + $maxButtons - 1 > $totalPages) {
                $startPage = max(1, $totalPages - $maxButtons + 1);
            }
            $html ="";
            $htmlPages = '
                <li class="page-item">
                    <button type="button" class="page-link text-secondary" href="#" onclick="getProducts(1)" aria-label="First">
                        <span aria-hidden="true"><i class="fas fa-angle-double-left"></i></span>
                    </button>
                </li>
                <li class="page-item">
                    <button type="button" class="page-link text-secondary" href="#" onclick="getProducts('.max(1, $page-1).')" aria-label="Previous">
                        <span aria-hidden="true"><i class="fas fa-angle-left"></i></span>
                    </button>
                </li>
            ';
            for ($i = $startPage; $i < min($startPage + $maxButtons, $totalPages + 1); $i++) {
                $htmlPages .= '<li class="page-item">
                    <button type="button" class="page-link  '.($i == $page ? ' bg-primary text-white' : 'text-secondary').'" href="#" onclick="getProducts('.$i.')">'.$i.'</button>
                </li>';
            }
            foreach ($data as $pro) {
                $price = '<span>'.$pro['price_sell_format'].'</span>';
                $stock = $pro['is_stock'] ? $pro['stock'] : "N/A";
                if($pro['price_offer'] > 0){
                    $price = '<span class="text-decoration-line-through">'.$pro['price_sell_format'].
                    '</span> <span class="text-danger">'.$pro['price_offer_format'].'</span>';
                }
                $html.='
                    <tr role="button" onclick="addProduct({},2,'.$pro['id'].','."'".$pro['variant_name']."'".','.$pro['product_type'].')">
                        <td data-title="Portada" class="text-center"><img src="'.$pro['url'].'" height="50" width="50"></td>
                        <td data-title="Stock" class="text-center">'.$stock.'</td>
                        <td data-title="Referencia">'.$pro['reference'].'</td>
                        <td data-title="Artículo">'.$pro['name'].'</td>
                        <td data-title="Precio" class="text-end">'.$price.'</td>
                    </tr>
                ';
            }
            $htmlPages .= '
                <li class="page-item">
                    <button type="button" class="page-link text-secondary" href="#" onclick="getProducts('.min($totalPages, $page+1).')" aria-label="Next">
                        <span aria-hidden="true"><i class="fas fa-angle-right"></i></span>
                    </button>
                </li>
                <li class="page-item">
                    <button type="button" class="page-link text-secondary" href="#" onclick="getProducts('.($pages).')" aria-label="Last">
                        <span aria-hidden="true"><i class="fas fa-angle-double-right"></i></span>
                    </button>
                </li>
            ';
            return array("products"=>$html,"pages"=>$htmlPages);
        }
        public function getCustomers(){
            if($_SESSION['permitsModule']['w']){
                $request = $this->model->selectCustomers();
                echo json_encode($request,JSON_UNESCAPED_UNICODE);
            }
            die();
        }
        public function setOrder(){
            if($_SESSION['permitsModule']['w']){
                if($_POST){
                    if(empty($_POST['id'])){
                        $arrResponse = array("status"=>false,"msg"=>"Something went wrong");
                    }else{
                        $strDate = $_POST['strDate'] == "" ? date("Y-m-d") : strClean($_POST['strDate']);
                        $strDateQuote = $_POST['strDate'] == "" ? date("Y-m-d") : strClean($_POST['strDateQuote']);
                        $arrProducts = json_decode($_POST['products'],true);
                        $intOrderType = intval($_POST["order_type"]);
                        $arrTotal = json_decode($_POST['total'],true);
                        $id = intval($_POST['id']);
                        $request_customer = $this->model->selectCustomer($id);
                        if(!empty($request_customer)){
                            if(is_array($arrProducts) && !empty($arrProducts) && is_array($arrTotal) && !empty($arrTotal) ){
                                $dateObj = new DateTime($strDate);
                                $dateCount = 0;
                                while ($dateCount < 30) {
                                    $dateObj->modify('+1 day');
                                    $dayWeek = $dateObj->format('N');
                                    if($dayWeek < 7){
                                        $dateCount++;
                                    }
                                }
                                $dateBeat = $dateObj->format("Y-m-d");
                                $data = array(
                                    "customer"=>$request_customer,
                                    "date"=>$strDate,
                                    "date_quote"=>$strDateQuote,
                                    "date_beat"=>$dateBeat,
                                    "type"=>strClean($_POST['paymentList']),
                                    "note"=>strClean($_POST['strNote']),
                                    "note_quote"=>strClean($_POST['strNoteQuote']),
                                    "status_order"=>intval($_POST['statusOrder']),
                                    "products"=>$arrProducts,
                                    "total"=>$arrTotal
                                );
                                $request = $this->model->insertOrder($data);
                                if($request > 0){
                                    $arrResponse = array("status"=>true,"msg"=>"The sale has been saved successfully");
                                }else{
                                    $arrResponse = array("status"=>false,"msg"=>"Something went wrong");
                                }
                            }else{
                                $arrResponse = array("status"=>false,"msg"=>"You must add at least a product");
                            }
                        }else{
                            $arrResponse = array("status"=>false,"msg"=>"This customer does not exist!"); 
                        }
                    }
                    echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
                }
            }
            die();
        }
    }
?>