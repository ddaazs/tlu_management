<?php

namespace App\Http\Controllers;

use App\Http\Requests\Document\StoreDocumentRequest;
use App\Http\Requests\Document\UpdateDocumentRequest;
use App\Services\Core\DocumentService;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    protected $documentService;

    public function __construct(DocumentService $documentService)
    {
        $this->middleware(['auth']);
        $this->documentService = $documentService;
    }

    /**
     * Display a listing of documents
     */
    public function index()
    {
        $documents = $this->documentService->getAllDocuments();
        return view('documents.index', compact('documents'));
    }

    /**
     * Show the form for creating a new document
     */
    public function create()
    {
        return view('documents.create');
    }

    /**
     * Store a newly created document
     */
    public function store(StoreDocumentRequest $request)
    {
        $this->documentService->createDocument(
            $request->only(['title', 'description']),
            $request->file('file')
        );

        return redirect()->route('documents.index')
            ->with('success', 'Tài liệu đã được upload thành công.');
    }

    /**
     * Download document
     */
    public function download($id)
    {
        $response = $this->documentService->downloadDocument($id);
        if (!$response) {
            return redirect()->back()->with('error', 'File không tồn tại.');
        }
        return $response;
    }

    /**
     * Show the form for editing document
     */
    public function edit($id)
    {
        $document = $this->documentService->getDocumentById($id);
        return view('documents.edit', compact('document'));
    }

    /**
     * Update document
     */
    public function update(UpdateDocumentRequest $request, $id)
    {
        $this->documentService->updateDocument(
            $id,
            $request->only(['title', 'description']),
            $request->hasFile('file') ? $request->file('file') : null
        );

        return redirect()->route('documents.index')
            ->with('success', 'Tài liệu đã được cập nhật thành công.');
    }
}
