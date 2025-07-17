<?php

namespace App\Contracts\Interfaces;

use App\Contracts\Interfaces\Eloquent\BaseInterface;
use App\Contracts\Interfaces\Eloquent\FindInterface;

interface JournalInterface extends BaseInterface, FindInterface
{
    public function getStudentJournalById(mixed $id);
    public function getAllJournalToDay();
    public function countJournalToDay();
    public function getAllJournalTodayByTeacherId($teacherId);
    public function existsJournalToday(array $data);
}
