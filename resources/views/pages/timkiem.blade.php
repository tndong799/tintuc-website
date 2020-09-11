@extends('layout.index')
@section('content')
<!-- Page Content -->
<div class="container">
    <div class="row">
        @include('layout.menu')
        <?php
            function doimau($str,$tukhoa){
                return str_replace($tukhoa,"<span style='color:red'>$tukhoa</span>",$str);
            }
        ?>
        <div class="col-md-9 ">
            <div class="panel panel-default">
                <div class="panel-heading" style="background-color:#337AB7; color:white;">
                <h4><b>Tìm kiếm : {{$tukhoa}}</b></h4>
                </div>
                @foreach($tintuc as $tt)
                <div class="row-item row">
                    <div class="col-md-3">

                        <a href="tintuc/{{$tt->id}}/{{$tt->TieuDeKhongDau}}.html">
                            <br>
                            <img style="max-width: 200px;max-height: 200px" class="img-responsive" src="upload/tintuc/{{$tt->Hinh}}" alt="">
                        </a>
                    </div>
                
                    <div class="col-md-9">
                        <h3>{!! doimau($tt->TieuDe,$tukhoa) !!}</h3>
                        <p>{!! doimau($tt->TomTat,$tukhoa) !!}</p>
                        <a class="btn btn-primary" href="tintuc/{{$tt->id}}/{{$tt->TieuDeKhongDau}}.html">Xem thêm<span class="glyphicon glyphicon-chevron-right"></span></a>
                    </div>
                    <div class="break"></div>
                </div>
                @endforeach
                <div style="text-align: center">
                {{$tintuc->appends(Request::all())->links()}}
                </div>

            </div>
        </div> 

    </div>

</div>
<!-- end Page Content -->
@endsection