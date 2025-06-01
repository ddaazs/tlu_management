<?php

namespace App\Http\Requests\Document;

use Illuminate\Foundation\Http\FormRequest;

abstract class BaseDocumentRequest extends FormRequest
{
    /**
     * Common validation rules for documents
     */
    protected function baseRules(): array
    {
        return [
            'title' => [
                'required',
                'string',
                'max:255',
                'not_regex:/^\s+$/',
                'regex:/^(?!.*[\r\n]).+$/'
            ],
            'description' => [
                'nullable',
                'string',
                'not_regex:/^\s+$/',
                'regex:/^(?!.*[\r\n]).+$/'
            ],
        ];
    }

    /**
     * Common validation messages
     */
    protected function baseMessages(): array
    {
        return [
            'title.required' => 'Tiêu đề không được để trống!',
            'title.not_regex' => 'Tiêu đề không được chỉ chứa khoảng trắng.',
            'description.not_regex' => 'Nội dung không được chỉ chứa khoảng trắng.',
        ];
    }
}