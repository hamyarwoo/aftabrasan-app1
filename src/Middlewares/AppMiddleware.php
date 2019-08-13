<?php

namespace Middlewares;

class AppMiddleware {

    /**
     * local container
     */
    private $cont;

    /**
     * constructor to get the DI container
     */
    function __construct($di) {
        $this->cont = $di;
    }

    /**
     * Exclude List : Static
     */
    private $excludeListStatic = array(

        'login',
        'token',
        'offline',
        '/',

    );

    /**
     * Exclude List : pattern
     */
    private $excludeListPattern = array(
        'v1/user/info/check',
    );

    /**
     * exclude check method
     */
    private function excludeCheck($uri) {
        // static rule check
        if (in_array($uri, $this->excludeListStatic)) {
            return true;
        }
        // dynamic rule check
        foreach ($this->excludeListPattern as $pattern) {
            if (preg_match("|^" . $pattern . "|is", $uri)) {
                return true;
            }
        }
        return false;
    }





    /**
     * Example middleware invokable class
     *
     * @param  \Psr\Http\Message\ServerRequestInterface $request PSR7 request
     * @param  \Psr\Http\Message\ResponseInterface $response PSR7 response
     * @param  callable $next Next middleware
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function __invoke($request, $response, $next) {

        $uri = $request->getUri()->getPath();

        if ($this->excludeCheck($uri)) {
            $pass = true;
        } else {

            $exists_user = $this->cont->session->exists('user_id');

            if ($exists_user && is_numeric($this->cont->session->get('user_id')) ) {
                if (
                    $this->cont->session->exists('UA') &&
                    $this->cont->session->exists('IP') &&
                    $this->cont->session->get('IP') == $_SERVER['REMOTE_ADDR'] &&
                    $this->cont->session->get('UA') == $_SERVER['HTTP_USER_AGENT']
                ) {
                    $user_id=$this->cont->session->get('user_id');
                    $request = $request->withAttribute('uid',$user_id );
                    global $new_request;
                    $new_request = $request;
                    $pass = true;

                }else{

                    $this->cont->session::destroy();
                    return $response->withStatus(302)->withHeader("location", base_url("login"));
                }
            }else{

                $this->cont->session::destroy();
                return $response->withStatus(302)->withHeader("location", base_url("login"));

            }
        }

        // Auth Action : True
        if ($pass) {
            $response = $next($request, $response);
            return $response;
        } else {

            if (isAjax()){
                return $response->withStatus(401);
            }
            return $response->withStatus(302)->withHeader("location", base_url("/login"));
        }
    }

}

?>
