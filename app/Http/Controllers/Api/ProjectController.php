<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Technology;
use App\Models\Type;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with('type', 'technologies')->paginate(15);
        return response()->json($projects);
    }

    public function getTypes()
    {
        $types = Type::all();
        return response()->json($types);
    }

    public function getTechnologies()
    {
        $technologies = Technology::all();
        return response()->json($technologies);
    }


    public function getProjectBySlug($slug)
    {
        // dd($slug);
        $project = Project::where('slug', $slug)->with('type', 'technologies')->first();
        if ($project) {
            $success = true;
            if ($project->image) {
                $project->image = asset('storage/' . $project->image);
            } else {
                $project->image = asset('storage/uploads/no-image.webp');
                $project->original_image = 'no-image';
            }
        } else {
            $success = false;
        }
        return response()->json(compact('project', 'success'));
    }
}
