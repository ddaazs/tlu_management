# Factory Method Pattern Implementation

## Tổng quan

Hệ thống quản lý tài liệu sử dụng **Factory Method Pattern** trực tiếp trong Controller để tạo ra các đối tượng document khác nhau dựa trên loại file.

## Cấu trúc Factory Method Pattern

### 1. Abstract Creator
**File**: `app/Factories/DocumentFactories/DocumentCreator.php`

```php
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
}
```

### 2. Product Interface
**File**: `app/Factories/DocumentFactories/DocumentProduct.php`

```php
interface DocumentProduct
{
    public function create(array $data): array;
    public function update(array $data): array;
    public function delete(): array;
    public function download(): string;
    public function validate(array $data): array;
    public function getType(): string;
}
```

### 3. Concrete Creators

#### PDFDocumentCreator
**File**: `app/Factories/DocumentFactories/PDFDocumentCreator.php`

```php
class PDFDocumentCreator extends DocumentCreator
{
    public function createDocument(): DocumentProduct
    {
        return new PDFDocument($this->document);
    }
}
```

#### WordDocumentCreator
**File**: `app/Factories/DocumentFactories/WordDocumentCreator.php`

```php
class WordDocumentCreator extends DocumentCreator
{
    public function createDocument(): DocumentProduct
    {
        return new WordDocument($this->document);
    }
}
```

#### ZipDocumentCreator
**File**: `app/Factories/DocumentFactories/ZipDocumentCreator.php`

```php
class ZipDocumentCreator extends DocumentCreator
{
    public function createDocument(): DocumentProduct
    {
        return new ZipDocument($this->document);
    }
}
```

### 4. Concrete Products

#### PDFDocument
**File**: `app/Factories/DocumentFactories/PDFDocument.php`

- Xử lý tạo, cập nhật, xóa, download file PDF
- Validation riêng cho file PDF
- Lưu trữ trong thư mục `documents/pdf`

#### WordDocument
**File**: `app/Factories/DocumentFactories/WordDocument.php`

- Xử lý tạo, cập nhật, xóa, download file Word (doc, docx)
- Validation riêng cho file Word
- Lưu trữ trong thư mục `documents/word`

#### ZipDocument
**File**: `app/Factories/DocumentFactories/ZipDocument.php`

- Xử lý tạo, cập nhật, xóa, download file ZIP
- Validation riêng cho file ZIP
- Lưu trữ trong thư mục `documents/zip`

## Controller Integration

### DocumentController
**File**: `app/Http/Controllers/DocumentController.php`

Controller sử dụng Factory Method pattern trực tiếp:

```php
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
```

## Cách sử dụng

### 1. Tạo document mới
```php
// Trong Controller
$creator = $this->getCreator($extension, $document, $request);
$result = $creator->processDocument();
```

### 2. Cập nhật document
```php
// Trong Controller
$creator = $this->getCreator($extension, $document, $request);
$result = $creator->processDocument();
```

### 3. Xóa document
```php
// Trong Controller
$creator = new PDFDocumentCreator($document, request());
$documentProduct = $creator->createDocument();
$result = $documentProduct->delete();
```

### 4. Download document
```php
// Trong Controller
$creator = new PDFDocumentCreator($document, request());
$documentProduct = $creator->createDocument();
$filePath = $documentProduct->download();
```

## Lợi ích của Factory Method Pattern

✅ **Mở rộng dễ dàng**: Thêm loại file mới chỉ cần tạo Creator và Product mới  
✅ **Tách biệt trách nhiệm**: Mỗi loại file có logic xử lý riêng  
✅ **Dễ bảo trì**: Code được tổ chức rõ ràng, dễ hiểu  
✅ **Tái sử dụng**: Có thể sử dụng lại các component  
✅ **Linh hoạt**: Dễ dàng thay đổi logic xử lý cho từng loại file  
✅ **Đơn giản**: Không cần Service layer, sử dụng trực tiếp trong Controller  

## Cấu trúc thư mục

```
app/
├── Factories/
│   └── DocumentFactories/
│       ├── DocumentCreator.php          # Abstract Creator
│       ├── DocumentProduct.php          # Product Interface
│       ├── PDFDocument.php              # Concrete Product
│       ├── PDFDocumentCreator.php       # Concrete Creator
│       ├── WordDocument.php             # Concrete Product
│       ├── WordDocumentCreator.php      # Concrete Creator
│       ├── ZipDocument.php              # Concrete Product
│       └── ZipDocumentCreator.php       # Concrete Creator
└── Http/Controllers/
    └── DocumentController.php           # Controller sử dụng Factory trực tiếp
```

## Mở rộng

Để thêm loại file mới (ví dụ: Excel), chỉ cần:

1. Tạo `ExcelDocument.php` implement `DocumentProduct`
2. Tạo `ExcelDocumentCreator.php` extend `DocumentCreator`
3. Thêm case trong `DocumentController::getCreator()`

```php
case 'xlsx':
case 'xls':
    return new ExcelDocumentCreator($document, $request);
```

## Ưu điểm của việc sử dụng Factory Method trong Controller

✅ **Đơn giản hóa**: Không cần Service layer phức tạp  
✅ **Trực tiếp**: Logic xử lý ngay trong Controller  
✅ **Dễ hiểu**: Code flow rõ ràng từ Controller đến Factory  
✅ **Hiệu quả**: Giảm số lượng class và dependency  
✅ **Linh hoạt**: Dễ dàng thay đổi logic xử lý trong Controller  

Factory Method pattern được sử dụng trực tiếp trong Controller giúp code đơn giản và dễ hiểu hơn!
