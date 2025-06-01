<?php

namespace App\Http\Requests\Document;

class StoreDocumentRequest extends BaseDocumentRequest
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
        return array_merge($this->baseRules(), [
            'file' => [
                'required',
                'file',
                'mimes:pdf,doc,docx,zip',
                'max:20480'
            ]
        ]);
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return array_merge($this->baseMessages(), [
            'file.required' => 'Vui lòng chọn file để upload.',
            'file.mimes' => 'Tệp phải có định dạng: pdf, doc, docx hoặc zip.',
            'file.max' => 'Kích thước tệp không được vượt quá 20MB.',
        ]);
    }
}