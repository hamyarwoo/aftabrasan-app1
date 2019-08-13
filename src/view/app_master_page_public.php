<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>آفتاب رسان</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta name="keywords"  content="">
    <meta name="description" content="آفتاب رسان، پلتفرم نوین انبارداری و ارسال دیجیتال مرسولات، ارائه دهنده صندوق های پستی مجازی در ایران و کشورهای دیگر با نام آفتاب باکس، جهت دریافت، تجمیع و ارسال مرسولات و نامه ها به اشخاص و سازمان ها.">
    <!-- fontawesome  -->
    <link rel="stylesheet" href="<?= base_url("assets/fonts/font-awesome/css/font-awesome.min.css") ?>">
    <link rel="stylesheet" href="<?= base_url("assets/css/bootstrap.min.css") ?>">
    <link rel="stylesheet" href="<?= base_url("assets/css/app_style.css") ?>">
    <?= put_headers() ?>
    <link rel="stylesheet" href="<?= base_url("assets/css/rtl.css") ?>">
    <link rel="shortcut icon" type="image/png" href="<?= base_url("favicon.ico") ?>"/>
    <script src="<?= base_url("assets/js/jquery-3.2.1.min.js") ?>"></script>
    <script>
        const site_url = '<?= base_url() ?>';
        const site_url_api = '<?= base_api_url() ?>';
    </script>


    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-title" content="Packt PWA Note">
    <link rel="apple-touch-startup-image" href="/assets/images/icon-512x512.png">
    <link rel="apple-touch-icon" sizes="57x57" href="/assets/images/icons/icon-57x57.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/assets/images/icons/icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/assets/images/icons/icon-114x114.png">
    <link rel="apple-touch-icon" sizes="167x167" href="/assets/images/icons/apple-icon-167x167.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/assets/images/icons/icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/assets/images/icons/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/images/icons/apple-icon-180x180.png">
    <link rel="apple-touch-icon" sizes="192x192" href="/assets/images/icons/icon-192x192.png">
    <!--&zT",0o9hFho)m'#9F3([-->
    <!-- Tile icon for Win8 (144x144 + tile color) -->
    <meta name="msapplication-TileImage" content="/assets/images/icons/icon-144x144.png">
    <meta name="msapplication-TileColor" content="#3372DF">
    <meta name="msapplication-starturl" content="/">

    <!-- Theme color for mobile users -->
    <meta name="theme-color" content="#3f51b5">


    <!-- Manifest.json-->
    <link rel="manifest" href="<?=base_url("manifest.json")?>">
</head>
<body>
<div class="loading_back">
    <div class="row justify-content-center">
        <i class="fa fa-spinner fa-spin"></i>
    </div>
</div>

<div class="row header">
    <div class="container-fluid app_bar_menu">

        <div class="col-md-3 header_section col-12">
<!--            <i class="fa fa-bars collapsed_menu" onclick="toggleMenu(this,event)"></i>-->
            <h1 class="app_title">
                آفتاب رسان
            </h1>
        </div>

    </div>
</div>


<div class="main_menu">
    <div style="overflow: auto;height: 100%;">
        <div class="mm_top_img">
            <img src="<?=base_url("assets/images/profile-bg.jpg")?>" alt="">
        </div>
        <ul class="mm_lists">
            <li><a href="<?=base_url("dashboard")?>">داشبورد</a></li>
            <li><a href="<?=base_url("aftabboxes")?>">آفتاب باکس های من</a></li>
            <li><a href="<?=base_url("/parcelout")?>">مرسولات خروجی</a></li>
            <li><a href="<?=base_url("/addresses")?>">آدرس های من</a></li>
            <li><a href="<?=base_url("credit")?>">کیف پول من</a></li>
            <li><a href="<?=base_url("logout")?>">خروج</a></li>
            <li><a href="#" id="notification">فعال سازی نوتیفیکیشن</a></li>
            <li><a href="#" id="notification_send">ارسال نوتیفیکیشن</a></li>
        </ul>
    </div>
    <span class="close fa fa-close" onclick="closeMainMenu()"></span>
</div>


<?php

include $view_content; ?>

</body>

<?php
if (isset($js_vars)) {
    $js_var = json_encode($js_vars);
    ?>
    <script>
        var js_var = <?= $js_var; ?>;

    </script>
    <?PHP

}?>

<!-- jquery library  -->

<script src="<?= base_url("assets/js/popper.min.js") ?>"></script>

<script src="<?= base_url("assets/js/bootstrap.min.js") ?>"></script>

<?= put_footers() ?>

<script src="bundle.js"></script>

<script src="<?= base_url("assets/js/app-main.js") ?>"></script>

</html>
