<?php

namespace App\Http\Controllers;

use App\Constants\DBCode;
use App\Constants\DBMessage;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{


    public function jsonError(Exception $e, $classname = null, $function = null)
    {

        $code = intval($e->getCode());
        $message = DBMessage::API_SERVER_ERROR_MESSAGE;

        if($code == DBCode::AUTHORIZED_ERROR)
            $message = $e->getMessage();

        return response()->json([
            'status' => $code,
            'result' => false,
            'message' => $message,
            'code' => $code,
            'reporting' => array(
                'type' => 'API Server',
                'filename' => $e->getFile(),
                'classname' => $classname,
                'function' => $function,
                'line' => $e->getLine(),
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            )
        ], 200);
    }

    public function jsonSuccess($message, $data = array())
    {
        $json['result'] = true;
        $json['status'] = 200;
        $json['message'] = $message;
        $json['data'] = $data;

        return response()->json($json);
    }
}
