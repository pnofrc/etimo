<?php

use Illuminate\Support\Facades\Route;
use App\Models\Info;
use App\Models\Project;
use App\Http\VideoStream;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    $info = Info::first();
    $projects = Project::get();
    return view('welcome', compact('info','projects'));
});




// Route::get('/stream/{vid_id}', function (Project $project) {

//     $file =  Storage::disk('public')->path('01JRGWB4P8W72A8W72YQW0GJ1W.mp4');

//     $stream = new VideoStream($file);

//     return response()->stream(function () use ($stream) {
//         $stream->start();
//     });

// });


Route::get('/stream/{project}/{filename}', function (Project $project, $filename) {

    $matchedFile = collect($project->files)->first(function ($file) use ($filename) {
        return basename($file) === $filename;
    });

    if (!$matchedFile) {
        $matchedFile = $project->file_path;
    }
    dd($matchedFile);

    if (!$matchedFile) {
        $cover = $project->cover_image;
        $coverExt = strtolower(pathinfo($cover, PATHINFO_EXTENSION));
        if (in_array($coverExt, ['mp4', 'webm', 'mov', 'avi']) && basename($cover) === $filename) {
            $matchedFile = $cover;
        }
    }

    if (!$matchedFile) {
        if (!$matchedFile || basename($matchedFile) !== $filename) {
            abort(404, 'Video non trovato.');
        }
    }

    $path = Storage::disk('public')->path($matchedFile);

    if (!file_exists($path)) {
        abort(404, 'File non trovato nel filesystem.');
    }

    $stream = new VideoStream($path);

    return response()->stream(function () use ($stream) {
        $stream->start();
    });
})->where('filename', '.*')->name('video.stream');




Route::get('/{project:slug}', function (Project $project) {
    
    $info = Info::first();

    $files = $project->files;
    $videos = [];

    foreach ($files as $file) {
        $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));

        if (in_array($ext, ['mp4', 'webm', 'mov', 'avi'])) {
            $videos[] = $file;
        }
    }

    $coverCheck = strtolower(pathinfo($project->cover_image, PATHINFO_EXTENSION));

        if (in_array( $coverCheck, ['mp4', 'webm', 'mov', 'avi'])) {
            $videos[] = $file;
        }

    
    return view('project', compact('project', 'info'));
    
})->name('projects.show');





