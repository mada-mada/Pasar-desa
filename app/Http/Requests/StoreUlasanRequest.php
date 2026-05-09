<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreUlasanRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'ulasanable_id' => 'required|integer',
            'ulasanable_type' => 'required|string|in:App\Models\PasarDesa,App\Models\Artikel',
            'nama_pengunjung' => 'required|string|max:100',
            'kontak' => 'nullable|string|max:100',
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'required|string|max:500',
        ];
    }
}
