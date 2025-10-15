<?php
class Response{
    public static function response(array $data, int $code): void{
        $status = ($code >= 200 && $code < 300) ? 'success' : 'error';
        header('Content-Type: application/json');
        http_response_code($code);
        echo json_encode([
            'status' => $status,
            'ResponseData' => $data
        ]);
        exit;
    }
}