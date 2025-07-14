<?php
namespace App\Http\Controllers\Api\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Resources\DetailUserResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\JournalResource;
use App\Contracts\Interfaces\JournalInterface;
use App\Contracts\Interfaces\TeacherInterface;

class MonitoredController extends Controller
{
    private JournalInterface $journalInterface;
    private TeacherInterface $teacherInterface;

    public function __construct(
        JournalInterface $journalInterface,
        TeacherInterface $teacherInterface,

    ) {
        $this->journalInterface = $journalInterface;
        $this->teacherInterface = $teacherInterface;
    }

    public function getMonitoredStudents()
    {
        $teacher = Auth::user()->teacher;

        if (! $teacher) {
            return response()->json(['message' => 'Not a teacher.'], 403);
        }

        $students = $teacher->monitoredStudents;

        return response()->json([
            'status'   => true,
            'messages' => 'Collection Students data',
            'students' => DetailUserResource::collection($students),
        ]);
    }

    public function getAllJournalToDayByTeacherId(){
        $teacherId = Auth::user()->teacher->id;
         return response()->json([
            'status'   => true,
            'messages' => 'Collection Journal all today data',
            'journals' => JournalResource::collection($this->journalInterface->getAllJournalTodayByTeacherId($teacherId)),
        ]);
    }
    public function getJurnalByStudentId($id)
    {
        try {
            $studentId = $id;
            $journal   = $this->journalInterface->getStudentJournalById($studentId);
            return response()->json([
                'status'   => true,
                'messages' => 'Collection journals data',
                'data'     => JournalResource::collection($journal),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status'   => false,
                'messages' => 'error',
                'data'     => $e->getMessage(),
            ], 500);
        }
    }
}
