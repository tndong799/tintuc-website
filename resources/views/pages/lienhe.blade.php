@extends('layout.index')
@section('content')   
    <!-- Page Content -->
    <div class="container">

    	<!-- slider -->
        @include('layout.slide')
        <!-- end slide -->

        <div class="space20"></div>


        <div class="row main-left">
            @include('layout.menu')

            <div class="col-md-9">
	            <div class="panel panel-default">            
	            	<div class="panel-heading" style="background-color:#337AB7; color:white;" >
	            		<h2 style="margin-top:0px; margin-bottom:0px;">Liên hệ</h2>
	            	</div>

	            	<div class="panel-body">
	            		<!-- item -->
                        <h3><span class="glyphicon glyphicon-align-left"></span> Thông tin liên hệ</h3>
					    
                        <div class="break"></div>
					   	<h4><span class= "glyphicon glyphicon-home "></span> Địa chỉ : </h4>
                        <p>12 Nguyễn Văn Bảo, Gò Vấp, Hồ Chí Minh</p>

                        <h4><span class="glyphicon glyphicon-envelope"></span> Email : </h4>
                        <p>ngocdongfc1999@gmail.com</p>

                        <h4><span class="glyphicon glyphicon-phone-alt"></span> Điện thoại : </h4>
                        <p>(+84) 35 696 2897</p>



                        <br><br>
                        <h3><span class="glyphicon glyphicon-globe"></span> Bản đồ</h3>
                        <div class="break"></div><br>
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3918.8576365001068!2d106.68530891474944!3d10.822204892290493!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x317528e55115a4b1%3A0x4f368bbe0a88daf5!2zMTIgTmd1eeG7hW4gVsSDbiBC4bqjbywgUGjGsOG7nW5nIDQsIEfDsiBW4bqlcCwgSOG7kyBDaMOtIE1pbmgsIFZp4buHdCBOYW0!5e0!3m2!1svi!2s!4v1592663126136!5m2!1svi!2s" width="100%" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>

					</div>
	            </div>
        	</div>
        </div>
        <!-- /.row -->
    </div>
    <!-- end Page Content -->
@endsection
