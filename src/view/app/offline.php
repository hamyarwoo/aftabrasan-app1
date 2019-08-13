<div class="app_main">
    <div class="row justify-content-center">
        <div class="col-md6">
            <div class="alert alert-danger">شما به اینترنت متصل نیستید برای استفاده از خدمات اپلیکیشن لازم است اینترنت خود را فعال کنید</div>
        </div>
        <br>
        <div class="col-md-6">
        <div class="btn btn-danger" onclick="location.reload();">تلاش دوباره</div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('.loading_back').fadeOut(200);
    })
</script>