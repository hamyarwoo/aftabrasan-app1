<div class="app_main">
<div class="row justify-content-center">
    <div class="col-md-4 col-12">
        <div class="app_login_box">

            <div class="apb_title">
                <img src="<?=base_url("assets/images/ar-logo-bottom.png")?>" alt="" style="text-align: center;margin: 10px 0" >
            </div>
            <div class="apb_body">
                <div class="ajax-alert"><span class="msg"></span><i class="fa fa-window-close-o" onclick="closeAlertMSG(this)"></i></div>
                    <form id="frm-login" action="<?=base_api_url("api/v1/auth")?>" novalidate="novalidate" class="app_form" method="post">
                        <div class="form-group">
                            <label>نام کاربری (موبایل)</label>
                            <input type="text" class="form-control" name="mobile" data-number="" autocomplete="off" placeholder="091712345678" required>
                        </div>
                        <div class="form-group">
                            <label>رمز عبور</label>
                            <input type="password" class="form-control" name="password" autocomplete="off" required>
                        </div>
                        <button type="submit" class="btn btn-info btn-block">
                            <i class="fa fa-sign-in submit_icon"></i>


                            ورود اعضاء
                        </button>
                    </form>
            </div>
        </div>
    </div>
</div>
</div>

<script>
    $(document).ready(function () {
        if (localStorage.getItem("token")){
            document.location.href = site_url + 'dashboard';
            // alert("sdsd");
        } else{
            $('.loading_back').fadeOut(200);
        }
    });
</script>