<?php

namespace App\Http\Controllers;
use App\LoaiTin;
use App\Theloai;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AjaxController extends Controller
{
    //
    public function getLoaiTin($idTheLoai){
        $loaitin = LoaiTin::where('idTheLoai',$idTheLoai)->get();
        foreach($loaitin as $lt){
            echo "<option value='".$lt->id."'>".$lt->Ten."</option>";
        }
    }
}
