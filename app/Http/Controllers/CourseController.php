<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Course;
use App\Models\Episode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class CourseController extends Controller
{
    public function index()
    {
        return Inertia::render('Courses/Index', ['courses' => Course::with('user')
            ->select('courses.*', DB::raw('
            (
                SELECT COUNT(DISTINCT(user_id)) 
                FROM completions 
                inner JOIN 
                episodes ON episodes.id=completions.episode_id
                WHERE episodes.course_id=courses.id
            ) AS participants'))
            ->withCount('episodes')->latest()->get()]);
    }
    public function show(int $id)
    {
        return Inertia::render('Courses/Show', [
            'course' => Course::where('id', $id)->with('episodes')->first(),
            'watched' => auth()->user()->episodes
        ]);
    }


    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'episodes' => ['required', 'array'],
            'episodes.*.title' => 'required',
            'episodes.*.description' => 'required',
            'episodes.*.video_url' => 'required'
        ]);
        $course = Course::create($request->all());
        foreach ($request->input('episodes') as $ep) {
            $ep['course_id'] = $course->id;
            Episode::create($ep);
        }
        return Redirect::route('dashboard')->with('success', 'Félicitations , la formation a été mise en ligne.');
    }

    public function toggle(Request $request)
    {
        $id = $request->input('episode_id');
        $user =  Auth::user();
        $user->episodes()->toggle($id);
        return $user->episodes;
    }

    public function edit(int $id)
    {
        $course = Course::where('id', $id)->with('episodes')->first();
        $this->authorize('update', $course);
        return Inertia::render('Courses/Edit', ['course' => $course]);
    }
    public function update(Request $request)
    {

        $course = Course::where('id', $request->id)->with('episodes')->first();
        $this->authorize('update', $course);
        $course->update($request->all());
        $course->episodes()->delete();
        foreach ($request->episodes as $ep) {
            $ep['course_id'] = $course->id;
            Episode::create($ep);
        }
        return Redirect::route('dashboard')->with('success', 'Félicitations , la formation a été mise à jour.');
    }
}
