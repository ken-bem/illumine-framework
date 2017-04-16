<?php /** @var \IllumineFramework\WpShortcode $shortcodes **/


$shortcodes->add(
    'wpp_search',
    'WppSkeleton\Http\Controllers\SearchController@load',
    array('search' => 'Find Plugins...'),
    array('wpp-search')
);
$shortcodes->add(
    'wpp_directory',
    'WppSkeleton\Http\Controllers\DirectoryController@load',
    array('post_type' => 'page'),
    array('wpp-directory') //css
);
