<?php

namespace App\Http\Controllers;

use App\Models\Seminar;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;

class SeminarController extends Controller
{
    // Display all seminars on the dashboard
    public function index(): View
    {
        $user = Auth::user();
        $today = now();
        $oneMonthFromNow = $today->copy()->addDays(30);

        if ($user->type_id == 1) {
            // Regular users should only see upcoming seminars within the next month
            $seminars = Seminar::whereBetween('date', [$today, $oneMonthFromNow])->get();
        } else {
            // Workers and Admins can see all seminars: planned, upcoming, and concluded
            $plannedSeminars = Seminar::where('date', '>', $oneMonthFromNow)->get();
            $upcomingSeminars = Seminar::whereBetween('date', [$today, $oneMonthFromNow])->get();
            $concludedSeminars = Seminar::where('date', '<', $today)->get();

            // Merge the seminars in the required order
            $seminars = $plannedSeminars->merge($upcomingSeminars)->merge($concludedSeminars);
        }

        return view('dashboard', compact('seminars', 'user'));
    }

    // Register for a seminar (for users and admins)
    public function register($id): RedirectResponse
    {
        try {
            $seminar = Seminar::findOrFail($id);
            $user = Auth::user();

            // Attach the seminar to the user and log the result
            $user->seminars()->syncWithoutDetaching([$seminar->id]);
            Log::info('User registered for seminar:', [
                'user_id' => $user->id,
                'seminar_id' => $seminar->id
            ]);

            return redirect()->route('dashboard')->with('success', 'Registered for seminar successfully.');
        } catch (\Exception $e) {
            Log::error('Error in registration: ' . $e->getMessage());
            return redirect()->route('dashboard')->with('error', 'An error occurred during registration.');
        }
    }
    // Unregister from a seminar (for users and admins)
    public function unregister($id): RedirectResponse
    {
        $seminar = Seminar::findOrFail($id);
        $user = Auth::user();

        // Unregister only if already registered
        if ($user->seminars()->where('seminar_id', $id)->exists()) {
            $user->seminars()->detach($id);
            return redirect()->route('dashboard')->with('success', 'Unregistered from seminar successfully.');
        }

        return redirect()->route('dashboard')->with('error', 'Not registered for this seminar.');
    }

    // Create a new seminar (for workers and admins)
    public function create(): View
    {
        return view('create-seminar'); // A form view to create a seminar
    }


    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'required|date',
            'time' => 'required|string', // Now just plain text
            'speakers' => 'required|string|max:255',
            'location' => 'required|string|max:255',
        ]);

        Seminar::create([
            'title' => $request->title,
            'description' => $request->description,
            'date' => $request->date,
            'time' => $request->time, // No conversion needed
            'speakers' => $request->speakers,
            'location' => $request->location,
            'created_by' => Auth::id(),
            'status' => $request->status ?? 'planned',
        ]);

        return redirect()->route('dashboard')->with('success', 'Seminar created successfully.');
    }


    // Show edit form (for workers and admins)
    public function edit($id): View
    {
        $seminar = Seminar::findOrFail($id);
        return view('edit-seminar', compact('seminar'));
    }


    // Update seminar details (for workers and admins)
    public function update(Request $request, $id): RedirectResponse
    {
        $seminar = Seminar::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'required|date',
            'time' => 'required', // 24-hour format: H:i
            'speakers' => 'required|string|max:255',
            'location' => 'required|string|max:255',
        ]);

        // Convert time from 24-hour format
        $formattedTime = Carbon::createFromFormat('H:i', $request->time)->format('H:i:s');

        $seminar->update([
            'title' => $request->title,
            'description' => $request->description,
            'date' => $request->date,
            'time' => $formattedTime,
            'speakers' => $request->speakers,
            'location' => $request->location,
        ]);

        return redirect()->route('dashboard')->with('success', 'Seminar updated successfully.');
    }

    // Delete a seminar (for workers and admins)
    public function delete($id): RedirectResponse
    {
        $seminar = Seminar::findOrFail($id);
        $seminar->delete();

        return redirect()->route('dashboard')->with('success', 'Seminar deleted successfully.');
    }
    public function showConference($id): View
    {
        // Fetch the seminar along with the registered users
        $seminar = Seminar::with('users')->findOrFail($id);

        return view('show', compact('seminar'));
    }
}
