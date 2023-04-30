@extends('layouts.admin')
@section('title', 'Chi tiết menu')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Chi tiết menu</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Bảng điều khiển</a></li>
                            <li class="breadcrumb-item active">Tất cả menu</li>
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
                        </div>
                        <div class="col-md-6 text-right">
                            <a href="{{ route('menu.edit', ['menu' => $menu->id]) }}"class="btn btn-sm btn-primary">
                                <i class="fas fa-edit"></i> Sửa
                            </a>
                            <a href="{{ route('menu.destroy', ['menu' => $menu->id]) }}"class="btn btn-sm btn-danger">
                                <i class="fas fa-trash"></i> Xóa
                            </a>
                            <a href="{{ route('menu.index') }}"class="btn btn-sm btn-success">
                                <i class="fas fa-long-arrow-alt-left"></i> Quay về danh sách
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    @includeIf('backend.message_alert')
                    <table class="table">
                        <tr>
                            <th>Tên trường</th>
                            <th>Giới thiệu</th>
                        </tr>
                        <tr>
                            <td>Id</td>
                            <td>{{ $menu->id }}</td>
                        </tr>
                        <tr>
                            <td>Link</td>
                            <td>{{ $menu->link }}</td>
                        </tr>
                        <tr>
                            <td>Kiểu</td>
                            <td>{{ $menu->type }}</td>
                        </tr>
                        <tr>
                            <td>Vị trí</td>
                            <td>{{ $menu->position }}</td>
                        </tr>
                        <tr>
                            <td>Tạo bởi</td>
                            <td>{{ $menu->created_by }}</td>
                        </tr>
                        <tr>
                            <td>Người cập nhật</td>
                            <td>{{ $menu->updated_by }}</td>
                        </tr>
                        <tr>
                            <td>Ngày tạo</td>
                            <td>{{ $menu->created_at }}</td>
                        </tr>
                        <tr>
                            <td>Ngày cập nhật</td>
                            <td>{{ $menu->updated_at }}</td>
                        </tr>
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
