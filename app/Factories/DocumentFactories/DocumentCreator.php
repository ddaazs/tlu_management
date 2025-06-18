<?php

namespace App\Factories\DocumentFactories;

use App\Models\Document;
use Illuminate\Http\Request;

abstract class DocumentCreator
{
    protected Document $document;
    protected Request $request;

    public function __construct(Document $document, Request $request)
    {
        $this->document = $document;
        $this->request = $request;
    }

    abstract public function createDocument(): DocumentProduct;

    public function processDocument(): array
    {
        $documentProduct = $this->createDocument();

        // Validate the document
        $validation = $documentProduct->validate($this->request->all());
        if (!empty($validation['errors'])) {
            return $validation;
        }

        // Process based on request method
        if ($this->request->isMethod('post')) {
            return $documentProduct->create($this->request->all());
        } elseif ($this->request->isMethod('put') || $this->request->isMethod('patch')) {
            return $documentProduct->update($this->request->all());
        }

        return ['success' => false, 'message' => 'Invalid request method'];
    }

    public function getDocumentType(): string
    {
        $documentProduct = $this->createDocument();
        return $documentProduct->getType();
    }
}
