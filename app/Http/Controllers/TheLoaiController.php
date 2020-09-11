<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TheLoai;
use Illuminate\Support\Str;

class TheLoaiController extends Controller
{
    //
    public function getDanhSach(){
        $theloai = TheLoai::all();
        return view('admin.theloai.danhsach',['theloai'=>$theloai]);
    }

    public function getThem(){
        return view('admin.theloai.them');
    }

    public function postThem(Request $request){
        $this->validate($request,
        [
            'Ten' => 'required|min:3|max:100|unique:TheLoai,Ten'
        ],
        [
            'Ten.required'=>'Bạn chưa nhập tên thể loại',
            'Ten.min'=>"Tên thể loại phải có dộ dài từ 3 đến 100 ký tự",
            'Ten.max'=>"Tên thể loại phải có dộ dài từ 3 đến 100 ký tự",
            'Ten.unique'=>"Tên thể loại đã tồn tại"
        ]);
        $theloai = new TheLoai;
        $theloai->Ten = $request->Ten;
        $theloai->TenKhongDau = Str::slug($request->Ten,'-');
        $theloai->save();
        return redirect('admin/theloai/them')->with('thongbao','Thêm thành công');
    }
    public function getSua($id){
        $theloai = TheLoai::find($id);
        return view('admin.theloai.sua',['theloai'=>$theloai]);
    }
    public function postSua(Request $request,$id){
        $theloai = TheLoai::find($id);
        $this->validate($request,
        [
            'Ten' => 'required|unique:TheLoai,Ten|min:3|max:100'
        ],
        [
            'Ten.required'=>'Bạn chưa nhập tên thể loại',
            'Ten.unique'=>"Tên thể loại đã tồn tại",
            'Ten.min'=>"Tên thể loại phải có dộ dài từ 3 đến 100 ký tự",
            'Ten.max'=>"Tên thể loại phải có dộ dài từ 3 đến 100 ký tự",
        ]);
        $theloai->Ten = $request->Ten;
        $theloai->TenKhongDau = changeTitle($request->Ten);
        $theloai->save();
        return redirect('admin/theloai/sua/'.$id)->with('thongbao','Sửa thành công');
    }
    public function getXoa($id){
        $theloai = Theloai::find($id);
        if(count($theloai->loaitin) == 0){
            $theloai->delete();
            return redirect('admin/theloai/danhsach')->with('thongbao','Bạn đã xóa thành công');
        }
        return redirect('admin/theloai/danhsach')->with('thongbao','Trong thể loại có nhiều loại tin! Không thể xóa!');
    }
}
