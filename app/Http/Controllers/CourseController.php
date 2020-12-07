<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Course;
use App\Models\Episode;
use Illuminate\Http\Request;
use App\Events\NewCourseEvent;
use App\Youtube\YoutubeServices;
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
            ->addSelect(DB::raw(
                '
                (SELECT sum(duration) from episodes where episodes.course_id=courses.id)
                 as total_duration'
            ))
            ->withCount('episodes')->latest()->paginate(5)]);
    }
    public function show(int $id)
    {
        return Inertia::render('Courses/Show', [
            'course' => Course::where('id', $id)->with('episodes')->first(),
            'watched' => auth()->user()->episodes
        ]);
    }
    public function store(Request $request, YoutubeServices  $ytb)
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
            $epi = Episode::create($ep);
            $epi->duration
                = $ytb->handleYoutubeVideoDuration($ep['video_url']);
            $epi->save();
        }
        $name = Auth::user()->name;
        $data = [
            'message' => "$name just added $course->title.",
            'course' => [
                'id' => $course->id,
            ]
        ];
        event(new NewCourseEvent($data));
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
    public function update(Request $request, YoutubeServices $ytb)
    {
        // $request->validate([
        //     'title' => 'required',
        //     'description' => 'required',
        //     'episodes' => ['required', 'array'],
        //     'episodes.*.title' => 'required',
        //     'episodes.*.description' => 'required',
        //     'episodes.*.video_url' => 'required'
        // ]);
        $course = Course::where('id', $request->id)->with('episodes')->first();
        $this->authorize('update', $course);
        $course->update($request->all());
        $course->episodes()->delete();
        foreach ($request->episodes as $ep) {
            $ep['course_id'] = $course->id;
            $epi = Episode::create($ep);
            $epi->duration
                = $ytb->handleYoutubeVideoDuration($ep['video_url']);
            $epi->save();
        }
        return Redirect::route('courses.show', $course->id)->with('success', 'Félicitations , la formation a été mise à jour.');
    }

    public function new()
    {
        $name = Auth::user()->name;
        $data = [
            'message' => "$name just added a new course.",
            'course' => [
                'id' => 1,
                'title' => "Title test"
            ]
        ];
        event(new NewCourseEvent($data));
        return $data;
    }
}
