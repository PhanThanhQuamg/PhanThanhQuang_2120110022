@extends('layouts.site')
@section('title', 'Đăng nhập')
@section('content')
    <section id="form">
        <!--form-->
        <div class="container">
            <div class="row">
                <div class="col-sm-4 col-sm-offset-1">
                    <div class="login-form">
                        <!--login form-->
                        <h2>Đăng nhập tài khoản</h2>
                        <form action="{{ route('frontend.postlogin') }}" method="post">
                            @method('POST')
                            @csrf
                            <input type="text" name="username" placeholder="Tên tài khoản">
                            <input type="password" name="password" placeholder="Mật khẩu">
                            <span>
                                <input type="checkbox" class="checkbox">
                                Nhớ mật khẩu
                            </span>
                            <button type="submit" class="btn btn-default">Đăng nhập</button>
                        </form>
                    </div>
                    <!--/login form-->
                </div>
                <div class="col-sm-1">
                    <h2 class="or">Hoặc</h2>
                </div>
                <div class="col-sm-4">
                    <div class="signup-form">
                        <!--sign up form-->
                        <h2>Đăng ký người dùng mới!</h2>
                        <form action="{{ route('frontend.postregister') }}" method="post">
                            @method('POST')
                            @csrf
                            <input type="text" name="name" placeholder="Tên đăng nhập">
                            @if ($errors->has('name'))
                                <div class="text-danger">
                                    {{ $errors->first('name') }}
                                </div>
                            @endif
                            <input type="text" name="username" placeholder="Tên tài khoản">
                            @if ($errors->has('username'))
                                <div class="text-danger">
                                    {{ $errors->first('username') }}
                                </div>
                            @endif
                            <input type="email" name="email" placeholder="Địa chỉ email">
                            @if ($errors->has('email'))
                                <div class="text-danger">
                                    {{ $errors->first('email') }}
                                </div>
                            @endif
                            <input type="password" name="password" placeholder="Mật khẩu">
                            @if ($errors->has('password'))
                                <div class="text-danger">
                                    {{ $errors->first('password') }}
                                </div>
                            @endif
                            <input type="text" name="phone" placeholder="SĐT">
                            @if ($errors->has('phone'))
                                <div class="text-danger">
                                    {{ $errors->first('phone') }}
                                </div>
                            @endif
                            <input type="text" name="address" placeholder="Địa chỉ">
                            @if ($errors->has('address'))
                                <div class="text-danger">
                                    {{ $errors->first('address') }}
                                </div>
                            @endif
                            <button type="submit" class="btn btn-default">Đăng ký</button>
                        </form>
                    </div>
                    <!--/sign up form-->
                </div>
            </div>
        </div>
    </section>
@endsection
