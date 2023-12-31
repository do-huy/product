{{-- <x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div>
                <x-label for="name" value="{{ __('Name') }}" />
                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            </div>

            <div class="mt-4">
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" autocomplete="username" />
            </div>

            <div class="mt-4">
                <x-label for="phone" value="{{ __('Số điện thoại') }}" />
                <x-input id="phone" class="block mt-1 w-full" type="number" name="phone" :value="old('phone')" required />
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            </div>

            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-4">
                    <x-label for="terms">
                        <div class="flex items-center">
                            <x-checkbox name="terms" id="terms" required />

                            <div class="ms-2">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                        'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Terms of Service').'</a>',
                                        'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Privacy Policy').'</a>',
                                ]) !!}
                            </div>
                        </div>
                    </x-label>
                </div>
            @endif

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-button class="ms-4">
                    {{ __('Register') }}
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
                    <li class="active">Đăng ký</li>
                </ul>
            </div>
        </div>
    </div>
<!-- Li's Breadcrumb Area End Here -->
<!-- Begin Login Content Area -->
    <div class="page-section mb-60">
        <div class="container">
            <div style="justify-content: center;margin-top:20px" class="row">
                <div class="col-sm-12 col-md-12 col-lg-6 col-xs-12">
                    <form action="{{ route('register') }}" method="POST">
                    @csrf
                        <div class="login-form">
                            <h4 class="login-title">Đăng ký</h4>
                            @foreach ($errors->all() as $error)
                                <div class="alert alert-danger">
                                    <p class="text-danger">{{ $error }}</p>
                                </div>
                            @endforeach
                            <div class="row">
                                <div class="col-md-12 mb-20">
                                    <label>Họ và tên*</label>
                                    <input class="mb-0" type="text" name="name" value="{{ old('name') }}" placeholder="Nhập họ và tên ...">
                                </div>
                                <div class="col-md-12 mb-20">
                                    <label>Email*</label>
                                    <input class="mb-0" type="email" name="email" value="{{ old('email') }}"  placeholder="Nhập email ...">
                                </div>
                                <div class="col-md-12 mb-20">
                                    <label>Số điện thoại*</label>
                                    <input class="mb-0" type="number" name="phone" value="{{ old('phone') }}" placeholder="Nhập số điện thoại ...">
                                </div>
                                <div class="col-md-6 mb-20">
                                    <label>Mật khẩu*</label>
                                    <input class="mb-0" type="password" name="password" placeholder="Nhập mật khẩu ...">
                                </div>
                                <div class="col-md-6 mb-20">
                                    <label>Nhập lại mật khẩu*</label>
                                    <input class="mb-0" type="password" name="password_confirmation" placeholder="Nhập lại mật khẩu ...">
                                </div>
                                <div class="col-md-12 mb-20">
                                    <div class="register-form"><a href="{{ route('login') }}">Bạn đã có tài khoản? Đăng nhập ngay</a></div>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="register-button mt-0">Đăng ký</button>
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
