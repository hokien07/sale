<?php include "includes/header.php"; ?>
<?php include('includes/mysqli_connect.php'); ?>
<?php include('includes/function.php'); ?>
<?php include "includes/top-header.php"; ?>
<?php
if (empty($_SESSION)) {
    header('location:index.php');
}

?>
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <?php include "includes/sidebar.php"; ?>
        </div>

        <div class="col-md-8">
            <div class="content">

                <div class="khachhang-moi">
                    <h2 style="text-transform: uppercase; text-align: center; padding-top: 20px; font-weight: bold; padding-bottom: 20px">
                        Tiến Độ</h2>

                    <!--Loc ngày và loại khách hàng-->
                    <form method="post">
                        <div class="row">
                            <div class="col-md-4">

                                <select name="loai-kh" id="loai-kh"
                                        style="width: 100%; height: 40px; background-color: #1e7e34; color: #fff; ">
                                    <option value="0">Chọn Loại Khách</option>
                                    <?php
                                    $lkh = "SELECT * FROM loaikhachhang";
                                    $r_lkh = mysqli_query($dbc, $lkh);
                                    confirm_query($r_lkh, $lkh);

                                    while ($loaikh = mysqli_fetch_array($r_lkh)) {
                                        echo "<option value='{$loaikh['idLoaikhachhang']}'";
                                        if (isset($_POST['loai-kh']) && $_POST['loai-kh'] == $loaikh['idLoaikhachhang'])
                                            echo "selected = 'selected'";
                                        echo ">{$loaikh['tenLoaikhachhang']}</option>";
                                    }
                                    ?>

                                    ?>
                                </select>
                            </div>
                            <div class="col-md-5">
                                <select name="thang" id="thang"
                                        style="width: 100%; height: 40px; background-color: #1e7e34; color: #fff; ">
                                    <option value="0">Chọn Tháng</option>
                                    <?php

                                    $thang = 1;
                                    while ($thang <= 12) {
                                        echo "<option value='{$thang}'";
                                        if (isset($_POST['thang']) && $_POST['thang'] == $thang)
                                            echo "selected = 'selected'";
                                        echo ">Tháng {$thang}</option>";
                                        $thang++;
                                    }
                                    ?>

                                    ?>
                                </select>

                            </div>


                            <div class="col-md-3">
                                <input type="submit" name="submit" id="loai-kh" value="Chọn"
                                       style="width: 100%; height: 40px; background-color: #1e7e34; color: #fff; margin-left: -15px; margin-bottom: 20px;">
                            </div>
                    </form>



                    <?php
                    $display = 20;
                    $id_nv = $_SESSION['dang_nhap']['id_NV'];

                    if (isset($_GET['trang']) && filter_var($_GET['trang'], FILTER_VALIDATE_INT, array('min-range' => 1))) {
                        $from = ($_GET['trang'] - 1) * $display;
                    } else {
                        $from = 0;
                    }

                    if (isset($_POST['submit'], $_POST['thang'])) {

                        //so sanh voi loai khach hang
                        $idLoaikhachhang = $_POST['loai-kh'];
                        $thang = $_POST['thang'];
                        $thang < 10 ? $thang = "0" . $thang : $thang = $thang;

                        $q = "SELECT kh.ten_KH, nv.ten_NV, td.date, td.tuong_tac, td.phan_hoi
                            FROM khachhang kh
                            INNER JOIN tiendo td ON td.id_KH = kh.id_KH
                            INNER JOIN nhanvien nv ON td.id_NV = nv.id_NV
                            WHERE nv.id_NV = {$id_nv}
                            AND kh.idLoaikhachhang = {$idLoaikhachhang}
                            AND MONTH(td.date) = {$thang}
                            ORDER BY td.date DESC LIMIT $from, $display";


                    }else {
                        $q = "SELECT kh.ten_KH, nv.ten_NV, td.date, td.tuong_tac, td.phan_hoi
                            FROM khachhang kh
                            INNER JOIN tiendo td ON td.id_KH = kh.id_KH
                            INNER JOIN nhanvien nv ON td.id_NV = nv.id_NV
                            WHERE nv.id_NV = {$id_nv}
                            ORDER BY td.date DESC LIMIT $from, $display";
                    }
                    $r = mysqli_query($dbc, $q);
                    confirm_query($r, $q); ?>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th style="background-color: #1e7e34; color: #ffffff;">Ngày</th>
                                <th style="background-color: #1e7e34; color: #ffffff;">Khách Hàng</th>
                                <th style="background-color: #007bff; color: #ffffff;">Tương Tác</th>
                                <th style="background-color: #6c757d; color: #ffffff;">Phản Hồi</th>
                            </tr>
                            <?php while ($row = mysqli_fetch_array($r)): ?>

                                <tr>
                                    <td style="background-color: #1e7e34; color: #ffffff;"><?php echo $row['date'] ?></td>
                                    <td style="background-color: #1e7e34; color: #ffffff;"><?php echo $row['ten_KH'] ?></td>
                                    <td style="background-color: #007bff;  color: #ffffff;"><?php echo $row['tuong_tac'] ?></td>
                                    <td style="background-color: #6c757d; color: #ffffff;"><?php echo $row['phan_hoi'] ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </table>

                        <nav aria-label="Page navigation example">
                            <ul class="pagination">
                                <?php
                                //lay tong so tin
                                $ts_tin = "SELECT id_tiendo FROM tiendo";
                                $trang = mysqli_query($dbc, $ts_tin);
                                confirm_query($trang, $ts_tin);

                                $ts_tin = mysqli_num_rows($trang);
                                $soTrang = ceil($ts_tin / $display);
                                for ($i = 1; $i <= $soTrang; $i++) {
                                    echo "<li class='page-item'><a class='page-link' href='admin.php?trang={$i}'>{$i}</a></li>";

                                }
                                ?>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div><!--/.content-admin-->
        </div>
    </div>
    <?php include "includes/footer.php"; ?>

