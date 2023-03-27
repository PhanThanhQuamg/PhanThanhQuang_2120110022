@extends('layouts.admin')
@section('title', 'Chi tiết thương hiệu sản phẩm')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Chi tiết thương hiệu sản phẩm</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Bảng điều khiển</a></li>
                            <li class="breadcrumb-item active">Tất cả thương hiệu sản phẩm</li>
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
                            <a
                                href="{{ route('product.edit', ['product' => $product->id]) }}"class="btn btn-sm btn-primary">
                                <i class="fas fa-edit"></i> Sửa
                            </a>
                            {{-- <a href="{{ route('product.destroy', ['product' => $product->id]) }}"class="btn btn-sm btn-danger">
                                <i class="fas fa-trash"></i> Xóa
                            </a> --}}
                            <a href="{{ route('product.index') }}"class="btn btn-sm btn-success">
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
                            <td>{{ $product->id }}</td>
                        </tr>
                        <tr>
                            <td>Name</td>
                            <td>{{ $product->name }}</td>
                        </tr>
                        <tr>
                            <td>Slug</td>
                            <td>{{ $product->slug }}</td>
                        </tr>
                        <tr>
                            <td>Hình ảnh</td>
                            <td>
                                <img class="img-fluid" src="{{ asset('images/product/' . $product->image) }}"
                                    alt="{{ $product->image }}">
                            </td>
                        </tr>
                        <tr>
                            <td>Từ khóa</td>
                            <td>{{ $product->metakey }}</td>
                        </tr>
                        <tr>
                            <td>Mô tả</td>
                            <td>{{ $product->metadesc }}</td>
                        </tr>
                        <tr>
                            <td>Tạo bởi</td>
                            <td>{{ $product->create_by }}</td>
                        </tr>
                        <tr>
                            <td>Người cập nhật</td>
                            <td>{{ $product->update_by }}</td>
                        </tr>
                        <tr>
                            <td>Ngày tạo</td>
                            <td>{{ $product->created_at }}</td>
                        </tr>
                        <tr>
                            <td>Ngày cập nhật</td>
                            <td>{{ $product->updated_at }}</td>
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
