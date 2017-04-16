<?php namespace IllumineFramework;

//Illuminate
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Cookie\CookieJar;
use Illuminate\Events\Dispatcher;
use Illuminate\Config\Repository;
use Illuminate\Container\Container;
use Illuminate\Support\Facades\Facade;
use Illuminate\View\ViewServiceProvider;
use Illuminate\Cache\CacheServiceProvider;
use Illuminate\Events\EventServiceProvider;
use Illuminate\Session\SessionServiceProvider;
use Illuminate\Routing\RoutingServiceProvider;
use Illuminate\Filesystem\FilesystemServiceProvider;
use Illuminate\Database\Capsule\Manager as Database;

//IllumineFramework
use IllumineFramework\Factories\AdminFactory;
use IllumineFramework\Factories\ShortcodeFactory;
use IllumineFramework\Factories\WidgetFactory;
use IllumineFramework\ServiceProviders\ValidationProvider;
use IllumineFramework\ServiceProviders\ViewFactoryProvider;


class IlluminePlugin extends Container{

    protected $this, $routeDispatched;
    private static $app_path = __DIR__.'/../app';

    /**
     * WppFramework constructor.
     */
    public function __construct(){

        //Set Response Type, used in BaseController
        $this->routeDispatched = false;
        $this->setFacadeApp($this);
        $this->addConfig();
        $this->addCoreProviders();
        $this->captureRequest();
        $this->addCookieJar();
        $this->addDatabase();
        $this->addSession();
        $this->addPluginProviders();
        $this->addRoutes();
        $this->setInstance($this);
        $this->routeRequests();
        $this->bindWpSupport();
        $this->initWpFunctions();
    }


    /**
     * Add Plugin Configuration
     */
    private function addConfig()
    {
        //UnBind Current Config
        if($this->bound('config')){
            $this->offsetUnset('config');
        }
        //Bind Config as Namespace in Container
        $this->bind('config', function(){
            return new Repository($this['files']->getRequire(self::$app_path.'/config.php'));
        }, true);
    }

    /**
     * Set Facade Application
     * @param $app
     */
    private function setFacadeApp($app)
    {
        Facade::setFacadeApplication($app);
    }

    /**
     * Add Core Service Providers
     */
    private function addCoreProviders()
    {
        with(new EventServiceProvider($this))->register();
        with(new CacheServiceProvider($this))->register();
        with(new FilesystemServiceProvider($this))->register();
        with(new ViewServiceProvider($this))->register();
        with(new RoutingServiceProvider($this))->register();
        with(new SessionServiceProvider($this))->register();

        //IllumineFramework
        with(new ValidationProvider($this))->register();
        with(new ViewFactoryProvider($this))->register();
    }
    /**
     * Add Session
     */
    private function addCookieJar()
    {
        //Bind CookieJar to Container
        $this->bind('cookie', function(){

            $cookieJar = new CookieJar();
            $cookieJar->setDefaultPathAndDomain(
                $this['config']->get('session.path'),
                $this['config']->get('session.domain'),
                $this['config']->get('session.secure')
            );

            return $cookieJar;

        }, true);
    }
    /**
     * AddSession
     * Create or Inherit Session State
     * Set CSRF Token
     */
    private function addSession()
    {

        if($this->bound('session') && !$this['session']->isStarted()){

            //Set Session ID from Existing Cookie if Available
            if(isset($_COOKIE[$this['config']->get('session.cookie')])) {

                //Set Session ID from Existing Cookie if Available
                if ($sessionId = $_COOKIE[$this['config']->get('session.cookie')]) {
                    $this['session']->setId($sessionId);
                }
            }else{

                //Create new Session ID and Set Cookie
                $cookie = $this['cookie']->make($this['session']->getName(), $this['session']->getId(), 3600);
                setcookie($cookie->getName(),
                    $cookie->getValue(),
                    $cookie->getExpiresTime(),
                    $cookie->getPath(),
                    $cookie->getDomain(),
                    $cookie->isSecure(),
                    $cookie->isHttpOnly());
            }

            //Start the Session
            $this['session']->start();

            //Regenerate CSRF token with each request
            if($this->getRequest()->method() == 'GET'){
                $this['session']->regenerateToken();
            }

            //Save the Session State
            $this['session']->save();
        }
    }

    /**
     * Add Plugin Service Providers
     */
    private function addPluginProviders()
    {
        if(count($this['config']->get('providers')) > 0){
            foreach($this['config']->get('providers') as $namespace){
                if($this['config']->get('encryption.enabled')){
                    if($namespace = '\Illuminate\Encryption\Encrypter'){
                        $this->bind('encrypter', function() use ($namespace){
                            return new $namespace($this['config']->get('encryption.key'), $this['config']->get('encryption.cipher'));
                        });
                    }
                }else{
                    with(new $namespace($this))->register();
                }
            }
        }
    }

    /**
     * Add Global Database Access & Boot Eloquent Drivers
     */
    private function addDatabase()
    {

        if($this['config']->get('database')){
            global $wpdb; //Get wpdb Object
            $database = new Database();
            $database->addConnection([
                'driver'    => 'mysql',
                'host'      => DB_HOST,
                'database'  => DB_NAME,
                'username'  => DB_USER,
                'password'  => DB_PASSWORD,
                'charset'   => $wpdb->charset,
                'collation' => $wpdb->collate,
                'prefix'    => $wpdb->prefix,
            ]);

            //Make Database Global
            $database->setAsGlobal();

            //Setup the Eloquent ORM
            $database->bootEloquent();

            //Setup Database Event Dispatcher
            $database->setEventDispatcher(new Dispatcher($this));

            $this->bind('db', function () use ($database){
                return $database->getDatabaseManager();
            }, true);
        }
    }

    /**
     * Capture HTTP Request
     */
    private function captureRequest()
    {
        //RequiredBy: Base Controller
        $this->instance('request', Request::capture());
    }

    /**
     * Bind Wordpress Support Classes
     */
    private function bindWpSupport()
    {
        //Bind WpShortcode Class
        if(!$this->bound('shortcodes')) {
            $this->bind('shortcodes', function () {
                return new ShortcodeFactory($this);
            }, true);
        }

        //Bind WpWidget Class
        if(!$this->bound('widgets')) {
            $this->bind('widgets', function () {
                return new WidgetFactory($this);
            }, true);
        }
        //Bind WpAdmin Class
        if(!$this->bound('admin')) {
            $this->bind('admin', function () {
                return new AdminFactory($this);
            }, true);
        }
    }

    /**
     * Initialize Wordpress Functions
     */
    private function initWpFunctions()
    {
        //Include Wordpress Functions
        add_action('init', function(){

            $WpIncludes = array(
                'Shortcodes',
                'Settings',
                'PostTypes',
                'Actions',
                'Filters',
                'Hooks',
                'Widgets',
                'Menus',
            );
            foreach ($WpIncludes as $directoryName){

                $config = $this['config'];
                $shortcodes = $this['shortcodes'];
                $widgets = $this['widgets'];
                $admin = $this['admin'];

                foreach($this['files']->glob(self::$app_path."/Wordpress/{$directoryName}/*.php") as $file){
                    require_once $file;
                }
            }
        });
        register_activation_hook(dirname(dirname(__FILE__)).'/plugin.php', function(){
            $activationClass = $this['config']->get('namespace').'\Wordpress\Activate';
            return new $activationClass($this);
        });
        register_deactivation_hook(dirname(dirname(__FILE__)).'/plugin.php', function(){
            $deactivationClass = $this['config']->get('namespace').'\Wordpress\DeActivate';
            return new $deactivationClass($this);
        });

        if($this['config']->get('mode') == 'development'){

            $this['admin']->addPanel(
                'Illumine Framework', //$page_title
                'Illumine Framework', //$menu_title
                'manage_options', //$capability
                'wpp_skeleton_illumine', //$menu_slug
                'IllumineFramework\Controllers\AdminController@load'
            );

        }

    }

    /**
     * Load Routes from Caching or Include them
     */
    private function addRoutes()
    {

        $routeCachePath = self::$app_path.'/../cache/routes.cache';

        //Use Cached Routes if Available
        if($this['config']->get('cache.routes') && $this['files']->exists($routeCachePath)){

            $contents = $this['files']->get($routeCachePath);
            if(!empty($contents)){
                //Get Cached Routes & Set Them
                $this['router']->setRoutes(unserialize(base64_decode($contents)));
            }

        }else{
            //Assign Router to Simple Variable for Include
            $route = $this['router'];

            //Include Routes

            $route->group(['prefix' => str_slug($this['config']->get('namespace')).'/api'], function () use ($route){
                require_once self::$app_path.'/Http/routes.php';
            });
        }
    }
    /**
     * Cache Routes to File
     */
    private function setRoutesCache(){

        if(!$this['files']->exists(self::$app_path.'/../cache/routes.cache')) {
            $allRoutes = $this['router']->getRoutes();

            //If Routes then Serialize
            if (count($allRoutes) > 0) {
                foreach ($allRoutes as $routeObject) {
                    $routeObject->prepareForSerialization();
                }
            }
            //Store Routes in Cache
            $this['files']->put(self::$app_path . '/../cache/routes.cache', base64_encode(serialize($allRoutes)));
        }
    }

    /**
     * Flush Route Cache
     */
    private function flushRoutesCache(){
        return $this['files']->delete(self::$app_path.'/../cache/routes.cache');
    }
    /**
     * Flush Object Cache
     */
    private function flushObjectsCache(){
        return $this['files']->cleanDirectory(self::$app_path.'/../cache/objects/');
    }
    /**
     * Flush View Cache
     */
    private function flushViewsCache(){
        return $this['files']->cleanDirectory(self::$app_path.'/../cache/views/');
    }
    /**
     * Try Routing Requests
     */
    private function routeRequests()
    {

        //Try Routing the Request
        try{

            //Store Cached Routes
            if($this['config']->get('cache.routes')){
                $this->setRoutesCache();
            }

            //Set Rendering Variable:
            //Shortcode (Echo) / Route (Response)
            $this['router']->matched(function($route){
                $this->routeDispatched = true;
            });

            //Load Helpers
            require 'Extras/Helpers.php';
            require self::$app_path.'/Helpers/Helpers.php';

            //Dispatch Request
            $this['router']->dispatch($this['request']);
            //End Transaction
            exit;

        }catch(\Exception $e){
            return; //Let It Go
        }
    }


    /**
     * Access CookieJar();
     * @return CookieJar
     */
    public function getCookieJar()
    {
        return $this['cookie'];
    }
    /**
     * Access flushRoutesCache();
     * @return mixed
     */
    public function flushRoutes()
    {
        return $this->flushRoutesCache();
    }

    /**
     * Access flushObjectsCache();
     * @return mixed
     */
    public function flushObjects()
    {
        return $this->flushObjectsCache();
    }

    /**
     * Access flushViewsCache();
     * @return mixed
     */
    public function flushViews()
    {
        return $this->flushViewsCache();
    }

    /**
     * Access Plugin Configuration
     * @return View;
     */
    public function getView()
    {
        return $this['view'];
    }

    /**
     * Access Plugin Configuration
     * @return mixed
     */
    public function getRequest()
    {
        return $this['request'];
    }

    /**
     * Access Plugin Configuration
     * @return mixed
     */
    public function getValidator()
    {
        return $this['validator'];
    }

    /**
     * Access Plugin Configuration
     * @return mixed
     */
    public function getConfig()
    {
        return $this['config'];
    }

    /**
     * Access Router Class
     * @return mixed
     */
    public function getRouter()
    {
        return $this['router'];
    }

    /**
     * Access Router Class
     * @return mixed
     */
    public function getUrlGenerator()
    {
        return $this['url'];
    }
    /**
     * Access Router Class
     * @return mixed
     */
    public function getRouterStatus()
    {
        return $this->routeDispatched;
    }
    /**
     * Access FileSystem Class
     * @return mixed
     */
    public function getFileSystem()
    {
        return $this['files'];
    }

    /**
     * Access Session Class
     * @return mixed
     */
    public function getSession()
    {
        return $this['session'];
    }

    /**
     * Access Session Class
     * @return mixed
     */
    public function getDatabase()
    {
        return $this['db'];
    }
}