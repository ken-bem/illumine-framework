<?php namespace WppSkeleton\Http\Controllers;
use WppSkeleton\Models\WpUser;
use Illuminate\Validation\Rule;

class UserProfileController extends Controller {

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
        $this->attributes['user'] = WpUser::find(get_current_user_id());
        $this->attributes['errors'] = null;
        $this->attributes['alertColor'] = 'red';
    }
    /**
     * Process Data
     * @return mixed
     */
    public function data()
    {

        //Assign Request Query to Template Variables
        $this->attributes['searchTerm'] = $this->request->get('wpp_search');

        //Save Data
        if($this->request->isMethod('put')){

            $validation = $this->validation->make($this->request->all(),
                array(
                    'display_name' => array('required', Rule::unique('users')->ignore($this->attributes['user']->ID, 'ID')),
                    '_token' => 'required'
                ),
                array(
                    'display_name.required' => 'A display name is required.',
                    'display_name.unique' => 'A display name must be unique.',
                    '_token.required' => 'A Security Token must be present.'
                )
            );

            if($validation->passes() && $this->verifyCSRF()) {

                $this->attributes['user']->fill($this->request->all());

                if($this->attributes['user']->save()) {
                    $this->attributes['alertClass'] = 'green';
                    $this->attributes['messages'] = array('Profile updated Successfully.');
                }
            }elseif(count($validation->errors()) > 0){
                $this->attributes['messages'] = $validation->errors()->all();
            }else{
                $this->attributes['alertClass'] = 'red';
                $this->attributes['messages'] = array('CSRF Token Expired Please refresh the page to start a new request.');
            }
        }
    }

    /**
     * Render Shortcode Template
     * @return mixed
     */
    public function template()
    {

        $this->view('forms.user-profile',$this->attributes)->render();
    }

    /**
     * Render Shortcode
     * @param $parameters
     * @return string
     */
    public function load($parameters)
    {
        //Capture Output Object
        ob_start();

            //Load Self with Shortcode Parameters
            $shortcode = new self($parameters['attributes']);

            //Process Data
            $shortcode->data();

            //Render Template
            $shortcode->template();

        //Return Cleaned Output
        return ob_get_clean();
    }
}

