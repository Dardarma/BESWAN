<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\User;

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
        $userId = (int) $this->route('id');
        // dd($userId, User::find($userId),gettype($userId));
        return [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($userId, 'id'), // Pakai array
            ],
            'password' => 'nullable|string|min:8',
            'tanggal_lahir' => 'required|date', // Validasi format tanggal
            'no_hp' => 'required|string|min:10|max:12', // Jadikan string supaya min dan max berfungsi
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
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
