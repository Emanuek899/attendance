<?php
class Validator{
    public array $errors = [];

    /**
     * validate parameters by rules
     * @param array $data datos para examinar, normalmente son los que se pasan desde
     *              la api, ejemplo ['role_id' => 5]
     * @param array $rules rules to be follow to validate 
     *              example of format ['role_id' => 'Integer|Min:8']
     */
    public function validate(array $data, array $rules){
        foreach($rules as $parameter => $rules){
            $r = explode('|', $rules);
            foreach($r as $rule){

                if(str_contains($rule, ':')){
                    $delimiter = strpos($rule, ':');
                    $sMethod = substr($rule, 0, $delimiter);
                    $limit = substr($rule, $delimiter + 1);
                    $method = 'validate' . $sMethod;

                    if(method_exists($this, $method)){
                        $this->$method($parameter, $data[$parameter], $limit);
                    }
                }

                $method = 'validate' . $rule;
                if(method_exists($this, $method)){
                    $this->$method($parameter, $data[$parameter]);
                }
            }
        }
        return $this->errors;
    }

    private function validateMin(string $parameter, string $data, int $lenght){
        if (mb_strlen($data) < $lenght){
            $this->errors[$parameter][] = "El $parameter es demasiado corto";
        }
    }

    private function validateInteger(string $parameter, $num){
        if(!is_int($num)){
            $this->errors[$parameter][] = "El $parameter no esta en formato entero";
        }
    }

    private function validateEmpty(string $parameter, $value){
        if(empty($value)){
            $this->errors[$parameter][] = "El $parameter esta vacio o no esta declarado";
        }   
    }
}