@extends('admin.layout.index')
@section('content')
  <!-- Page Content -->
   <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Tin Tức Bị Xóa
                        <small>Danh sách</small>
                    </h1>
                </div>
                <!-- /.col-lg-12 -->
                @if(session('thongbao'))
                    <div class="alert alert-success">
                        {{session('thongbao')}}
                    </div>
                @endif
                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr align="center">
                            <th>ID</th>
                            <th>Tiêu đề</th>
                            <th>Tóm tắt</th>
                            <th>Người xóa</th>
                            <th>Ngày xóa</th>
                            <th>Khôi phục</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tintuc_del as $tt)
                        <tr class="odd gradeX" align="center">
                            <td>{{$tt->id}}</td>
                            <td><p>{{$tt->TieuDe}}</p>
                                <img width="100px" src="upload/tintuc/{{$tt->Hinh}}">
                            </td>
                            <td>{{$tt->TomTat}}</td>
                            <td>{{$tt->Ten}}</td>
                            <td>{{$tt->created_at}}</td>
                            <td class="center"><i class="fa fa-trash-o  fa-fw"></i><a href="admin/tintuc/khoiphuc/{{$tt->id}}" onClick = "return confirm('Bạn có chắc chắn muốn khôi phục không?');"> Restore</a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->
@endsection
