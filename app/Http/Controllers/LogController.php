<?php

namespace App\Http\Controllers;

use App\Models\LogSystem;
use Illuminate\Http\Request;

class LogController extends Controller
{
    public function logs()
    {
        return $this->apiSuccessResponse(LogSystem::orderBy('id', 'desc')->paginate(4));
    }
}
