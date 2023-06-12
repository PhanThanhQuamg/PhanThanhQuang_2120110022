@extends('layouts.admin')
@section('title', 'Chi tiết đơn hàng')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Chi tiết đơn hàng</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Bảng điều khiển</a></li>
                            <li class="breadcrumb-item active">Tất cả đơn hàng</li>
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
                            <a href="{{ route('order.index') }}"class="btn btn-sm btn-success">
                                <i class="fas fa-long-arrow-alt-left"></i> Quay về danh sách
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    @includeIf('backend.message_alert')
                    <h3>THÔNG TIN KHÁCH HÀNG</h3>
                    <table class="table table-bordered table-striped">
                        <tr>
                            <td>Mã Khách Hàng</td>
                            <td>MKH 0{{ $order->cus_id }}</td>
                        </tr>
                        <tr>
                            <td>Họ Tên Khách Hàng</td>
                            <td>
                                {{ $order->fullname }}
                            </td>
                        </tr>
                        <tr>
                            <td>Địa chỉ Khách Hàng</td>
                            <td>
                                {{ $order->address }}
                            </td>
                        </tr>
                    </table>
                    <h3 class="py-3">THÔNG TIN ĐƠN HÀNG</h3>

                    @php
                        $tong = 0;
                    @endphp
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">Hình ảnh</th>
                                <th class="text-center">Tên sản phẩm</th>
                                <th class="text-center">Giá sản phẩm</th>
                                <th class="text-center">Số lượng</th>
                                <th class="text-center">Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orderdetail as $donhang)
                                @php
                                    // Hinh
                                    $arr_image = $donhang->productimg;
                                    $hinh = 'hinh.png';
                                    if (count($arr_image) > 0) {
                                        $hinh = $arr_image[0]['image'];
                                    }
                                    //   san pham
                                    $sanpham = $donhang->sanpham;
                                    $namepro = 'san pham A';
                                    $namepro = $sanpham->name;
                                    //tong tien don hang
                                    $tong += $donhang->amount;
                                @endphp
                                <tr>
                                    <td style="width:100px"><img class="img-fluid"
                                            src="{{ asset('images/product/' . $hinh) }}" alt="{{ $hinh }}"></td>
                                    <td>{{ $namepro }}</td>
                                    <td>{{ number_format($donhang->price, 0) }}</td>
                                    <td>{{ $donhang->qty }}</td>
                                    <td>{{ number_format($donhang->amount, 0) }}</td>
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
