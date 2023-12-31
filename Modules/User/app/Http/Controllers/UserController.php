<?php

namespace Modules\User\app\Http\Controllers;

use App\DataTables\UsersDataTable;
use App\Http\Controllers\Controller;
use App\Traits\DeleteModelTraits;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Modules\User\app\Http\Requests\CreateUserRequest;
use Modules\User\app\Http\Requests\UpdatePasswordUserRequest;
use Modules\User\app\Http\Requests\UpdateUserRequest;
use Modules\User\app\Models\User;
use Modules\User\Services\UserService;

class UserController extends Controller
{
    use DeleteModelTraits;

    protected $userService, $user;
    public function __construct(UserService $userService, User $user) {
        $this->userService = $userService;
        $this->user = $user;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(UsersDataTable $usersDataTable)
    {
        return $usersDataTable->render('user::index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateUserRequest $request)
    {
        return DB::transaction(function () use ($request) {
            $data = $request->all();
            $this->userService->createUser($data);
            return redirect()->route('user.index')->with('success','Thêm tài khoản thành công.');
        });
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('user::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = $this->userService->getById($id);
        return view('user::edit',compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, $id)
    {
        return DB::transaction(function () use ($request, $id) {
            $data = $request->all();
            $this->userService->updateUser($data, $id);
            return redirect()->route('user.index')->with('success','Cập nhập tài khoản thành công.');
        });
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        return $this->deleteModelTraits($id, $this->user);
    }

    public function edit_password($id)
    {
        $user = $this->userService->getById($id);
        return view('user::password',compact('user'));
    }

    public function update_password(UpdatePasswordUserRequest $request, $id)
    {
        return DB::transaction(function () use ($request, $id) {
            $data = $request->all();
            $this->userService->updatePasswordUser($data, $id);
            return redirect()->route('user.index')->with('success','Đặt lại mật khẩu thành công.');
        });
    }
}
