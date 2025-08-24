<?php 
    class GalleryModel extends Mysql{
        private $intIdBanner;
		private $intStatus;
        private $strPhoto;

        public function __construct(){
            parent::__construct();
        }
        /*************************Category methods*******************************/
        public function insertBanner(string $photo,int $status){

            $this->strPhoto = $photo;
            $this->intStatus = $status;
			$query_insert  = "INSERT INTO gallery(picture,status) VALUES(?,?)";
            $arrData = array( $this->strPhoto, $this->intStatus );
            $request_insert = $this->insert($query_insert,$arrData);
            $return = $request_insert;
	        return $return;
		}
        public function updateBanner(int $intIdBanner,string $photo,int $status){
            $this->intIdBanner = $intIdBanner;
            $this->intStatus = $status;
            $this->strPhoto = $photo;
            $sql = "UPDATE gallery SET picture=?,status=? WHERE id = $this->intIdBanner";
            $arrData = array( $this->strPhoto, $this->intStatus);
            $request = $this->update($sql,$arrData);
			return $request;
		
		}
        public function deleteBanner($id){
            $this->intIdBanner = $id;
            $sql = "DELETE FROM gallery WHERE id = $this->intIdBanner";
            $return = $this->delete($sql);
            return $return;
        }
        public function selectBanners(){
            $sql = "SELECT * FROM gallery ORDER BY id DESC";       
            $request = $this->select_all($sql);
            return $request;
        }
        public function selectBanner($id){
            $this->intIdBanner = $id;
            $sql = "SELECT * FROM gallery WHERE id = $this->intIdBanner";
            $request = $this->select($sql);
            return $request;
        }
    }
?>