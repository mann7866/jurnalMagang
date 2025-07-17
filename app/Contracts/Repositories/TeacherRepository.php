<?php
namespace App\Contracts\Repositories;

use App\Contracts\Interfaces\TeacherInterface;
use App\Models\Teacher;

class TeacherRepository extends BaseRepository implements TeacherInterface
{

    public function __construct(Teacher $teacher)
    {
        $this->model = $teacher;
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

    public function find(mixed $id): mixed{
        return $this->model->query()->findOrFail($id);
    }
    public function count(){
        return $this->model->query()->count();
    }
}
