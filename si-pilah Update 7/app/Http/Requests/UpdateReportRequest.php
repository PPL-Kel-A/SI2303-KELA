<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReportRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'judul'         => 'required|string|max:255',
            'deskripsi'     => 'required|string',
            'detail_alamat' => 'required|string',
            'foto_laporan'  => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'judul.required'         => 'Judul laporan harus diisi',
            'judul.max'              => 'Judul laporan maksimal 255 karakter',
            'deskripsi.required'     => 'Deskripsi harus diisi',
            'detail_alamat.required' => 'Detail alamat harus diisi',
            'foto_laporan.image'     => 'File harus berupa gambar',
            'foto_laporan.mimes'     => 'Hanya JPG, JPEG, dan PNG yang diizinkan',
            'foto_laporan.max'       => 'Ukuran foto maksimal 2 MB',
        ];
    }
}
