@extends('layouts.admin')
@section('title', 'Tất cả danh mục trang đơn')
{{-- Phân trang --}}
@section('header')
    <link rel="stylesheet" href="{{ asset('jquery.dataTables.min.css') }}">
@endsection
@section('footer')
    <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script>
        let table = new DataTable('#myTable');
    </script>
@endsection
{{-- end phân trang --}}
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Danh mục trang đơn</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Bảng điều khiển</a></li>
                            <li class="breadcrumb-item active">Tất cả danh mục trang đơn</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <button class="btn btn-sm btn-danger" type="submit">
                                <i class="far fa-file-times"></i>Xóa</button>
                        </div>
                        <div class="col-md-6 text-right">
                            <a href="{{ route('page.create') }}"class="btn btn-sm btn-success">
                                <i class="fas fa-plus"></i> Thêm
                            </a>
                            <a href="{{ route('page.trash') }}"class="btn btn-sm btn-danger">
                                <i class="fas fa-trash"></i> Thùng rác
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    @includeIf('backend.message_alert')
                    <table class="table table-bordered table-striped" id="myTable">
                        <thead>
                            <tr>
                                <th style="width:30px" class="text-center">#</th>
                                <th style="width:90px" class="text-center">Hình đại diện</th>
                                <th style="width:100px" class="text-center">Tên chủ đề</th>
                                <th style="width:100px" class="text-center">slug</th>
                                <th style="width:100px" class="text-center">Ngày đăng</th>
                                <th style="width:150px" class="text-center">Chức năng</th>
                                <th style="width:30px" class="text-center">ID</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($list_page as $page)
                                <tr>
                                    <td>
                                        <input type="checkbox">
                                    </td>
                                    <td>
                                        <img class="img-fluid" src="{{ asset('images/page/' . $page->image) }}"
                                            alt="{{ $page->image }}">
                                    </td>
                                    <td>{{ $page->tenchude }}</td>
                                    <td>{{ $page->slug }}</td>
                                    <td class="text-center">{{ $page->created_at }}</td>
                                    <td class="text-center">
                                        @if ($page->status == 1)
                                            <a href="{{ route('page.status', ['page' => $page->id]) }}"
                                                class="btn btn-sm btn-success"><i class="fas fa-toggle-on"></i> </a>
                                        @else
                                            <a href="{{ route('page.status', ['page' => $page->id]) }}"
                                                class="btn btn-sm btn-danger"><i class="fas fa-toggle-off"></i> </a>
                                        @endif

                                        <a href="{{ route('page.edit', ['page' => $page->id]) }}"
                                            class="btn btn-sm btn-info"><i class="fas fa-edit"></i> Edit</a>
                                        <a href="{{ route('page.show', ['page' => $page->id]) }}"
                                            class="btn btn-sm btn-success"><i class="far fa-eye"></i> View</a>
                                        <a href="{{ route('page.delete', ['page' => $page->id]) }}"
                                            class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i> Delete</a>
                                    </td>
                                    <td>{{ $page->id }}</td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    Footer
                </div>
                <!-- /.card-footer-->
            </div>
            <!-- /.card -->

        </section>
        <!-- /.content -->
    </div>
@endsection
