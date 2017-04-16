<?php

add_action('admin_bar_menu', function( $wp_admin_bar ) {

    $wp_admin_bar->add_node(array(
        'id'    => '#wpp_developer',
        'title' => 'WPP',
        'href'  => '?TB_iframe=true&width=800&height=600',
        'meta'  => array( 'class' => 'thickbox')
    ));
});