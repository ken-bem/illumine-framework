<?php namespace WppSkeleton\Http\Controllers;
use WppSkeleton\Models\WpPage;
use WppSkeleton\Http\Middleware\CsrfFilter;
class DirectoryController extends Controller {

    protected $this;
    public $data, $attributes, $parameters;
    /**
     * @param $attributes
     * DirectoryController constructor.
     */
    public function __construct($attributes = array())
    {
        parent::__construct();
        $this->attributes = $attributes;
    }

    /**
     * Display Directory Index
     * @return mixed
     */
    public function data()
    {

        $posts = WpPage::with('meta')
            ->where('post_title', 'like', '%'.$this->request->get('post_title').'%')
            ->remember(10)
            ->paginate(10, ['post_title'], 'wpp_directory', $this->request->get('wpp_directory'))
            ->withPath(route_url('directory'));


        $this->cookieJar->queue('test', 'test', 45000);

        $this->view('test', array(
            'posts' => $posts
        ))->render();
    }

    /**
     * @param $parameters
     * @return string
     */
    public function load($parameters)
    {
        ob_start();
        echo '<div class="' . implode(" ",$parameters['css']) . '">';
            new self($parameters['attributes']);
            self::data();
        echo '</div>';
        return ob_get_clean();
    }
}

