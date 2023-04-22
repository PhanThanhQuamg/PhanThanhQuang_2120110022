@extends('layouts.admin')
@section('title', 'Chi tiết bài viết')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Chi tiết bài viết</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Bảng điều khiển</a></li>
                            <li class="breadcrumb-item active">Tất cả bài viết</li>
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
                            <a href="{{ route('page.edit', ['page' => $page->id]) }}"class="btn btn-sm btn-primary">
                                <i class="fas fa-edit"></i> Sửa
                            </a>
                            <a href="{{ route('page.destroy', ['page' => $page->id]) }}"class="btn btn-sm btn-danger">
                                <i class="fas fa-trash"></i> Xóa
                            </a>
                            <a href="{{ route('page.index') }}"class="btn btn-sm btn-success">
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
                            <td>{{ $page->id }}</td>
                        </tr>
                        <tr>
                            <td>Tên bài viết</td>
                            <td>{{ $page->title }}</td>
                        </tr>
                        <tr>
                            <td>Slug</td>
                            <td>{{ $page->slug }}</td>
                        </tr>
                        <tr>
                            <td>Danh mục chủ đề</td>
                            <td>{{ $page->topic_id }}</td>
                        </tr>
                        <tr>
                            <td>Hình ảnh</td>
                            <td>
                                <img class="img-fluid" src="{{ asset('images/page/' . $page->image) }}"
                                    alt="{{ $page->image }}">
                            </td>
                        </tr>
                        <tr>
                            <td>Từ khóa</td>
                            <td>{{ $page->metakey }}</td>
                        </tr>
                        <tr>
                            <td>Mô tả</td>
                            <td>{{ $page->metadesc }}</td>
                        </tr>
                        <tr>
                            <td>Chi tiết</td>
                            <td>{{ $page->detail }}</td>
                        </tr>
                        <tr>
                            <td>Tạo bởi</td>
                            <td>{{ $page->create_by }}</td>
                        </tr>
                        <tr>
                            <td>Người cập nhật</td>
                            <td>{{ $page->update_by }}</td>
                        </tr>
                        <tr>
                            <td>Ngày tạo</td>
                            <td>{{ $page->created_at }}</td>
                        </tr>
                        <tr>
                            <td>Ngày cập nhật</td>
                            <td>{{ $page->updated_at }}</td>
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
