<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LevelStore extends FormRequest
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
        // dd($this->route('id'));

        return [
            'nama_level' => [
                'required',
                'string',
                'max:255',
                Rule::unique('level', 'nama_level')->ignore($this->route('id')),
            ],
            'deskripsi_level' => 'required|string',
            'warna' => 'required|string'
        ];
    }
    
    

    public function messages(): array
    {
        return [
            'nama_level.required' => 'Nama level harus diisi',
            'nama_level.string' => 'Nama level harus berupa string',
            'nama_level.max' => 'Nama level maksimal 255 karakter',
            'nama_level.unique' => 'Nama level sudah ada',
            'deskripsi_level.required' => 'Deskripsi level harus diisi',
            'deskripsi_level.string' => 'Deskripsi level harus berupa string',
        ];
    }
}
