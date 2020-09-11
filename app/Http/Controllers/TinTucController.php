<?php

namespace App\Http\Controllers;
use App\LoaiTin;
use App\Theloai;
use App\TinTuc;
use App\TinTuc_Del;
use App\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TinTucController extends Controller
{
    //
    public function getDanhSach(){
        $tintuc = TinTuc::orderBy('id','DESC')->get();
        return view('admin.tintuc.danhsach',['tintuc'=>$tintuc]);
    }

    public function getThem(){
        $theloai = TheLoai::all();
        $loaitin = LoaiTin::all();
        return view('admin.tintuc.them',['theloai'=>$theloai],['loaitin'=>$loaitin]);
    }
    public function postThem(Request $request){
        $this->validate($request,
        [
            'LoaiTin'=>'required',
            'TieuDe'=>'required|min:3|unique:TinTuc,TieuDe',
            'NoiDung'=>'required',
            'TomTat'=>'required'

        ],
        [
            'LoaiTin.required'=>"Bạn chưa chọn loại tin",
            'TieuDe.required'=>'Bạn chưa nhập tiêu đề',
            'TieuDe.min'=>'Tiêu đề ít nhất phải 3 ký tự',
            'NoiDung.required'=>'Bạn chưa nhập nội dung',
            'NoiDung.required'=>'Bạn chưa nhập tóm tắt'
        ]);
        $tintuc = new TinTuc;
        $user = Auth::user();
        $tintuc->TieuDe = $request->TieuDe;
        $tintuc->TieuDeKhongDau = changeTitle($request->TieuDe);
        $tintuc->idLoaiTin = $request->LoaiTin;
        $tintuc->TomTat = $request->TomTat;
        $tintuc->NoiDung = $request->NoiDung;
        $tintuc->NoiBat = $request->NoiBat;
        $tintuc->idUser = $user->id;
        $tintuc->SoluotXem = 0;

        if($request->hasFile('Hinh')){
            $file = $request->file('Hinh');
            $duoi =$file->getClientOriginalExtension();
            if($duoi != 'jpg' && $duoi != 'png' && $duoi !='jpeg'){
                return redirect('admin/tintuc/them')->with('loi','Chỉ được nhập file ảnh (jpg,png,jpeg)');
            }
            $name = $file->getClientOriginalName();
            $Hinh = str_random(4)."_".$name;
            while(file_exists("upload/tintuc".$Hinh)){
                $Hinh = str_random(4)."_".$name;
            }
            $file->move("upload/tintuc",$Hinh);
            $tintuc->Hinh =$Hinh;
        }
        else{
            $tintuc->Hinh = "";
        }
        $tintuc->save();
        return redirect('admin/tintuc/them')->with('thongbao','Thêm tin thành công');
    }

    public function getSua($id){
        $user = Auth::user();
        $theloai = TheLoai::all();
        $loaitin = LoaiTin::all();
        $tintuc = TinTuc::find($id);
        if($user->id == $tintuc->idUser){
            return view('admin.tintuc.sua',['tintuc'=>$tintuc,'loaitin'=>$loaitin,'theloai'=>$theloai]);
        }
        return redirect('admin/tintuc/danhsach')->with('thongbao','Bạn không phải là người đăng bài! Không thể sửa!');
    }
    public function postSua(Request $request,$id){
        $tintuc = TinTuc::find($id);
        $this->validate($request,
        [
            'LoaiTin'=>'required',
            'TieuDe'=>'required|min:3',
            'NoiDung'=>'required',
            'TomTat'=>'required'

        ],
        [
            'LoaiTin.required'=>"Bạn chưa chọn loại tin",
            'TieuDe.required'=>'Bạn chưa nhập tiêu đề',
            'TieuDe.min'=>'Tiêu đề ít nhất phải 3 ký tự',
            'NoiDung.required'=>'Bạn chưa nhập nội dung',
            'NoiDung.required'=>'Bạn chưa nhập tóm tắt'
        ]);
        $tintuc->TieuDe = $request->TieuDe;
        $tintuc->TieuDeKhongDau = changeTitle($request->TieuDe);
        $tintuc->idLoaiTin = $request->LoaiTin;
        $tintuc->TomTat = $request->TomTat;
        $tintuc->NoiDung = $request->NoiDung;
        $tintuc->NoiBat = $request->NoiBat;
        if($request->hasFile('Hinh')){
            $file = $request->file('Hinh');
            $duoi =$file->getClientOriginalExtension();
            if($duoi != 'jpg' && $duoi != 'png' && $duoi !='jpeg'){
                return redirect('admin/tintuc/them')->with('loi','Chỉ được nhập file ảnh (jpg,png,jpeg)');
            }
            $name = $file->getClientOriginalName();
            $Hinh = str_random(4)."_".$name;
            while(file_exists("upload/tintuc".$Hinh)){
                $Hinh = str_random(4)."_".$name;
            }
            $file->move("upload/tintuc",$Hinh);
            unlink("upload/tintuc/".$tintuc->Hinh);
            $tintuc->Hinh =$Hinh;
        }
        $tintuc->save();
        return redirect('admin/tintuc/sua/'.$id)->with('thongbao','Sửa thành công');
    }
    public function getXoa($id){
        $tintuc = TinTuc::find($id);
        $user = Auth::user();
        if($user->id == $tintuc->idUser){
            $tintuc_del = new TinTuc_Del;   
            $tintuc_del->idTinTuc = $tintuc->id;
            $tintuc_del->idLoaiTin = $tintuc->idLoaiTin;
            $tintuc_del->TieuDe = $tintuc->TieuDe;
            $tintuc_del->TomTat = $tintuc->TomTat;
            $tintuc_del->NoiDung = $tintuc->NoiDung;
            $tintuc_del->Hinh = $tintuc->Hinh;
            $tintuc_del->Email = $user->email;
            $tintuc_del->Ten = $user->name;
            $tintuc_del->save();
            $comment = Comment::where('idTinTuc',$id);
            $comment->delete();
            $tintuc->delete();
            return redirect('admin/tintuc/danhsach')->with('thongbao','Xóa thành công');
        }
        return redirect('admin/tintuc/danhsach')->with('thongbao','Bạn không phải là người đăng bài! Không thể xóa!');
    }

    public function getTinTucDel(){
        $tintuc_del = TinTuc_Del::all();
        return view('admin.tintuc.tintuc_del',['tintuc_del'=>$tintuc_del]);
    }

    public function getKhoiPhuc($id){
        $tintuc_del = TinTuc_Del::find($id);
        $user = Auth::user();
        if($user->email == $tintuc_del->Email){
            $tintuc = new TinTuc;
            $tintuc->TieuDe = $tintuc_del->TieuDe;
            $tintuc->TieuDeKhongDau = changeTitle($tintuc_del->TieuDe);
            $tintuc->idLoaiTin = $tintuc_del->idLoaiTin;
            $tintuc->TomTat = $tintuc_del->TomTat;
            $tintuc->NoiDung = $tintuc_del->NoiDung;
            $tintuc->NoiBat = 0;
            $tintuc->idUser = $user->id;
            $tintuc->SoluotXem = 0;
            $tintuc->Hinh = $tintuc_del->Hinh;
            $tintuc->save();
            $tintuc_del->delete();
            return redirect('admin/tintuc/tintuc-del')->with('thongbao','Khôi phục thành công!');
        }
        return redirect('admin/tintuc/tintuc-del')->with('thongbao','Bạn không phải người xóa tin! Không thể khôi phục!');
    }
}