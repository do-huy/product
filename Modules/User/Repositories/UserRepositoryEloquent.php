<?php

namespace Modules\User\Repositories;

use Modules\User\app\Models\User;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\User\Repositories\UserRepository;
use Validators\User\Repositories\UserValidator;

//add
use Illuminate\Support\Facades\Hash;

/**
 * Class UserRepositoryEloquent.
 *
 * @package namespace Modules\User\Repositories;
 */
class UserRepositoryEloquent extends BaseRepository implements UserRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return User::class;
    }

    public function create($data)
    {
        $user = $this->model;
            $user->fill($data);
            $user->password = Hash::make($data['password']);
        $user->save();
    }

    public function getById($id)
    {
        return $this->model->find($id);
    }

    public function update($data, $id)
    {
        $user = $this->model->find($id);
        $user->fill($data);
        $user->update();
    }

    public function updatePassword($data, $id)
    {
        $user = $this->model->find($id);
        $user->update([
            $user->password = Hash::make($data['password'])
        ]);
        return $user;
    }

     //client

    public function updateProfile()
    {
        $user = $this->model->find(auth()->user()->id)->fill(request()->all());
        $user->save();
        if (request()->has('seller_name')) {
            $user->seller()->update([
                'name' => request()->seller_name,
            ]);
        }
    }

    public function updateProfilePhone()
    {
       $this->model->find(auth()->user()->id)->update([
            'phone' => request()->phone,
        ]);
    }

    public function updateProfileEmail()
    {
       $this->model->find(auth()->user()->id)->update([
            'email' => request()->email,
        ]);
    }

    public function updateProfilePassword()
    {
        $this->model->find(auth()->user()->id)
        ->update([
            'password'=> Hash::make(request()->new_password)
        ]);
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
