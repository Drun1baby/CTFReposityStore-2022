<?php

namespace App\Http\Controllers;



class HelloController extends Controller
{
    public function hello(\Illuminate\Http\Request $request){
        $h3 = base64_decode($request->input("h3"));
        unserialize($h3);
        return "Welcome Nepctf! GL&HF";
    }

}
