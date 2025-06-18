<?php

namespace App\Factories\DocumentFactories;

use App\Models\Document;
use Illuminate\Http\Request;

class WordDocumentCreator extends DocumentCreator
{
    public function createDocument(): DocumentProduct
    {
        return new WordDocument($this->document);
    }
}
