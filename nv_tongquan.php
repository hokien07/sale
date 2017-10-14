<?php include "includes/header.php"; ?>
<?php include('includes/mysqli_connect.php'); ?>
<?php include('includes/function.php'); ?>
<?php include "includes/top-header.php"; ?>
<?php
if (empty($_SESSION)) {
    header('location:index.php');
}

?>
<div class="row">
    <div class="col-md-3">
        <?php include "includes/sidebar.php"; ?>
    </div>

    <div class="col-md-9">
        <div class="content">
            <div class="khachhang-moi">
                <h2 style="text-transform: uppercase; text-align: center; padding-top: 20px; font-weight: bold; padding-bottom: 20px">
                    Tiến Độ</h2>
                <?php
                //phan trang
                $id_nv = $_SESSION['dang_nhap']['id_NV'];
                $display = 20;

                //phan trang
                if (isset($_GET['trang']) && filter_var($_GET['trang'], FILTER_VALIDATE_INT, array('min-range' => 1))) {
                    $from = ($_GET['trang'] - 1) * $display;
                } else {
                    $from = 0;
                }
                ?>

                <!--Chọn tháng-->
                <form method="post">
                    <div clas="row">
                        <div class="col-md-6">

                            <select name="thang" id="thang"
                                    style="width: 80%; height: 40px; background-color: #1e7e34; color: #fff; float:left;">
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
                            </select>
                            <input type="submit" name="submit" id="loai-kh" value="Chọn"
                                   style="width: 20%; height: 40px; background-color: #1e7e34; color: #fff; margin-bottom: 20px;">
                        </div>
                    </div>
                </form>

                <ul class="nav nav-tabs" id="pills-tab" role="tablist">
                    <li class="nav-item col-md-3">
                        <a class="nav-link active"
                           id="mua-tab" data-toggle="tab" href="#mua" role="tab" aria-controls="mua"
                           aria-expanded="true" style="background-color: #0c5460; color: #fff;">Dự Án (
                            <?php
                            $q_mua = "SELECT cskh.id_KH
                                          FROM khachhang kh
                                          INNER JOIN ChamSocKhacHang cskh ON kh.id_KH = cskh.id_KH
                                          WHERE kh.loaikhach = 0
                                          AND cskh.id_NV = $id_nv";
                            $r_mua = mysqli_num_rows(mysqli_query($dbc, $q_mua));
                            echo $r_mua . " Khách";
                            ?>
                            )</a>
                    </li>
                    <li class="nav-item col-md-3">
                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#thue" role="tab"
                           aria-controls="profile" style="background-color: #007bff; color: #fff;">Thuê (
                            <?php
                            $q_mua = "SELECT cskh.id_KH
                                          FROM khachhang kh
                                          INNER JOIN ChamSocKhacHang cskh ON kh.id_KH = cskh.id_KH
                                          WHERE kh.loaikhach = 1
                                          AND cskh.id_NV = $id_nv";
                            $r_mua = mysqli_num_rows(mysqli_query($dbc, $q_mua));
                            echo $r_mua . " Khách";
                            ?>
                            )</a>
                    </li>
                    <li class="nav-item col-md-3">
                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#chuyen" role="tab"
                           aria-controls="profile" style="background-color: #1e7e34; color: #fff;">Chuyển Nhượng (
                            <?php
                            $q_mua = "SELECT cskh.id_KH
                                          FROM khachhang kh
                                          INNER JOIN ChamSocKhacHang cskh ON kh.id_KH = cskh.id_KH
                                          WHERE kh.loaikhach = 2
                                          AND cskh.id_NV = $id_nv";
                            $r_mua = mysqli_num_rows(mysqli_query($dbc, $q_mua));
                            echo $r_mua;
                            ?>
                            )</a>
                    </li>
                    <li class="nav-item col-md-3">
                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#chuacs" role="tab"
                           aria-controls="profile" style="background-color: #1e7e34; color: #fff;">Chưa Chăm Sóc (
                            <?php
                            $q_cs = "SELECT kh.id_KH
                                      FROM khachhang kh
                                      INNER JOIN ChamSocKhacHang cskh ON kh.id_KH = cskh.id_KH
                                      WHERE kh.cs = 0 AND cskh.id_NV = $id_nv";
                            $r_cs = mysqli_num_rows(mysqli_query($dbc, $q_cs));
                            echo $r_cs;
                            ?>
                            )</a>
                    </li>
                </ul>


                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="mua" role="tabpanel" aria-labelledby="mua-tab"
                         style="padding: 10px;">

                        <?php
                        if (isset($_POST['submit'], $_POST['thang'])) {

                            $thang = $_POST['thang'];
                            $thang < 10 ? $thang = "0" . $thang : $thang = $thang;

                            $q = "SELECT kh.ten_KH, kh.id_KH, kh.ttthem_KH, kh.sdt_KH, kh.loaikhach, td.*
                                      FROM tiendo td
                                      INNER JOIN khachhang kh ON td.id_KH = kh.id_KH
                                      WHERE kh.loaikhach = 0 AND MONTH(td.date) = {$thang} AND td.id_NV = $id_nv
                                      ORDER BY td.date DESC LIMIT $from, $display";

                        } else {
                            $q = "SELECT kh.ten_KH, kh.id_KH, kh.ttthem_KH, kh.sdt_KH, kh.loaikhach, td.*
                                      FROM khachhang kh
                                      INNER JOIN tiendo td ON td.id_KH = kh.id_KH
                                      WHERE kh.loaikhach = 0 AND td.id_NV = $id_nv
                                      ORDER BY td.date DESC LIMIT $from, $display";
                        }

                        $r = mysqli_query($dbc, $q);
                        confirm_query($r, $q); ?>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <th>Ngày:</th>
                                    <th>Khách Hàng</th>
                                    <th>SĐT Khách</th>
                                    <th>Nhu Cầu</th>
                                    <th>Phản Hồi:</th>
                                </tr>
                                <?php while ($row = mysqli_fetch_array($r)): ?>

                                    <tr <?php if($row['loaikhach'] == 4) echo "class = 'khach-bo'" ?>>
                                        <td><?php
                                            $phpdate = strtotime( $row['date'] );
                                            echo $mysqldate = date( 'd-m-Y H:i:s', $phpdate );?></td>
                                        <td><?php echo "<a href='chitiet_cskh.php?id_nv={$id_nv}&id_kh={$row['id_KH']}' style='color: #5706FF;'> {$row['ten_KH']} </a>"?></td>
                                        <td><?php echo "0". $row['sdt_KH'] ?></td>
                                        <td><?php echo $row['ttthem_KH'] ?></td>
                                        <td><?php echo $row['phan_hoi'] ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            </table>

                            <nav aria-label="Page navigation example">
                                <ul class="pagination">
                                    <?php
                                    //lay tong so tin
                                    $ts_tin = "SELECT id_tiendo
                                                FROM tiendo";
                                    $trang = mysqli_query($dbc, $ts_tin);
                                    confirm_query($trang, $ts_tin);

                                    $ts_tin = mysqli_num_rows($trang);
                                    $soTrang = ceil($ts_tin / $display);
                                    for ($i = 1; $i <= $soTrang; $i++) {
                                        echo "<li class='page-item'><a class='page-link' href='nv_tongquan.php?trang={$i}'>{$i}</a></li>";

                                    }
                                    ?>
                                </ul>
                            </nav>
                        </div>

                    </div>
                    <div class="tab-pane fade" id="thue" role="tabpanel" aria-labelledby="profile-tab"
                         style="padding: 10px;">
                        <?php
                        if (isset($_POST['submit'], $_POST['thang'])) {

                            $thang = $_POST['thang'];
                            $thang < 10 ? $thang = "0" . $thang : $thang = $thang;

                            $q_thue = "SELECT kh.ten_KH, kh.id_KH, kh.ttthem_KH, kh.sdt_KH, kh.loaikhach, td.*
                                      FROM tiendo td
                                      INNER JOIN khachhang kh ON td.id_KH = kh.id_KH
                                      WHERE kh.loaikhach = 1 AND MONTH(td.date) = {$thang} AND td.id_NV = $id_nv
                                      ORDER BY td.date DESC LIMIT $from, $display";

                        } else {
                            $q_thue = "SELECT kh.ten_KH, kh.id_KH, kh.ttthem_KH, kh.sdt_KH, kh.loaikhach, td.*
                                      FROM khachhang kh
                                      INNER JOIN tiendo td ON td.id_KH = kh.id_KH
                                      WHERE kh.loaikhach = 1 AND td.id_NV = $id_nv
                                      ORDER BY td.date DESC LIMIT $from, $display";
                        }

                        $r_thue = mysqli_query($dbc, $q_thue);
                        confirm_query($r_thue, $q_thue); ?>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <th>Ngày:</th>
                                    <th>Khách Hàng</th>
                                    <th>SĐT Khách</th>
                                    <th>Nhu Cầu</th>
                                    <th>Phản Hồi:</th>
                                </tr>
                                <?php while ($row = mysqli_fetch_array($r_thue)): ?>

                                    <tr <?php if($row['loaikhach'] == 4) echo "class = 'khach-bo'" ?>>
                                        <td><?php  $phpdate = strtotime( $row['date'] );
                                            echo $mysqldate = date( 'd-m-Y H:i:s', $phpdate ); ?></td>
                                        <td><?php echo "<a href='chitiet_cskh.php?id_nv={$id_nv}&id_kh={$row['id_KH']}' style='color: #5706FF;'> {$row['ten_KH']} </a>"?></td>
                                        <td><?php echo "0".$row['sdt_KH'] ?></td>
                                        <td><?php echo $row['ttthem_KH'] ?></td>
                                        <td><?php echo $row['phan_hoi'] ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            </table>

                            <nav aria-label="Page navigation example">
                                <ul class="pagination">
                                    <?php
                                    //lay tong so tin
                                    $ts_tin = "SELECT id_tiendo FROM tiendo WHERE id_NV = $id_nv";
                                    $trang = mysqli_query($dbc, $ts_tin);
                                    confirm_query($trang, $ts_tin);

                                    $ts_tin = mysqli_num_rows($trang);
                                    $soTrang = ceil($ts_tin / $display);
                                    for ($i = 1; $i <= $soTrang; $i++) {
                                        echo "<li class='page-item'><a class='page-link' href='nv_tongquan.php?trang={$i}'>{$i}</a></li>";

                                    }
                                    ?>
                                </ul>
                            </nav>
                        </div>

                    </div>
                    <div class="tab-pane fade" id="chuyen" role="tabpanel" style="padding: 10px;">
                        <?php
                        if (isset($_POST['submit'], $_POST['thang'])) {

                            $thang = $_POST['thang'];
                            $thang < 10 ? $thang = "0" . $thang : $thang = $thang;

                            $q_chuyen = "SELECT kh.ten_KH, kh.id_KH, kh.ttthem_KH, kh.sdt_KH, kh.loaikhach, td.*
                                      FROM tiendo td
                                      INNER JOIN khachhang kh ON td.id_KH = kh.id_KH
                                      WHERE kh.loaikhach = 2 AND MONTH(td.date) = {$thang} AND td.id_NV = $id_nv
                                      ORDER BY td.date DESC LIMIT $from, $display";

                        } else {
                            $q_chuyen = "SELECT kh.ten_KH, kh.id_KH, kh.ttthem_KH, kh.sdt_KH, kh.loaikhach, td.*
                                      FROM khachhang kh
                                      INNER JOIN tiendo td ON td.id_KH = kh.id_KH
                                      WHERE kh.loaikhach = 2 AND td.id_NV = $id_nv
                                      ORDER BY td.date DESC LIMIT $from, $display";
                        }

                        $r_chuyen = mysqli_query($dbc, $q_chuyen);
                        confirm_query($r_chuyen, $q_chuyen); ?>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <th>Ngày:</th>
                                    <th>Khách Hàng</th>
                                    <th>SĐT Khách</th>
                                    <th>Nhu Cầu</th>
                                    <th>Phản Hồi:</th>
                                </tr>
                                <?php while ($row = mysqli_fetch_array($r_chuyen)): ?>

                                    <tr <?php if($row['loaikhach'] == 4) echo "class = 'khach-bo'" ?>>
                                        <td><?php $phpdate = strtotime( $row['date'] );
                                            echo $mysqldate = date( 'd-m-Y H:i:s', $phpdate ); ?></td>
                                        <td><?php echo "<a href='chitiet_cskh.php?id_nv={$id_nv}&id_kh={$row['id_KH']}' style='color: #5706FF;'> {$row['ten_KH']} </a>"?></td>
                                        <td><?php echo "0". $row['sdt_KH'] ?></td>
                                        <td><?php echo $row['ttthem_KH'] ?></td>
                                        <td><?php echo $row['phan_hoi'] ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            </table>

                            <nav aria-label="Page navigation example">
                                <ul class="pagination">
                                    <?php
                                    //lay tong so tin
                                    $ts_tin = "SELECT id_tiendo FROM tiendo WHERE id_NV = $id_nv";
                                    $trang = mysqli_query($dbc, $ts_tin);
                                    confirm_query($trang, $ts_tin);

                                    $ts_tin = mysqli_num_rows($trang);
                                    $soTrang = ceil($ts_tin / $display);
                                    for ($i = 1; $i <= $soTrang; $i++) {
                                        echo "<li class='page-item'><a class='page-link' href='nv_tongquan.php?trang={$i}'>{$i}</a></li>";

                                    }
                                    ?>
                                </ul>
                            </nav>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="chuacs" role="tabpanel" style="padding: 10px;">
                        <?php

                        $q_chuacs = "SELECT kh.*, cskh.*
                                      FROM khachhang kh
                                      INNER JOIN ChamSocKhacHang cskh ON cskh.id_KH = kh.id_KH
                                      WHERE kh.cs = 0 AND cskh.id_NV = {$id_nv}
                                      ORDER BY cskh.ngay DESC LIMIT $from, $display";

                        $r_chuacs = mysqli_query($dbc, $q_chuacs);
                        confirm_query($r_chuacs, $q_chuacs);
                        ?>


                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <th>Ngày Thêm</th>
                                    <th>Khách Hàng</th>
                                    <th>SĐT Khách</th>
                                    <th>Nhu Cầu</th>
                                </tr>
                                <?php while ($row = mysqli_fetch_array($r_chuacs)): ?>

                                    <tr>
                                        <td><?php $phpdate = strtotime( $row['ngay_them'] );
                                            echo $mysqldate = date( 'd-m-Y H:i:s', $phpdate ); ?></td>
                                        <td><?php echo "<a href='chitiet_cskh.php?id_nv={$id_nv}&id_kh={$row['id_KH']}' style='color: #5706FF;'> {$row['ten_KH']} </a>"?></td>
                                        <td><?php echo "0". $row['sdt_KH'] ?></td>
                                        <td><?php echo $row['ttthem_KH'] ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            </table>

                            <nav aria-label="Page navigation example">
                                <ul class="pagination">
                                    <?php
                                    //lay tong so tin
                                    $ts_tin = "SELECT id_tiendo FROM tiendo WHERE id_NV = $id_nv";
                                    $trang = mysqli_query($dbc, $ts_tin);
                                    confirm_query($trang, $ts_tin);

                                    $ts_tin = mysqli_num_rows($trang);
                                    $soTrang = ceil($ts_tin / $display);
                                    for ($i = 1; $i <= $soTrang; $i++) {
                                        echo "<li class='page-item'><a class='page-link' href='nv_tongquan.php?trang={$i}'>{$i}</a></li>";

                                    }
                                    ?>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<?php include "includes/footer.php"; ?>
