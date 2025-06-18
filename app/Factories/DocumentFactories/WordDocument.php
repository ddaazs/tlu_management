<?php

namespace App\Factories\DocumentFactories;

use App\Models\Document;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class WordDocument implements DocumentProduct
{
    protected Document $document;

    public function __construct(Document $document)
    {
        $this->document = $document;
    }

    public function create(array $data): array
    {
        try {
            $filePath = $data['file']->store('documents/word', 'public');

            $this->document->create([
                'title' => $data['title'],
                'description' => $data['description'] ?? null,
                'file' => $filePath,
            ]);

            return ['success' => true, 'message' => 'Word document created successfully'];
        } catch (\Exception $e) {
            return ['success' => false, 'message' => 'Failed to create Word document: ' . $e->getMessage()];
        }
    }

    public function update(array $data): array
    {
        try {
            if (isset($data['file'])) {
                // Delete old file
                if (Storage::disk('public')->exists($this->document->file)) {
                    Storage::disk('public')->delete($this->document->file);
                }

                $filePath = $data['file']->store('documents/word', 'public');
                $this->document->file = $filePath;
            }

            $this->document->title = $data['title'];
            $this->document->description = $data['description'] ?? null;
            $this->document->save();

            return ['success' => true, 'message' => 'Word document updated successfully'];
        } catch (\Exception $e) {
            return ['success' => false, 'message' => 'Failed to update Word document: ' . $e->getMessage()];
        }
    }

    public function delete(): array
    {
        try {
            if (Storage::disk('public')->exists($this->document->file)) {
                Storage::disk('public')->delete($this->document->file);
            }

            $this->document->delete();
            return ['success' => true, 'message' => 'Word document deleted successfully'];
        } catch (\Exception $e) {
            return ['success' => false, 'message' => 'Failed to delete Word document: ' . $e->getMessage()];
        }
    }

    public function download(): string
    {
        if (Storage::disk('public')->exists($this->document->file)) {
            return storage_path('app/public/' . $this->document->file);
        }
        throw new \Exception('Word file not found');
    }

    public function validate(array $data): array
    {
        $validator = Validator::make($data, [
            'title' => 'required|string|max:255|not_regex:/^\s+$/|regex:/^(?!.*[\r\n]).+$/',
            'description' => 'nullable|string|not_regex:/^\s+$/|regex:/^(?!.*[\r\n]).+$/',
            'file' => 'required|file|mimes:doc,docx|max:20480'
        ], [
            'title.required' => 'Tiêu đề không được để trống!',
            'title.not_regex' => 'Tiêu đề không được chỉ chứa khoảng trắng.',
            'description.not_regex' => 'Nội dung không được chỉ chứa khoảng trắng.',
            'file.mimes' => 'Tệp phải có định dạng DOC hoặc DOCX.',
            'file.max'   => 'Kích thước tệp không được vượt quá 20MB.',
        ]);

        if ($validator->fails()) {
            return ['errors' => $validator->errors()];
        }

        return ['success' => true];
    }

    public function getType(): string
    {
        return 'word';
    }
}
