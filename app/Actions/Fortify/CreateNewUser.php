<?php

namespace App\Actions\Fortify;

use Modules\User\app\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'min:10', 'max:10', 'unique:users'],
            'password' => $this->passwordRules(),
            'password_confirmation' =>['required', 'string'],
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ],[
            'name.required'         =>  'Họ và tên không được bỏ trống.',
            'email.required'        =>  'Email không được bỏ trống.',
            'email.unique'          =>  'Email đã tồn tại.',
            'phone.required'        =>  'Số điện thoại không được bỏ trống.',
            'phone.max'             =>  'Số điện thoại không vượt quá 10 ký tự.',
            'phone.min'             =>  'Số điện thoại không ít hơn 10 ký tự.',
            'phone.unique'          =>  'Số điện thoại đã tồn tại.',
            'password.required'     =>  'Mật khẩu không được bỏ trống.',
            'password.min'          =>  'Mật khẩu không ít hơn 8 ký tự.',
            'password.confirmed'    =>  'Mật khẩu không khớp.',
            'password_confirmation.required' => 'Nhập lại mật khẩu không được bỏ trống.',
        ])->validate();

        $user =  User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'phone' => $input['phone'],
            'password' => Hash::make($input['password']),
        ]);

        $user->seller()->create([
            'name' => $user['name'] . '\'s Sene',
            'description' => $user['name'] . '\'s Sene Shop',
        ]);
        return $user;
    }
}
