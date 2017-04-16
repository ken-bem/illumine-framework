<?php namespace WppSkeleton\Http\Controllers;
use IllumineFramework\Controllers\BaseController;
class Controller extends BaseController{

    /**
     * Default Controller Class
     */
    protected $this, $app, $request, $currentUser, $plugin, $blade;

    public function __construct()
    {
        parent::__construct();
        //$this->plugin->stats->start();
        //$this->plugin->stats->calculate();
    }
}