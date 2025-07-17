<?php
namespace App\Contracts\Repositories;

use App\Contracts\Interfaces\JournalInterface;
use App\Models\Journal;
use App\Models\Teacher;
use Carbon\Carbon;

class JournalRepository extends BaseRepository implements JournalInterface
{
    public function __construct(Journal $journal)
    {
        $this->model = $journal;
    }

    public function get(): mixed
    {
        return $this->model->query()->get();
    }

    public function getWhere(array $data): mixed
    {
        return $this->model->where($data);
    }

    public function store(array $data): mixed
    {
        return $this->model->query()->create($data);
    }

    public function show(mixed $id): mixed
    {
        return $this->model->query()->findOrFail($id);
    }

    public function update(mixed $id, array $data): mixed
    {
        return $this->model->query()->findOrFail($id)->update($data);
    }

    /**
     * Handle the Delete data event from models.
     * @param mixed $id
     *
     * @return mixed
     */
    public function delete(mixed $id): mixed
    {
        return $this->model->query()->findOrFail($id)->delete($id);
    }

    public function find(mixed $id): mixed
    {
        return $this->model->query()->findOrFail($id);
    }

    public function getStudentJournalById(mixed $id)
    {
        return $this->model->query()->latest()->where('student_id', $id)->get();
    }

    public function getAllJournalToDay()
    {
        return $this->model->query()
            ->latest()
            ->whereDate('created_at', Carbon::today())
            ->get();
    }
    public function countJournalToDay()
    {
        return $this->model->query()
            ->whereDate('created_at', Carbon::today())
            ->count();
    }
    public function getAllJournalTodayByTeacherId($teacherId)
    {
        $teacher = Teacher::with('monitoredStudents')->findOrFail($teacherId);

        $journals = collect();

        foreach ($teacher->monitoredStudents as $student) {
            $journal = $this->model->query()
                ->where('student_id', $student->id)
                ->whereDate('created_at', Carbon::today())
                ->latest()
                ->get();

            $journals = $journals->merge($journal);
        }

        return $journals;
    }

    public function existsJournalToday(array $data)
    {
        return $this->model->query()
        ->where('student_id', $data['student_id'])
        ->whereDate('created_at', $data['date'])
        ->exists();
    }

}
