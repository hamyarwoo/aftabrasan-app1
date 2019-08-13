<?php


namespace Models\v1;


class MainModel
{

    private $cont;

    /**
     * constructor to get the DI container
     */
    function __construct($di)
    {
        $this->cont = $di;
    }

    function saveSubscription($data){
        $end_point = $data->endpoint;

        $auth = $data->keys->auth;
        $p256dh = $data->keys->p256dh;

        $id = $this->cont->db->table("subscription")->insertGetId([
            "endpoint" => $end_point,
            "auth" => $auth,
            "p256dh" => $p256dh,
            "created_at" => date("Y-m-d H:i:s")
        ]);

        var_dump($id);
    }

    public function deleteSubscription($id){
        $result = $this->cont->db->table("subscription")->where("id",$id)->delete();
        return $result;
    }

    public function getSubscriptions(){
        $get_sub = $this->cont->db->table("subscription")->select("*")->get();
        return $get_sub;
    }

}