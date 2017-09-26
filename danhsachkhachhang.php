<?php include "includes/header.php"; ?>
<?php include('includes/mysqli_connect.php'); ?>
<?php include('includes/function.php'); ?>
<?php include "includes/top-header.php"; ?>
<?php
if(empty($_SESSION)) {
    header('location:index.php');
}

?>
        <div class="row">
            <div class="col-md-3">
                <?php include "includes/sidebar.php"; ?>
            </div>

            <div class="col-md-9">
                <div class="content">
                    <!--Tìm kiếm khách hàng-->
                    <form action="tim-khach-hang.php" method="get">
                        <div class="col-sm-6 col-sm-offset-3">
                            <div id="imaginary_container">
                                <div class="input-group stylish-input-group">
                                    <input type="text" class="form-control" placeholder="Tìm khách hàng..."
                                           name="search">
                                    <span class="input-group-addon">
                                      <button type="submit" name="tim-kh"value="search">
                                        <i class="fa fa-search"></i>
                                      </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="khachhang-moi">
                        <?php
                        $display = 10;
                        if (isset($_GET['trang']) && filter_var($_GET['trang'], FILTER_VALIDATE_INT, array('min-range' => 1))) {
                            $from = ($_GET['trang'] - 1) * $display;
                        } else {
                            $from = 0;
                        }

                        $q = "SELECT *
                              FROM khachhang
                              ORDER BY id_KH DESC
                              LIMIT $from, $display";

                        $r = mysqli_query($dbc, $q);
                        confirm_query($r, $q);

                        $count = 0;
                        while ($khachhang = mysqli_fetch_array($r)) { ?>
                            <p>
                                <button class="btn btn-primary" type="button" data-toggle="collapse"
                                        data-target="#collapse-<?php echo $count ?>" aria-expanded="false"
                                        aria-controls="collapseExample" style="width: 100%; text-align: left">
                                    <?php echo $khachhang['ten_KH'] . "--". "0" . $khachhang['sdt_KH'] ?>
                                </button>
                            </p>

                            <div class="collapse" id="collapse-<?php echo $count ?>">
                                <div class="card card-block">
                                    <div class="meta">
                                        <p>Tên: <span><?php echo $khachhang['ten_KH'] ?>.</span></p>
                                        <p>Phone: <?php echo "0". $khachhang['sdt_KH'] ?>.</p>
                                        <p>Email: <?php echo $khachhang['email_KH'] ?>.</p>
                                        <p>Ngày Thêm: <?php echo $khachhang['ngay_them'] ?>.</p>
                                        <p>Loại Khách:
                                          <?php
                                            if($khachhang['loaikhach'] == 0){
                                              echo "Khách Mua";
                                            }elseif($khachhang['loaikhach'] == 1){
                                              echo "Khách Thuê";
                                            }else {
                                              echo "Chuyển Nhưỡng";
                                            }
                                            ?>.
                                          </p>
                                        <p>Thông tin thêm: <?php echo $khachhang['ttthem_KH'] ?></p>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <a href="sua_khach_hang.php?id_kh=<?php echo $khachhang['id_KH'] ?>"
                                                   class="btn btn-primary">Cập Nhật Thông Tin</a>
                                            </div>
                                            <div class="col-md-4">
                                                <a href="xoa_khach_hang.php?id_kh=<?php echo $khachhang['id_KH']; ?>&ten_kh=<?php echo $khachhang['ten_KH']; ?>"
                                                   class="btn btn-danger">Xóa Khách Hàng Này</a>
                                            </div>

                                            <div class="col-md-4">
                                                <a href="chot_khach.php?id_kh=<?php echo $khachhang['id_KH']; ?>"
                                                   class="btn btn-success">Chốt khách</a>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <?php $count++;
                        } ?>
                    </div>

                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            <?php
                            //lay tong so tin
                            $ts_kh = "SELECT id_KH FROM khachhang";
                            $trang = mysqli_query($dbc, $ts_kh);
                            confirm_query($trang, $ts_kh);

                            $ts_kh = mysqli_num_rows($trang);
                            $soTrang = ceil($ts_kh / $display);
                            for ($i = 1; $i <= $soTrang; $i++) {
                                echo "<li class='page-item'><a class='page-link' href='danhsachkhachhang.php?trang={$i}'>{$i}</a></li>";

                            }
                            ?>
                        </ul>
                    </nav>
                </div><!--/.content-admin-->
            </div>
        </div>
<?php include "includes/footer.php"; ?>
