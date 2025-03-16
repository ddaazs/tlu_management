<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use App\Models\Lecturer;
use App\Models\Student;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TopicController extends Controller
{
    /**
     * Hiển thị danh sách đề tài.
     */
    public function index()
    {   
        $topics = Topic::with('lecturer')->orderBy('created_at', 'desc')->paginate(10);
        $lecturers = Lecturer::all();
        $students = Student::all();
        return view('topics.index', compact('topics', 'lecturers', 'students'));
    }

    public function student()
    {   
        $topics = Topic::with('lecturer')->orderBy('created_at', 'desc')->paginate(10);
        $lecturers = Lecturer::all();
        $students = Student::all();
        return view('topics.student', compact('topics', 'lecturers', 'students'));
    }

    public function show($id)
    {
        $topic = Topic::findOrFail($id);
        return view('topics.show', compact('topic'));
    }

    public function pending()
    {
        if (!Gate::allows('giangvien') && !Gate::allows('quantri')) {
            abort(403, 'Bạn không có quyền xem danh sách chờ duyệt.');
        }

        $topics = Topic::where('status', 'pending')->get();
        return view('topics.pending', compact('topics'));
    }

    public function approve(Topic $topic)
    {
        if (!Gate::allows('giangvien') && !Gate::allows('quantri')) {
            return response()->json(['success' => false, 'message' => 'Bạn không có quyền duyệt đề tài.'], 403);
        }

        $topic->update(['status' => 'approved']);

        return redirect()->route('topics.pending')->with('success', 'Đề tài đã được duyệt!');
    }

    public function reject(Topic $topic)
    {
        if (!Gate::allows('giangvien') && !Gate::allows('quantri')) {
            return response()->json(['success' => false, 'message' => 'Bạn không có quyền từ chối đề tài.'], 403);
        }

        $topic->update(['status' => 'rejected']);

        return redirect()->route('topics.pending')->with('success', 'Đề tài đã bị từ chối!');
    }

    public function changeStatus($id, $action)
    {
        if (!Gate::allows('giangvien') && !Gate::allows('quantri')) {
            abort(403, 'Bạn không có quyền thay đổi trạng thái.');
        }

        $topic = Topic::findOrFail($id);

        if (!in_array($action, ['approve', 'reject'])) {
            return redirect()->route('topics.pending')->with('error', 'Hành động không hợp lệ.');
        }

        $topic->status = ($action === 'approve') ? 'approved' : 'rejected';
        $topic->save();

        return redirect()->route('topics.pending')->with('success', 'Cập nhật trạng thái thành công.');
    }

    public function assign(Request $request)
    {
        if (!Gate::allows('giangvien') && !Gate::allows('quantri')) {
            abort(403, 'Bạn không có quyền phân công giảng viên.');
        }

        $request->validate([
            'topic_id' => 'required|exists:topics,id',
            'lecturer_id' => 'required|exists:users,id',
            'student_id' => 'required|exists:users,id',
        ]);

        $topic = Topic::findOrFail($request->topic_id);

        Project::create([
            'name' => $topic->title,
            'description' => $topic->description,
            'instructor_id' => $request->lecturer_id,
            'student_id' => $request->student_id,
            'status' => 'Đang thực hiện',
            'topic_id' => $topic->id,
        ]);

        return redirect()->route('topics.index')->with('success', 'Phân công giảng viên hướng dẫn thành công!');
    }

    public function create()
    {
        if (!Gate::allows('giangvien') && !Gate::allows('quantri')) {
            abort(403, 'Bạn không có quyền tạo đề tài.');
        }

        $lecturers = Lecturer::all();
        return view('topics.create', compact('lecturers'));
    }

    public function store(Request $request)
    {
        if (!Gate::allows('giangvien') && !Gate::allows('quantri')) {
            abort(403, 'Bạn không có quyền tạo đề tài.');
        }

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'lecturer_id' => 'required|exists:lecturers,id',
        ]);

        $topic = Topic::create($validatedData);

        return redirect()->route('topics.index')->with('success', 'Đề tài đã được lưu thành công!');
    }

    public function register()
    {
        if (!Gate::allows('sinhvien')) {
            abort(403, 'Chỉ sinh viên mới có thể đăng ký đề tài.');
        }

        $lecturers = Lecturer::all();
        return view('topics.register', compact('lecturers'));
    }

    public function storeStudent(Request $request)
    {
        if (!Gate::allows('sinhvien')) {
            abort(403, 'Chỉ sinh viên mới có thể đăng ký đề tài.');
        }

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'lecturer_id' => 'required|exists:lecturers,id',
        ]);

        $topic = Topic::create([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'lecturer_id' => $validatedData['lecturer_id'],
            'student_id' => auth()->user()->id,
            'status' => 'pending',
        ]);

        return redirect()->route('topics.student')->with('success', 'Đăng ký đề tài thành công!');
    }

    public function edit($id)
    {
        if (!Gate::allows('giangvien') or Gate::allows('quantri')) {
            abort(403, 'Bạn không có quyền chỉnh sửa đề tài.');
        }

        $topic = Topic::findOrFail($id);
        $lecturers = Lecturer::all();

        return view('topics.edit', compact('topic', 'lecturers'));
    }

    public function update(Request $request, $id)
    {
        if (!Gate::allows('giangvien') or Gate::allows('quantri')) {
            abort(403, 'Bạn không có quyền chỉnh sửa đề tài.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'lecturer_id' => 'required|exists:lecturers,id',
        ]);

        $topic = Topic::findOrFail($id);
        $topic->update($request->all());

        return redirect()->route('topics.index')->with('success', 'Đề tài đã được cập nhật thành công!');
    }

    public function destroy($id)
    {
        if (!Gate::allows('giangvien') or Gate::allows('quantri')) {
            abort(403, 'Bạn không có quyền xóa đề tài.');
        }

        $topic = Topic::findOrFail($id);
        $topic->delete();

        return redirect()->route('topics.index')->with('success', 'Đề tài đã được xóa!');
    }
}
