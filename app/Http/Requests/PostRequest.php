<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class PostRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'comment'
        ];
    }

    public function params()
    {
        return [
            'user_id' => 1,
            // 'user_id' => Auth::id(),
            'comment' => $this->comment,
        ];
    }
}
