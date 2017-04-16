<?php /** @var \IllumineFramework\WpShortcode $shortcodes **/
$shortcodes->add(
    'illumine_user_profile',
    'WppSkeleton\Http\Controllers\UserProfileController@load',
    array('search' => 'Find Plugins...'),
    array('wpp-search')
);