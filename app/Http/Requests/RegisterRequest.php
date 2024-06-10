<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "username" => "required|max:30|regex:/^[A-Za-z0-9\-_]+$/|unique:users,username,except,id",
            "password" => "required|min:5|max:30",
            "full_name" => "required|max:50|string",
            "phone" => "required|string|size:17|starts_with:+998|unique:users,phone,except,id",
            "email" => "required|max:50|string|unique:users,email,expect,id",
        ];
    }

    public function messages()
    {
        return [
            "username.required" => "username kiriting",
            "username.unique" => "username oldin kiritilgan",
            "username.max" => "username 30 ta belgidan kam bo'lishi kerak",
            "username.regex" => "yaroqsiz username kiritildi",

            
            "password.required" => "parol kiriting",
            "password.min" => "parol 5 ta belgidan kam bo'lmasligi kerak",
            "password.max" => "parol 30 ta belgidan kam bo'lishi kerak",
            
            "full_name.max" => "full_name 50 ta belgidan kam bo'lishi kerak",
            "full_name.required" => "full_name kiriting",
            "full_name.string" => "full_name string holatida kiriting",

            "phone.required" => "telefon raqam kiriting",
            "phone.string" => "telefon raqam string holatida  kiriting",
            "phone.unique" => "telefon raqam oldin kiritilgan",
            "phone.size" => "telefon raqamni to'liq kiriting",
            "phone.starts_with" => "uzbekistanga tegishli telefon raqami kiriting",

            "email.required" => "email kiriting",
            "email.string" => "email string kiriting",
            "email.unique" => "email oldin kiritilgan",
            "email.max" => "email 50 belgidan ko'p bo'lmasligi kerak",
        ];
    }
}
