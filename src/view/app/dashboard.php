<div class="app_main">
    <?PHP
    $user_info = isset($data['user_info']) ? $data['user_info'] : [];
    //$user_detail = getUserDetail();
    ?>
    <div class="dash_item_parent col-md-4">
        <div class="card card-stats">
            <div class="card-header" data-background-color="red">
                <i class="fa fa-cart-plus"></i>
                <p class="category">تعداد آفتاب باکس شما</p>
            </div>

            <div class="card-content">

                <h3 class="title" id="aftab_box_number"></h3>
            </div>
        </div>
    </div>
    <div class="dash_item_parent col-md-4">
        <div class="card card-stats">
            <div class="card-header" data-background-color="green">
                <i class="fa fa-address-book"></i>
                <p class="category">آدرس های شما</p>
            </div>
            <div class="card-content">

                <h3 class="title" id="addresses"></h3>
            </div>
        </div>
    </div>
    <div class="dash_item_parent col-md-4">
        <div class="card card-stats">
            <div class="card-header" data-background-color="orange">
                <i class="fa fa-money"></i>
                <p class="category" >کیف پول شما</p>
            </div>
            <div class="card-content">

                <h3 class="title"><span
                            style="text-align: left;direction: ltr;display: inline-block" id="credit"><?= isset($user_info->credit) ? fa_number_format($user_info->credit) : "" ?></span>
                    تومان </h3>
            </div>
        </div>
    </div>
    <div class="dash_item_parent col-md-4">
        <div class="card card-stats">
            <div class="card-header" data-background-color="green">
                <i class="fa fa-ticket"></i>
                <p class="category" >تیکت های باز</p>
            </div>
            <div class="card-content">

                <h3 class="title" id="tickets"></h3>
            </div>
        </div>
    </div>
    <div class="dash_item_parent col-md-4">
        <div class="card card-stats">
            <div class="card-header" data-background-color="orange">
                <i class="fa fa-dropbox"></i>
                <p class="category" >تعداد کالای شما در انبار آفتاب رسان</p>
            </div>
            <div class="card-content">

                <h3 class="title" id="parcels_in"></h3>
            </div>
        </div>
    </div>
    <div class="dash_item_parent col-md-4">
        <div class="card card-stats">
            <div class="card-header" data-background-color="red">
                <i class="fa fa-calendar"></i>
                <p class="category" >آخرین ورود شما</p>
            </div>
            <div class="card-content">

                <h3 class="title"
                    style="font-size: 11pt;font-weight: bold" id="last_login"></h3>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        handleAjaxRequest(site_url_api + "api/v1/reports/detail", "get", {}, function (data) {

            $('#aftab_box_number').html(data.total_order);
            $('#addresses').html(data.total_address);
            $('#credit').html(data.credit);
            $('#tickets').html(data.total_tickets);
            $('#parcels_in').html(data.total_order);
            $('#last_login').html(data.last_login_persian_date);

        }, function () {

        });
    })
</script>
