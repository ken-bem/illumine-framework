<?php namespace WppSkeleton\Http\Controllers;
use Illuminate\Validation\Validator;
use Illuminate\Translation\Translator;
use Illuminate\Translation\LoaderInterface;
class SearchController extends Controller {

    protected $this;
    public $data, $attributes, $parameters;

    /**
     * DirectoryController constructor.
     * @param $attributes
     */
    public function __construct($attributes = array())
    {
        parent::__construct();
        $this->attributes = $attributes;
    }
    /**
     * Render Shortcode Template
     * @return mixed
     */
    public function data()
    {
        //Assign Request Query to Template Variables
        $this->attributes['searchTerm'] = $this->request->get('wpp_search');
    }

    /**
     * Build Template
     * @return mixed
     */
    public function template()
    {

        $this->view('forms.search',$this->attributes)->render();
    }

    /**
     * Render Shortcode
     * @param $parameters
     * @return string
     */
    public function load($parameters)
    {
        ob_start();
            $shortcode = new self($parameters['attributes']);
            $shortcode->data();
            $shortcode->template();
        return ob_get_clean();
    }
}

