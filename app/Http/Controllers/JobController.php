<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class JobController extends Controller
{
    public function index() : View
    {
        $jobs = Job::with('employer')->latest()->Paginate(5);     // show 5 records with First, Last, Prev, Next, and Page number buttons
        return view('jobs.index', [     // 'jobs/index' can also be used by convention.
            'jobs' => $jobs
        ]);
    }

    public function show(Job $job) : View
    {
        return view('jobs.show', ['job' => $job]);
    }

    public function create() : View
    {
        return view('jobs.create');
    }

    public function edit(Job $job) : View
    {
        return view('jobs.edit', ['job' => $job]);
    }

    public function store(Job $job) : RedirectResponse
    {
        // Validate request...
        request()->validate([
            'title' => ['required', 'min:3'],
            'salary' => ['required', '']
        ]);

        Job::create([
            'title' => request('title'),
            'salary'  => request('salary'),
            'employer_id' => 1
        ]);

        return redirect('/jobs');
    }

    public function update(Job $job) : RedirectResponse
    {
        // authorize (On hold...)

        // validate
        request()->validate([
            'title' => ['required', 'min:3'],
            'salary' => ['required', '']
        ]);

        // update the job and persist
        // $job = Job::findOrFail($id);    // findOrFail is fail-safe method to check for if the $id is null or not
        $job->update([
            'title' => request('title'),
            'salary' => request('salary')
        ]);

        // redirect to the job page
        return redirect('/jobs/' . $job->id);
    }

    public function destroy(Job $job) : RedirectResponse
    {
        $job->delete();
        return redirect('/jobs');
    }
}
