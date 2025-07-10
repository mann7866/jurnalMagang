<?php

namespace App\Contracts\Interfaces\Eloquent;

interface FindInterface
{
    /**
     * Handle the find data event by ID from models.
     *
     * @param int $id
     * @return mixed
     */
    public function find(int $id): mixed;
}
