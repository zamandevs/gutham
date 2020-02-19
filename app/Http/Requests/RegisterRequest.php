<?php


namespace App\Http\Requests;


class RegisterRequest extends AuthRequest
{
    public function rules()
    {
        return array_merge(parent::rules(), ['name' => 'required', 'email' => 'required|unique:users|email',
        ]);
    }
}
