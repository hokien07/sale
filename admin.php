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

                $display = 20;
                $id_nv = $_SESSION['dang_nhap']['id_NV'];


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

                <!--Loc ngày và loại khách hàng-->
                <ul class="nav nav-tabs" id="pills-tab" role="tablist">
                    <li class="nav-item col-md-3">
                        <a class="nav-link active"
                           id="home-tab" data-toggle="tab" href="#mua" role="tab" aria-controls="home"
                           aria-expanded="true" style="background-color: #0c5460; color: #fff;">Dự Án (
                                <?php
                                if (isset($_POST['submit'], $_POST['thang'])) {

                                    $thang = $_POST['thang'];
                                    $thang < 10 ? $thang = "0" . $thang : $thang = $thang;

                                    $q_mua = "SELECT id_KH FROM khachhang WHERE loaikhach = 0 AND MONTH(ngay_them) = $thang";

                                }else {
                                    $q_mua = "SELECT id_KH FROM khachhang WHERE loaikhach = 0";
                                }

                                $r_mua = mysqli_num_rows(mysqli_query($dbc, $q_mua));
                                echo $r_mua . " Khách";
                                ?>

                            )</a>
                    </li>
                    <li class="nav-item col-md-3">
                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#thue" role="tab"
                           aria-controls="profile" style="background-color: #007bff; color: #fff;">Thuê (
                            <?php
                            if (isset($_POST['submit'], $_POST['thang'])) {

                                $thang = $_POST['thang'];
                                $thang < 10 ? $thang = "0" . $thang : $thang = $thang;

                                $q_thue = "SELECT id_KH FROM khachhang WHERE loaikhach = 1 AND MONTH(ngay_them) = $thang";

                            }else {
                                $q_mua = "SELECT id_KH FROM khachhang WHERE loaikhach = 1";
                            }
                            $r_thue = mysqli_num_rows(mysqli_query($dbc, $q_mua));
                            echo $r_thue . " Khách";
                            ?>
                            )</a>
                    </li>
                    <li class="nav-item col-md-3">
                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#chuyen" role="tab"
                           aria-controls="profile" style="background-color: #1e7e34; color: #fff;">Chuyển Nhượng (
                            <?php
                            if (isset($_POST['submit'], $_POST['thang'])) {

                                $thang = $_POST['thang'];
                                $thang < 10 ? $thang = "0" . $thang : $thang = $thang;

                                $q_chuyen = "SELECT id_KH FROM khachhang WHERE loaikhach = 2 AND MONTH(ngay_them) = $thang";

                            }else {
                                $q_mua = "SELECT id_KH FROM khachhang WHERE loaikhach = 2";
                            }
                            $r_chuyen = mysqli_num_rows(mysqli_query($dbc, $q_mua));
                            echo $r_chuyen;
                            ?>
                            )</a>
                    </li>
                    <li class="nav-item col-md-3">
                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#chuacs" role="tab"
                           aria-controls="profile" style="background-color: #1e7e34; color: #fff;">Chưa Chăm Sóc (
                           <?php
                            $q_mua = "SELECT id_KH FROM khachhang WHERE cs = 0";
                            $r_chuyen = mysqli_num_rows(mysqli_query($dbc, $q_mua));
                            echo $r_chuyen;
                            ?>
                            )</a>
                    </li>
                </ul>


                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="mua" role="tabpanel" aria-labelledby="home-tab"
                         style="padding: 10px;">

                        <?php
                        if (isset($_POST['submit'], $_POST['thang'])) {

                            $thang = $_POST['thang'];
                            $thang < 10 ? $thang = "0" . $thang : $thang = $thang;

                            $q = "SELECT kh.ten_KH, kh.id_KH, kh.loaikhach, kh.sdt_KH, kh.ttthem_KH, nv.ten_NV, csmn.csNgay, csmn.csTuongTac, csmn.csPhanHoi
                                      FROM csMoiNhat csmn
                                      INNER JOIN khachhang kh ON csmn.id_KH = kh.id_KH
                                      INNER JOIN nhanvien nv ON csmn.id_NV = nv.id_NV
                                      WHERE kh.loaikhach = 0 AND MONTH(csmn.csNgay) = {$thang}
                                      ORDER BY csmn.csNgay DESC LIMIT $from, $display";

                        } else {
                            $q = "SELECT kh.ten_KH, kh.id_KH, kh.loaikhach, kh.sdt_KH, kh.ttthem_KH, nv.ten_NV,  csmn.csNgay, csmn.csTuongTac, csmn.csPhanHoi
                                      FROM khachhang kh
                                      INNER JOIN csMoiNhat csmn ON csmn.id_KH = kh.id_KH
                                      INNER JOIN nhanvien nv ON csmn.id_NV = nv.id_NV
                                      WHERE kh.loaikhach = 0
                                      ORDER BY csmn.csNgay DESC LIMIT $from, $display";
                        }

                        $r = mysqli_query($dbc, $q);
                        confirm_query($r, $q); ?>

                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <th>STT</th>
                                    <th>Ngày:</th>
                                    <th>Nhân Viên:</th>
                                    <th>Khách Hàng:</th>
                                    <th>SĐT Khách</th>
                                    <th>Nhu Cầu</th>
                                    <th>Phản Hồi:</th>
                                </tr>
                                <?php $stt1 = 1; while ($row = mysqli_fetch_array($r)): ?>

                                    <tr <?php if($row['loaikhach'] == 4) echo "class = 'khach-bo'" ?>>
                                        <td><?php echo $stt1; ?></td>
                                        <td>
                                            <?php
                                                $phpdate = strtotime( $row['csNgay'] );
                                                echo $mysqldate = date( 'd-m-Y H:i:s', $phpdate );
                                              ?>
                                        </td>
                                        <td><?php echo $row['ten_NV'] ?></td>
                                        <td><?php echo "<a href='chitiet_cskh.php?id_nv={$id_nv}&id_kh={$row['id_KH']}' style='color: #5706FF;'> {$row['ten_KH']} </a>"?></td>
                                        <td><?php echo "0". $row['sdt_KH'] ?></td>
                                        <td><?php echo $row['ttthem_KH'] ?></td>
                                        <td><?php echo $row['csPhanHoi'] ?></td>
                                    </tr>
                                <?php $stt1++;  endwhile; ?>
                            </table>

                            <nav aria-label="Page navigation example">
                                <ul class="pagination">
                                    <?php
                                    //lay tong so tin
                                    $ts_tin = "SELECT td.id_tiendo 
                                                FROM tiendo td
                                                INNER JOIN khachhang kh ON kh.id_KH = td.id_KH
                                                WHERE kh.loaikhach= 2";
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

                    <div class="tab-pane fade" id="thue" role="tabpanel" aria-labelledby="profile-tab" style="padding: 10px;">

                        <?php
                        if (isset($_POST['submit'], $_POST['thang'])) {

                            $thang = $_POST['thang'];
                            $thang < 10 ? $thang = "0" . $thang : $thang = $thang;

                            $q = "SELECT kh.ten_KH, kh.id_KH, kh.sdt_KH, kh.ttthem_KH, nv.ten_NV, csmn.csNgay, csmn.csTuongTac, csmn.csPhanHoi
                                      FROM csMoiNhat csmn
                                      INNER JOIN khachhang kh ON csmn.id_KH = kh.id_KH
                                      INNER JOIN nhanvien nv ON csmn.id_NV = nv.id_NV
                                      WHERE kh.loaikhach = 1 AND MONTH(csmn.csNgay) = {$thang}
                                      ORDER BY csmn.csNgay DESC LIMIT $from, $display";

                        } else {
                            $q = "SELECT kh.ten_KH, kh.id_KH, kh.sdt_KH, kh.ttthem_KH, nv.ten_NV, csmn.csNgay, csmn.csTuongTac, csmn.csPhanHoi
                                      FROM khachhang kh
                                      INNER JOIN csMoiNhat csmn ON csmn.id_KH = kh.id_KH
                                      INNER JOIN nhanvien nv ON csmn.id_NV = nv.id_NV
                                      WHERE kh.loaikhach = 1
                                      ORDER BY csmn.csNgay DESC LIMIT $from, $display";
                        }

                        $r = mysqli_query($dbc, $q);
                        confirm_query($r, $q); ?>

                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <th>STT</th>
                                    <th>Ngày</th>
                                    <th>Nhân Viên</th>
                                    <th>Khách Hàng</th>
                                    <th>SĐT Khách</th>
                                    <th>Nhu Cầu</th>
                                    <th>Phản Hồi</th>
                                </tr>
                                <?php $stt = 1; while ($row = mysqli_fetch_array($r)): ?>

                                    <tr>
                                        <td><?php echo $stt; ?></td>
                                        <td>
                                            <?php
                                                $phpdate = strtotime( $row['csNgay'] );
                                                echo $mysqldate = date( 'd-m-Y H:i:s', $phpdate );
                                            ?>
                                        </td>
                                        <td><?php echo $row['ten_NV'] ?></td>
                                        <td><?php echo "<a href='chitiet_cskh.php?id_nv={$id_nv}&id_kh={$row['id_KH']}' style='color: #5706FF;'> {$row['ten_KH']} </a>"?></td>
                                        <td><?php echo "0". $row['sdt_KH'] ?></td>
                                        <td><?php echo $row['ttthem_KH'] ?></td>
                                        <td><?php echo $row['csPhanHoi'] ?></td>
                                    </tr>
                                <?php $stt++;  endwhile; ?>
                            </table>

                            <nav aria-label="Page navigation example">
                                <ul class="pagination">
                                    <?php
                                    //lay tong so tin
                                    $ts_tin = "SELECT td.id_tiendo 
                                                FROM tiendo td
                                                INNER JOIN khachhang kh ON kh.id_KH = td.id_KH
                                                WHERE kh.loaikhach= 2";
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

                    <div class="tab-pane fade" id="chuyen" role="tablist" style="padding: 10px;">
                        <?php
                        if (isset($_POST['submit'], $_POST['thang'])) {

                            $thang = $_POST['thang'];
                            $thang < 10 ? $thang = "0" . $thang : $thang = $thang;

                            $q = "SELECT kh.ten_KH, kh.id_KH, kh.sdt_KH, kh.ttthem_KH, nv.ten_NV, csmn.csNgay, csmn.csTuongTac, csmn.csPhanHoi
                                      FROM csMoiNhat csmn
                                      INNER JOIN khachhang kh ON csmn.id_KH = kh.id_KH
                                      INNER JOIN nhanvien nv ON csmn.id_NV = nv.id_NV
                                      WHERE kh.loaikhach = 2 AND MONTH(csmn.csNgay) = {$thang}
                                      ORDER BY csmn.csNgay DESC LIMIT $from, $display";

                        } else {
                            $q = "SELECT kh.ten_KH, kh.id_KH, kh.sdt_KH, kh.ttthem_KH, nv.ten_NV, csmn.csNgay, csmn.csTuongTac, csmn.csPhanHoi
                                      FROM khachhang kh
                                      INNER JOIN csMoiNhat csmn ON csmn.id_KH = kh.id_KH
                                      INNER JOIN nhanvien nv ON csmn.id_NV = nv.id_NV
                                      WHERE kh.loaikhach = 2
                                      ORDER BY csmn.csNgay DESC LIMIT $from, $display";
                        }

                        $r = mysqli_query($dbc, $q);
                        confirm_query($r, $q); ?>

                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <th>STT</th>
                                    <th>Ngày</th>
                                    <th>Nhân Viên</th>
                                    <th>Khách Hàng</th>
                                    <th>SĐT Khách</th>
                                    <th>Nhu Cầu</th>
                                    <th>Phản Hồi</th>
                                </tr>
                                <?php $stt2 =1; while ($row = mysqli_fetch_array($r)): ?>

                                    <tr>
                                        <td><?php echo $stt2; ?></td>
                                        <td><?php
                                            $phpdate = strtotime( $row['csNgay'] );
                                            echo $mysqldate = date( 'd-m-Y H:i:s', $phpdate );
                                            ?></td>
                                        <td><?php echo $row['ten_NV'] ?></td>
                                        <td><?php echo "<a href='chitiet_cskh.php?id_nv={$id_nv}&id_kh={$row['id_KH']}' style='color: #5706FF;'> {$row['ten_KH']} </a>"?></td>
                                        <td><?php echo "0". $row['sdt_KH'] ?></td>
                                        <td><?php echo $row['ttthem_KH'] ?></td>
                                        <td><?php echo $row['csPhanHoi'] ?></td>
                                    </tr>
                                <?php $stt2++;  endwhile; ?>
                            </table>

                            <nav aria-label="Page navigation example">
                                <ul class="pagination">
                                    <?php
                                    //lay tong so tinidVTTDung
                                    $ts_tin = "SELECT td.id_tiendo 
                                                FROM tiendo td
                                                INNER JOIN khachhang kh ON kh.id_KH = td.id_KH
                                                WHERE kh.loaikhach= 2";
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

                    <div class="tab-pane fade" id="chuacs" role="tablist" style="padding: 10px;">
                        <?php
                            $q = "SELECT *
                                      FROM khachhang
                                      WHERE cs = 0
                                      ORDER BY id_KH DESC LIMIT $from, $display";
                            $r = mysqli_query($dbc, $q);
                            confirm_query($r, $q); ?>

                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <th>STT</th>
                                    <th>Ngày</th>
                                    <th>Khách Hàng</th>
                                    <th>SĐT Khách</th>
                                    <th>Nhu Cầu</th>
                                </tr>
                                <?php $stt2 =1; while ($row = mysqli_fetch_array($r)): ?>

                                    <tr>
                                        <td><?php echo $stt2; ?></td>
                                        <td><?php
                                            $phpdate = strtotime( $row['ngay_them'] );
                                            echo $mysqldate = date( 'd-m-Y H:i:s', $phpdate );
                                            ?></td>
                                        <td><?php echo "<a href='chitiet_cskh.php?id_nv={$id_nv}&id_kh={$row['id_KH']}' style='color: #5706FF;'> {$row['ten_KH']} </a>"?></td>
                                        <td><?php echo "0". $row['sdt_KH'] ?></td>
                                        <td><?php echo $row['ttthem_KH'] ?></td>
                                    </tr>
                                    <?php $stt2++;  endwhile; ?>
                            </table>

                            <nav aria-label="Page navigation example">
                                <ul class="pagination">
                                    <?php
                                    //lay tong so tin
                                    $ts_tin = "SELECT id_KH FROM khachhang WHERE cs = 0";
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

                </div>
            </div>

        </div>
    </div>
</div>
<?php include "includes/footer.php"; ?>
