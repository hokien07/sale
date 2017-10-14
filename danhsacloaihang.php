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

                    <!--Tìm kiếm loại hàng-->
                    <form action="tim-hang.php" method="get">
                        <div class="col-sm-6 col-sm-offset-3">
                            <div id="imaginary_container">
                                <div class="input-group stylish-input-group">
                                    <input type="text" class="form-control" placeholder="Tìm loại hàng..."
                                           name="search">
                                    <span class="input-group-addon"><button type="submit" name="tim-hang"
                                                                            value="search"><i class="fa fa-search"></i></button></span>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="khachhang-moi">
                        <h2 style="text-transform: uppercase; text-align: center; padding-top: 20px; font-weight: bold; padding-bottom: 20px">
                            Danh Sách Loại Hàng</h2>

                                <?php

                                $display = 10;

                                if (isset($_GET['trang']) && filter_var($_GET['trang'], FILTER_VALIDATE_INT, array('min-range' => 1))) {
                                    $from = ($_GET['trang'] - 1) * $display;
                                } else {
                                    $from = 0;
                                }

                                $q = "SELECT * FROM Hang LIMIT $from, $display";
                                $r = mysqli_query($dbc, $q);
                                confirm_query($r, $q);

                        $count = 0;
                        while ($hang = mysqli_fetch_array($r)) {?>
                        <p>
                            <button class="btn btn-primary" type="button" data-toggle="collapse"
                                    data-target="#collapse-<?php echo $count ?>" aria-expanded="false" aria-controls="collapseExample" style="width: 100%; text-align: left">
                                <?php echo $hang['ma_hang'] . "--". $hang['ten_hang'] ?>
                            </button>
                        </p>

                        <div class="collapse" id="collapse-<?php echo $count ?>">
                            <div class="card card-block">
                                <div class="meta">
                                    <p><span><?php echo $hang['ten_hang']?>.</span></p>
                                    <p>Mã Hàng: <?php echo $hang['ma_hang']?>.</p>
                                    <p>Diện Tích: <?php echo $hang['dtich_hang']?>.</p>
                                    <p>Số Lượng: <?php echo $hang['sluong_hang']?></p>
                                    <p>
                                        <a href="sua_hang.php?id_hang=<?php echo $hang['id_hang'] ?>"
                                           class="btn btn-success">Cập Nhật Thông Tin</a>
                                        <a href="xoa_hang.php?id_nv=<?php echo $hang['id_hang']; ?>&ten_hang=<?php echo $hang['ten_hang']; ?>"
                                           class="btn btn-danger">Xóa Loại Hàng Này</a>
                                    </p>
                                </div>

                            </div>
                        </div>
                        <?php $count++; } ?>
                        <nav aria-label="Page navigation example">
                            <ul class="pagination">
                                <?php
                                //lay tong so tin
                                $ts_hang = "SELECT id_hang FROM Hang";
                                $trang = mysqli_query($dbc, $ts_hang);
                                confirm_query($trang, $ts_hang);

                                $ts_hang = mysqli_num_rows($trang);
                                $soTrang = ceil($ts_hang / $display);
                                for ($i = 1; $i <= $soTrang; $i++) {
                                    echo "<li class='page-item'><a class='page-link' href='danhsacloaihang.php?trang={$i}'>{$i}</a></li>";

                                }
                                ?>
                            </ul>
                        </nav>
                    </div>
                </div><!--/.content-admin-->
            </div>
        </div>

<?php include "includes/footer.php"; ?>