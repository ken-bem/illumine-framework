<?php

add_action('template_redirect', function($template){
    //Detect & Intercept 404s
    if(is_404()){

    }
}, 99);