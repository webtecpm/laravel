<?php

use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\JobController;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Route;
use App\Models\Job;

Route::get('/', function () {
    return view('home');
});

// Static Routes definition...
Route::get('/about', function () {
    return view('about');
});

// Shorthand way to write View routes...
Route::view('/contact', 'contact');

// Route Resource usage to connect to a dedicated controller... using 'only' and 'except' conditions
Route::resource('yjobs', JobController::class, [
    // 'except' => ['index']
    // 'only' => ['index', 'show', 'create', 'store', 'update', 'destroy']
])->only(['index', 'show']);
Route::resource('yjobs', JobController::class)->except(['index', 'show'])->middleware('auth');

// Auth using middleware on Routes
Route::get('/jobs', [JobController::class, 'index']);
Route::get('/jobs/create', [JobController::class, 'create']);
Route::post('/jobs', [JobController::class, 'store'])->middleware('auth');
Route::get('/jobs/{job}', [JobController::class, 'show']);

// Route::get('/jobs/{job}/edit', [JobController::class, 'edit'])->middleware(['auth', 'can:edit-post,job']);
Route::get('/jobs/{job}/edit', [JobController::class, 'edit'])
    ->middleware('auth')
    ->can('edit', 'job'); // same as above

Route::patch('/jobs/{job}', [JobController::class, 'update'])->middleware('auth');
Route::delete('/jobs/{job}', [JobController::class, 'destroy'])->middleware('auth');

//Auth
Route::get('/register', [RegisteredUserController::class, 'create']);
Route::post('/register', [RegisteredUserController::class, 'store']);

Route:: get('/login', [SessionController::class, 'create'])->name('login'); // named-route for middleware to work
Route:: post('/login', [SessionController::class, 'store']);
Route:: post('/logout', [SessionController::class, 'destroy']);


// Routes grouping for same controller....
/* Route::controller(JobController::class)->group(function () {
    Route::get('/jobs', 'index');
    Route::get('/jobs/create', 'create');
    Route::post('/jobs', 'store');
    Route::get('/jobs/{job}', 'show');
    Route::get('/jobs/{job}/edit', 'edit');
    Route::delete('/jobs/{job}', 'destroy');
    Route::patch('/jobs/{job}', 'update');
});
 */

// Index
Route::get('/yjobs', [JobController::class, 'index']);
Route::get('/xjobs', function () {

    // dd(Job::all()[0]['title']);

    //lazy-loading, executing individual records select query
    // $jobs = Job::all(); // when preventEasyLoading() is set in AppServiceProvider.php boot() method, it will throw error.

    //eager-loading, executing single query to select all records
    // $jobs = Job::with('employer')->get();

    // applying pagination
    // $jobs = Job::with('employer')->paginate(5);     // show 5 records with First, Last, Prev, Next, and Page number buttons
    $jobs = Job::with('employer')->latest()->Paginate(5);     // show 5 records with First, Last, Prev, Next, and Page number buttons
    // $jobs = Job::with('employer')->cursor(5);     // show 5 records with First, Last, Prev, Next, and Page number buttons


    return view('jobs.index', [     // 'jobs/index' can also be used by convention.
        'jobs' => $jobs
    ]);
});

// Create
Route::get('/yjobs/create', [JobController::class, 'create']);
Route::get('/xjobs/create', function () {
    return view('jobs.create');
});

// Store / Add
Route::post('/yjobs', [JobController::class, 'store']);
Route::post('/xjobs', function () {
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
});

// Show -- this is regular fetching of records from model
/* Route::get('/jobs/{id}', function ($id) {
    $job = Job::find($id);

    return view('jobs.show', ['job' => $job]);
});
 */

// Route::get('/jobs/{job:title}', ...)    // this 'jobs:title' tells that the passed parameter should be matched to 'title'

// Show -- Route Model Binding in action
Route::get('/yjobs/{job}', [JobController::class, 'show']);
Route::get('/xjobs/{job}', function (Job $job) {
    // $job = Job::find($id);       // this is not needed since we're using Laravel RMB

    return view('jobs.show', ['job' => $job]);
});


// Edit
Route::get('/yjobs/{job}/edit', [JobController::class, 'edit']);
Route::get('/xjobs/{job}/edit', function (Job $job) {
    // $job = Job::find($id);   // commented, to have RMB

    return view('jobs.edit', ['job' => $job]);
});

// Update
Route::patch('/yjobs/{job}', [JobController::class, 'update']);
Route::patch('/xjobs/{job}', function (Job $job) {
    // validate
    request()->validate([
        'title' => ['required', 'min:3'],
        'salary' => ['required', '']
    ]);

    // authorize (On hold...)

    // update the job and persist
    // $job = Job::findOrFail($id);    // findOrFail is fail-safe method to check for if the $id is null or not
    $job->update([
        'title' => request('title'),
        'salary' => request('salary')
    ]);

    // redirect to the job page
    return redirect('/jobs/' . $job->id);
});

// Destroy
Route::delete('/yjobs/{job}', [JobController::class, 'delete']);
Route::delete('/xjobs/{job}', function (Job $job) {
    // authorize (On hold...)

    // delete  the job
    // Job::findOrFail($id)->delete();  // this is an inline way of doing the same as below...
    // $job = Job::findOrFail($id); // commented to use RMB
    $job->delete();
    return redirect('/jobs');
});
