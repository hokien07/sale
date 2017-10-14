<div class="top-header">
        <div class="row">
            <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="left-top-header">
                    <?php
                        date_default_timezone_set('Asia/Ho_Chi_Minh');

                    ?>
                    <p class="date">Hôm Nay: <?php echo date('d-m-Y');?></p>
                </div><!--/.left-top-header-->
            </div>

            <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="right-top-header">
                    <?php
                        if(isset($_SESSION['dang_nhap'])) {
                            echo "<p class='wellcom'>Xin Chào: <a href='chitiet_nhan_vien.php?id_nv={$_SESSION['dang_nhap']['id_NV']}&ten_nv={$_SESSION['dang_nhap']['ten_NV']}'>{$_SESSION['dang_nhap']['ten_NV']}</a> | <a href='includes/logout.php'>Đăng Xuất</a></p>";
                        }else {
                            echo "<p class='wellcom'>Bạn Chưa Đăng Nhập</p>";
                        }

                    ?>
                </div><!--/.left-top-header-->
            </div>
        </div>
</div><!--/.top-header-->
