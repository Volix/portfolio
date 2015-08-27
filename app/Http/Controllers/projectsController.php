<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use View;
use App\Project;
use Input;
use Redirect;
use Session;

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
        
        return View::make('projectsList', ["projects"=>$projects]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //create new Project
        
        $data = Input::all();
        
        $project =  new Project;
        
        $project->name = Input::get('name');
        
        $project->short_description = Input::get('short_description');
        
        strlen(Input::get('description')) > 0 ? $project->description = Input::get('description') : $project->description = Input::get('short_description');
        
        $project->made_at = Input::get('made_at');
        
        $project->project_url = Input::get('project_url');
        
        $project->slug = str_replace(' ', '_', Input::get('name'));
        
        $project->save();
        
        return var_dump($data);
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
        
        return View::make('projectShow', ['project' => Project::find($id)]);
        
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
        
        if ($project){
            return View::make('projectEdit', ['project' => $project]);
        }else{
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
            'name'       => 'required',
            'made_at'      => 'required|date',
            'project_url' => 'url'
        );
        $this -> validate($request, $rules);

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
        return    Redirect::route('projectManageList');
    }
    
    public function manage()
    {
        //Manage projects from dashboard
        
        $projects = Project::all();
        
        if (count($projects)>0){
        
            return View::make('projectsManageList', ['projects' => Project::all()]);
        
        }else{
        
            return View::make('projectCreate', ['communications' => ["Nie odnaleziono żadnego projektu, dodaj jakiś"]]);
        
        }
        
    }
}
