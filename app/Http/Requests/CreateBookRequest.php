<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateBookRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required',
        ];
    }

    public function getTitle(): mixed
    {
        return $this->input('title');
    }

    public function getDescription()
    {
        return $this->input('description');
    }
}
