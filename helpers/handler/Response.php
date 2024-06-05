<?php

class Response
{

    public static function sendResponse($data = []): bool|string
    {
        $response = array(
            'status' => true,
        );

        if ($data) {
            $response = array_merge($response, $data);
        }
        // get_http_code(200);
        return print_r(json_encode($response));
    }
    public static function sendError($message = '', $code = 500): bool|string
    {
        $response = array(
            'status' => false,
            'code' => $code,
            'message' => $message
        );
        return print_r(json_encode($response));
    }

}
