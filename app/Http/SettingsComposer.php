<?php

namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use App\Setting;

class SettingsComposer
{
    /**
     * The user repository implementation.
     *
     * @var SettingsRepository
     */
    protected $settings;

    /**
     * Create a new settings composer.
     *
     * @param  $settings
     * @return void
     */
    public function __construct($settings = Setting:all())
    {
       
	   // Dependencies automatically resolved by service container...
        $this->$settings = $settings;

	}

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('settings', $this->settings);
    }
}