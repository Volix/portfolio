<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Image;
use View;
use App\Project;
use App\Image as Photo;
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
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //create new Project
        
        $project =  new Project;
        
        $project->name = Input::get('name');
        
        $project->short_description = Input::get('short_description');
        
        strlen(Input::get('description')) > 0 ? $project->description = Input::get('description') : $project->description = Input::get('short_description');
        
        $project->made_at = Input::get('made_at');
        
        $project->project_url = Input::get('project_url');
        
        $project->slug = str_replace(' ', '_', Input::get('name'));
        
        $project->save();
		
	//	 $extension = Input::file('images')->getClientOriginalExtension(); // getting image extension
     // $fileName = rand(11111,99999).'.'.$extension; // renameing image
     // Input::file('images')->move('uploads', $fileName);
		
		
		if (Input::hasFile('images')){
	//	die('dupa4');
			ini_set('memory_limit','32M');
	//	die('dupa5');
			foreach(Input::file('images') as $image){
				//die('8y88');
				//return var_dump($image);
				$time = time();
				$extension = $image->getClientOriginalExtension();
				$filename = $image->getClientOriginalName();
				
				$image->move('uploads\\'.$time.'\\original\\original', $filename);
				
		//	 var_dump(public_path('uploads\\'.$time.'\\'.$filename));
		//	var_dump(url('uploads\\'.$time.'\\'.$filename));
				
				$current_image = Image::make(url('uploads/'.$time.'/original/original/'.$filename));
			
				$width = $current_image->width($image);
				$heigth = $current_image->height($image);
				
				$project_id = $project->id;
				
			
				var_dump($height);
				
				if ($width >= 300 || $height >= 300){
				
				die('lbb');
					$current_image->resize(300, 300)->save(public_path('content\\'.$time.'\\'.'300x300'.'\\original\\'.$image->getClientOriginalName));
			//		$current_image->resize(300, 300)->greyscale()->save('content\\'.$time.'\\'.'300x300'.'grayscale\\'.$image->getClientOriginalName);

				}
				
			/*	if ($width >= 800 || $height >= 600){
				
					$current_image->resize(800, 600)->save('/content/'.$time.'/'.'800x600'.'/original/'.$image);
					$current_image->resize(800, 600)->greyscale()->save('/content/'.$time.'/'.'800x600'.'/greyscale/'.$image);

				}
				
				if ($width >= 1024 || $height >= 768){
				
					$current_image->save('/content/'.$time.'/'.'1024x768'.'/original/'.$image);
					$current_image->resize(1024, 768)->greyscale()->save('/content/'.$time.'/'.'1024x768'.'/greyscale/'.$image);

				}
				*/				
			//		$current_image->resize($width, $height)->save('content/'.$time.'/'.'original'.'/original/'.$image);
			//	$current_image->resize($width, $height)->greyscale()->save('/content/'.$time.'/'.'original'.'/greyscale/'.$image);
		
			
			
			$photo = Photo;
			
			$photo->name = $image->getClientOriginalName();
			$photo->extension = $image->getClientExtension();
			$photo->timeAdded = $time;
			
			$photo->save();
			
			$project->images()->attach($photo->id);
		
	
			}
			die('lol');
	
		}else{
				die('dupa2222');
			}
	
	
	return var_dump(Input::all());
	
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
        
            return Redirect::route('projectCreate')->with('communications_info', ["Nie odnaleziono żadnego projektu, dodaj jakiś"]);
        
        }
        
    }
    
    private function images()
    {
        //load images for project
        
        return $this->BelongsToMany('app/Image', 'projects_images');
    }
}
