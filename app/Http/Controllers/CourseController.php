<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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
    public function toggle(Request $request)
    {
        $id = $request->input('episode_id');
        $user =  Auth::user();
        $user->episodes()->toggle($id);
        return $user->episodes;
    }
}
