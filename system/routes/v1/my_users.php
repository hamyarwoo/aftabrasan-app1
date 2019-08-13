<?php
/**
 * Login
 */
 $app->post('/user/login', function ($request, $response, $args)
 {
   // empty output payload
   $payload = array();
   // get post json
   $json = $request->getBody();
   $pdata = json_decode($json, true);
   // populating user data
   $user = !empty($pdata['user']) ? $pdata['user'] : '' ;
   $pass = !empty($pdata['pass']) ? $pdata['pass'] : '' ;
   // loader user model
   $uModel = new \Models\v1\Users($this);
   // check login
   $chk = $uModel->checkLogin($user, $pass);
   if ($chk)
   {
     $payload['token'] = $chk;
     return $response->withStatus(200)->withJson($payload);
   }
   // error, not found
   $payload['err'] = 101;
   $payload['msg'] = 'Auth Failed!';
   return $response->withStatus(401)->withJson($payload);
 });

/**
 * Logout
 */
 $app->post('/user/logout', function ($request, $response, $args)
 {
   $token = $request->getHeader('X-AUTH');
   $aModel = new \Models\v1\Auth($this);
   // delete from db
   $aModel->deleteToken($token[0]);
   // return success msg
   $payload = array();
   $payload['msg'] = 'Logged Out';
   return $response->withStatus(200)->withJson($payload);
 });

/**
 * Register a new user
 */
 $app->put('/user/register', function ($request, $response, $args)
 {
   // get post data
   $json = $request->getBody();
   $pdata = json_decode($json, true);
   // if there is some data
   if (!empty($pdata) && is_array($pdata) /*&& count($pdata) > 0*/)
   {
     // init user model
     $uModel = new \Models\v1\Users($this);
     // check login
     $res = $uModel->register($pdata);
     // return resp
     return $response->withStatus(200)->withJson($res);
   }
   return $response->withStatus(400);
 });

/**
 * Invite new users
 */
 $app->post('/user/invite', function ($request, $response, $args)
 {
   // get user id
   $uid = $request->getAttribute('uid');
   // get post data
   $json = $request->getBody();
   $pdata = json_decode($json, true);
   // if there is some data
   if (!empty($pdata) && is_array($pdata) && count($pdata) > 0)
   {
     // init user model
     $uModel = new \Models\v1\Users($this);
     // check login
     $res = $uModel->invite($pdata, $uid);
     // return resp
     return $response->withStatus(200)->withJson($res);
   }
   return $response->withStatus(400);
 });

/**
 * get invite list of a user
 */
 $app->post('/user/invite/list', function ($request, $response, $args)
 {
   // get user id
   $uid = $request->getAttribute('uid');
   // init user model
   $uModel = new \Models\v1\Users($this);
   // check login
   $res = $uModel->inviteList($uid);
   // return resp
   if (!empty($res) && is_array($res))
   {
     return $response->withStatus(200)->withJson($res);
   }
   return $response->withStatus(404);
 });

/**
 * delete invite by mobile
 */
 $app->delete('/user/invite/delete', function ($request, $response, $args)
 {
   // get user id
   $uid = $request->getAttribute('uid');
   // get post data
   $json = $request->getBody();
   $pdata = json_decode($json, true);
   // check mobile exists
   if (!empty($pdata['mobile']))
   {
     // init user model
     $uModel = new \Models\v1\Users($this);
     // check login
     $res = $uModel->inviteDelete($pdata['mobile'], $uid);
     // return resp
     return $response->withStatus(200)->withJson($res);
   }
   return $response->withStatus(400);
 });

/**
 * GET USER INFO
 */
 $app->post('/user/info/get', function ($request, $response, $args)
 {
   // get user id
   $uid = $request->getAttribute('uid');
   // init user model
   $uModel = new \Models\v1\Users($this);
   // check login
   $res = $uModel->getInfo($uid);
   // output
   if ($res)
   {
     return $response->withStatus(200)->withJson($res);
   }
   return $response->withStatus(404);
 });

/**
 * GET USER INFO by Param
 */
 $app->post('/user/info/get/{param}', function ($request, $response, $args)
 {
   // get user id
   $uid = $request->getAttribute('uid');
   // init user model
   $uModel = new \Models\v1\Users($this);
   // check login
   $res = $uModel->getInfo($uid, $args['param']);
   // output
   if ($res)
   {
     return $response->withStatus(200)->withJson($res);
   }
   return $response->withStatus(404);
 });

/**
 * SET USER INFO
 */
 $app->put('/user/info/set', function ($request, $response, $args)
 {
   $cList = array();
   // get user id
   $uid = $request->getAttribute('uid');
   // get post data
   $json = $request->getBody();
   $pdata = json_decode($json, true);
   // if there is some data
   if (!empty($pdata)){
     // init user model
     $uModel = new \Models\v1\Users($this);
     // check login
     $res = $uModel->setInfo($uid, $pdata);
     // output
     if ($res)
     {
       return $response->withStatus(200)->withJson($res);
     }
   }
   return $response->withStatus(404);
 });

/**
 * Check User Info Exists
 */
 $app->post('/user/info/check', function ($request, $response, $args)
 {
   // get post data
   $json = $request->getBody();
   $pdata = json_decode($json, true);
   // init user model
   $uModel = new \Models\v1\Users($this);
   // check login
   $res = $uModel->checkInfo($pdata);
   // output
   if ($res === true)
   {
     $payload = array('exists' => true);
     return $response->withStatus(200)->withJson($payload);
   }
   if ($res === false){
     $payload = array('exists' => false);
     return $response->withStatus(200)->withJson($payload);
   }
   return $response->withStatus(404);
 });

/**
 * Upload Avatar
 */
 $app->post('/user/avatar', function ($request, $response, $args)
 {
   // set output width, output height
   $outWidth = 250;
   $outHeight = 250;
   // quality
   $quality = 30;
   // get upload dir from config
   $dir = $this['settings']['upload']['dir'];
   $dirTmp = $dir . DIRECTORY_SEPARATOR .
      $this['settings']['upload']['folder']['tmp'];
   $dirAvatar = $dir . DIRECTORY_SEPARATOR .
      $this['settings']['upload']['folder']['avatar'];
   // get user id
   $uid = $request->getAttribute('uid');
   // return array
   $toReturn = array('err' => false, 'msg' => array());
   // get uploaded files from req
   $uploadedFiles = $request->getUploadedFiles();
   // get post data
   $pdata = $request->getParsedBody();
   // validation : x
   if (!empty($pdata['x']) && abs((int)$pdata['x']) >= 0)
   {
     $x = abs((int)$pdata['x']);
   }else{
     $x = 0;
   }
   // validation : y
   if (!empty($pdata['y']) && abs((int)$pdata['y']) >= 0)
   {
     $y = abs((int)$pdata['y']);
   }else{
     $y = 0;
   }
   // validation : width
   if (!empty($pdata['width']) && abs((int)$pdata['width']) >= $outWidth)
   {
     $width = abs((int)$pdata['width']);
   }else{
     $width = 0;
   }
   // validation : height
   if (!empty($pdata['height']) && abs((int)$pdata['height']) >= $outHeight)
   {
     $height = abs((int)$pdata['height']);
   }else{
     $height = 0;
   }
   // if there is a file
   if (!empty($uploadedFiles))
   {
     // get by input name
     $uploadedFile = $uploadedFiles['file'];
     // if upload ok
     if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
       // move uploaded file to temp
       $fileName = moveUploadedFile($dirTmp, $uploadedFile);
       $tmpFile = $dirTmp . DIRECTORY_SEPARATOR . $fileName;
       //$response->write($dirTmp.DIRECTORY_SEPARATOR.$filename);
       if (exif_imagetype($tmpFile) == IMAGETYPE_JPEG ||
           exif_imagetype($tmpFile) == IMAGETYPE_PNG)
       {
         // create image from uploaded file
         $imageLib = new Intervention\Image\ImageManagerStatic;
         $img = $imageLib::make($tmpFile);
         // crop if crop size is right
         if ($x + $width  <= $img->width() &&
             $y + $height <= $img->height() &&
             $width != 0 && $height != 0)
         {
           $img->crop($width, $height, $x, $y);
         }
         // resizes
         $img->resize($outWidth, $outHeight);
         // save
         $finalFile = $dirAvatar . DIRECTORY_SEPARATOR . $fileName;
         $img->save($finalFile, $quality);
         // add to db
         $uModel = new \Models\v1\Users($this);
         // delete last avatar
         $uModel->delAvatar($uid);
         // set avatar
         $res = $uModel->setAvatar($fileName, $uid);
       }else{
         $toReturn['err'] = true;
         $toReturn['msg'][] = 'Unsupported File Type!';
       }
       // delete temp file
       unlink($tmpFile);
     }else{
       $toReturn['err'] = true;
       $toReturn['msg'][] = 'Upload Failed!';
       if ($this['settings']['displayErrorDetails'] == true)
       {
         $toReturn['msg'][] = uploadCodeToMessage($uploadedFile->getError());
       }
     }
   }else{
     $toReturn['err'] = true;
     $toReturn['msg'][] = 'No Upload File!';
   }

   return $response->withStatus(200)->withJson($toReturn);
 });

 /**
  * Delete Avatar
  */
  $app->delete('/user/avatar/delete', function ($request, $response, $args)
  {
    // get user id
    $uid = $request->getAttribute('uid');
    // init user model
    $uModel = new \Models\v1\Users($this);
    // delete
    $res = $uModel->delAvatar($uid);
    // return resp
    return $response->withStatus(200)->withJson($res);
  });

/**
 *
 */

?>
