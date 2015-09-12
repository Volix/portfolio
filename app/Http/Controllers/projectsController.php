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
     * Return list of all projects.
     *
     * @return Response
     */
    public function index()
    {
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
     * Show specified project.
     *
     * @param  int  $id
     * @return View
     */
    public function show($id)
    {
        return View::make('projectShow', [
            'project' => Project::find($id),
        ]);

    }

    /**
     * Find projects by slug.
     *
     * @param  string  $slug
     * @return projectsController
     */
    public function findBySlug($slug)
    {
        $id = Project::where('slug', '=', $slug)->firstOrFail()['id'];
        return $this->show($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        // Find project by id
        $project = Project::find($id);

        if ($project) {
            return View::make('projectEdit', ['project' => $project]);
        } else {
            abort(404);
        }
    }

    /**
     * Update the project.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $rules = array(
            'name' => 'required',
            'made_at' => 'required|date',
            'project_url' => 'url',
        );
        $this->validate($request, $rules);

        $project = Project::find($id);

        $project->name = Input::get('name');

        $project->short_description = Input::get('short_description');

        $project->description = strlen(Input::get('description')) > 0 ? Input::get('description') : Input::get('short_description');

        $project->made_at = Input::get('made_at');

        $project->project_url = Input::get('project_url');

        $project->slug = str_slug(Input::get('name');

        $project->save();

        // Redirect
        return Redirect::route('projectManageList')->with('message', 'Successfully updated nerd!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        Project::destroy($id);
        return Redirect::route('projectManageList');
    }

    /**
     * Manage projects from dashboard
     */
    public function manage()
    {
        $projects = Project::all();

        if (count($projects) > 0) {
            return View::make('projectsManageList', ['projects' => Project::all()]);
        } else {
            return Redirect::route('projectCreate')->with('communications_info', ["Nie odnaleziono żadnego projektu, dodaj jakiś"]);
        }
    }
}
