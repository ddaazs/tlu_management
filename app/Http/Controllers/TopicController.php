<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use App\Models\Lecturer;
use Illuminate\Http\Request;

class TopicController extends Controller
{
    /**
     * Hiển thị danh sách đề tài.
     */
    public function index()
    {
        $topics = Topic::with('lecturer')
                   ->orderBy('created_at', 'desc') // Sắp xếp mới nhất lên đầu
                   ->paginate(10); // Phân trang 10 đề tài mỗi trang
         // Phân trang 10 bản ghi
        return view('topics.index', compact('topics'));
    }

    /**
     * Hiển thị form tạo đề tài mới.
     */
    public function show($id)
    {
        $topic = Topic::findOrFail($id); // Tìm đề tài theo ID, nếu không có thì báo lỗi 404
        return view('topics.show', compact('topic'));
    }
    public function pending()
    {
        $topics = Topic::where('status', 'pending')->get();
        return view('topics.pending', compact('topics'));
    }
    public function approve($id)
    {
        $topic = Topic::findOrFail($id);
        
        if ($topic->status !== 'Chờ duyệt') {
            return redirect()->back()->with('error', 'Đề tài này không thể duyệt!');
        }

        $topic->update(['status' => 'Đã duyệt']);

        return redirect()->back()->with('success', 'Đề tài đã được duyệt!');
    }

    // ✅ Từ chối đề tài
    public function reject($id)
    {
        $topic = Topic::findOrFail($id);
        
        if ($topic->status !== 'Chờ duyệt') {
            return redirect()->back()->with('error', 'Đề tài này không thể từ chối!');
        }

        $topic->update(['status' => 'Từ chối']);

        return redirect()->back()->with('error', 'Đề tài đã bị từ chối!');
    }

    public function create()
    {
        $lecturers = Lecturer::all(); // Lấy danh sách giảng viên
        return view('topics.create', compact('lecturers'));
    }

    /**
     * Lưu đề tài mới vào database.
     */
    public function store(Request $request)
    {

        try {
            // ✅ Kiểm tra dữ liệu đầu vào
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'lecturer_id' => 'required|exists:lecturers,id',
                'student_id' => 'nullable|exists:students,id',
                'status' => 'nullable|string|in:pending,approved,rejected',
            ]);
    
            // ✅ Tạo đề tài mới
            $topic = Topic::create($validatedData);
    
            // ✅ Kiểm tra nếu lưu thành công
            if ($topic) {
                return redirect()->route('topics.index')->with('success', 'Đề tài đã được lưu thành công!');
            } else {
                return back()->with('error', 'Lưu đề tài thất bại!');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Lỗi khi lưu đề tài: ' . $e->getMessage());
        }
    }


    /**
     * Hiển thị form chỉnh sửa đề tài.
     */
    public function edit($id)
    {
        $topic = Topic::findOrFail($id);
        $lecturers = Lecturer::all();
        return view('topics.edit', compact('topic', 'lecturers'));
    }

    /**
     * Cập nhật đề tài trong database.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'lecturer_id' => 'required|exists:lecturers,id',
        ]);

        $topic = Topic::findOrFail($id);
        $topic->update([
            'title' => $request->title,
            'description' => $request->description,
            'lecturer_id' => $request->lecturer_id,
        ]);

        return redirect()->route('topics.index')->with('success', 'Đề tài đã được cập nhật thành công!');
    }

    /**
     * Xóa đề tài.
     */
    public function destroy($id)
    {
        $topic = Topic::findOrFail($id);
        $topic->delete();

        return redirect()->route('topics.index')->with('success', 'Đề tài đã được xóa!');
    }
}
