<?php namespace IllumineFramework\Factories;
class ShortcodeFactory {

    public static function add(
        $tag,
        $callback,
        $attributes = array(),
        $css = array()
    ){
        // Add shortcode support for widgets
        add_shortcode($tag, function() use ($tag, $callback, $attributes, $css){

            if(is_array($callback) || strpos($callback, '@') == false){
                //Call defined class function & Pass Parameters
                return call_user_func($callback,array(
                    'attributes' => $attributes,
                    'css' => array_merge(array($tag),$css)
                ));
            }else{
                if(strpos($callback, '@') !== false){
                    $classMethod = explode('@',$callback);
                }else{
                    $classMethod = $callback;
                }
                $controller = new $classMethod[0]();
                return $controller->{$classMethod[1]}(array(
                    'attributes' => $attributes,
                    'css' => array_merge(array($tag),$css)
                ));
            }


        });
    }
}