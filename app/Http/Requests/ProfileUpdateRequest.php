<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        if (! $this->user()?->isCandidate()) {
            return [];
        }

        return [
            'phone' => ['nullable', 'string', 'max:40'],
            'location' => ['nullable', 'string', 'max:255'],
            'headline' => ['nullable', 'string', 'max:255'],
            'summary' => ['nullable', 'string', 'max:5000'],
            'cv' => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:2048'],
            'remove_cv' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'cv.max' => 'The CV must not be larger than 2 MB.',
            'cv.mimes' => 'The CV must be a PDF, DOC, or DOCX file.',
        ];
    }
}
