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
            <div class="row">
                <?php //phan quyen user
                if ($_SESSION['dang_nhap']['loai_user'] == 1): ?>
                    <!--chọn nhan vien-->
                    <div class="col-md-6">

                        <form method="post">
                            <select name="chon-nv" class="selectpicker"
                                    style="width: 80%; height: 40px; background-color: #1e7e34; color: #fff; float:left;">
                                <option>Chọn Nhân Viên</option>
                                <?php
                                $q = "SELECT id_NV, ten_NV FROM nhanvien";
                                $r = mysqli_query($dbc, $q);
                                confirm_query($r, $q);

                                while ($nhanvien = mysqli_fetch_array($r)) {
                                    echo "<option value='{$nhanvien['id_NV']}'";
                                    if (isset($_POST['chon-nv']) && $_POST['chon-nv'] == $nhanvien['id_NV'])
                                        echo "selected = 'selected'";
                                    echo ">{$nhanvien['ten_NV']}</option>";
                                }
                                ?>

                            </select>

                            <input type="submit" class="btn btn-primary" name="submit" value="Chọn"
                                   style="width: 20%; height: 40px; background-color: #1e7e34; color: #fff; margin-bottom: 20px;">
                        </form>
                    </div>
                <?php endif; ?>
            </div>

            <?php
                if(isset($_POST['chon-nv'])) {
                    $id_nv = $_POST['chon-nv'];
                }else {
                    $id_nv = $_SESSION['dang_nhap']['id_NV'];
                }

            //lay danh sach khach thue
            $q_thue = " SELECT cskh.id_KH, kh.ten_KH, kh.id_KH, kh.loaikhach
                                    FROM khachhang kh
                                    INNER JOIN ChamSocKhacHang cskh ON cskh.id_KH = kh.id_KH  
                                    WHERE cskh.id_NV = {$id_nv}";

            $r_thue = mysqli_query($dbc, $q_thue);
            confirm_query($r_thue, $q_thue);
            $count = 1;
            while ($khach_thue = mysqli_fetch_array($r_thue)): ?>

                <?php
                //phan loai khach
                if($khach_thue['loaikhach'] == 0 ) {
                    $class =  "Khách Mua";
                }elseif($khach_thue['loaikhach'] == 1 ) {
                    $class =  "Khách Thuê";
                }elseif($khach_thue['loaikhach'] == 2 ) {
                    $class =  "Khách Chuyển";
                }elseif($khach_thue['loaikhach'] == 3 ) {
                    $class =  "Khách Đã Chốt";
                }else {
                    $class =  "khách Không có Nhu Cầu";
                }
                ?>

                <div class="card">
                    <div class="card-header" role="tab" id="heading-<?php echo $count; ?>">
                        <h5 class="mb-0">
                            <a data-toggle="collapse" href="#collapse-<?php echo $count; ?>" aria-expanded="true"
                               aria-controls="collapse-<?php echo $count; ?>" style="color:#111111;">
                                <?php echo $khach_thue['ten_KH']; ?> ( <?php echo $class ?>)
                            </a>
                        </h5>
                    </div>

                    <div id="collapse-<?php echo $count; ?>" class="collapse" role="tabpanel"
                         aria-labelledby="heading-<?php echo $count; ?>" data-parent="#accordion">
                        <div class="card-body">
                            <!--table thông tin khách hàng-->
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Số điện thoại</th>
                                    <th>Email</th>
                                    <th>Nguyện vọng khách hàng</th>
                                    <th>Ngày nhận</th>
                                </tr>
                                </thead>
                                <tbody>

                                <?php
                                $q_tt = " SELECT *
                                        FROM khachhang 
                                        WHERE id_KH = {$khach_thue['id_KH']}";
                                $r_tt = mysqli_query($dbc, $q_tt);
                                confirm_query($r_tt, $q_tt);

                                while ($tt_khach = mysqli_fetch_array($r_tt)): ?>

                                    <tr>
                                        <td><?php echo "0" . $tt_khach['sdt_KH'] ?></td>
                                        <td><?php echo $tt_khach['email_KH'] ?></td>
                                        <td><?php echo $tt_khach['ttthem_KH'] ?></td>

                                        <td>
                                            <?php
                                            $phpdate = strtotime( $tt_khach['ngay_them'] );
                                            echo $mysqldate = date( 'd-m-Y H:i:s', $phpdate );
                                            ?>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                                </tbody>
                            </table><!--/.table thong tin khach hang-->

                            <h4 style="text-align: center; color: #fff; font-weight: bold">
                                Tiến độ Công việc</h4>
                            <!--table tien do cong viec-->
                            <?php
                                if($class !=  "Khách Đã Chốt"):?>

                                    <div class="row">
                                        <!--cạp nhật thông tin khách hàng-->
                                        <div class="col-md-3">
                                            <a class="btn btn-success" href="nv_cskh.php?id_nv=<?php echo $id_nv; ?>&id_kh=<?php echo $khach_thue['id_KH']; ?>"> Cập nhật mới</a>
                                        </div>
                                        <div class="col-md-3">
                                            <a class="btn btn-danger" href="chot_khach.php?id_kh=<?php echo $khach_thue['id_KH']; ?>"> Chốt khách</a>
                                        </div>

                                    </div>

                            <?php  endif;?>

                            <table class="table" style="margin-top: 40px;">
                                <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Thời gian</th>
                                    <th>Tương tác</th>
                                    <th>Phản Hồi</th>
                                </tr>
                                </thead>
                                <tbody>

                                <?php
                                $q_meta = " SELECT *
                                                    FROM ChamSocKhacHang cskh
                                                    INNER JOIN tiendo  td ON td.id_KH = cskh.id_KH 
                                                    WHERE td.id_KH = {$khach_thue['id_KH']}
                                                    ORDER BY td.date DESC";

                                $r_meta = mysqli_query($dbc, $q_meta);
                                confirm_query($r_meta, $q_meta);
                                $count1 = 1;
                                while ($meta_khach = mysqli_fetch_array($r_meta)): ?>

                                    <tr>
                                        <th scope="row"><?php echo $count1; ?></th>
                                        <td>
                                            <?php
                                            $phpdate = strtotime( $meta_khach['date'] );
                                            echo $mysqldate = date( 'd-m-Y H:i:s', $phpdate );
                                            ?>

                                        </td>
                                        <td><?php echo $meta_khach['tuong_tac'] ?></td>
                                        <td><?php echo $meta_khach['phan_hoi'] ?></td>
                                    </tr>
                                    <?php $count1++; endwhile; ?>
                                </tbody>
                            </table><!--/.end tablke tien do cong viec-->

                        </div>
                    </div>
                </div>
            <?php $count++; endwhile; ?>


        </div>
    </div>
</div>


<?php include "includes/footer.php"; ?>