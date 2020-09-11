    @extends('layout.index')
    @section('content')
    <!-- Page Content -->
    <div class="container">
        <div class="row">

            <!-- Blog Post Content Column -->
            <div class="col-lg-9">

                <!-- Blog Post -->

                <!-- Title -->
                <h1 style="font-size:32px; line-height: 36px; padding:0; font-weight:bold; color: #222;">{{$tintuc->TieuDe}}</h1>

                <!-- Author -->
                <p class="lead">
                by {{$tintuc->user->name}}
                </p>
                <!-- Date/Time -->
                <p><span class="glyphicon glyphicon-time"></span> Posted on: {{$tintuc->created_at}}<br>
                    <span class="glyphicon glyphicon-eye-open"></span> Views: {{$tintuc->SoLuotXem}}</p>
                    
                    <p><div class="fb-like" data-href="https://developers.facebook.com/docs/plugins/" data-width="" data-layout="button" data-action="like" data-size="small" data-share="true"></div>
                        <div class="fb-save" data-uri="https://www.instagram.com/facebook/" data-size="small"></div>
                    </p>
                <!-- Preview Image -->
                <img class="img-responsive" src="upload/tintuc/{{$tintuc->Hinh}}" alt="">

                
                
                <hr>

                <!-- Post Content -->
                <h2 style="font-size: 17px; line-height: 22px; font-weight: bold; color: #111;">{!!$tintuc->TomTat!!}</h2>
                <p class="lead">{!!$tintuc->NoiDung!!}</p>

                <hr>

                <!-- Blog Comments -->

                <!-- Comments Form -->
                @if(Auth::user())
                    <div class="well">
                        
                        @if(session('thongbao'))
                            <div class="alert alert-success">
                                {{session('thongbao')}}
                            </div>
                        @endif
                        <h4>Viết bình luận ...<span class="glyphicon glyphicon-pencil"></span></h4>
                        <form action="comment/{{$tintuc->id}}" method="POST" role="form">
                            <input type="hidden" name="_token" value="{{csrf_token()}}" />
                            <div class="form-group">
                                <textarea name="NoiDung" class="form-control" rows="3"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Gửi</button>
                        </form>
                    </div>
                    
                    <hr>
                    
                @endif

                <!-- Posted Comments -->

                <!-- Comment -->
                @foreach($tintuc->comment as $cm)
                <div class="media">
                    <a class="pull-left" href="">
                        <img style="width: 64px; height: 64px" class="media-object" src="upload/user/{{$cm->user->Hinh}}" alt="">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading">{{$cm->user->name}}
                            <small>{{$cm->created_at}}</small>
                        </h4>
                        {{$cm->NoiDung}}
                    </div>
                    
                    @if(Auth::user()&&$cm->user->name == Auth::user()->name)
                    
                    <div class="pull-right">
                        <button id="xoaComment"><span class="glyphicon glyphicon-option-vertical"></i></button>
                        <div class="delete">
                            <button  class="btn"><a href="delComment/{{$cm->id}}/{{$tintuc->id}}">Xóa</a></button>
                        </div>
                    </div>
                    @endif
                </div>
                @endforeach
            </div>

            <!-- Blog Sidebar Widgets Column -->
            <div class="col-md-3">

                <div class="panel panel-default">
                    <div class="panel-heading"><b>Tin liên quan</b></div>
                    <div class="panel-body">
                        @foreach($tinlienquan as $tlq)
                        <!-- item -->
                        <div class="row" style="margin-top: 10px;">
                            <div class="col-md-5">
                                <a href="tintuc/{{$tlq->id}}/{{$tlq->TieuDeKhongDau}}.html">
                                    <img class="img-responsive" src="upload/tintuc/{{$tlq->Hinh}}" alt="">
                                </a>
                            </div>
                            <div class="col-md-7">
                                <a href="tintuc/{{$tlq->id}}/{{$tlq->TieuDeKhongDau}}.html"><b>{{$tlq->TieuDe}}</b></a>
                            </div>
                            <p style="padding-left: 5px">{{$tlq->TomTat}}</p>
                            <div class="break"></div>
                        </div>
                        <!-- end item -->
                        @endforeach
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading"><b>Tin nổi bật</b></div>
                    <div class="panel-body">
                        @foreach($tinnoibat as $tnb)
                        <!-- item -->
                        <div class="row" style="margin-top: 10px;">
                            <div class="col-md-5">
                                <a href="tintuc/{{$tnb->id}}/{{$tnb->TieuDeKhongDau}}.html">
                                    <img class="img-responsive" src="upload/tintuc/{{$tnb->Hinh}}" alt="">
                                </a>
                            </div>
                            <div class="col-md-7">
                                <a href="tintuc/{{$tnb->id}}/{{$tnb->TieuDeKhongDau}}.html"><b>{{$tnb->TieuDe}}</b></a>
                            </div>
                            <p style="padding-left: 5px">{{$tnb->TomTat}}</p>
                            <div class="break"></div>
                        </div>
                        <!-- end item -->
                        @endforeach
                    </div>
                </div>
                
            </div>

        </div>
        <!-- /.row -->
    </div>
    <!-- end Page Content -->
    <div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v7.0" nonce="lxFGWp8E"></script>
    @endsection