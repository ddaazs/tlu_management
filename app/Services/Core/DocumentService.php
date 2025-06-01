<?php

namespace App\Services\Core;

use App\Repositories\Contracts\IDocumentRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class DocumentService
{
    protected $documentRepository;

    /**
     * Create a new class instance.
     */
    public function __construct(IDocumentRepository $documentRepository)
    {
        $this->documentRepository = $documentRepository;
    }

    /**
     * Get all documents
     */
    public function getAllDocuments()
    {
        return $this->documentRepository->getAllDocuments();
    }

    /**
     * Get document by ID
     */
    public function getDocumentById(int $id)
    {
        return $this->documentRepository->getDocumentById($id);
    }

    /**
     * Create new document
     */
    public function createDocument(array $data, UploadedFile $file)
    {
        $filePath = $file->store('documents', 'public');
        $data['file'] = $filePath;

        return $this->documentRepository->createDocument($data);
    }

    /**
     * Update document
     */
    public function updateDocument(int $id, array $data, ?UploadedFile $file = null)
    {
        $document = $this->documentRepository->getDocumentById($id);
        if (!$document) {
            return false;
        }

        if ($file) {
            // Delete old file if exists
            if ($this->documentRepository->fileExists($document->file)) {
                Storage::disk('public')->delete($document->file);
            }
            $data['file'] = $file->store('documents', 'public');
        }

        return $this->documentRepository->updateDocument($id, $data);
    }

    /**
     * Download document
     */
    public function downloadDocument(int $id)
    {
        $document = $this->documentRepository->getDocumentById($id);
        if (!$document || !$this->documentRepository->fileExists($document->file)) {
            return false;
        }

        return response()->download(storage_path('app/public/' . $document->file));
    }
}
