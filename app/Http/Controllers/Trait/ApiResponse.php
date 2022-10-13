<?php

namespace App\Http\Controllers\Trait;

trait ApiResponse
{
public function Apiresponse($data = null,$message = null,$status = null)
{
    # code...
    $array = [
        'data'=>$data,
        'message'=>$message,
        'status'=>$status

    ];
    return response($array,200);
}
}