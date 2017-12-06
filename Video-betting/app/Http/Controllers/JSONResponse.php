<?php
/**
 * Created by PhpStorm.
 * User: kaylee
 * Date: 4/22/17
 * Time: 3:55 PM
 */

namespace App\Http\Controllers;


trait JSONResponse
{


    public function jsonResponse($status,$message,array $extras=null){

        $arr = [
            'status' => $status,
            'message'   =>  $message
        ];

        if($extras !== null)

            $arr = array_merge($arr, $extras);

        return response()->json($arr);
    }
    
    public function jsonRedirectResponse($url, $status, $message, array $extras = null, $extra_name=null, $extra_value=null){

        $arr = [
            'status' => $status,
            'message'   =>  $message
        ];

        if($extras !== null)

            $arr = array_merge($arr, $extras);
        if($extra_name == null)
            return redirect($url)->with('jsonRedirectResponse',json_encode($arr));
        return redirect($url)->with('jsonRedirectResponse',json_encode($arr))->with($extra_name,$extra_value);
    }



}