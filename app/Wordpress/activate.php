<?php namespace WppSkeleton\Wordpress;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
class Activate{
    public function __construct($app)
    {
        $this->app = $app;
    }
    public function addTables()
    {
        Schema::create('flights', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('airline');
            $table->timestamps();
        });
    }
}