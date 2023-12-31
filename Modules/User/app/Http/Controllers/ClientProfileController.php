<?php

namespace Modules\User\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Modules\User\app\Http\Requests\Client\UpdateProfileEmailRequest;
use Modules\User\app\Http\Requests\Client\UpdateProfilePasswordRequest;
use Modules\User\app\Http\Requests\Client\UpdateProfilePhoneRequest;
use Modules\User\app\Http\Requests\Client\UpdateProfileRequest;
use Modules\User\Services\UserService;

class ClientProfileController extends Controller
{
    protected $userService;
    public function __construct(UserService $userService) {
        $this->userService = $userService;
    }
    /**
     * Display a listing of the resource.
     */
    public function profile()
    {
        return view('user::client.profile.index');
    }
    public function update_profile(UpdateProfileRequest $request)
    {
        return DB::transaction(function () use ($request) {
            $this->userService->updateProfile();
            return response()->json([
                'success' => 'Cập nhập thành công',
            ], 200);
        });
    }

    public function phone()
    {
        return view('user::client.profile.phone');
    }

    public function update_phone(UpdateProfilePhoneRequest $request)
    {
        return DB::transaction(function () use ($request) {
            $this->userService->updateProfilePhone();
            return response()->json([
                'success' => 'Cập nhập thành công',
            ], 200);
        });
    }

    public function email()
    {
        return view('user::client.profile.email');
    }

    public function update_email(UpdateProfileEmailRequest $request)
    {
        return DB::transaction(function () use ($request) {
            $this->userService->updateProfileEmail();
            return response()->json([
                'success' => 'Cập nhập thành công',
            ], 200);
        });
    }

    public function password()
    {
        return view('user::client.profile.password');
    }

    public function update_password(UpdateProfilePasswordRequest $request)
    {
        return DB::transaction(function () use ($request) {
            $this->userService->updateProfilePassword();
            return response()->json([
                'success' => 'Cập nhập thành công',
            ], 200);
        });
    }
}
