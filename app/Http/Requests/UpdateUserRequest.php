<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Services\UserService;

class UpdateUserRequest extends FormRequest
{

    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $user = $this->userService->show(request('id'));

        $email_rules = ['required', 'string', 'email', 'max:255'];

        if (isset($user->email) && ($user->email != request('email'))) {
            array_push($email_rules, 'unique:users');
        }

        $rules = [
            'name'     => ['required', 'string', 'max:255'],
            'email'    => $email_rules,
        ];

        if (request('password')) {
            $rules['password'] = ['required', 'string', 'min:8', 'confirmed'];
        }

        return $rules;
    }
}
