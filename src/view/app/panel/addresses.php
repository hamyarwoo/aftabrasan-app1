<div class="app_main">

<div class="main_addresses_parent">



</div>


<div class="modal fade bd-example-modal-sm" id="address-modal" tabindex="-1" role="dialog" aria-labelledby="address-modalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="address-modalLabel">
                    <img src="<?= base_url("assets/img/ar-logo-top.png") ?>"/>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body padding-20px ">
                <div class="form-group modal-body-headline ">

                    <img src="<?= base_url("assets/img/receive-address.png") ?>" width="50" />&nbsp;
                    <span class="js-address-title">
                        افزودن آدرس جدید
                    </span>
                    <span style="font-size: 12px;font-weight: normal;">از این آدرس در زمان تحویل نامه ها و مرسولات به شما استفاده خواهد شد</span>
                </div>
                <form id="address-form" >
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>عنوان آدرس</label>
                                <input type="text" name="name" class="form-control" placeholder="عنوان آدرس" required autocomplete="off" />
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>نام و نام خانوادگی تحویل گیرنده</label>
                                <input type="text" name="receiver_name" class="form-control" placeholder="نام تحویل گیرنده را وارد کنید" required  autocomplete="off"/>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>کشور</label>
                                <select class="form-control js-ui-select js-select-country" name="country"  required >
                                    <option value="">انتخاب کنید</option>
                                    <?php
                                    if (!empty($country_list)) {
                                        foreach ($country_list as $key=>$name) {
                                            ?>
                                            <option value="<?= $key ?>"><?= $name ?></option>
                                            <?php
                                        }
                                    }
                                    ?>

                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>استان</label>
                                <select class="form-control js-ui-select js-select-province" name="province"  required >
                                    <option value="">انتخاب کنید</option>

                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>شهر</label>
                                <select class="form-control js-ui-select js-select-city"  name="city" required >
                                    <option value="">انتخاب کنید</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>شماره موبایل</label>
                                <input type="text" name="mobile" class="form-control ltr-input" placeholder="09xxxxxxxx" required autocomplete="off" />
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>شماره تلفن</label>
                                <input type="text" name="tel" class="form-control ltr-input" placeholder="07xxxxxxxx" required  autocomplete="off"/>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>کد پستی</label>
                                <input type="text" maxlength="10" name="post_code" class="form-control" placeholder="کد پستی را بدون خط تیره وارد کنید"  required autocomplete="off" />
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>پیش فرض سیستم</label>
                                <select class="form-control" name="default" required >
                                    <option value="1">بلی</option>
                                    <option value="0">خیر</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>آدرس پستی</label>
                                <textarea class="form-control" name="address" name="address" placeholder="آدرس تحویل گیرنده" required></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <button class="main-btn" type="submit">
                                ثبت آدرس
                            </button>
                        </div>
                        <div class="col-md-12 margin-top-5px" id="result-ajax">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
<script>
    $(document).ready(function () {
        handleAjaxRequest(site_url_api + "api/v1/addresses/get", "get", {}, function (data) {
            console.log(data);


            $.each(data.addresses,function (index,val) {
                var text = '<div class="col-md-6 js-user-address-container"><div class="profile-address-card "><div class="profile-address-card__desc"><h4 class="address-full_name">'+val.name+'</h4><p class="checkout-address__text user-address">کشور<span class="address-state"> '+val.country_name+'</span> ،استان<span class="address-state"> '+val.province_name+'</span>،شهر<span class="address-city"> '+val.city_name+'</span> ، <span class="address-address-part"> آدرس '+val.address+'</span></p><p>نام دریافت کننده: '+val.receiver_name+'</p></div><div class="profile-address-card__data"><ul class="profile-address-card__methods"><li class="profile-address-card__method"><i class="fa fa-envelope-o icon"></i>کد پستی : <span class="address-post_code">'+val.post_code+'</span></li><li class="profile-address-card__method"><i class="fa fa-phone-square icon"></i>موبایل : <span class="address-mobile_phone">'+val.mobile+'</span></li> <li class="profile-address-card__method"><i class="fa fa-phone icon"></i>تلفن : <span class="address-mobile_phone">'+val.tel+'</span></li></ul></div></div></div>';
                $('.main_addresses_parent').append(text);
            });

        }, function () {

        });
    })
</script>

