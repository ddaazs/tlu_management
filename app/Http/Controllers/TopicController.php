<?php

namespace App\Http\Controllers;

use App\Models\Lecturer;
use App\Models\Project;
use App\Models\Student;
use App\Models\Topic;
use App\Services\Core\LectureService;
use App\Services\Core\StudentService;
use App\Services\Core\TopicService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TopicController extends Controller
{
    protected $topicService;
    protected $studentService;
    protected $lecturerService;

    public function __construct(
        TopicService $topicService,
        StudentService $studentService,
        LectureService $lecturerService
    ) {
        $this->middleware(['auth', 'can:sinhvien']);
        $this->middleware('can:quantri')->only('search');
        $this->topicService = $topicService;
        $this->studentService = $studentService;
        $this->lecturerService = $lecturerService;
    }

    /**
     * Hiển thị danh sách đề tài.
     */
    public function index()
    {
        $topics = $this->topicService->getTopics();
        $lecturers = $this->lecturerService->getLecture();
        $students = $this->studentService->getStudent();

        return view('topics.index', compact('topics', 'lecturers', 'students'));
    }

    public function student()
    {
        $student = Student::where('account_id', auth()->id())->first();

        if (!$student) {
            abort(404, 'Không tìm thấy thông tin sinh viên');
        }

        $registeredTopic = $this->topicService->getStudentTopic($student->id);
        $topics = $this->topicService->getAvailableTopics();

        return view('topics.student', compact('topics', 'registeredTopic'));
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

        $topics = $this->topicService->getPendingTopics();
        return view('topics.pending', compact('topics'));
    }

    public function approve(Topic $topic)
    {
        if (!Gate::allows('giangvien') && !Gate::allows('quantri')) {
            return response()->json(['success' => false, 'message' => 'Bạn không có quyền duyệt đề tài.'], 403);
        }

        $this->topicService->updateTopicStatus($topic->id, 'approved');
        return redirect()->route('topics.pending')->with('success', 'Đề tài đã được duyệt!');
    }

    public function reject(Topic $topic)
    {
        if (!Gate::allows('giangvien') && !Gate::allows('quantri')) {
            return response()->json(['success' => false, 'message' => 'Bạn không có quyền từ chối đề tài.'], 403);
        }

        $this->topicService->updateTopicStatus($topic->id, 'rejected');
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
        // Kiểm tra trạng thái của đề tài
        if ($topic->status !== 'approved') {
            return redirect()->route('topics.index')->with('error', 'Chỉ có thể phân công các đề tài đã được duyệt.');
        }

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

        $this->topicService->createTopic($validatedData);
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

        // Lấy sinh viên hiện tại từ bảng students
        $student = Student::where('account_id', auth()->id())->first();

        // Kiểm tra nếu sinh viên đã có đề tài
        if (!$student) {
            return back()->with('error', 'Không tìm thấy thông tin sinh viên.');
        }

        $existingTopic = Topic::where('student_id', $student->id)->first();
        if ($existingTopic) {
            return back()->with('error', 'Bạn đã đăng ký đề tài. Không thể đăng ký thêm.');
        }

        // Validate dữ liệu nhập vào
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'lecturer_id' => 'required|exists:lecturers,id',
        ]);

        // Tạo mới đề tài
        Topic::create([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'lecturer_id' => $validatedData['lecturer_id'],
            'student_id' => $student->id,
            'status' => 'pending',
        ]);

        return redirect()->route('topics.student')->with('success', 'Đăng ký đề tài thành công!');
    }

    public function register_1(Request $request, $id)
    {
        // Lấy thông tin sinh viên hiện tại
        $student = Student::where('account_id', auth()->id())->first();

        // Kiểm tra nếu sinh viên đã có đề tài rồi
        if (Topic::where('student_id', $student->id)->exists()) {
            return redirect()->back()->with('error', 'Bạn đã đăng ký một đề tài khác.');
        }

        // Lấy đề tài cần đăng ký
        $topic = Topic::findOrFail($id);

        // Kiểm tra xem đề tài đã có sinh viên chưa
        if ($topic->student_id) {
            return redirect()->back()->with('error', 'Đề tài này đã có sinh viên đăng ký.');
        }

        // Cập nhật đề tài với sinh viên đăng ký
        $topic->student_id = $student->id;
        $topic->save();

        return redirect()->back()->with('success', 'Đăng ký đề tài thành công!');
    }

    public function edit($id)
    {
        if (!Gate::allows('giangvien') && !Gate::allows('quantri')) {
            abort(403, 'Bạn không có quyền chỉnh sửa đề tài.');
        }

        $topic = Topic::findOrFail($id);
        $lecturers = Lecturer::all();

        return view('topics.edit', compact('topic', 'lecturers'));
    }

    public function update(Request $request, $id)
    {
        if (!Gate::allows('giangvien') && !Gate::allows('quantri')) {
            abort(403, 'Bạn không có quyền chỉnh sửa đề tài.');
        }

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'lecturer_id' => 'required|exists:lecturers,id',
        ]);

        $this->topicService->updateTopic($id, $validatedData);
        return redirect()->route('topics.index')->with('success', 'Đề tài đã được cập nhật thành công!');
    }

    public function destroy($id)
    {
        if (!Gate::allows('giangvien') && !Gate::allows('quantri')) {
            abort(403, 'Bạn không có quyền xóa đề tài.');
        }

        $this->topicService->deleteTopic($id);
        return redirect()->route('topics.index')->with('success', 'Đề tài đã được xóa!');
    }
}
