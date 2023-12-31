{{-- <x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-label for="loginname" value="{{ __('Số điện thoại / Email') }}" />
                <x-input id="loginname" class="block mt-1 w-full" type="text" name="loginname" :value="old('loginname')" required autofocus autocomplete="username" />
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-checkbox id="remember_me" name="remember" />
                    <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <x-button class="ms-4">
                    {{ __('Log in') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout> --}}
@extends('client.master')
@section('content')
<!-- Begin Li's Breadcrumb Area -->
<div class="breadcrumb-area">
    <div class="container">
        <div class="breadcrumb-content">
            <ul>
                <li><a href="{{ route('home') }}">Trang chủ</a></li>
                <li class="active">Đăng nhập</li>
            </ul>
        </div>
    </div>
</div>
<!-- Li's Breadcrumb Area End Here -->
<!-- Begin Login Content Area -->
<div class="page-section mb-60">
    <div class="container">
        <div style="justify-content: center;margin-top:20px" class="row">
            <div class="col-sm-12 col-md-12 col-xs-12 col-lg-6 mb-30">
                <!-- Login Form s-->
                <form method="POST"  action="{{ route('login') }}" >
                @csrf
                    <div class="login-form">
                        <h4 class="login-title">Đăng nhập</h4>
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger">
                                <p class="text-danger">{{ $error }}</p>
                            </div>
                        @endforeach
                        <div class="row">
                            <div class="col-md-12 col-12 mb-20">
                                <label>Số điện thoại / Email</label>
                                <input class="mb-0" type="text" name="loginname" value="{{ old('loginname') }}" placeholder="Nhập số điện thoại hoặc email ...">
                            </div>
                            <div class="col-12 mb-20">
                                <label>Mật khẩu</label>
                                <input class="mb-0" type="password" name="password" placeholder="Nhập mật khẩu ...">
                            </div>
                            <div class="col-md-8">
                                <div class="check-box d-inline-block ml-0 ml-md-2 mt-10">
                                    <input type="checkbox" id="remember_me">
                                    <label for="remember_me">Ghi nhớ</label>
                                </div>
                            </div>
                            <div class="col-md-4 mt-10 mb-20 text-left text-md-right">
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}">Bạn quên mật khẩu?</a>
                                @endif
                            </div>
                            <div class="col-md-12 mb-20">
                                <div class="register-form"><a href="{{ route('register') }}">Bạn chưa có tài khoản? Đăng ký ngay</a></div>
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="register-button mt-0">Đăng nhập</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Login Content Area End Here -->
@endsection
