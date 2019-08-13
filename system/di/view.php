<?php

use Slim\Views\PhpRenderer;

$container['view'] = function ($container ) {
	
    $templateVar = [
        "title" => "آفتاب رسان",
    ];
    $u_info= $container->session->get('user_info');
    if ($u_info) {
		$u_info=(object)$u_info;
        $u_info->full_name = $u_info->fname . " " . $u_info->lname;
        if (empty($u_info->avatar_url)) {
            $u_info->avatar_url = $container["settings"]["default-avatar"];
        }
        $u_info->full_name = $u_info->fname . ' ' . $u_info->lname;
		
        $templateVar["user_info"] = $u_info;
        $templateVar["user_login"] = true;
    }

    return new PhpRenderer('./src/view/', $templateVar);
};




