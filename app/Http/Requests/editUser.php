<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class editUser extends FormRequest
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
        $userId = $this->route('id');
        return [
            'name' => 'required|string|max:255',
            Rule::unique('users', 'email')->ignore($userId),
            'password' => 'nullable|string|min:8',
            'tanggal_lahir' => 'required',
            'no_hp' => 'required|min:10|max:12'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Nama harus diiisi',
            'name.max' => 'nama terlalu panjang',
            'email.required' => 'Email harus ada',
            'email.unique' => 'email sudah dipakai',
            'password.min' => 'password min 8',
            'tanggal_lahir.required' => 'tanggal lahir tidak boleh kosong',
            'no_hp.required' => 'nomor telephone tidak boleh kosong',
            'no_hp.min' => 'pastikan nomor telephone benar',
            'no_hp.max' => 'pastikan nomor telephone benar'
        ];
    }
}
