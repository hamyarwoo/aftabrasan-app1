<?php

namespace Models\v1;

class Auth
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
   * Check Token in DB
   */
   public function checkToken($token)
   {
     // check token exist in db
     $chk = $this->cont->db->table('tokens')->where('token', $token)->get();
     if (count($chk) == 1)
     {
       $row = $chk->first();
       return $row;
     }
     return false;
   }

  /**
   * Update Token Stats
   */
   public function updateToken($row)
   {
     $this->cont->db->table('tokens')->where('token', $row->token)->update([
       'last_used' => time() ,
       'transactions' => $row->transactions+1 ,
     ]);
   }

   /**
    * Delete Token
    */
    public function deleteToken($token)
    {
      $this->cont->db->table('tokens')->where('token', $token)->delete();
    }

   /**
    * Delete Token By Id
    */
    public function deleteTokenById($id)
    {
      $this->cont->db->table('tokens')->where('id', $id)->delete();
    }
}

?>
