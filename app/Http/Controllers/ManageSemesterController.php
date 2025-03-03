<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FirestoreService;
use Carbon\Carbon;

class ManageSemesterController extends Controller
{
    protected $firestoreService;

    public function __construct(FirestoreService $firestoreService)
    {
        $this->firestoreService = $firestoreService;
    }

    /**
     * Fetch and display semesters on the Task page
     */
    public function index()
    {
        $semestersCollection = $this->firestoreService->getCollection('Semester Calendar');
        $documents = $semestersCollection->documents();
        $semesters = [];

        foreach ($documents as $document) {
            if ($document->exists()) {
                $semesterData = $document->data();

                // Get today's date
                $today = Carbon::today()->format('Y-m-d');

                // Determine semester status
                if ($semesterData['end_date'] < $today) {
                    $semesterData['status'] = 'past';
                } else {
                    $semesterData['status'] = 'current';
                }

                // Update status in Firestore if changed
                if ($semesterData['status'] !== ($document->data()['status'] ?? null)) {
                    $this->firestoreService->getCollection('Semester Calendar')->document($document->id())->update([
                        ['path' => 'status', 'value' => $semesterData['status']]
                    ]);
                }

                $semesters[] = array_merge(['id' => $document->id()], $semesterData);
            }
        }

        return view('task', compact('semesters'));
    }

    /**
     * Create a new semester
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        $semestersCollection = $this->firestoreService->getCollection('Semester Calendar');

        // Get today's date
        $today = Carbon::today()->format('Y-m-d');

        // Determine the status of the semester
        if ($request->end_date < $today) {
            $status = 'past';
        } else {
            $status = 'current';
        }

        // Create a unique ID for the semester
        $semesterId = uniqid('semester_');

        // Save semester to Firestore
        $semestersCollection->document($semesterId)->set([
            'id' => $semesterId,
            'name' => $request->name,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $status, // Current or Past
            'created_at' => now(),
        ]);

        return redirect()->route('task.view')->with('success', 'Semester added successfully!');
    }
}
