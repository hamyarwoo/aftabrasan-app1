<style>
    .card-header{
        padding: 0 10px!important;
        color: #fff !important;
    }
    .card-header button{
        padding: 0 !important;
        color: #fff !important;
    }
</style>
<div class="app_main">

    <div class="accordion" id="accordionExample">

        <div class="card">
            <div class="card-header" id="headingTwo">
                <h2 class="mb-0">
                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                       نصب آسان آفتاب رسان
                    </button>
                </h2>
            </div>
            <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo" data-parent="#accordionExample">
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-md-4 col-12">
                            <div class="app_login_box">

                                <div class="apb_title">
                                    <img src="<?=base_url("assets/images/ar-logo-bottom.png")?>" alt="" style="text-align: center;margin: 10px 0" >
                                </div>
                                <div class="apb_body">
                                    لطفا جهت استفاده از اپلیکیشن آفتاب رسان برای روی دکمه زیر کلیک کنید
                                    <br>
                                    <br>
                                    <div class="row justify-content-center">
                                        <span class="btn btn-outline-success install_pwa">نصب اپلیکیشن</span>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header" id="headingThree">
                <h2 class="mb-0">
                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        نصب دستی آفتاب رسان
                    </button>
                </h2>
            </div>
            <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                <div class="card-body">
                    برای نصب دستی ابتدا  . . .
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('.loading_back').fadeOut(200);

        // Opera 8.0+
        var isOpera = (!!window.opr && !!opr.addons) || !!window.opera || navigator.userAgent.indexOf(' OPR/') >= 0;

// Firefox 1.0+
        var isFirefox = typeof InstallTrigger !== 'undefined';

// Safari 3.0+ "[object HTMLElementConstructor]"
        var isSafari = /constructor/i.test(window.HTMLElement) || (function (p) { return p.toString() === "[object SafariRemoteNotification]"; })(!window['safari'] || (typeof safari !== 'undefined' && safari.pushNotification));

// Internet Explorer 6-11
        var isIE = /*@cc_on!@*/false || !!document.documentMode;

// Edge 20+
        var isEdge = !isIE && !!window.StyleMedia;

// Chrome 1 - 71
        var isChrome = !!window.chrome;

// Blink engine detection
        var isBlink = (isChrome || isOpera) && !!window.CSS;


        if (isSafari){
            $('#collapseThree').collapse('show');
            $('#collapseTwo').collapse('hide');
        }
    })
</script>