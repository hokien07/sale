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
        <div class="them-nhan-vien">
            <div class="content"><!--form thêm nhân viên-->
                <?php
                if (isset($_POST['submit'])) {
                    $errors = array();
                    if (empty($_POST['ten-nv'])) {
                        $errors[] = "ten-nv";
                    } else {
                        $ten_nv = mysqli_real_escape_string($dbc, strip_tags($_POST['ten-nv']));
                    }
                    if (empty($_POST['sdt-nv'])) {
                        $errors[] = "sdt-nv";
                    } else {
                        $sdt_nv = mysqli_real_escape_string($dbc, strip_tags($_POST['sdt-nv']));
                    }

                    if (empty($_POST['email-nv'])) {
                        $errors[] = 'email-nv';
                    } else {
                        $email_nv = mysqli_real_escape_string($dbc, $_POST['email-nv']);
                    }

                    if (empty($_POST['diachi-nv'])) {
                        $errors[] = 'diachi-nv';
                    } else {
                        $diachi_nv = mysqli_real_escape_string($dbc, $_POST['diachi-nv']);
                    }

                    if (empty($_POST['cmnd-nv'])) {
                        $errors[] = 'cmnd-nv';
                    } else {
                        $cmnd_nv = mysqli_real_escape_string($dbc, $_POST['cmnd-nv']);
                    }

                    if (empty($_POST['luuy-nv'])) {
                        $errors[] = 'luuy-nv';
                    } else {
                        $ttthem_nv = mysqli_real_escape_string($dbc, $_POST['luuy-nv']);
                    }

                    if(isset($_POST['loai-user'])) {
                        if($_POST['loai-user'] == 0){
                            $loai_user = 0;
                        }else {
                            $loai_user = 1;
                        }
                    }

                    if (empty($errors)) {

                        //them moi nhan vien.
                        $q = "INSERT INTO nhanvien (ten_NV, sdt_NV, email_NV, mcnd_NV, diachi_NV, ttthem_NV, loai_user)
                        VALUES ('{$ten_nv}', '0{$sdt_nv}', '{$email_nv}', '{$cmnd_nv}', '{$diachi_nv}','{$ttthem_nv}', {$loai_user})";
                        $r = mysqli_query($dbc, $q);
                        confirm_query($r, $q);

                        //cap nhat vao log.
                        $id_nv = $_SESSION['dang_nhap']['id_NV'];
                        $q_log = "INSERT INTO Log (id_NV, ngay, ghi_chu)
                                  VALUES ($id_nv, NOW(), 'thêm nhân viên: {$ten_nv}')";
                        $r_log = mysqli_query($dbc, $q_log);
                        confirm_query($r_log,$q_log);

                        if (mysqli_affected_rows($dbc) == 1) {
                            $mes = "<p class='success'>Thêm Nhân Viên Thành Công!</p>";
                            header("Location: danhsachnhanvien.php");
                        } else {
                            $mes = "<p class='warning'>Thêm Nhân Viên Không Thành Công. Vui lòng kiểm tra lại.</p>";
                        }
                    } else {
                        $mes = "<p class='warning'> Vui Lòng Nhập Đầy Đủ Thông Tin.";
                    }


                }//end main if condituon submit.

                ?>

                <h1 class="well"
                    style="text-transform: uppercase; text-align: center; padding-top: 20px; font-weight: bold; padding-bottom: 20px">
                    Thêm Nhân Viên Mới</h1>
                <?php if (isset($mes)) echo $mes; ?>

                <form method="post">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="ho-ten">Họ & Tên
                                <?php
                                if (isset($errors) && in_array("ten-nv", $errors, true)) {
                                    echo "<p class='warning'>Vui lòng nhập họ tên. </p>";
                                }

                                ?>
                            </label>
                            <input type="text" name="ten-nv" placeholder="Nhập họ và tên nhân viên"
                                   class="form-control"
                                   value="<?php if (isset($_POST['ten-nv'])) echo strip_tags($_POST['ten-nv']) ?>">
                        </div>

                        <div class="col-md-6 form-group">
                            <label>Số Điện Thoại Nhân Viên
                                <?php
                                if (isset($errors) && in_array("sdt-nv", $errors, true)) {
                                    echo "<p class='warning'>Vui lòng nhập số điện thoại. </p>";
                                }

                                ?>
                            </label>
                            <input type="text" name="sdt-nv" placeholder="Nhập Số Điện Thoại Nhân Viên"
                                   class="form-control"
                                   value="<?php if (isset($_POST['sdt-nv'])) echo strip_tags($_POST['sdt-nv']) ?>">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Email Nhân Viên
                                <?php
                                if (isset($errors) && in_array("email-nv", $errors, true)) {
                                    echo "<p class='warning'>Vui lòng nhập Email. </p>";
                                }

                                ?>
                            </label>
                            <input type="email" name="email-nv" id="email-nv"
                                   placeholder="Nhập vào email nhân viên."
                                   class="form-control"
                                   value="<?php if (isset($_POST['email-nv'])) echo strip_tags($_POST['email-nv']) ?>">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>CMND Nhân Viên
                                <?php
                                if (isset($errors) && in_array("cmnd-nv", $errors, true)) {
                                    echo "<p class='warning'>Vui lòng nhập CMND. </p>";
                                }

                                ?>
                            </label>
                            <input type="text" name="cmnd-nv" placeholder="Nhập vào số CMND Nhân Viên."
                                   class="form-control"
                                   value="<?php if (isset($_POST['cmnd-nv'])) echo strip_tags($_POST['cmnd-nv']) ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="diachi">Địa chỉ nhân viên
                            <?php
                            if (isset($errors) && in_array("diachi-nv", $errors, true)) {
                                echo "<p class='warning'>Vui lòng nhập Địa Chỉ. </p>";
                            }

                            ?>
                        </label>
                        <textarea placeholder="Nhập địa chỉ nhân viên" rows="3"
                                  class="form-control" name="diachi-nv"
                                  value="<?php if (isset($_POST['diachi-nv'])) echo strip_tags($_POST['diachi-nv']) ?>"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="diachi">Thông Tin Thêm nhân viên
                            <?php
                            if (isset($errors) && in_array("luuy-nv", $errors, true)) {
                                echo "<p class='warning'>Vui lòng nhập chi tiết nhân viên. </p>";
                            }

                            ?>
                        </label>
                        <textarea placeholder="Lưu ý về nhân viên " rows="3"
                                  class="form-control" name="luuy-nv"
                                  value="<?php if (isset($_POST['luuy-nv'])) echo strip_tags($_POST['luuy-nv']) ?>"></textarea>
                    </div>
                    <div class="checkbox checkbox-circle">
                        <input id="checkbox7" type="checkbox" name="loai-user" checked = "checked" value="0">
                        <label for="checkbox7">Nhân Viên</label>

                        <input id="checkbox8" type="checkbox" name="loai-user" value="1">
                        <label for="checkbox8">Quản Lý</label>
                    </div>

                    <input type="submit" name="submit" class="btn btn-lg btn-info" value="Thêm Nhân Viên">
                </form>
            </div><!--/.content-->
        </div>
    </div>
</div>

<?php include "includes/footer.php"; ?>
