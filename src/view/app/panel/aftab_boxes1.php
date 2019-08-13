<?PHP
$orders = isset($data['aftabboxes']) ? $data['aftabboxes'] : "";
$orders = is_array($orders) ? $data['aftabboxes'] : [];
$current_page = !empty($data['current_page'])? $data['current_page']:1;
$total_pages = !empty($data['total_pages'])? $data['total_pages']:1;
?>

    <div class="main_aftab_box">
        <?PHP
        $status_desc = [
            "cart" => "سبد خرید",
            "owner" => "خریداری شده",
        ];
        if (sizeof($orders) > 0) {
            if($current_page==1){
                ?>
<!--                <div class="col-md-6">-->
<!--                    <div class="profile-address-container">-->
<!--                        <a href="--><?//=base_url("order")?><!--" class="profile-address-add js-add-address-btn">-->
<!--                            <img src="--><?//= base_url('assets/images/afbox-new.png') ?><!--" width="90">-->
<!--                            <span><i class="fa fa-plus"></i> افزودن آفتاب باکس</span>-->
<!--                        </a>-->
<!--                    </div>-->
<!--                </div>-->
                <?php
            }
            foreach ($orders as $key => $row_order) {
                $buy_time = $row_order['buy_time'];
                $auto_renew = $row_order['auto_renew'];
                $expire_time = $row_order['expire_time'];
                $status = $row_order['status'];
                $code = addArValidSeg($row_order['code']);
                $address = $row_order['address'];
                $price = $row_order['price'];
                $expire_days = $row_order['expire_days'];
                $pricing_classes_name = $row_order['pricing_classes_name'];
                $in_count = $row_order['in_count'];
                $days_to_expier = floor(($expire_time - time()) / 86400);
                $is_expier = ($expire_time < time()) ? true : false;
                $buyer_id = $row_order['my_buyer_id'];
                $country = $row_order['country'];
                $province = $row_order['province'];
                $city = $row_order['city'];
                $payment_id = $row_order['payment_id'];
                ?>
                <div class="col-md-6">
                    <div class="aftab-box">
                        <div class="content">
                            <div class="status">
                                <?php if ($is_expier) { ?>
                                    <span class="badge badge-danger p-2">منقضی شده</span>
                                <?php } else { ?>
                                    <span class="badge <?=($status=="owner")? "badge-success":"badge-warning"?> p-2"><?= $status_desc[$status] ?></span>
                                <?php } ?>
                            </div>
                            <h4 class="code"><?= $code ?></h4>
                            <div class="address-content">
                                <span class="country"><?= $country ?></span>
                                <?= $province ?> - <?= $city ?>
                                <p class="address"><?= $address ?></p>
                            </div>
                            <span style="width:41%;display: block;;border-top:1px solid #e5ebfa;"></span>
                            <div class="data">
                                <?php if (!$is_expier) { ?>
                                    <p><i class=""></i><?= tr_num($days_to_expier, "fa") ?> روز تا زمان انقضاء</p>
                                <?php } else { ?>
                                    <p>منقضی شده در <?= jdate("Y/m/d", $expire_time, "fa") ?></p>
                                <?php } ?>
                                <p>مرسولات : <?= tr_num($in_count, "fa") ?></p>
                            </div>
                            <div class="active">
                                <a href="<?= base_url("aftabboxes/detail/" . $buyer_id) ?>" class="btn btn-info"><i class="fa fa-cog"></i> مدیریت</a>
                                <?php if ($status == "cart") { ?>
<!--                                    <a href="--><?//= base_url("user/payment/$payment_id") ?><!--" class="btn btn-primary"><i class="fa fa-money"></i> پرداخت</a>-->
                                <?php } else { ?>
<!--                                    <a href="--><?//= base_url("aftabbox/tarefe/$buyer_id?type=extend") ?><!--" class="btn btn-warning"><i class="fa fa-refresh"></i> تمدید</a>-->
                                <?php } ?>
                            </div>

                        </div>
                    </div>
                </div>
                <?PHP
            }
        } else {
            ?>
            <div class="col-md-12">
                <div class="alert alert-info text-center" style="float: right;width: 100%;">
                    <h3>شما آفتاب باکسی ثبت نکرده اید</h3>
                    برای شروع کار با آفتاب رسان ابتدا باید آفتاب باکس خود را خریداری کنید . برای خرید بر روی لینک زیر کلیک کنید .
                    <br>
                    <a href="<?= base_url('order') ?>" class="btn btn-sm btn-primary margin-top-20px margin-bottom-10px">
                        <i class="fa fa-cart-plus"></i>
                        سفارش آفتاب باکس
                    </a>
                </div>
                <div class="card">
                    <div class="card-body" style="text-align:center !important">
                        <img src="<?=base_url("assets/images/no-aftab-box.jpg")?>" style="width:70%"/>
                    </div>
                </div>
            </div>
            <?PHP
        }
        ?>
    </div>

<?PHP

if ($total_pages > 1) {
    ?>
    <br/>
    <ul class="pagination pagination-md">
        <li class="page-item"><a class="page-link" href="<?= base_url('user/aftabboxes') ?>" tabindex="-1">صفحه اول</a></li>
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
                <a class="page-link" href="<?= base_url('user/aftabboxes?paged=' . $i) ?>"><?= tr_num($i,"fa") ?></a>
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
?>