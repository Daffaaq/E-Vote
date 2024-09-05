<?php

namespace App\Repositories;

use App\Models\Log;

class LogRepository
{
    public function create($data)
    {
        return Log::create($data);
    }
}
