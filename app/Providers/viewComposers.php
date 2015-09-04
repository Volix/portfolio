<?php

namespace App\Providers;

use \View;
use App\Setting;
use Illuminate\Support\ServiceProvider;

class viewComposers extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
	 
	 function __construct()
	 {
		
	 }
    public function boot()
    {
        // Using class based composers...
     

    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
		//$params = null;
		//foreach (Setting::all() as $key => $value){
		//	$params[]=[$key=>$value];
		//}
		 View::composer('*', function ($view){
			
			$settings = Setting::all();
			
			foreach($settings as $data){
				$param = array_values($data['attributes']);
				$params[$param[0]] = $param[1];
			}
		  $view->with('settings', $params);
		  
	  });
	 // die ('lol');

    }
}