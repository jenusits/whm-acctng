<?php

namespace App;

use App\Model;

class Charts extends Model
{
    //
    public static function name($id){

        $name = DB::table('charts')->where('id',$id)->first();

        return $name;
    }

    public static function names(){
       $names = DB::table('charts')->get();
    }
       
}
