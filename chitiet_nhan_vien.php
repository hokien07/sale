<?php include "includes/header.php"; ?>
<?php include('includes/mysqli_connect.php'); ?>
<?php include('includes/function.php'); ?>
<?php include "includes/top-header.php"; ?>
<?php
if(empty($_SESSION)) {
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
                <?php
                if ((isset($_GET['id_nv']) && (filter_var($_GET['id_nv'], FILTER_VALIDATE_INT, array('min_range' => 1))))) {
                    $id_nv = $_GET['id_nv'];
                    $q = "SELECT * FROM nhanvien WHERE id_NV ={$id_nv}";
                    $r = mysqli_query($dbc, $q);
                    confirm_query($r, $q);
                    $nhanvien = mysqli_fetch_array($r);
                } else {
                    // Neu CID va cat_name khong ton tai, hoac khong dung dinh dang mong muon
                    header("location:danhsachnhanvien.php");
                }
                ?>
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title"></h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-3 col-lg-3 " align="center">
                                <?php
                                if (isset($_GET['id_nv'])) {
                                    $id_nv = $_GET['id_nv'];
                                    $q_avatar = "SELECT avatar FROM nhanvien WHERE id_NV = {$id_nv}";
                                    $r_avatar = mysqli_query($dbc, $q_avatar);
                                    confirm_query($r_avatar, $q_avatar);
                                    $hinh = mysqli_fetch_array($r_avatar);
                                } else {
                                    $q_avatar = "SELECT avatar FROM nhanvien WHERE id_NV = {$_SESSION['dang_nhap']['id_NV']}";
                                    $r_avatar = mysqli_query($dbc, $q_avatar);
                                    confirm_query($r_avatar, $q_avatar);
                                    $hinh = mysqli_fetch_array($r_avatar);
                                }

                                ?>

                                <form action="upload.php" method="post" enctype="multipart/form-data">
                                    <fieldset>
                                        <legend>Avatar</legend>
                                        <img class="img-responsive center-block avatar"
                                             src="upload\<?php echo $hinh['avatar'] ?>" alt="avatar" width="150"
                                             height="150">
                                        <input type="hidden" name="MAX_FILE_SIZE" value="524288">
                                        <input type="file" name="image">
                                        <input class="btn btn-success" type="submit" name="upload" value="Thay avartar"
                                               style="margin-top: 10px;">

                                    </fieldset>
                                </form>
                            </div>
                            <div class="col-md-1"></div>

                            <div class=" col-md-8 col-lg-8 ">
                                <div class="table-responsive" style="overflow-x:auto;">


                                    <table class="table table-user-information">
                                        <tbody>
                                        <tr>
                                            <td>Họ & Tên</td>
                                            <td><?php echo $nhanvien['ten_NV'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>Số Điện Thoại</td>
                                            <td><?php echo $nhanvien['sdt_NV'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>Email</td>
                                            <td>
                                                <a href="mailto:<?php echo $nhanvien['email_NV'] ?>"><?php echo $nhanvien['email_NV'] ?></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Số CMND</td>
                                            <td><?php echo $nhanvien['mcnd_NV'] ?></td>
                                        </tr>

                                        <tr>
                                        <tr>
                                            <td>Địa Chỉ</td>
                                            <td><?php echo $nhanvien['diachi_NV'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>Thông Tin Thêm</td>
                                            <td><?php echo $nhanvien['ttthem_NV'] ?></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                echo " <a href='doimatkhau.php?id_nv={$id_nv}' class='btn btn-danger'>Đổi Mật Khẩu</a>";
                ?>

            </div><!--/.content-admin-->
        </div>
    </div>
</div>
<?php include "includes/footer.php"; ?>













