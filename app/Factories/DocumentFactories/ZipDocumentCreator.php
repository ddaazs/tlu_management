<?php

namespace App\Factories\DocumentFactories;

use App\Models\Document;
use Illuminate\Http\Request;

class ZipDocumentCreator extends DocumentCreator
{
    public function createDocument(): DocumentProduct
    {
        return new ZipDocument($this->document);
    }
}
