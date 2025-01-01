<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AgeGroup;

class AgeGroupController extends Controller
{
    public function index()
    {
        $ageGroups = AgeGroup::all();
        return response()->json($ageGroups);
    }
}
