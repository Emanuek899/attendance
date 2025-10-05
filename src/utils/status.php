<?php
/**
 * Retorna un formato de datos en base a la operacion
 * Se usa en los managers
 */
function status($exec, $msg1, $msg2, $data){    
    return [
        'status' => $exec,
        'message' => $exec ? $msg1 : $msg2,
        'data' => $data
    ];
}