<?php

namespace App\Http\Controllers;
use App\LoaiTin;
use App\Theloai;
use App\TinTuc;
use App\Comment;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    //
    public function getXoa($id,$idTinTuc){
        $comment = Comment::find($id);
        $comment->delete();
        return redirect('admin/tintuc/sua/'.$idTinTuc)->with('thongbao','Bạn đã xóa comment thành công');
    }
    public function postComment($id, Request $request){
        $idTinTuc = $id;
        if($request->NoiDung == ""){
            $tintuc = TinTuc::find($id);
            return redirect("tintuc/$id/".$tintuc->TieuDeKhongDau.".html")->with('thongbao','Phần bình luận không được bỏ trống');
        }else{
            $tintuc = TinTuc::find($id);
            $comment = new Comment;
            $comment->idTinTuc = $idTinTuc;
            $comment->idUser = Auth::user()->id;
            $comment->NoiDung = $request->NoiDung;
            $comment->save();
            return redirect("tintuc/$id/".$tintuc->TieuDeKhongDau.".html")->with('thongbao','Bình luận thành công');
        }
        
    }

    public function xoaComment($id, $idTinTuc){
        $comment = Comment::find($id);
        $tintuc = TinTuc::find($idTinTuc);
        $comment->delete();
        return redirect("tintuc/$idTinTuc/".$tintuc->TieuDeKhongDau.".html")->with('thongbao','Bạn đã xóa comment thành công');
    }
}
