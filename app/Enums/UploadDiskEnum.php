<?php

namespace App\Enums;

enum UploadDiskEnum: string
{
    case IMAGETEACHER = 'image-teacher';
    case IMAGESTUDENT = 'image-student';
    case IMAGEJOURNAL = 'image-journal';
}
