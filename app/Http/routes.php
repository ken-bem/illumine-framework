<?php //Routes

$route->get('/ajax/route/{page?}', 'WppSkeleton\Http\Controllers\DirectoryController@data')
    ->name('directory');
//->middleware(\WppSkeleton\Http\Middleware\CsrfFilter::class)