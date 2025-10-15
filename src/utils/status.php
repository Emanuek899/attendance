<?php
/**
 * Retorna un formato de datos en base a la operacion
 * Se usa en los managers
 */
function status(bool $exec, $msg1, $msg2, $data, ){    
    return [
        'message' => $exec ? $msg1 : $msg2,
        'data' => $data
    ];
}

function statusError(string $error, int $statusCode = 400){
    return [
        'error' => $error,
        'statusCode' => $statusCode
    ];
}

function dbErrorStatus(string $message, string $code){
    return [
        'details' => $message,
        'internal_code'  => $code
    ];
}