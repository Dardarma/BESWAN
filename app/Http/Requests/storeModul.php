<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class storeModul extends FormRequest
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
            'judul' => 'required|string',
            'deskripsi' => 'required|string',
            'url_file' => 'required|file|mimes:pdf,doc,docx|max:5120',
            'author' => 'required|string',
            'tumbnail' => 'required|file|mimes:jpeg,jpg,png|max:2048',
            'terbitan' => 'required|date',
        ];
    }
}
