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
                <?php

                    //lay id nhan vien va id khach hang
                    if(isset($_GET['id_nv'], $_GET['id_kh']) && filter_var($_GET['id_nv'], FILTER_VALIDATE_INT, array('min-range' => 1))) {
                        $id_nv = $_GET['id_nv'];
                        $id_kh = $_GET['id_kh'];

                        $q_ttkh = "SELECT * FROM khachhang WHERE id_KH = $id_kh";
                        $r_ttkh = mysqli_query($dbc, $q_ttkh);
                        confirm_query($r_ttkh, $q_ttkh);
                        $ttkh = mysqli_fetch_array($r_ttkh);
                    }

                    $display = 20;
                    if (isset($_GET['trang']) && filter_var($_GET['trang'], FILTER_VALIDATE_INT, array('min-range' => 1))) {
                        $from = ($_GET['trang'] - 1) * $display;
                    } else {
                        $from = 0;
                    }

                    $q_tendo = "SELECT  td.*
                                  FROM tiendo td
                                  WHERE td.id_KH = {$id_kh}
                                  ORDER BY td.id_tiendo DESC LIMIT $from, $display";

                    $r_tiendo = mysqli_query($dbc, $q_tendo);
                    confirm_query($r_tiendo, $q_tendo);

                    //lay ten nhan vien
                    $ten_nv = "SELECT ten_NV FROM nhanvien WHERE id_NV = $id_nv";
                    $r_ten_nv = mysqli_query($dbc, $ten_nv);
                    confirm_query($r_ten_nv, $ten_nv);
                    $ten_nhanvien = mysqli_fetch_array($r_ten_nv);


                    //lay ten kachhang
                    $ten_kh = "SELECT ten_KH FROM khachhang WHERE id_KH = $id_kh";
                    $r_ten_kh = mysqli_query($dbc, $ten_kh);
                    confirm_query($r_ten_kh, $ten_kh);
                    $ten_khachhang = mysqli_fetch_array($r_ten_kh);
                ?>
                <h2 style="text-transform: uppercase; text-align: center; padding-top: 20px; font-weight: bold; padding-bottom: 20px">
                    Thông tin khách hàng</h2>

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <th>Ngày Thêm</th>
                            <th>Tên</th>
                            <th>Số Điện Thoại</th>
                            <th>Email </th>
                            <th>Địa Chỉ</th>
                            <th>Nguyện Vọng</th>

                        </tr>
                        <tr>
                            <td>
                                <?php
                                    $phpdate = strtotime($ttkh['ngay_them']);
                                    echo $mysqldate = date('d-m-Y H:i:s', $phpdate);
                                ?>
                            </td>
                            <td><?php echo $ttkh['ten_KH'] ?></td>
                            <td><?php echo $ttkh['sdt_KH'] ?></td>
                            <td><?php echo $ttkh['email_KH'] ?></td>
                            <td><?php echo $ttkh['diachi_KH'] ?></td>
                            <td><?php echo $ttkh['ttthem_KH'] ?></td>
                        </tr>

                    </table>
                </div>


                <div class="row">
                    <!--cạp nhật thông tin khách hàng-->
                    <div class="col-md-3">
                        <a class="btn btn-success" href="nv_cskh.php?id_nv=<?php echo $id_nv; ?>&id_kh=<?php echo $id_kh; ?>"> Cập nhật mới</a>
                    </div>
                    <div class="col-md-3">
                        <a class="btn btn-danger" href="chot_khach.php?id_kh=<?php echo $id_kh; ?>"> Chốt khách</a>
                    </div>

                </div>

                <h2 style="text-transform: uppercase; text-align: center; padding-top: 20px; font-weight: bold; padding-bottom: 20px">
                    Tiến Độ</h2>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <th>STT</th>
                            <th>Ngày</th>
                            <th>Nhân Viên</th>
                            <th>Khách Hàng</th>
                            <th>Tương Tác</th>
                            <th>Phản Hồi</th>
                        </tr>
                        <?php $stt1 = 1;
                        while ($row = mysqli_fetch_array($r_tiendo)): ?>

                            <tr>
                                <td><?php echo $stt1; ?></td>
                                <td>
                                    <?php
                                    $phpdate = strtotime($row['date']);
                                    echo $mysqldate = date('d-m-Y H:i:s', $phpdate);
                                    ?>
                                </td>
                                <td><?php echo $ten_nhanvien['ten_NV'] ?></td>
                                <td><?php echo $ten_khachhang['ten_KH'] ?></td>
                                <td><?php echo $row['tuong_tac'] ?></td>
                                <td><?php echo $row['phan_hoi'] ?></td>
                            </tr>
                            <?php $stt1++; endwhile; ?>
                    </table>

                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            <?php
                            //lay tong so tin
                            $ts_tin = "SELECT id_tiendo FROM tiendo WHERE id_NV = $id_nv AND id_KH = $id_kh";
                            $trang = mysqli_query($dbc, $ts_tin);
                            confirm_query($trang, $ts_tin);

                            $ts_tin = mysqli_num_rows($trang);
                            $soTrang = ceil($ts_tin / $display);
                            for ($i = 1; $i <= $soTrang; $i++) {
                                echo "<li class='page-item'><a class='page-link' href='chitiet_cskh.php?id_nv={$id_nv}&id_kh={$id_kh}&trang={$i}'>{$i}</a></li>";

                            }
                            ?>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include "includes/footer.php"; ?>
