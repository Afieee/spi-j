<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;

class AuditRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'tanggal' => ['required', 'date'],
            'divisi' => ['required', 'string'],
            'judul' => ['required', 'string'],
            'bentuk_kegiatan' => ['required', 'string'],
            'type' => ['required', 'string'],
        ];

        if (Route::is('admin.menu.store')) {
            $rules['nomorLaporan'] = ['required', 'unique:audits,code'];
        } else {
            // Assuming $this->menu is the menu model being updated
            $rules['nomorLaporan'] = ['required', 'unique:audits,code,' . $this->audit->id];
        }

        return $rules;
    }
}
