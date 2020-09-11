<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TheLoai;
use App\Slide;
use App\LoaiTin;
use App\TinTuc;
use App\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class PagesController extends Controller
{
    //
    function __construct()
    {
        $theloai = TheLoai::all();
        $slide = Slide::all();
        view()->share('theloai',$theloai);
        view()->share('slide',$slide);

        if(Auth::check()){
            view()->share('nguoidung',Auth::user());
        }    
    }
    function trangchu(){
        return view('pages.trangchu');
    }
    function lienhe(){
        return view('pages.lienhe');
    }
    function loaitin($id){
        $loaitin = LoaiTin::find($id);
        $tintuc = TinTuc::where('idLoaiTin',$id)->paginate(5);
        return view('pages.loaitin',['loaitin'=>$loaitin,'tintuc'=>$tintuc]);
    }
    function tintuc($id){
        $tintuc = TinTuc::find($id);
        $tinnoibat = TinTuc::where('NoiBat',1)->orderBy('SoLuotXem','desc')->take(4)->get();
        $tinlienquan = TinTuc::where('idLoaiTin',$tintuc->idLoaiTin)->take(4)->get();
        $tintucKey = 'product_' . $id;
        if(Auth::check()){
            if(!Session::has($tintucKey)){
                TinTuc::where('id', $id)->increment('SoLuotXem');
                Session::put($tintucKey, 1);
            }
        }
        return view('pages.tintuc',['tintuc'=>$tintuc,'tinnoibat'=>$tinnoibat,'tinlienquan'=>$tinlienquan]);
    }
    function getDangnhap(){
        return view('pages.dangnhap');
    }
    function postDangnhap(Request $request){
        $this->validate($request,
        [
            'email'=>'required',
            'password'=>'required|min:3|max:32'
        ],
        [
            'email.required'=>'Bạn chưa nhập Email',
            'password.required'=>'Bạn chưa nhập password',
            'password.min'=>'Mật khẩu quá ngắn',
            'password.max'=>'Mật khẩu quá dài'
        ]);
        if(Auth::attempt(['email'=>$request->email,'password'=>$request->password])){
            return redirect('trangchu');
        }
        else{
            return redirect('dangnhap')->with('thongbao1','Sai tên tài khoản hoặc mật khẩu');
        }
    }
    public function getDangxuat(){
        Auth::logout();
        return redirect('trangchu');
    }
    function getNguoidung(){
        return view('pages.nguoidung');
    }
    function postNguoidung(Request $request){
        $this->validate($request,
        [
            'name'=>'required|min:3',
        ],
        [
            'name.required'=>'Bạn chưa nhập tên người dùng',
            'name.min'=>'tên người dùng quá ngắn',
        ]);
        $user = Auth::user();
        $user->name = $request->name;
        if($request->changePassword == "on")
            {
                $this->validate($request,
                [

                    'password'=>'required|min:3|max:32',
                    'passwordAgain'=> 'required|same:password'
                ],
                [
                    'password.required'=>'Bạn chưa nhập mật khẩu',
                    'password.min'=>'Mật khẩu quá ngắn',
                    'password.max'=>'Mật khẩu quá dài',
                    'passwordAgain.required'=>'Bạn chưa nhập lại mật khẩu',
                    'passwordAgain.same'=>'Mật khẩu nhập lại chưa khớp'
                ]);
                
                $user->password = bcrypt($request->password);
            }
            if($request->hasFile('Hinh')){
                $file = $request->file('Hinh');
                $duoi =$file->getClientOriginalExtension();
                if($duoi != 'jpg' && $duoi != 'png' && $duoi !='jpeg'){
                    return redirect('nguoidung')->with('loi','Chỉ được nhập file ảnh (jpg,png,jpeg)');
                }
                $name = $file->getClientOriginalName();
                $Hinh = str_random(4)."_".$name;
                while(file_exists("upload/user".$Hinh)){
                    $Hinh = str_random(4)."_".$name;
                }
                $file->move("upload/user",$Hinh);

                if(isset($user->Hinh)){
                    unlink("upload/user/".$user->Hinh);
                }
                $user->Hinh = $Hinh;
            }
        $user->save();

        return redirect('nguoidung')->with('thongbao','Sửa thành công');
    }

    function getDangky(){
        return view('pages.dangky');
    }
    function postDangky(Request $request){
        $this->validate($request,
        [
            'name'=>'required|min:3',
            'email'=>'required|email|unique:users,email',
            'password'=>'required|min:3|max:32',
            'passwordAgain'=> 'required|same:password'
        ],
        [
            'name.required'=>'Bạn chưa nhập tên người dùng',
            'name.min'=>'tên người dùng quá ngắn',
            'email.required'=>'Bạn chưa nhập eamil',
            'email.email'=>'Bạn chưa nhập Email đúng định dạng',
            'email.unique'=>'Email đã tồn tại',
            'password.required'=>'Bạn chưa nhập mật khẩu',
            'password.min'=>'Mật khẩu quá ngắn',
            'password.max'=>'Mật khẩu quá dài',
            'passwordAgain.required'=>'Bạn chưa nhập lại mật khẩu',
            'passwordAgain.same'=>'Mật khẩu nhập lại chưa khớp'
        ]);
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->quyen = 0;
        $user->save();

        return redirect('dangnhap')->with('thongbao','Đăng ký thành công!!!');
    }

    function timkiem(Request $request){
        $tukhoa = $request->tukhoa;
        $tintuc = TinTuc::where('TieuDe','like','%'.$tukhoa.'%')->orWhere('TomTat','like','%'.$tukhoa.'%')->orWhere('NoiDung','like','%'.$tukhoa.'%')->take(30)->paginate(5,['*'], 'np');
        return view('pages.timkiem',['tintuc'=>$tintuc,'tukhoa'=>$tukhoa]);
    }
    function gioithieu(){
        return view('pages.gioithieu');
    }
}


