<?php

namespace App\Http\Controllers;

use App\Factories\DocumentFactories\PDFDocumentCreator;
use App\Factories\DocumentFactories\WordDocumentCreator;
use App\Factories\DocumentFactories\ZipDocumentCreator;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function index()
    {
        $documents = Document::orderBy('updated_at', 'desc')->paginate(10);
        $supportedTypes = $this->getSupportedTypes();

        return view('documents.index', compact('documents', 'supportedTypes'));
    }

    public function create()
    {
        $supportedTypes = $this->getSupportedTypes();
        return view('documents.create', compact('supportedTypes'));
    }

    public function store(Request $request)
    {
        try {
            $file = $request->file('file');
            $extension = strtolower($file->getClientOriginalExtension());

            // Create document instance
            $document = new Document();

            // Get appropriate creator based on file type
            $creator = $this->getCreator($extension, $document, $request);

            if (!$creator) {
                return redirect()->back()->with('error', 'Loại file không được hỗ trợ')->withInput();
            }

            // Process document using factory method
            $result = $creator->processDocument();

            if ($result['success']) {
                return redirect()->route('documents.index')->with('success', $result['message']);
            } else {
                if (isset($result['errors'])) {
                    return redirect()->back()->withErrors($result['errors'])->withInput();
                }
                return redirect()->back()->with('error', $result['message'])->withInput();
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Lỗi tạo tài liệu: ' . $e->getMessage())->withInput();
        }
    }

    public function download($id)
    {
        try {
            $document = Document::findOrFail($id);

            // Create a creator to handle download
            $creator = new PDFDocumentCreator($document, request());
            $documentProduct = $creator->createDocument();

            $filePath = $documentProduct->download();

            return response()->download($filePath, $document->title);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Lỗi tải tài liệu: ' . $e->getMessage());
        }
    }

    /**
     * Hiển thị form chỉnh sửa tài liệu
     */
    public function edit($id)
    {
        $document = Document::findOrFail($id);
        $supportedTypes = $this->getSupportedTypes();

        return view('documents.edit', compact('document', 'supportedTypes'));
    }

    /**
     * Cập nhật tài liệu
     */
    public function update(Request $request, $id)
    {
        try {
            $document = Document::findOrFail($id);
            $file = $request->file('file');

            if ($file) {
                $extension = strtolower($file->getClientOriginalExtension());
                $creator = $this->getCreator($extension, $document, $request);

                if (!$creator) {
                    return redirect()->back()->with('error', 'Loại file không được hỗ trợ')->withInput();
                }

                $result = $creator->processDocument();
            } else {
                // Update without file
                $document->title = $request->title;
                $document->description = $request->description;
                $document->save();

                $result = ['success' => true, 'message' => 'Tài liệu đã được cập nhật thành công'];
            }

            if ($result['success']) {
                return redirect()->route('documents.index')->with('success', $result['message']);
            } else {
                if (isset($result['errors'])) {
                    return redirect()->back()->withErrors($result['errors'])->withInput();
                }
                return redirect()->back()->with('error', $result['message'])->withInput();
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Lỗi cập nhật tài liệu: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $document = Document::findOrFail($id);

            // Create a creator to handle deletion
            $creator = new PDFDocumentCreator($document, request());
            $documentProduct = $creator->createDocument();

            $result = $documentProduct->delete();

            if ($result['success']) {
                return redirect()->route('documents.index')->with('success', $result['message']);
            }

            return redirect()->back()->with('error', $result['message']);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Lỗi xóa tài liệu: ' . $e->getMessage());
        }
    }

    private function getCreator(string $extension, Document $document, Request $request)
    {
        switch ($extension) {
            case 'pdf':
                return new PDFDocumentCreator($document, $request);
            case 'doc':
            case 'docx':
                return new WordDocumentCreator($document, $request);
            case 'zip':
                return new ZipDocumentCreator($document, $request);
            default:
                return null;
        }
    }

    private function getSupportedTypes(): array
    {
        return ['pdf', 'doc', 'docx', 'zip'];
    }
}
