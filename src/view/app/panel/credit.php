 <style>
        .fa-number{
            font-size: 12px;
            color: #666;
        }
        .is_lock_alert{
            display: none;
        }
    </style>
    <div class="profile-page-title">
        <div class="title">
            <a href="<?= base_url("user") ?>" class="home">
                <svg id="utouch-icon-home-icon-silhouette" viewBox="0 0 512 512" width="100%" height="100%">
                    <path d="m504 233l-78-77 0-90c0-16-13-29-29-29-16 0-30 13-30 29l0 31-57-58c-29-29-79-28-107 0l-194 194c-12 12-12 30 0 42 11 11 30 11 41 0l194-194c7-7 18-7 24 0l194 194c6 6 14 8 21 8 8 0 15-2 21-8 11-12 11-30 0-42z m-238-97c-5-5-14-5-20 0l-171 171c-2 3-4 6-4 10l0 125c0 29 24 53 53 53l84 0 0-131 96 0 0 131 84 0c30 0 53-24 53-53l0-125c0-4-1-7-4-10z"></path>
                </svg>
            </a>
            <ul class="profile-breadcrumb">
                <li>پروفایل</li>
                <li>شارژ کیف پول</li>
            </ul>

        </div>
    </div>
    <div class="card">
        <div class="card-body">






            <div class="row justify-content-md-center">
                <div class="col-md-6">
                    <div class="features-item background-white padding-20px box-shadow">
                        <form id="frm-charge-credit" action="<?=base_url("uajax/send-charge")?>" method="post">
                            <div class="form-group text-center">
                                <h4>موجودی فعلی: <span style="unicode-bidi: plaintext;" class="kif_value"></span> تومان</h4>
                            </div>
                            <div class="form-group text-center">
                                <img src="<?=base_url("assets/images/ar-wallet.jpg")?>" width="150"/>
                            </div>
<!--                            <div class="form-group">-->
<!--                                <label>مبلغ شارژ (تومان)</label>-->
<!--                                <input type="text" name="price" class="form-control" data-seprator="true" value=""  placeholder="مبلغ شارژ را وارد کنید" autocomplete="off" required />-->
<!--                                <div class="text-left fa-number" id="fa-number"></div>-->
<!--                            </div>-->
<!--                            <div class="form-group text-center">-->
<!---->
<!--                                <button class="btn btn-primary" >-->
<!--                                    <i class="fa fa-money"></i>-->
<!--                                    پرداخت-->
<!--                                </button>-->
<!--                            </div>-->
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script>
    $(document).ready(function () {
        handleAjaxRequest(site_url_api + "api/v1/reports/detail", "get", {}, function (data) {


            if (data.is_lock != 0){
                $('.is_lock_alert').show();

            }

            $('.kif_value').html(data.credit);

        }, function () {

        });
    })
</script>