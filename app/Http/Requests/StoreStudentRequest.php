<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStudentRequest extends FormRequest
{
    public function authorize() { return true; }

    public function rules()
    {
        return [
            'name'        => 'required|string|max:255',
            'phone' => [
                    'required',
                    'string',
                    'max:20',
                    'unique:users,phone',
                    'unique:students,phone',
                ],

            'email'       => 'nullable|email|max:255|unique:users,email',
            'looking_for' => 'required|string',

             'utm_source'   => 'nullable|string|max:255',
            'utm_medium'   => 'nullable|string|max:255',
            'utm_campaign' => 'nullable|string|max:255',
            'utm_term'     => 'nullable|string|max:255',
            'utm_content'  => 'nullable|string|max:255',
            'agree_terms' => 'required|accepted',
        ];  
    }
    
        public function messages()
        {
            return [
                'phone.unique'         => 'This phone number is already registered.',
                'email.unique'         => 'This email is already registered.',
                'agree_terms.accepted' => 'You must agree to receive information before submitting.',
                'agree_terms.required' => 'Please accept the consent checkbox.',
            ];
        }
}
