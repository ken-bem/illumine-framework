<?php namespace IllumineFramework\Controllers;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use IllumineFramework\IlluminePlugin;
abstract class BaseController extends Controller{
    protected
        $this,
        $plugin,
        $config,
        $session,
        $filesystem,
        $router,
        $routeDispatched,
        $currentUserId,
        $request,
        $response,
        $cookieJar,
        $cookies,
        $view,
        $viewRendered,
        $validation;
    /**
     * BaseController constructor.
     * http://flightphp.com/learn/#frameworkmethods
     */
    public function __construct()
    {
        $this->plugin = IlluminePlugin::getInstance();
        $this->config = $this->plugin->getConfig();
        $this->session = $this->plugin->getSession();
        $this->filesystem = $this->plugin->getFileSystem();
        $this->router = $this->plugin->getRouter();
        $this->routeDispatched = $this->plugin->getRouterStatus();
        $this->currentUserId = get_current_user_id();
        $this->request = $this->plugin->getRequest();
        $this->response = new Response();
        $this->cookieJar = $this->plugin->getCookieJar();
        $this->cookies = array();
        $this->view = $this->plugin->getView();
        $this->viewRendered = null;
        $this->validation = $this->plugin->getValidator();
    }

    /**
     * Verify CSRF Token Presence
     * @return boolean
     */
    public function verifyCSRF()
    {
        if(!$this->request->isMethod('get')){
            if($this->request->get('_token') == $this->session->get('_token')){
                $this->session->regenerateToken();
                $this->session->save();
                return true;
            }else{
                return false;
            }
        }
    }

    /**
     * Get Current WP User ID
     * @return integer
     */
    public function currentUserId()
    {
        return (is_null($this->currentUserId) ? null : $this->currentUserId);
    }

    /**
     * Build View with Engine
     * @return $this
     * start chain
     */
    public function view($template, $parameters)
    {
        //Setup Template Variables
        $data = array(
            'request' => $this->request,
            'currentUserId' => $this->currentUserId(),
        );

        //Loop & Combine User Template Variables
        foreach($parameters as $parameter => $value){
            $data[$parameter] = $value;
        }

        //Bind Template Variables to ViewRendered
        $this->viewRendered = $this->view->make($template, $data)->render();

        //Allow Chaining
        return $this;
    }

    /**
     * Echo View or Respond as Route
     * @return $this
     * end chain
     */
    public function render(){

        if($this->routeDispatched){
            $this->respond();
        }else{
            echo $this->viewRendered;
        }
    }

    /**
     * Send Response with CookieJar
     * @return $this
     * end chain
     */
    private function respond($content = null, $status = 200){

        //Loop CookieJar
        foreach($this->cookieJar->getQueuedCookies() as $cookie){

            //Set Cookie
            setcookie($cookie->getName(),
                $cookie->getValue(),
                $cookie->getExpiresTime(),
                $cookie->getPath(),
                $cookie->getDomain(),
                $cookie->isSecure(),
                $cookie->isHttpOnly());
        }

        //Set Status Code
        $this->response->setStatusCode($status);

        //Set Content
        $this->response->setContent((is_null($content) ? $this->viewRendered : $content));

        //Send Response
        $this->response->send();
    }
}