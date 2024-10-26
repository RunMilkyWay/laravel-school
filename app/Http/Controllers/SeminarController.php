<?php

namespace App\Http\Controllers;

use App\Models\Seminar;
use Illuminate\View\View;

class SeminarController extends Controller
{
    // Display all seminars on the dashboard
    public function index(): View
    {
        $seminars = Seminar::all(); // Fetch all seminars
        return view('dashboard', compact('seminars')); // Pass seminars to the view
    }
}
