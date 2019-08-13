<?php

namespace Models\v1;

class Users
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
   * Check Login Using Username & Password
   */
  public function checkLogin($user='', $pass='')
  {
    if (!empty($user) && !empty($pass))
    {
      // cypher query to check user
      $res = $this->cont->neo4j->run(
        'MATCH (n:USER { user: {user} })
        RETURN id(n) as id, n LIMIT 1',
        ['user' => $user]
      );
      if ($res->records())
      {
        $data = $res->getRecord();
        $n = $data->value('n');
        if (password_verify($pass, $n->value('pass')))
        {
          // generating unique token
          $token = hash('sha1', uniqid($user));
          // adding token to mysql db
          $this->cont->db->table('tokens')->insert([
            'uid' => $data->value('id'),
            'token' => $token,
            'ip' => !empty($_SERVER['REMOTE_ADDR']) ?
              $_SERVER['REMOTE_ADDR'] : '',
            'ua' => !empty($_SERVER['HTTP_USER_AGENT']) ?
              $_SERVER['HTTP_USER_AGENT'] : '',
            'created' => time(),
            'last_used' => 0,
            'transactions' => 0,
          ]);
          return $token;
        }
      }
      // error, not res
      return false;
    }
  }

  /**
   * get user info, all | by param
   */
  public function getInfo($uid, $param='')
  {
    $res = $this->cont->neo4j->run(
      'MATCH (n) WHERE id(n)={uid}
      RETURN n, labels(n) as label LIMIT 1',
      ['uid' => $uid]
    );
    // parse results
    if ($res->records())
    {
      // our return array
      $toReturn = array();
      // gettin the res val
      $data = $res->getRecord();
      $n = $data->value('n');
      // user
      if ($param == 'user' || empty($param))
      {
        if ($n->hasValue('user'))
        {
          $toReturn['user'] = $n->value('user');
        }
      }
      // first name
      if ($param == 'fname' || empty($param))
      {
        if ($n->hasValue('fname'))
        {
          $toReturn['fname'] = $n->value('fname');
        }
      }
      // last name
      if ($param == 'lname' || empty($param))
      {
        if ($n->hasValue('lname'))
        {
          $toReturn['lname'] = $n->value('lname');
        }
      }
      // mobile
      if ($param == 'mobile' || empty($param))
      {
        if ($n->hasValue('mobile'))
        {
          $toReturn['mobile'] = $n->value('mobile');
        }
      }
      // tel
      if ($param == 'tel' || empty($param))
      {
        if ($n->hasValue('tel'))
        {
          $toReturn['tel'] = $n->value('tel');
        }
      }
      // address
      if ($param == 'address' || empty($param))
      {
        if ($n->hasValue('address'))
        {
          $toReturn['address'] = $n->value('address');
        }
      }
      // province
      if ($param == 'province' || empty($param))
      {
        if ($n->hasValue('province'))
        {
          $toReturn['province'] = $n->value('province');
        }
      }
      // city
      if ($param == 'city' || empty($param))
      {
        if ($n->hasValue('city'))
        {
          $toReturn['city'] = $n->value('city');
        }
      }
      // labels
      if ($param == 'label' || empty($param))
      {
        if ($data->hasValue('label'))
        {
          $toReturn['label'] = $data->value('label');
        }
      }
      // changed
      if ($param == 'changed' || empty($param))
      {
        if ($n->hasValue('changed'))
        {
          $toReturn['changed'] = $n->value('changed');
        }
      }
      // avatar
      if ($param == 'avatar' || empty($param))
      {
        if ($n->hasValue('avatar'))
        {
          $baseUrl = $this->cont['settings']['upload']['url'] .
            $this->cont['settings']['upload']['folder']['avatar'] . '/';
          $toReturn['avatar'] = $baseUrl . $n->value('avatar');
        }
      }
      // return array
      return $toReturn;
    }
  }

  /**
   * set user info by param
   */
  public function setInfo($uid, $pdata=array())
  {
    // initial cypher query
    $cypher = 'MATCH (n) WHERE id(n)={uid} SET ';
    // to return array;
    $toReturn = array('err' => false, 'msg' => array());
    // array that contains the vypher variable values
    $cypherVals = array('uid'=>$uid);
    // whether to run query or not
    $todo = false;
    // username
    if (!empty($pdata['user']))
    {
      if (myValidator($pdata['user'], 'user'))
      {
        if (!$this->checkInfo(['user' => $pdata['user']]))
        {
          $todo = true;
          $cypher .= ' n.user={nuser}, ';
          $cypherVals['nuser'] = $pdata['user'];
        }else{
          $toReturn['err'] = true;
          $toReturn['msg'][] = 'نام کاربری وارد شده در سیستم وجود دارد.';
        }
      }else{
        $toReturn['err'] = true;
        $toReturn['msg'][] = 'ورودی های خود را کنترل کنید: نام کاربری';
      }
    }
    // password
    if (!empty($pdata['pass']))
    {
      if (myValidator($pdata['pass'], 'pass'))
      {
        $todo = true;
        $cypher .= ' n.pass={npass}, ';
        $cypherVals['npass'] = password_hash($pdata['pass'], PASSWORD_BCRYPT);
      }else{
        $toReturn['err'] = true;
        $toReturn['msg'][] = 'ورودی های خود را کنترل کنید: پسورد';
      }
    }
    // first name
    if (!empty($pdata['fname']))
    {
      if (myValidator($pdata['fname'], 'name'))
      {
        $todo = true;
        $cypher .= ' n.fname={nfname}, ';
        $cypherVals['nfname'] = $pdata['fname'];
      }else{
        $toReturn['err'] = true;
        $toReturn['msg'][] = 'ورودی های خود را کنترل کنید: نام';
      }
    }
    // last name
    if (!empty($pdata['lname']))
    {
      if (myValidator($pdata['lname'], 'name'))
      {
        $todo = true;
        $cypher .= ' n.lname={nlname}, ';
        $cypherVals['nlname'] = $pdata['lname'];
      }else{
        $toReturn['err'] = true;
        $toReturn['msg'][] = 'ورودی های خود را کنترل کنید: نام خانوادگی';
      }
    }
    // mobile
    if (!empty($pdata['mobile']))
    {
      if (myValidator($pdata['mobile'], 'irmobile'))
      {
        if (!$this->checkInfo(['mobile' => $pdata['mobile']]))
        {
          $todo = true;
          $cypher .= ' n.mobile={nmobile}, ';
          $cypherVals['nmobile'] = $pdata['mobile'];
        }else{
          $toReturn['err'] = true;
          $toReturn['msg'][] = 'شماره موبایل وارد شده در سیستم وجود دارد.';
        }
      }else{
        $toReturn['err'] = true;
        $toReturn['msg'][] = 'ورودی های خود را کنترل کنید: شماره موبایل';
      }
    }
    // tel
    if (!empty($pdata['tel']))
    {
      if (myValidator($pdata['tel'], 'irtel'))
      {
        $todo = true;
        $cypher .= ' n.tel={ntel}, ';
        $cypherVals['ntel'] = $pdata['tel'];
      }else{
        $toReturn['err'] = true;
        $toReturn['msg'][] = 'ورودی های خود را کنترل کنید: شماره تلفن';
      }
    }
    // address
    if (!empty($pdata['address']))
    {
      if (myValidator($pdata['address'], 'address'))
      {
        $todo = true;
        $cypher .= ' n.address={naddress}, ';
        $cypherVals['naddress'] = $pdata['address'];
      }else{
        $toReturn['err'] = true;
        $toReturn['msg'][] = 'ورودی های خود را کنترل کنید: آدرس';
      }
    }
    // province
    if (!empty($pdata['province']))
    {
      if (myValidator($pdata['province'], 'cpc'))
      {
        $todo = true;
        $cypher .= ' n.province={nprovince}, ';
        $cypherVals['nprovince'] = $pdata['province'];
      }else{
        $toReturn['err'] = true;
        $toReturn['msg'][] = 'ورودی های خود را کنترل کنید: استان';
      }
    }
    // city
    if (!empty($pdata['city']))
    {
      if (myValidator($pdata['city'], 'cpc'))
      {
        $todo = true;
        $cypher .= ' n.city={ncity}, ';
        $cypherVals['ncity'] = $pdata['city'];
      }else{
        $toReturn['err'] = true;
        $toReturn['msg'][] = 'ورودی های خود را کنترل کنید: شهر';
      }
    }

    // if todo is true, run query
    if ($todo)
    {
      $cypher .= ' n.changed={nchanged} ';
      $cypherVals['nchanged'] = time();
      $this->cont->neo4j->run($cypher, $cypherVals);
    }
    return $toReturn;
  }

  /**
   * Check info exists in users
   */
   public function checkInfo($pdata)
   {
     // whteher run the query or not
     $todoNeo = false;
     // mobile
     if (!empty($pdata['mobile']))
     {
       $pval = $pdata['mobile'];
       if (myValidator($pval, 'irmobile'))
       {
         $cypher = 'MATCH (n { mobile:{val} }) RETURN id(n) as id;';
         $todoNeo = true;
       }else{
         return false;
       }
      }
      // user
      if (!empty($pdata['user']))
      {
        $pval = $pdata['user'];
        if (myValidator($pval, 'user'))
        {
          $cypher = 'MATCH (n { user:{val} }) RETURN id(n) as id;';
          $todoNeo = true;
        }else{
          return false;
        }
      }
      // invite
      if (!empty($pdata['invite']))
      {
        $pval = $pdata['invite'];
        if (self::checkInfo(["mobile" => $pval]) === true)
        {
          return true;
        }
        if (self::checkInfo(["mobile" => $pval]) === false)
        {
          $chk = $this->cont->db->table('invites')->where('mobile', $pval)
            ->get();
          if (count($chk) > 0)
          {
            return true;
          }
          return false;
        }
     }
     // if something to do
     if ($todoNeo)
     {
       $cypherVals = array('val' => $pval);
       $res = $this->cont->neo4j->run($cypher, $cypherVals);
       if ($res->records())
       {
         return true;
       }
       return false;
     }
     return 'err';
   }

  /**
   * new invite
   */
   public function invite($dataArray, $uid)
   {
     // check role
     $roles = $this->getInfo($uid, 'label');
     if (!in_array('ADMIN', $roles['label']))
     {
       return array('err' => true, 'msg' => 'Insufficient Access!');
     }
     // to return array
     $toReturn = array('err' => false, 'msg' => array());
     // whther create new invite token
     $todoAll = true;
     // inserts array
     $inserts = array();
     // cycle through data array
     foreach ($dataArray as $data)
     {
       if (is_array($data))
       {
         $todo = true;
         // validation: mobile
         if (!empty($data['mobile']) && myValidator($data['mobile'], 'irmobile'))
         {
           if ($this->checkInfo(['invite' => $data['mobile']]) === false)
           {
             $mobile = $data['mobile'];
           }else{
             $todo = false;
             $todoAll = false;
             $toReturn['err'] = true;
             $toReturn['msg'][$data['mobile']] = 'شماره مورد نظر قبلا دعوت شده یا در سیستم وجود دارد';
           }
         }else{
           $todo = false;
           $todoAll = false;
           $toReturn['err'] = true;
           $toReturn['msg'][$data['mobile']] = 'ورودی های خود را کنترل کنید: شماره موبایل';
         }
         // validation: first name
         if (!empty($data['fname']) && myValidator($data['fname'], 'name'))
         {
           $fname = $data['fname'];
         }else{
           $todo = false;
           $todoAll = false;
           $toReturn['err'] = true;
           $toReturn['msg'][$data['fname']] = 'ورودی های خود را کنترل کنید: نام';
         }
         // validation: last name
         if (!empty($data['lname']) && myValidator($data['lname'], 'name'))
         {
           $lname = $data['lname'];
         }else{
           $todo = false;
           $todoAll = false;
           $toReturn['err'] = true;
           $toReturn['msg'][$data['lname']] = 'ورودی های خود را کنترل کنید: نام خانوادگی';
         }
         // validation: relation
         if (!empty($data['relation']) && myValidator($data['relation'], 'relation'))
         {
           $relation = $data['relation'];
         }else{
           $todo = false;
           $todoAll = false;
           $toReturn['err'] = true;
           $toReturn['msg'][$data['relation']] = 'ورودی های خود را کنترل کنید: نسبت';
         }
         if ($todo)
         {
           // generate invitation code
           $code = substr(md5(uniqid($uid)), 1, 3) .
                   substr(abs(crc32(uniqid())), -4, -1);
           // do query
           $inserts[] = array(
             'uid' => $uid,
             'mobile' => $mobile,
             'code' => $code,
             'fname' => $fname,
             'lname' => $lname,
             'rel' => $relation,
             'created' => time(),
           );
         }
       }else{
         return array('err' => true, 'msg' => ['فرمت داده ارسالی نامعتبر است.']);
       }
     }
     // if todoAll is still true, run query
     if ($todoAll)
     {
       $this->cont->db->table('invites')->insert($inserts);
     }
     // retuen resp
     return $toReturn;
   }

  /**
   * get invite list of a user
   */
   public function inviteList($uid)
   {
     // $toReturn array
     $toReturn = array();
     // query
     $invites = $this->cont->db->table('invites')->where('uid', $uid)->get();
     // looping through res
     if (count($invites) > 0)
     {
       foreach ($invites as $invite)
       {
         $toReturn[] = array(
           'mobile' => $invite->mobile,
           'code' => $invite->code,
           'fname' => $invite->fname,
           'lname' => $invite->lname,
           'relation' => $invite->rel,
           'created' => $invite->created,
         );
       }
     }
     return $toReturn;
   }

  /**
   * delete invite by mobile
   */
   public function inviteDelete($mobile, $uid)
   {
     if (myValidator($mobile, 'irmobile'))
     {
       $res = $this->cont->db->table('invites')
         ->where(['mobile' => $mobile, 'uid' => $uid])->delete();
       if ($res)
       {
         return array('err' => false, 'msg' => '');
       }
     }
     return array('err' => true, 'msg' => 'دعوت نامه مورد نظر وجود ندارد.');
   }

  /**
   * register
   */
   public function register($pdata)
   {
     // toReturn array
     $toReturn = array('err' => false, 'msg' => array());
     // validation bool
     $valid = true;
     // mobile
     if (!empty($pdata['mobile']) && myValidator($pdata['mobile'], 'irmobile'))
     {
       $mobile = $pdata['mobile'];
     }else{
       $valid = false;
       $toReturn['err'] = true;
       $toReturn['msg'][] = 'ورودی های خود را کنترل کنید: شماره موبایل';
     }
     // code
     if (!empty($pdata['code']) && strlen($pdata['code']) == 6)
     {
       $code = $pdata['code'];
     }else{
       $valid = false;
       $toReturn['err'] = true;
       $toReturn['msg'][] = 'ورودی های خود را کنترل کنید: کد دعوت';
     }
     // user
     if (!empty($pdata['user']) && myValidator($pdata['user'], 'user'))
     {
       $user = $pdata['user'];
     }else{
       $valid = false;
       $toReturn['err'] = true;
       $toReturn['msg'][] = 'ورودی های خود را کنترل کنید: نام کاربری';
     }
     // pass
     if (!empty($pdata['pass']) && myValidator($pdata['pass'], 'pass'))
     {
       $pass = $pdata['pass'];
     }else{
       $valid = false;
       $toReturn['err'] = true;
       $toReturn['msg'][] = 'ورودی های خود را کنترل کنید: کلمه عبور';
     }

     if ($valid)
     {
       $res = $this->cont->db->table('invites')
       ->where(['mobile' => $mobile, 'code' => $code])->get();
       if (count($res) > 0)
       {
         $rel = strtoupper($res[0]->rel);
         // populating query and vals
         $cypher = 'MATCH (ref) WHERE id(ref) = {refid}
                    MATCH (ref)-[:MOD]-(clan)
                    CREATE (n:USER {user:{nuser}, fname:{nfname},
                    lname:{nlname}, pass:{npass}, mobile:{nmobile},
                    created:{ncreated}})
                    MERGE (ref)-[r:'. $rel .']->(n)
                    MERGE (n)-[:MEMBER]->(clan)
                    RETURN id(n) as id;';
         $cypherVals = array(
           'refid' => $res[0]->uid,
           'nuser' => $user,
           'nfname' => $res[0]->fname,
           'nlname' => $res[0]->lname,
           'npass' => password_hash($pass, PASSWORD_BCRYPT),
           'nmobile' => $mobile,
           'ncreated' => time(),
         );
         // running query
         $cy = $this->cont->neo4j->run($cypher, $cypherVals);
         if ($cy->records())
         {
           // delete invitation
           $this->inviteDelete($mobile, $res[0]->uid);
         }
       }else{
         $toReturn['err'] = true;
         $toReturn['msg'][] = 'دعوت نامه شما نامعتبر است.';
       }
     }

     return $toReturn;
   }

  /**
   * Set Avatar
   */
   public function setAvatar($filename, $uid)
   {
     $cypher = 'MATCH (n) WHERE id(n)={uid} SET n.avatar={avatar}, n.changed={changed}';
     $cypherVals = array('uid' =>  $uid, 'avatar' =>  $filename, 'changed' => time());
     $this->cont->neo4j->run($cypher, $cypherVals);
   }

  /**
   * Delete Avatar
   */
   public function delAvatar($uid)
   {
     $cypher = 'MATCH (n) WHERE id(n)={uid} RETURN n.avatar as avatar;';
     $cypherVals = array('uid' =>  $uid);
     $res = $this->cont->neo4j->run($cypher, $cypherVals);
     if ($res->records())
     {
       $data = $res->getRecord();
       if ($data->hasValue('avatar'))
       {
         $fileAddr = $this->cont['settings']['upload']['dir'] .
          DIRECTORY_SEPARATOR .
          $this->cont['settings']['upload']['folder']['avatar'] .
          DIRECTORY_SEPARATOR . $data->value('avatar');
         // unlink
         unlink($fileAddr);
         // remove from db
         $cypher = 'MATCH (n) WHERE id(n)={uid} REMOVE n.avatar SET n.changed={changed};';
         $cypherVals = array('uid' =>  $uid, 'changed' => time());
         $this->cont->neo4j->run($cypher, $cypherVals);
         // return resp
         return array('err' => false, 'msg' => '');
       }else{
         return array('err' => true, 'msg' => 'No Avatar!');
       }
     }
   }
}

 ?>
