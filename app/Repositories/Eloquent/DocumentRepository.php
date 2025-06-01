<?php

namespace App\Repositories\Eloquent;

use App\Models\Document;
use App\Repositories\Contracts\IDocumentRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;

class DocumentRepository implements IDocumentRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function getAllDocuments(int $perPage = 10): LengthAwarePaginator
    {
        return Document::orderBy('updated_at', 'desc')->paginate($perPage);
    }

    public function getDocumentById(int $id): ?Document
    {
        return Document::find($id);
    }

    public function createDocument(array $data): Document
    {
        return Document::create($data);
    }

    public function updateDocument(int $id, array $data): bool
    {
        $document = $this->getDocumentById($id);
        if (!$document) {
            return false;
        }
        return $document->update($data);
    }

    public function deleteDocument(int $id): bool
    {
        $document = $this->getDocumentById($id);
        if (!$document) {
            return false;
        }
        return $document->delete();
    }

    public function fileExists(string $path): bool
    {
        return Storage::disk('public')->exists($path);
    }
}
