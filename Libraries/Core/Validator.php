<?php 
    class Validator{
        /**
         * Arreglo donde se almacenan los errores
         * @var array
         */
        private $errors = [];
        /**
         * Función para hacer las respectivas validaciones de los campos recibidos
         * @param array $fields los campos a validar
         * @param array $data la información a validar
         * @return object $this retorna la instancia de la clase para usar sus métodos
         */
        public function validate($fields,$data=[]){
            if(!empty($data)){
                $arrFields = $data;
            }else if(!empty($_POST)){
                $arrFields = $_POST;
            }else if(!empty($_GET)){
                $arrFields = $_GET;
            }
            foreach ($fields as $field => $rule) {
                $content = $arrFields[$field];
                $arrRules = explode("|",$rule);
                $arrNickName = explode(";",implode(",",$arrRules));
                $strNickName =!empty($arrNickName) ? $arrNickName[1] : "";
                foreach ($arrRules as $ruleSet) {
                    $params = null;
                    if(strpos($ruleSet,":") !== false){
                        [$ruleName,$params] = explode(":",$ruleSet);
                        $params = explode(";",$params)[0];
                    }else{
                        $ruleName = explode(";",$ruleSet)[0];
                    }
                    $method = "validate".ucFirst(strtolower($ruleName));
                    if(method_exists($this,$method)){
                        $result = $this->$method($content,$params);
                        if(!$result){
                            $this->errors[$field][] = $this->getMessage($strNickName != "" ? $strNickName : $field,$ruleName,$params,$content);
                        }
                    }
                }
            }
            return $this;
        }
        /**
         * @return array $errors retorna los errores encontrados
         */
        public function getErrors(){
            return $this->errors;
        }
        private function validateString($content){
            return is_string($content);
        }
        private function validateArray($content){
            return is_array($content);
        }
        private function validateInteger($content){
            return is_int($content);
        }
        private function validateNumeric($content){
            return is_numeric($content);
        }
        private function validateDouble($content){
            return is_double($content);
        }
        private function validateRequired($content){
            return !empty($content);
        }
        private function validateGreater($content,$params){
            $content = doubleval($content);
            $params = doubleval($params);
            return $content > $params;
        }
        private function validateLess($content,$params){
            $content = doubleval($content);
            $params = doubleval($params);
            return $content < $params;
        }
        private function validateEqual($content,$params){
            $content = doubleval($content);
            $params = doubleval($params);
            return $content == $params;
        }
        private function validateMin($content,$params){
            $type = gettype($content);
            if($type == "string"){
                return strlen($content) >= intval($params);
            }else if($type == "integer" || $type =="double"){
                return $content >= intval($params);
            }else if($type == "array"){
                return count($content) >= intval($params);
            }
        }
        private function validateMax($content,$params){
            $type = gettype($content);
            if($type == "string"){
                return strlen($content) <= intval($params);
            }else if($type == "integer" || $type =="double"){
                return $content <= intval($params);
            }else if($type == "array"){
                return count($content) <= intval($params);
            }
        }
        private function validateEmail($content){
            if(filter_var($content, FILTER_VALIDATE_EMAIL)){
                $flag = true;
            }else{
                $flag = false;
            }
            return $flag;
        }
        private function getMessage($field,$rule,$params,$content){
            $messages = [
                "required" => "The field $field is required",
                "string"=>"The field $field must be a string",
                "email"=>"The field $field must be an email",
                "numeric"=>"The field $field must be numeric",
                "array"=>"The field must be a list",
                "integer"=>"The field must be an integer",
                "double"=>"The field must be decimal",
                "greater"=>"The field $field must be greater than $params",
                "less"=>"The field $field must be less than $params",
                "equal"=>"The field $field must be equal $params",
                "string_min"=>"The field $field must have at least $params characters",
                "string_max"=>"The field $field must have max $params characters",
                "array_min"=>"The field $field must have at least $params elements",
                "array_max"=>"The field $field must have max $params elemets",
                "numeric_min"=>"The field $field must be greater or equal to $params",
                "numeric_max"=>"The field $field must be less or equal to $params",
                "integer_min"=>"The field $field must be greater or equal to $params",
                "integer_max"=>"The field $field must be less or equal to $params",
                "double_min"=>"The field $field must be greater or equal to $params",
                "double_max"=>"The field $field must be less or equal to $params",
            ];
            $type = gettype($content);
            $rule = in_array($rule,["min","max"]) ? $type."_".$rule : $rule; 
            return $messages[$rule]; 
        }
    }
?>