<?php

namespace Middlewares;

class AuthMiddleware
{
  /**
   * local container
   */
  private $cont;
  /**
   * constructor to get the DI container
   */
  function __construct($di)
  {
    $this->cont = $di;
  }
  /**
   * Exclude List : Static
   */
  private $excludeListStatic = array(
    'v1/',
    'v1/user/login',
    'v1/user/register',
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
   private function excludeCheck($uri)
   {
     // static rule check
     if (in_array($uri, $this->excludeListStatic))
     {
       return true;
     }
     // dynamic rule check
     foreach ($this->excludeListPattern as $pattern)
     {
       if (preg_match("|^".$pattern."|is", $uri))
       {
         return true;
       }
     }
     return false;
   }
  /**
   * Example middleware invokable class
   *
   * @param  \Psr\Http\Message\ServerRequestInterface $request  PSR7 request
   * @param  \Psr\Http\Message\ResponseInterface      $response PSR7 response
   * @param  callable                                 $next     Next middleware
   *
   * @return \Psr\Http\Message\ResponseInterface
   */
  public function __invoke($request, $response, $next)
  {
    // pass variable declration
    $pass = false;
    // get current uri
    $uri = $request->getUri()->getPath();
    // if has uid in header, do not pass !
    if ($request->hasHeader('uid')){
      // bad request
      return $response->withStatus(400);
    }
    // do not apply middleware to excluded uris
    if ($this->excludeCheck($uri))
    {
      $pass = true;
    }else{
      // get token from request header
      if ($request->hasHeader('X-AUTH'))
      {
        $token = $request->getHeader('X-AUTH');
        // init Auth Model
        $authModel = new \Models\v1\Auth($this->cont);
        $chk = $authModel->checkToken($token);
        // check response from model
        if ($chk)
        {
          // check user agent matches with db value
          if ($_SERVER['HTTP_USER_AGENT'] == $chk->ua)
          {
            $pass = true;
            // add uid to request header
            $request = $request->withAttribute('uid', $chk->uid);
            // update token stats
            $authModel->updateToken($chk);
          }else{
            // user agent missmatch, delete it
            $authModel->deleteTokenById($chk->id);
          }
        }
      }
    }
    // Auth Action : True
    if ($pass)
    {
      $response = $next($request, $response);
      return $response;
    }
    // Auth Action : False
    return $response->withStatus(401);
  }
}

?>
