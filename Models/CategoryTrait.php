<?php
    trait CategoryTrait{
        private $con;

        public function getCategoriesT(){
            $this->con=new Mysql();
            $sql = "SELECT * FROM category WHERE status = 1 AND is_visible = 1 ORDER BY name ";       
            $request = $this->con->select_all($sql);
            if(count($request)>0){
                for ($i=0; $i < count($request) ; $i++) { 
                    $idCategory = $request[$i]['idcategory'];
                    $sqlSub = "SELECT * FROM subcategory WHERE categoryid = $idCategory AND status = 1";
                    $requestSub = $this->con->select_all($sqlSub);
                    for ($j=0; $j < count($requestSub) ; $j++) { 
                        $idSubcategory = $requestSub[$j]['idsubcategory'];
                        $sqlQty = "SELECT COUNT(idproduct) as total FROM product WHERE subcategoryid = $idSubcategory AND status = 1";
                        $requestQty = $this->con->select($sqlQty);
                        $requestSub[$j]['total'] = $requestQty['total'];
                    }
                    $request[$i]['subcategories'] = $requestSub;
                }
            }
            return $request;
        }
        public function getCategoriesShowT(string $categories){
            $this->con=new Mysql();
            $sql = "SELECT * FROM category WHERE idcategory IN ($categories) AND is_visible = 1";       
            $request = $this->con->select_all($sql);
            return $request;
        }
        public function getFaqT(){
            $this->con=new Mysql();
            $sql = "SELECT * FROM faq WHERE status = 1 ORDER BY id DESC";       
            $request = $this->con->select_all($sql);
            return $request;
        }
        public function getServicesT(){
            $this->con=new Mysql();
            $sql = "SELECT * FROM service WHERE status = 1 ORDER BY id DESC";       
            $request = $this->con->select_all($sql);
            return $request;
        }
        public function getServiceT($id){
            $this->con=new Mysql();
            $sql = "SELECT * FROM service WHERE status = 1 AND id = $id";       
            $request = $this->con->select($sql);
            return $request;
        }
        public function getPageT($tipo){
            $this->con=new Mysql();
            $sql = "SELECT * FROM page WHERE type = '$tipo'";
            $request = $this->con->select($sql);
            $strUrl = media()."/images/uploads/".$request['picture'];
            $request['url'] = $strUrl;
            return $request;
        }
        public function getGalleryT(){
            $this->con=new Mysql();
            $sql = "SELECT * FROM gallery WHERE status = 1 ORDER BY id DESC";       
            $request = $this->con->select_all($sql);
            return $request;
        }
        public function selectImageGalleryT(int $id){
            $this->con=new Mysql();
            $sql = "SELECT * FROM gallery WHERE status = 1 AND id = $id";       
            $request = $this->con->select($sql);
            return $request;
        }
        public function getBanners(){
            $this->con=new Mysql();
            $sql = "SELECT * FROM banners WHERE status = 1 ORDER BY id_banner DESC";       
            $request = $this->con->select_all($sql);
            return $request;
        }
        public function getTime($type,$date){
            $this->con=new Mysql();
            $sql = "SELECT value FROM schedule WHERE type = $type";
            $request = $this->con->select_all($sql);
            $arrTime = array_column($request,"value");
            $timeMap = array_map(function($e){
                return "'$e'";
            },$arrTime);
            $strTime = implode(",",$timeMap);
            $timeScheduled = $this->con->select_all("SELECT time FROM orderdata 
            WHERE type_order = 2 AND statusorder != 'finished' 
            AND time in ($strTime) AND DATE(date) = '$date'");
            $timeScheduled = array_column($timeScheduled,"time");
            $arrData = [];
            foreach ($request as $data) {
                if(!in_array($data['value'],$timeScheduled)){
                    array_push($arrData,$data);
                }
            }
            return $arrData;
        }
    }
    
?>