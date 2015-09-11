<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Image as Photo;
use App\Project;
use Illuminate\Http\Request;
use Image;
use Input;
use Redirect;
use Session;
use View;

class projectsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //Return list of all projects

        $projects = Project::all();

    }

    /**
     * Create new project.
     *
     * @return Response
     */
    public function create()
    {
        $project = new Project;

        $project->name = Input::get('name');

        $project->short_description = Input::get('short_description');

        $project->description = strlen(Input::get('description')) > 0 ? Input::get('description') : Input::get('short_description');

        $project->made_at = Input::get('made_at');

        $project->project_url = Input::get('project_url');

        $project->slug = str_slug(Input::get('name'));

        $project_id = $project->save();

        if (Input::hasFile('images')) {
            foreach (Input::file('images') as $image) {
                $date = date('Y-m-d');
                $extension = $image->getClientOriginalExtension();
                $filename = $image->getClientOriginalName();

                $image->move('uploads\\' . $date . '\\original\\original', $filename);

                $current_image = Image::make(public_path('uploads/' . $date . '/original/original/' . $filename));

                $width = $current_image->width();
                $height = $current_image->height();

                if ($width >= 300 || $height >= 300) {
                    $destinationDir = public_path('content\\' . $date . '\\' . '300x300' . '\\original\\');

                    if (!is_dir($destinationDir)) {
                        mkdir($destinationDir, 0777, true);
                    }

                    $current_image->resize(300, 300)->save($destinationDir . $filename);
                }

                $photo = new Photo;

                $photo->name = $filename;
                $photo->extension = $extension;

                $photo->save();

                $project->images()->attach($photo->id);

            }
        }

        return Redirect::route('projectManageList')->with('communications_success', ["Dodano pomyślnie"]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //Return view with the project

        return View::make('projectShow', ['project' => Project::find($id), 'images' => Project::find($id)->images()]);

    }

    /**
     * Find projects by slug.
     *
     * @param  str  $slug
     * @return int $id
     */
    public function findBySlug($slug)
    {
        $id = Project::where('slug', '=', $slug)->firstOrFail()['id'];
        return self::show($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //Find project by id
        $project = Project::find($id);

        if ($project) {
            return View::make('projectEdit', ['project' => $project]);
        } else {
            abort(404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //update Project

        $rules = array(
            'name' => 'required',
            'made_at' => 'required|date',
            'project_url' => 'url',
        );
        $this->validate($request, $rules);

        $project = Project::find($id);

        $project->name = Input::get('name');

        $project->short_description = Input::get('short_description');

        strlen(Input::get('description')) > 0 ? $project->description = Input::get('description') : $project->description = Input::get('short_description');

        $project->made_at = Input::get('made_at');

        $project->project_url = Input::get('project_url');

        $project->slug = str_replace(' ', '_', Input::get('name'));

        $project->save();

        // redirect
        Session::flash('message', 'Successfully updated nerd!');
        return View::make('projectsManageList', ['projects' => Project::all()]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
        Project::destroy($id);
        return Redirect::route('projectManageList');
    }

    public function manage()
    {
        //Manage projects from dashboard

        $projects = Project::all();

        if (count($projects) > 0) {

            return View::make('projectsManageList', ['projects' => Project::all()]);

        } else {

            return Redirect::route('projectCreate')->with('communications_info', ["Nie odnaleziono żadnego projektu, dodaj jakiś"]);

        }

    }

    private function images()
    {
        //load images for project

        return $this->BelongsToMany('app/Image', 'projects_images');
    }
}
