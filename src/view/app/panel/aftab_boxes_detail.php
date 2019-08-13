<style>
    .parcel-box {
        background: #fff;
        background-color: rgb(255, 255, 255);
        box-shadow: rgba(0, 0, 0, .1) 0 0 10px 0px;
        transition: box-shadow .2s linear;
        margin-bottom: 20px;
        background-color: #fff;
        border: 1px solid #dcdcdc;
        -webkit-border: 1px #dcdcdc solid;
        -moz-border: 1px #dcdcdc solid;
        -ms-border: 1px #dcdcdc solid;
        border-radius: 7px;
        padding: .25rem .55rem;
        text-align: center;
        cursor: pointer;
    }
    .parcel-box_status-container {

    position: absolute;
        top: 40px;
        left: -12px;
    }
    .parcel-box_status-text.success {
        box-shadow: 0 2px 10px rgba(139, 195, 74, 0.33);
        background-color: #8BC34A;
        border-radius: 0 25px 25px;
        max-width: 95px;
        width: 77px;
        color: #fff;
    }
    .parcel-box_status-text::before {
        content: " ";
        top: -5px;
        position: absolute;
        left: 1px;
        width: 0;
        height: 0;
        border-bottom: 5px solid #8bc34a;
        border-left: 10px solid transparent;
    }
    .parcel-box_status-text.success::before {
        border-bottom: 5px solid #8bc34a;
    }
    .parcel-box_image-holder {
        margin: 20px auto 0;
        height: auto;
        width: 150px;
        border: 1px solid #ddd;
        -webkit-border: 1px #dcdcdc solid;
        -moz-border: 1px #dcdcdc solid;
        -ms-border: 1px #dcdcdc solid;
        border-radius: 7px;
        padding: 5px;
    }
    .parcel-box_image-holder img {
        border-radius: 7px;
        height: auto;
        width: 100%;
        padding: .25rem;
        cursor: pointer;
    }
    .parcel-box_content {
        margin-top: 20px;
    }
    .parcel-box_content_title {
        color: #3c3c3c;
        margin: 0;
        font-size: 1rem;
        display: inline-block;
        line-height: 1.42857143;
    }
    .parcel-box_content_time {
        font-size: .8rem;
        color: #a0a0a0;
    }
    .parcel-box_content_items {
        background: #fdfdfd;
        border-radius: 5px;
        padding: 8px 10px;
        position: relative;
        border: 1px solid #ddd;
        text-align: right;
        font-size: 13px;
    }
    .parcel-box_content_items p {
        margin-bottom: 5px;
        border-bottom: 1px solid #ddd;
        padding-bottom: 10px;
    }
    .parcel-box_content_items .fa {
        font-size: 20px;
        vertical-align: middle;
        color: #949393;
        padding-left: 5px;
    }
    .parcel-box_action {
        margin-top: 10px;
        margin-bottom: 10px;
        text-align: center;

    }
.aftab_box_inputs_parent{
    float: right;
    width: 100%;
}
    .parcel-box{
        position: relative;
    }
</style>
<div class="app_main">
    <div class="col-md-12">
        <?PHP
        $id = $data['id'];
        ?>
        <div class="aftab_box_detail_parent">
            <div class="abd_header">
                جزییات آفتاب باکس
            </div>
            <div class="abd_body">
                <ul class="detail_ul">
                    <li>
                        اطلاعات عمومی
                    </li>
                    <li>
                        <span class="dbd_label">تاریخ خرید</span> :
                        <span class="abd_value" id="buy_date"></span>
                    </li>
                    <li>
                        <span class="dbd_label">تاریخ انقضا</span> :
                        <span class="abd_value" id="expire_date"></span>
                    </li>
                    <li>
                        <span class="dbd_label">وضعیت</span> :
                        <span class="abd_value" id="status"></span>
                    </li>
                </ul>
                <ul class="detail_ul">
                    <li>
                        اطلاعات آدرس
                    </li>
                    <li>
                        <span class="dbd_label">کشور</span> :
                        <span class="abd_value" id="country"></span>
                    </li>
                    <li>
                        <span class="dbd_label">استان</span> :
                        <span class="abd_value" id="province"></span>
                    </li>
                    <li>
                        <span class="dbd_label">شهر</span> :
                        <span class="abd_value" id="city"></span>
                    </li>
                    <li>
                        <span class="dbd_label">آدرس</span> :
                        <span class="abd_value" id="address"></span>
                    </li>
                    <li>
                        <span class="dbd_label">کدپستی</span> :
                        <span class="abd_value" id="postal_code"></span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="aftab_box_inputs_parent">

        </div>

    </div>
</div>
<script>
    $(document).ready(function () {
        $('.abd_header').on("click", function () {
            $(this).parents(".aftab_box_detail_parent").find(".abd_body").slideToggle(300);
        });
        handleAjaxRequest(site_url_api + "api/v1/aftabboxes/detail/<?=$id?>", "get", {}, function (data) {

            var aftabboxDetail = data.aftabboxes.box_info[0];
            var aftabboxInputs = data.aftabboxes.box_inputs;
            console.log(aftabboxDetail.buy_time_display);
            $('#buy_date').html(aftabboxDetail.buy_time_display);
            $('#expire_date').html(aftabboxDetail.expire_time_display);
            $('#status').html(aftabboxDetail.status_display);
            $('#country').html(aftabboxDetail.country);
            $('#province').html(aftabboxDetail.province);
            $('#city').html(aftabboxDetail.city);
            $('#address').html(aftabboxDetail.address);
            $('#postal_code').html(aftabboxDetail.post_code);
            $('.loading_back').fadeOut(200);
            $.each(aftabboxInputs,function (index,val) {
                var text = '<div class="parcel-box"><div class="parcel-box_status-container"></div><div class="parcel-box_image-holder"><img src="http://192.168.203.176/ar-upload/uploads/2019-07/12537253325d2e981ba470f.jpg"></div><div class="parcel-box_content"><h3 class="parcel-box_content_title">تاریخ دریافت</h3><p class="parcel-box_content_time">'+val.receive_time_display+'</p><div class="parcel-box_content_items"><p><i class="fa fa-object-group"></i> ابعاد : '+val.width+'                                    *'+val.height+'*'+val.length+'</p><p><i class="fa fa-balance-scale"></i> وزن : '+val.weight+' گرم</p><p><i class="fa fa-tty"></i> کد رهگیری : '+val.tracking_code+'</p><p><i class="fa fa-money"></i> انبارداری : '+val.price+' تومان روزانه</p></div></div></div>';
                $('.aftab_box_inputs_parent').append(text);
            })
        }, function () {

        });
    })
</script>