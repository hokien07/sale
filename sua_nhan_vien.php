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

                    <?php //lay thong tin nhan vien
                        if ((isset($_GET['id_nv']) && (filter_var($_GET['id_nv'], FILTER_VALIDATE_INT, array('min_range' => 1))))) {
                            $id_nv = $_GET['id_nv'];
                            $q = "SELECT * FROM nhanvien WHERE id_NV ={$id_nv}";
                            $r = mysqli_query($dbc, $q);
                            confirm_query($r, $q);
                            $nhanvien = mysqli_fetch_array($r);
                        } else {
                            // Neu CID va cat_name khong ton tai, hoac khong dung dinh dang mong muon
                            redirect_to('danhsachnhanvien.php');
                        }


                        //cap nhat thong tin nhan vien
                        if(isset($_POST['sua-nv'])) {

                            $ten_nv = mysqli_real_escape_string($dbc, strip_tags($_POST['ten-nv']));
                            $sdt_nv = mysqli_real_escape_string($dbc, strip_tags($_POST['sdt-nv']));
                            $email_nv = mysqli_real_escape_string($dbc, $_POST['email-nv']);
                            $diachi_nv = mysqli_real_escape_string($dbc, $_POST['diachi-nv']);
                            $cmnd_nv = mysqli_real_escape_string($dbc, $_POST['cmnd-nv']);
                            $ttthem_nv = mysqli_real_escape_string($dbc, $_POST['luuy-nv']);
                            $loai_user = mysqli_real_escape_string($dbc, $_POST['loai-user']);


                            //cap nhat vao nhan v
                            $q = "UPDATE nhanvien 
                                  SET ten_NV = '{$ten_nv}', sdt_NV= '{$sdt_nv}', email_NV = '{$email_nv}', mcnd_NV = '{$cmnd_nv}', diachi_NV = '{$diachi_nv}', ttthem_NV = '{$ttthem_nv}', loai_user = {$loai_user} 
                                  WHERE id_NV = $id_nv";
                            $r = mysqli_query($dbc, $q);
                            confirm_query($r, $q);

                            //cap nhat vao log.
                            $id_nv = $_SESSION['dang_nhap']['id_NV'];
                            $q_log = "INSERT INTO Log (id_NV, ngay, ghi_chu)  
                                      VALUES ($id_nv, NOW(), 'sửa nhân viên: {$nhanvien['ten_NV']} thành : {$ten_nv}')";
                            $r_log = mysqli_query($dbc, $q_log);
                            confirm_query($r_log,$q_log);

                            if (mysqli_affected_rows($dbc) == 1) {
                                $mes = "<p class='success'>Sửa Nhân Viên Thành Công!</p>";
                                sleep(5);
                                header("Location: danhsachnhanvien.php");
                            } else {
                                $mes = "<p class='warning'>Sửa Nhân Viên Không Thành Công. Vui lòng kiểm tra lại.</p>";
                            }

                        }//end main if condituon submit.
                    ?>
                    <h2 style="text-transform: uppercase; text-align: center; padding-top: 20px; font-weight: bold; padding-bottom: 20px">
                        Sửa Nhân Viên</h2>
                    <?php if(!empty($mes)) echo $mes; ?>
                    <form method="post">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="ho-ten">Họ & Tên</label>
                                <input type="text" name="ten-nv" placeholder="Nhập họ và tên nhân viên"
                                       class="form-control"
                                       value="<?php echo strip_tags($nhanvien['ten_NV']) ?>">
                            </div>

                            <div class="col-md-6 form-group">
                                <label>Số Điện Thoại Nhân Viên</label>
                                <input type="text" name="sdt-nv" placeholder="Nhập Số Điện Thoại Nhân Viên"
                                       class="form-control"
                                       value="<?php echo "0" .  strip_tags($nhanvien['sdt_NV']) ?>">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label>Email Nhân Viên</label>
                                <input type="email" name="email-nv" id="email-nv"
                                       placeholder="Nhập vào email nhân viên."
                                       class="form-control"
                                       value="<?php echo strip_tags($nhanvien['email_NV']) ?>">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>CMND Nhân Viên</label>
                                <input type="number" name="cmnd-nv" placeholder="Nhập vào số CMND Nhân Viên."
                                       class="form-control"
                                       value="<?php echo strip_tags($nhanvien['mcnd_NV']) ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="diachi">Địa chỉ nhân viên</label>
                            <textarea placeholder="Nhập địa chỉ nhân viên" rows="3"
                                      class="form-control" name="diachi-nv"
                                      value="<?php echo strip_tags($nhanvien['diachi_NV']) ?>"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="diachi">Thông Tin Thêm nhân viên</label>
                            <textarea placeholder="Lưu ý về nhân viên " rows="3"
                                      class="form-control" name="luuy-nv"
                                      value="<?php  echo strip_tags($nhanvien['ttthem_NV']) ?>"></textarea>
                        </div>

                        <div class="checkbox checkbox-circle">
                            <input id="checkbox7" type="checkbox" name="loai-user" checked = "checked" value="0">
                            <label for="checkbox7">Nhân Viên</label>

                            <input id="checkbox8" type="checkbox" name="loai-user" value="1">
                            <label for="checkbox8">Quản Lý</label>
                        </div>

                        <input type="submit" name="sua-nv" class="btn btn-lg btn-info" value="Cập Nhật Thông Nhân Viên">
                    </form>
                </div><!--/.content-admin-->
            </div>
        </div>
    </div>
<?php include "includes/footer.php"; ?>