<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Foundation\Auth\User as AuthUser;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //
    public function getDanhSach(){
        $user = User::all();
        return view('admin.user.danhsach',['user'=>$user]);
    }

    public function getThem(){
        return view('admin.user.them');
    }
    public function postThem(Request $request){
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
        $user->quyen = $request->quyen;
        $user->save();

        return redirect('admin/user/them')->with('thongbao','Thêm thành công');
    }

    public function getSua($id){
        $user = User::find($id);
        if($user->id == Auth::user()->id || $user->quyen == 0){
            return view('admin.user.sua',['user'=>$user]);
        }
        return redirect('admin/user/danhsach')->with('thongbao','Đây là tài khoản admin! không thể sửa!');
    }
    public function postSua(Request $request,$id){
        $this->validate($request,
        [
            'name'=>'required|min:3',
        ],
        [
            'name.required'=>'Bạn chưa nhập tên người dùng',
            'name.min'=>'tên người dùng quá ngắn',
        ]);
        $user = User::find($id);
        $user->name = $request->name;
        $user->quyen = $request->quyen;
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
        $user->save();

        return redirect('admin/user/sua/'.$id)->with('thongbao','Sửa thành công');
    }

    public function getXoa($id){
        $user = User::find($id);
        $user2 = Auth::user();
        if($user->id == $user2->id){
            $comment = Comment::where('idUser',$id);
            $comment->delete();
            $user->delete();
            return redirect('admin/dangnhap')->with('thongbao','Xóa tài khoản thành công');
        }
        if($user->quyen == 1){
            return redirect('admin/user/danhsach')->with('thongbao','Không thể xóa tài khoản admin!');
        }
        $comment = Comment::where('idUser',$id);
        $comment->delete();
        $user->delete();
        return redirect('admin/user/danhsach')->with('thongbao','Xóa người dùng thành công');
    }

    public function getDangnhapAdmin(){
        return view('admin.login');
    }

    public function postDangnhapAdmin(Request $request){
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
            return redirect('admin/theloai/danhsach');
        }
        else{
            return redirect('admin/dangnhap')->with('thongbao','Đăng nhập không thành công');
        }
    }
    public function getDangxuatAdmin(){
        Auth::logout();
        return redirect('admin/dangnhap');
    }
}
