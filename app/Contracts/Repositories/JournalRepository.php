<?php

namespace App\Contracts\Repositories;

use App\Contracts\Interfaces\JournalInterface;
use App\Models\Journal;

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

}
