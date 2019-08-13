<?php

$app->get('/dashboard', function ($request, $response, $args) {

    $data = array();



    $data["view_content"] = "app/dashboard.php";
    $data["page_title"] = "داشبورد";

    $this->view->render($response, 'app_master_page.php', $data);

});

$app->get('/addresses', function ($request, $response, $args) {

    $data = array();



    $data["view_content"] = "app/panel/addresses.php";
    $data["page_title"] = "داشبورد";
    add_js(base_url("app/assets/js/form-base.js"));
    $this->view->render($response, 'app_master_page.php', $data);

});

$app->group('/aftabboxes', function () use ($app) {


    $app->get('', function ($request, $response, $args) {

        $data = array();

        $data["view_content"] = "app/panel/aftab_boxes.php";
        $data["page_title"] = "داشبورد";
        add_js(base_url("app/assets/js/form-base.js"));
        $this->view->render($response, 'app_master_page.php', $data);

    });

    $app->get('/detail/{id}', function ($request, $response, $args) {

        $data = array();
        $data['id'] = $args['id'];
        $data["view_content"] = "app/panel/aftab_boxes_detail.php";
        $data["page_title"] = "جزییات مرسولات و آفتاب باکس";
        add_js(base_url("app/assets/js/form-base.js"));
        $this->view->render($response, 'app_master_page.php', $data);

    });

});


$app->get('/aftabboxes1', function ($request, $response, $args) {

    $data = $request->getParams();
    add_js(base_url("app/assets/js/form-base.js"));
    $data["title"] = "سفارش آفتاب باکس جدید";
    $data["html"] = $this->view->fetch('app/panel/aftab_boxes1.php', $data);

    return $response->withStatus(200)->withJson($data);

});

$app->get('/credit', function ($request, $response, $args) {

    $data = array();

    $data["view_content"] = "app/panel/credit.php";
    $data["page_title"] = "کیف پول من";
    add_js(base_url("app/assets/js/form-base.js"));
    $this->view->render($response, 'app_master_page.php', $data);

});

$app->get('/parcelout', function ($request, $response, $args) {

    $data = array();
    $data["view_content"] = "app/panel/parcel-out.php";
    $data["page_title"] = "مرسولات خروجی";
    add_js(base_url("app/assets/js/form-base.js"));
    $this->view->render($response, 'app_master_page.php', $data);

});

$app->post('/sub/save', function ($request, $response, $args) {

    $params = $request->getParams();
    $data = base64_decode($params['data']);
    $data = json_decode($data);
    $model_obj = new \Models\v1\MainModel($this);
    $model_obj->saveSubscription($data);
});

$app->get('/sub/get', function ($request, $response, $args) {


    $model_obj = new \Models\v1\MainModel($this);
    $data = $model_obj->getSubscriptions();
    if (isset($data)){
        return $response->withStatus(200)->withJson($data);
    }else{
        return $response->withStatus(401);
    }
});


$app->post('/sub/delete', function ($request, $response, $args) {

    $params = $request->getParams();
    
    $model_obj = new \Models\v1\MainModel($this);
    $data = $model_obj->deleteSubscription($params['id']);
    if (isset($data)){
        return $response->withStatus(200)->withJson($data);
    }else{
        return $response->withStatus(401);
    }
});