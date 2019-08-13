<?php

$app->get('/', function ($request, $response, $args) {


    $data["view_content"] = "app/index.php";
    $data["title"] = "ورود اعضاء";
//    add_js(base_url("assets/js/form-base.js"));
    $this->view->render($response, 'app_master_page_public.php', $data);

});

$app->get('/login', function ($request, $response, $args) {

    $data = array();
    $data["view_content"] = "app/login.php";
    $data["page_title"] = "ورود اعضاء";
    add_js(base_url("assets/js/form-base.js"));
    if (isLoggedIn()){
        return $response->withStatus(200)->withHeader("location", base_url("dashboard"));
    }

    $this->view->render($response, 'app_master_page_public.php', $data);

});

$app->post('/token', function ($request, $response, $args) {

    $params = $request->getParams();
    $this->session->set('token', $params['token']);
    $this->session->set('IP', $_SERVER['REMOTE_ADDR']);
    $this->session->set('UA', $_SERVER['HTTP_USER_AGENT']);
    $this->session->set('user_id', $params['user_id']);
    $this->session->set('token', $params['token']);
    if ($this->session->get('token')){
    return $response->withStatus(200)->withJson(1);
    }else{
        return $response->withStatus(401);
    }
});

$app->get('/offline', function ($request, $response, $args) {

    $data = array();
    $data["view_content"] = "app/offline.php";
    $data["page_title"] = "ورود اعضاء";
    add_js(base_url("app/assets/js/form-base.js"));

    $this->view->render($response, 'app_master_page.php', $data);

});


$app->get('/logout', function ($request, $response, $args) {
    $data["view_content"] = "app/panel/logout.php";
    $this->view->render($response, 'app_master_page.php', $data);
});