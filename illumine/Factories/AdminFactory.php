<?php namespace IllumineFramework\Factories;
class AdminFactory {

    public static function addPanel(
        $pageTitle,
        $menuTitle,
        $capability,
        $slug,
        $callback
    ){
        add_action('admin_menu', function() use(
            $pageTitle,
            $menuTitle,
            $capability,
            $slug,
            $callback
        ){
            // Add shortcode support for widgets
            add_menu_page(
                $pageTitle, //$page_title
                $menuTitle, //$menu_title
                $capability, //$capability
                $slug, //$menu_slug
                function() use ($callback,$pageTitle,$menuTitle,$capability,$slug){

                    if(is_array($callback) || strpos($callback, '@') == false){
                        //Call defined class function & Pass Parameters
                        return call_user_func($callback,compact('pageTitle', 'menuTitle', 'capability', 'slug'));
                    }else{
                        if(strpos($callback, '@') !== false){
                            $classMethod = explode('@',$callback);
                        }else{
                            $classMethod = $callback;
                        }
                        $controller = new $classMethod[0]();
                        return $controller->{$classMethod[1]}(compact('pageTitle', 'menuTitle', 'capability', 'slug'));
                    }
                }
            );
        });
    }

    public static function addSubPanel(
        $parentSlug,
        $pageTitle,
        $menuTitle,
        $capability,
        $slug,
        $callback
    ){
        add_action('admin_menu', function() use(
            $parentSlug,
            $pageTitle,
            $menuTitle,
            $capability,
            $slug,
            $callback
        ){
            // Add shortcode support for widgets
            add_submenu_page(
                $parentSlug,
                $pageTitle, //$page_title
                $menuTitle, //$menu_title
                $capability, //$capability
                $slug, //$menu_slug
                function() use ($callback,$parentSlug,$pageTitle,$menuTitle,$capability,$slug){

                    if(is_array($callback) || strpos($callback, '@') == false){
                        //Call defined class function & Pass Parameters
                        return call_user_func($callback,compact('parentSlug','pageTitle', 'menuTitle', 'capability', 'slug'));
                    }else{
                        if(strpos($callback, '@') !== false){
                            $classMethod = explode('@',$callback);
                        }else{
                            $classMethod = $callback;
                        }
                        $controller = new $classMethod[0]();
                        return $controller->{$classMethod[1]}(compact('parentSlug','pageTitle', 'menuTitle', 'capability', 'slug'));
                    }
                }
            );
        });
    }
}