<?php
namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\JournalResource;
use App\Http\Resources\DetailUserResource;
use App\Contracts\Interfaces\JournalInterface;
use App\Contracts\Interfaces\StudentInterface;
use App\Contracts\Interfaces\TeacherInterface;

class MonitoredController extends Controller
{
    private TeacherInterface $teacherInterface;
    private StudentInterface $studentInterface;
    private JournalInterface $journalInterface;

    public function __construct(
        TeacherInterface $teacherInterface,
        StudentInterface $studentInterface,
        JournalInterface $journalInterface,
    ) {
        $this->teacherInterface = $teacherInterface;
        $this->studentInterface = $studentInterface;
        $this->journalInterface = $journalInterface;
    }

    public function getMonitoredTeachers()
    {
        return response()->json([
            'status'   => true,
            'messages' => 'Collection Teachers all data',
            'teachers' => DetailUserResource::collection($this->teacherInterface->get()),
        ]);
    }

     public function getMonitoredStudentsByTeacherId($id)
    {
        $teacher = $this->teacherInterface->find($id);

        if (! $teacher) {
            return response()->json(['message' => 'Not a teacher.'], 403);
        }

        $students = $teacher->monitoredStudents;

        return response()->json([
            'status'   => true,
            'messages' => 'Collection Students by teacher data',
            'students' => DetailUserResource::collection($students),
        ]);
    }

    public function getAllStudent(){
         return response()->json([
            'status'   => true,
            'messages' => 'Collection Students all data',
            'students' => DetailUserResource::collection($this->studentInterface->get()),
        ]);
    }

    public function getAllJournalToDay(){
         return response()->json([
            'status'   => true,
            'messages' => 'Collection Journal all today data',
            'students' => JournalResource::collection($this->journalInterface->getAllJournalToDay()),
        ]);
    }

     public function getJurnalByStudentId($id)
    {
        try {

            $studentId = $id;
            $journal   = $this->journalInterface->getStudentJournalById($studentId);
            return response()->json([
                'status'   => true,
                'messages' => 'Collection journals by student data',
                'journals'     => JournalResource::collection($journal),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status'   => false,
                'messages' => 'error',
                'error'     => $e->getMessage(),
            ], 500);
        }
    }
}
