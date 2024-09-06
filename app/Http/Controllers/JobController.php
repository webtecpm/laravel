<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class JobController extends Controller
{
    public function index() : View
    {
        $jobs = Job::with('employer')->latest()->Paginate(10);     // show 5 records with First, Last, Prev, Next, and Page number buttons
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

    public function edit(Job $job)
    {
        // Defining Authorization rule using Gate Facade.
/*         Gate::define('edit-job', function (User $user, Job $job) {
            return $job->employer->user->is($user); // ruling
        });
 */
        // Inline Authorization, to check if you're authenticated/signed-in
/*         if(Auth::guest()) {
            return redirect('/login');
        }
 */

        // Laravel Model has can() and cannot() methods out-of-the-box for authorizations
/*         if( Auth::user()->can('edit-job', $job) ) { // this is an alternative way to check authorization
            // do something....
        }
 */


        // Gate::authorize attempts to authorize an action and automatically throw an exception (redirect to 403) if user is NOT allowed to perform the given action.
      /*   Gate::authorize('edit-job', $job);
 */

        // Below Gate::authorize can be used if you want to perform some actions or show message in case of
/*         Gate::allows('edit-job',$job) ? "You're good!" : "No, You're bad";
        if( Gate::denies('edit-job', $job) ) {
            // do something....
        }
 */
        // if($job->employer->user->isNot(Auth::user())) {
        //     abort(403);
        // }

        // The above authorization definition is stuck in the JobController and cannot be used outside.
        // To use it from outside, like to check for Edit Button to show or not, you can move it to AppServiceProvider

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
