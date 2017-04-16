<?php /** @var \IllumineFramework\WpShortcode $shortcodes **/


$shortcodes->add(
    'wpp_search',
    'WppSkeleton\Http\Controllers\SearchController@load',
    array('search' => 'Find Plugins...'),
    array('wpp-search')
);
