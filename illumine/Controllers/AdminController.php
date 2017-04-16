<?php namespace IllumineFramework\Controllers;
use IllumineFramework\Controllers\BaseController;
class AdminController extends BaseController {

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
        $this->attributes['config'] = $this->config;
        $this->attributes['session'] = $this->session;
        $this->attributes['filesystem'] = $this->filesystem;
        $this->attributes['router'] = $this->router;
        $this->attributes['request'] = $this->request;
        $this->attributes['validation'] = $this->validation;
        $this->attributes['paths'] = array(
            'objects' => realpath($this->config->get('cache.stores.files')['path']),
            'sessions' => realpath($this->config->get('session.files')),
            'views' => realpath($this->config->get('cache.stores.files')['path'].'/../views'),
            'routes' => realpath($this->config->get('cache.stores.files')['path'].'/../routes.cache'),
        );
    }

    /**
     * Format File Sizes
     * @return string
     */
    private function formatFileSize($size)
    {
        $units = array( 'Bytes', 'Kilobytes', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
        $power = $size > 0 ? floor(log($size, 1024)) : 0;
        return number_format($size / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power];
    }


    /**
     * Process Admin Settings Data
     * @return mixed
     */
    public function data()
    {

        if($this->request->method('post') && isset($this->attributes['paths'][$this->request->get('_flush')])){

            $flushed = false;

            if($this->filesystem->isFile($this->attributes['paths'][$this->request->get('_flush')])){
                $flushed = $this->attributes['paths'][$this->request->get('_flush')];
            }elseif($this->filesystem->isDirectory($this->attributes['paths'][$this->request->get('_flush')])){
                $flushed = $this->filesystem->cleanDirectory($this->attributes['paths'][$this->request->get('_flush')]);
            }
            if($flushed){
                $this->attributes['messages'] = array('&#10004; '.ucwords($this->request->get('_flush')).' flushed successfully.');
                $this->attributes['alertClass'] = 'success';
            }else{
                $this->attributes['messages'] = array('&#10004; '.ucwords($this->request->get('_flush')).' could not be flushed.  Check directory permissions and config paths.');
                $this->attributes['alertClass'] = 'error';
            }
        }

        $this->attributes['views_size'] = $this->formatFileSize($this->filesystem->size($this->attributes['paths']['views']));
        $this->attributes['objects_size'] =  $this->formatFileSize($this->filesystem->size($this->attributes['paths']['objects']));
        $this->attributes['sessions_size'] =  $this->formatFileSize($this->filesystem->size($this->attributes['paths']['sessions']));
        $this->attributes['routes_size'] =  $this->formatFileSize($this->filesystem->size($this->attributes['paths']['routes']));
    }

    /**
     * Build Template
     * @return mixed
     */
    public function template()
    {
        $this->view('admin.settings',$this->attributes)->render();
    }

    /**
     * Render Shortcode
     * @param $parameters
     * @return string
     */
    public function load($attributes)
    {
        $adminScreen = new self($attributes);
        $adminScreen->data();
        $adminScreen->template();
    }
}

