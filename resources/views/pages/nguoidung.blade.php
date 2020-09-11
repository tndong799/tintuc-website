@extends('layout.index')
@section('content')
    <!-- Page Content -->
    <div class="container">

    	<!-- slider -->
    	<div class="row carousel-holder">
            <div class="col-md-2">
            </div>
            <div class="col-md-8">
                <div class="panel panel-default">
				  	<div class="panel-heading">Thông tin tài khoản</div>
				  	<div class="panel-body">
					@if(count($errors)>0)
                        <div class="alert alert-danger">
                            @foreach($errors->all() as $err)
                                {{$err}} <br>
                            @endforeach
                        </div>
                    @endif

                    @if(session('thongbao'))
                        <div class="alert alert-success">
                            {{session('thongbao')}}
                        </div>
                    @endif
				    	<form action="nguoidung" method="POST" enctype="multipart/form-data">
							<input type="hidden" name="_token" value="{{csrf_token()}}">
				    		<div>
				    			<label>Họ tên</label>
							  	<input type="text" class="form-control" placeholder="Username" name="name" aria-describedby="basic-addon1" value="{{Auth::user()->name}}">
							</div>
							<br>
							<div>
				    			<label>Email</label>
							  	<input type="email" class="form-control" placeholder="Email" value="{{Auth::user()->email}}" name="email" aria-describedby="basic-addon1"
							  	disabled>
							</div>
                            <br>
                            <div>
                                <label>Ảnh đại diện</label>
                                <img src="upload/user/{{Auth::user()->Hinh}}" alt="" style="max-width: 100px; max-height:100px">
							  	<input type="file" class="form-control"   name="Hinh" aria-describedby="basic-addon1">
							</div>
							<br>
							<div>
								<input type="checkbox" class="" name="changePassword" id="changePass">
				    			<label>Đổi mật khẩu</label>
							  	<input type="password" class="form-control password" disabled name="password" aria-describedby="basic-addon1">
							</div>
							<br>
							<div>
				    			<label>Nhập lại mật khẩu</label>
							  	<input type="password" disabled class="form-control password" name="passwordAgain" aria-describedby="basic-addon1">
							</div>
							<br>
							<button type="submit" class="btn btn-default">Sửa
							</button>

				    	</form>
				  	</div>
				</div>
            </div>
            <div class="col-md-2">
            </div>
        </div>
        <!-- end slide -->
    </div>
    <!-- end Page Content -->

@endsection
@section('script')
        <script>
            $(document).ready(function(){
                $("#changePass").change(function(){
                    if($(this).is(":checked")){
                        $(".password").removeAttr('disabled');
                    }
                    else{
                        $(".password").attr('disabled','');
                    }
                });
            });
        </script>
@endsection