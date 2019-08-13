<div class="profile-page-title">
    <div class="title">
        <a href="<?= base_url("user") ?>" class="home">
            <svg id="utouch-icon-home-icon-silhouette" viewBox="0 0 512 512" width="100%" height="100%">
                <path d="m504 233l-78-77 0-90c0-16-13-29-29-29-16 0-30 13-30 29l0 31-57-58c-29-29-79-28-107 0l-194 194c-12 12-12 30 0 42 11 11 30 11 41 0l194-194c7-7 18-7 24 0l194 194c6 6 14 8 21 8 8 0 15-2 21-8 11-12 11-30 0-42z m-238-97c-5-5-14-5-20 0l-171 171c-2 3-4 6-4 10l0 125c0 29 24 53 53 53l84 0 0-131 96 0 0 131 84 0c30 0 53-24 53-53l0-125c0-4-1-7-4-10z"></path>
            </svg>
        </a>
        <ul class="profile-breadcrumb">
            <li>پروفایل</li>
            <li>آفتاب باکس های من</li>
        </ul>
    </div>
</div>
<div class="main_aftab_box">

</div>

<?PHP
if (isset($total_pages)) {
    if ($total_pages > 1) {
        ?>
        <br/>
        <ul class="pagination pagination-md">
            <li class="page-item"><a class="page-link" href="<?= base_url('user/aftabboxes') ?>" tabindex="-1">صفحه
                    اول</a></li>
            <?PHP
            $min_page = $current_page - 2;
            $max_page = $current_page + 2;
            if ($min_page <= 0) {
                $min_page = 1;
            }
            if ($max_page > $total_pages) {
                $max_page = $total_pages;
            }

            for ($i = $min_page; $i <= $max_page; $i++) {
                ?>
                <li class="page-item <?= ($i == $current_page) ? "active" : "" ?>">
                    <a class="page-link"
                       href="<?= base_url('user/aftabboxes?paged=' . $i) ?>"><?= tr_num($i, "fa") ?></a>
                </li>
                <?PHP
            }
            ?>
            <li class="page-item">
                <a class="page-link" href="<?= base_url('user/aftabboxes?paged=' . $total_pages) ?>">صفحه آخر</a>
            </li>
        </ul>
        <?PHP
    }
}
?>
<script>
    $(document).ready(function () {
        handleAjaxRequest(site_url_api + "api/v1/aftabboxes/get", "get", {}, function (data) {

            $.ajax({
                url: site_url + 'aftabboxes1',
                data: data,
                dataType: 'json',
                success: function (msg) {
                    $('.main_aftab_box').html(msg.html);
                    console.log(msg);
                }

            })

        }, function () {

        });
    })
</script>
