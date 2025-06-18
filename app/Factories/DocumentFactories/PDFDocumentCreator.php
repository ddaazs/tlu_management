<?php

namespace App\Factories\DocumentFactories;

use App\Models\Document;
use Illuminate\Http\Request;

class PDFDocumentCreator extends DocumentCreator
{
    public function createDocument(): DocumentProduct
    {
        return new PDFDocument($this->document);
    }
}
