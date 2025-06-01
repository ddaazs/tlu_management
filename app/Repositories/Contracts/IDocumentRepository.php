<?php

namespace App\Repositories\Contracts;

use App\Models\Document;
use Illuminate\Pagination\LengthAwarePaginator;

interface IDocumentRepository
{
    /**
     * Get all documents with pagination
     */
    public function getAllDocuments(int $perPage = 10): LengthAwarePaginator;

    /**
     * Get document by ID
     */
    public function getDocumentById(int $id): ?Document;

    /**
     * Create new document
     */
    public function createDocument(array $data): Document;

    /**
     * Update document
     */
    public function updateDocument(int $id, array $data): bool;

    /**
     * Delete document
     */
    public function deleteDocument(int $id): bool;

    /**
     * Check if file exists
     */
    public function fileExists(string $path): bool;
}
