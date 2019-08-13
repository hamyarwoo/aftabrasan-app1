
<style>
    .card{
        margin-bottom:10px;
    }
    .card-header{
        background:#fff;
        position:relative;
       
    }
</style>
<div class="profile-page-title">
    <div class="title">
        <a href="<?= base_url("user") ?>" class="home">

        </a>
        <ul class="profile-breadcrumb">
            <li>پروفایل</li>
            <li>گزارشات خروج کالا</li>
        </ul>

    </div>
</div>
<div class="card">

</div>
<div class="parent_parcels_out_list">

</div>
<script>
    $(document).ready(function () {

        searchForParcelOut();
    });

    function searchForParcelOut() {
        var tracking_code = $('.tracking_code_inp').val();
        handleAjaxRequest(site_url_api + "api/v1/parcels/out/get", "get", {search_type:'tracking_code',tracking_code:tracking_code}, function (data) {
console.log(data);
var arrayExport = data;



$.each(data.export,function (index,val) {
    var text = '<div class="col-md-12"><div id="accordion"><div class="card margin-bottom20px"><div class="card-header " id="heading1"><ul class="tickets-title"><li>#'+val.tracking_code+'</li><li>'+val.ctime_display+' </li><li><label class="badge badge-info p-2">شامل '+val.number_letter+'مرسوله</label></li><li><label class="label-badge">'+val.status_display+' </label></li></ul></div><div id="collapse'+index+'" class="collapse" aria-labelledby="heading1" data-parent="#accordion"><div class="card-body"><ul class="rectangle-list"><li>روش حمل و نقل : پست ایران</li><li>هزینه ارسال : ۱۰,۵۰۰تومان</li><li>هزینه بسته بندی : ۲,۲۵۰,۰۰۰تومان</li><li>کل مبلغ قابل پرداخت: ۲,۲۶۰,۵۰۰تومان</li></ul></div><br></div></div></div></div>';

    $('.parent_parcels_out_list').append(text);
});

console.log(arrayExport);
            $('.loading_back').fadeOut(200);

        }, function () {

        });
    }
</script>
