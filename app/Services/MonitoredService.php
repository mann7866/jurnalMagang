<?php
namespace App\Services;

use Illuminate\Support\Facades\Auth;
use App\Contracts\Interfaces\JournalInterface;
use App\Contracts\Interfaces\StudentInterface;
use App\Contracts\Interfaces\TeacherInterface;

class MonitoredService
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

    public function prepareDataForAdmin()
    {
        $totalTeacher      = $this->teacherInterface->count();
        $totalStudent      = $this->studentInterface->count();
        $totalJournalToday = $this->journalInterface->countJournalToDay();

        return [
            'totalTeacher'      => $totalTeacher,
            'totalStudent'      => $totalStudent,
            'totalJournalToday' => $totalJournalToday,
        ];
    }
    public function prepareDataForTeacher($teacher)
    {

        $students     = $teacher->monitoredStudents;
        $totalStudent = $students->count();

        $teacherId         = $teacher->id;
        $journals          = $this->journalInterface->getAllJournalTodayByTeacherId($teacherId);
        $totalJournalToday = $journals->count();

        return [
            'totalStudent'      => $totalStudent,
            'totalJournalToday' => $totalJournalToday,
        ];
    }
}
