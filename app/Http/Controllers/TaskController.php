<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FirestoreService;
use Carbon\Carbon;

class TaskController extends Controller
{
    protected $firestoreService;

    public function __construct(FirestoreService $firestoreService)
    {
        $this->firestoreService = $firestoreService;
    }

    public function show($semester)
    {
        // Extract start and end date from the URL (YYYY-MM-DD format)
        $semesterDates = explode('_', $semester);

        // Ensure Carbon can parse the dates properly
        try {
            $startDate = Carbon::createFromFormat('Y-m-d', $semesterDates[0])->format('d F Y');
            $endDate = Carbon::createFromFormat('Y-m-d', $semesterDates[1])->format('d F Y');
        } catch (\Exception $e) {
            abort(404, "Invalid semester format."); // Prevent errors if the format is wrong
        }

        // Properly formatted semester name
        $formattedSemester = "$startDate - $endDate";

        // Fetch tasks from Firestore
        $tasksCollection = $this->firestoreService->getCollection("Semester Calendar/$formattedSemester/Tasks");
        $documents = $tasksCollection->documents();
        $tasks = [];

        foreach ($documents as $document) {
            if ($document->exists()) {
                $tasks[] = array_merge(['id' => $document->id()], $document->data());
            }
        }

        return view('partials.pages.superadmin-semester-details', compact('formattedSemester', 'tasks'));
    }



    public function store(Request $request, $semester)
    {
        $request->validate([
            'deadline' => 'required|date',
            'task_name' => 'required|string',
            'activities' => 'required|string',
            'responsible' => 'required|string',
            'supervisor' => 'required|string',
            'supervisor_email' => 'required|email',
        ]);

        // Format semester name properly for Firestore
        $semesterDates = explode('_', $semester);
        $formattedSemester = Carbon::parse($semesterDates[0])->format('d F Y') . ' - ' .
            Carbon::parse($semesterDates[1])->format('d F Y');

        $tasksCollection = $this->firestoreService->getCollection("Semester Calendar/$formattedSemester/Tasks");

        $tasksCollection->add([
            'deadline' => $request->deadline,
            'task_name' => $request->task_name,
            'activities' => $request->activities,
            'responsible' => explode(',', $request->responsible),
            'supervisor' => $request->supervisor,
            'supervisor_email' => $request->supervisor_email,
            'created_at' => now(),
        ]);

        return redirect()->route('semester.details', ['semester' => $semester])
            ->with('success', 'Task added successfully!');
    }


}
