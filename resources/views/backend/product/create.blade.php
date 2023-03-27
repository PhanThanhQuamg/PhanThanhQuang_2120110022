@extends('layouts.admin')
@section('title', 'Thêm sản phẩm')
@section('content')
    <form action="{{ route('product.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Thêm sản phẩm</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Bảng điều khiển</a>
                                </li>
                                <li class="breadcrumb-item active">Thêm sản phẩm</li>
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
                                <button type="submit" class="btn btn-sm btn-success">
                                    <i class="fas fa-save"></i> Lưu[Thêm]
                                </button>
                                <a href="{{ route('product.index') }}"class="btn btn-sm btn-info">
                                    <i class="fas fa-trash"></i> Quay lại danh sách
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        @includeIf('backend.message_alert')
                        <div class="row">
                            <div class="col-md-9">
                                <div class="mb-3">
                                    <label for="name">Tên </label>
                                    <input type="text" name="name" value="{{ old('name') }}" id="name"
                                        class="form-control" placeholder="Nhập tên ">
                                </div>
                                <div class="mb-3">
                                    <label for="detail">Chi tiết</label>
                                    <textarea name="detail" id="detail" class="form-control" placeholder="Chi tiết sản phẩm">{{ old('detail') }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="metakey">Từ khóa</label>
                                    <textarea name="metakey" id="metakey" class="form-control" placeholder="Từ khóa tìm kiếm">{{ old('metakey') }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="metadesc">Mô tả</label>
                                    <textarea name="metadesc" id="metadesc" class="form-control" placeholder="Nhập mô tả">{{ old('metadesc') }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="category_id">Danh mục sản phẩm</label>
                                    <select class="form-control" name="category_id" id="category_id">
                                        <option value="0">Chọn danh mục-</option>
                                        @foreach ($html_category_id as $item)
                                            <option value=" {{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="brand_id">Thương hiệu sản phẩm</label>
                                    <select class="form-control" name="brand_id" id="brand_id">
                                        <option value="0">Chọn thương hiệu</option>
                                        @foreach ($html_brand_id as $item)
                                            <option value=" {{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="price">Giá </label>
                                    <input type="number" name="price" value="{{ old('price') }}" id="price"
                                        class="form-control" placeholder="Nhập giá sản phẩm ">
                                </div>
                                <div class="mb-3">
                                    <label for="image">Hình đại diện</label>
                                    <input type="file" name="image" value="{{ old('image') }}" id="image"
                                        class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label for="status">Trạng thái</label>
                                    <select class="form-control" name="status" id="status">
                                        <option value="1">Xuất bản</option>
                                        <option value="0">Chưa xuất bản</option>
                                    </select>
                                </div>
                            </div>
                        </div>
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
    </form>
@endsection
