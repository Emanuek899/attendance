<?php
function dbErrorStatus(string $message, string $code){
    return [
        'details' => $message,
        'errorCode'  => $code
    ];
}