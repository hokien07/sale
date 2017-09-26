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
                        <div class="col-md-12">
                            <form method="post">
                                <select name="chon-nv" class="selectpicker"
                                        style="height: 40px; width: 200px;  background-color: #007bff; color: #fff;">
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
                                       style="height: 40px;">
                            </form>
                        </div>

                    <?php endif; ?>

                    <div class="col-md-12">
                        <div class="khach-hang-cham-soc">

                            <!--tabs cham soc khach hang-->
                            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                <li class="nav-item col-md-4">
                                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#thue" role="tab"
                                       aria-controls="home" aria-expanded="true">
                                        Thuê (
                                            <?php
                                            //dem so luong khach hang
                                            $id_nv = $_SESSION['dang_nhap']['id_NV'];
                                            $q_thue = " SELECT cskh.*
                                                FROM khachhang kh 
                                                INNER JOIN ChamSocKhacHang cskh ON cskh.id_KH = kh.id_KH   
                                                WHERE loaikhach = 0 AND cskh.id_NV = {$id_nv}";
                                            $r_thue = mysqli_query($dbc, $q_thue);
                                            confirm_query($r_thue, $q_thue);

                                            $row = mysqli_num_rows($r_thue);
                                            echo $row;

                                            ?>
                                        )
                                    </a>
                                </li>
                                <li class="nav-item col-md-4">
                                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#mua" role="tab"
                                       aria-controls="profile">Mua (
                                            <?php
                                                //dem so luong khach hang
                                                $id_nv = $_SESSION['dang_nhap']['id_NV'];
                                                $q_thue = " SELECT cskh.*
                                                    FROM khachhang kh 
                                                    INNER JOIN ChamSocKhacHang cskh ON cskh.id_KH = kh.id_KH   
                                                    WHERE loaikhach = 1 AND cskh.id_NV = {$id_nv}";
                                                $r_thue = mysqli_query($dbc, $q_thue);
                                                confirm_query($r_thue, $q_thue);

                                                $row = mysqli_num_rows($r_thue);
                                                echo $row;

                                            ?>
                                        )</a>
                                </li>
                                <li class="nav-item col-md-4">
                                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#chot" role="tab"
                                       aria-controls="profile">Khách Chốt (
                                            <?php
                                                //dem so luong khach hang
                                                $id_nv = $_SESSION['dang_nhap']['id_NV'];
                                                $q_thue = " SELECT cskh.*
                                                            FROM khachhang kh 
                                                            INNER JOIN ChamSocKhacHang cskh ON cskh.id_KH = kh.id_KH   
                                                            WHERE loaikhach = 1 AND cskh.id_NV = {$id_nv}";
                                                $r_thue = mysqli_query($dbc, $q_thue);
                                                confirm_query($r_thue, $q_thue);

                                                $row = mysqli_num_rows($r_thue);
                                                echo $row;

                                            ?>
                                        )</a>
                                </li>

                            </ul>

                            <div class="tab-content" id="myTabContent">

                                <div class="col-md-12">
                                    <div class="tab-pane fade show active" id="thue" role="tabpanel"
                                         aria-labelledby="home-tab">
                                        <?php
                                        $id_nv = $_SESSION['dang_nhap']['id_NV'];
                                        $q_thue = " SELECT cskh.*, kh.*, td.*
                                            FROM khachhang kh
                                            INNER JOIN ChamSocKhacHang cskh ON cskh.id_KH = kh.id_KH  
                                            INNER JOIN tiendo td ON td.id_KH = kh.id_KH 
                                            WHERE loaikhach = 0 AND cskh.id_NV = {$id_nv}";

                                        $r_thue = mysqli_query($dbc, $q_thue);
                                        confirm_query($r_thue, $q_thue); ?>
                                        <?php $count = 0;
                                        while ($khach_mua = mysqli_fetch_array($r_thue)): ?>
                                            <p>
                                                <button class="btn btn-primary" type="button" data-toggle="collapse"
                                                        data-target="#collapse-<?php echo $count ?>"
                                                        aria-expanded="false" aria-controls="collapseExample"
                                                        style="width: 100%; text-align: left">
                                                    <?php echo $khach_mua['ten_KH']; ?>
                                                </button>
                                            </p>

                                            <div class="collapse" id="collapse-<?php echo $count ?>">
                                                <div class="card card-block">
                                                    <div class="meta">
                                                        <p><span><?php echo $khach_mua['ten_KH']?>.</span></p>
                                                        <p>Email: <?php echo $khach_mua['email_KH']?>.</p>
                                                        <p>SDT: <?php echo $khach_mua['sdt_KH']?>.</p>
                                                        <p>Ngay nhan: <?php echo $khach_mua['sdt_KH']?>.</p>
                                                    </div>

                                                </div>
                                            </div>
                                        <?php $count++; endwhile; ?>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="tab-pane fade" id="mua" role="tabpanel"
                                         aria-labelledby="profile-tab">

                                        <?php
                                        $id_nv = $_SESSION['dang_nhap']['id_NV'];
                                        $q_thue = " SELECT cskh.*, kh.*, td.*
                                            FROM khachhang kh
                                            INNER JOIN ChamSocKhacHang cskh ON cskh.id_KH = kh.id_KH  
                                            INNER JOIN tiendo td ON td.id_KH = kh.id_KH 
                                            WHERE loaikhach = 1 AND cskh.id_NV = {$id_nv}";

                                        $r_thue = mysqli_query($dbc, $q_thue);
                                        confirm_query($r_thue, $q_thue); ?>
                                        <?php $count = 0;
                                        while ($khach_mua = mysqli_fetch_array($r_thue)): ?>
                                            <p>
                                                <button class="btn btn-primary" type="button" data-toggle="collapse"
                                                        data-target="#collapse-<?php echo $count ?>"
                                                        aria-expanded="false" aria-controls="collapseExample"
                                                        style="width: 100%; text-align: left">
                                                    <?php echo $khach_mua['ten_KH']; ?>
                                                </button>
                                            </p>

                                            <div class="collapse" id="collapse-<?php echo $count ?>">
                                                <div class="card card-block">
                                                    <div class="meta">
                                                        <p><span><?php echo $khach_mua['ten_KH']?>.</span></p>
                                                        <p>Email: <?php echo $khach_mua['email_KH']?>.</p>
                                                        <p>SDT: <?php echo $khach_mua['sdt_KH']?>.</p>
                                                    </div>

                                                </div>
                                            </div>
                                            <?php $count++; endwhile; ?>


                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="tab-pane fade" id="chot" role="tabpanel"
                                         aria-labelledby="dropdown1-tab">
                                        ...
                                    </div>
                                </div>

                            </div>
                            <!--/.tabs cham soc khach hang-->
                        </div><!---/.end cham soc khach hang-->
                    </div><!--/.content-admin-->
                </div>
            </div>
        </div>
    </div>
<?php include "includes/footer.php"; ?>