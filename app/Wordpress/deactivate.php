<?php namespace WppSkeleton\Wordpress;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
class DeActivate{
    public function __construct($app)
    {
        $this->app = $app;
        $this->addTables();
    }
    public function addTables()
    {
        Schema::dropIfExists('flights');
    }
}