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
                    if ((isset($_GET['id_kh']) && (filter_var($_GET['id_kh'], FILTER_VALIDATE_INT, array('min_range' => 1))))) {
                        $id_kh = $_GET['id_kh'];
                        $q = "SELECT * FROM khachhang WHERE id_KH ={$id_kh}";
                        $r = mysqli_query($dbc, $q);
                        confirm_query($r, $q);
                        $khachhang = mysqli_fetch_array($r);
                    } else {
                        // Neu CID va cat_name khong ton tai, hoac khong dung dinh dang mong muon
                        redirect_to('danhsachnhanvien.php');
                    }


                    //cap nhat thong tin nhan vien
                    if(isset($_POST['sua-kh'])) {

                        $ten_kh = mysqli_real_escape_string($dbc, strip_tags($_POST['ten-kh']));
                        $sdt_kh = mysqli_real_escape_string($dbc, strip_tags($_POST['sdt-kh']));
                        $email_kh = mysqli_real_escape_string($dbc, $_POST['email-kh']);
                        $diachi_kh = mysqli_real_escape_string($dbc, $_POST['diachi-kh']);
                        $ttthem_kh = mysqli_real_escape_string($dbc, $_POST['ttthem-kh']);

                        //kiểm tra chọn loại khách
                        if(!isset($_POST['loaikh'])){
                          $errors[]= 'loaikhach';
                        }else{
                          if($_POST['loaikh'] == 'mua'){
                              $loaikhach = 0;
                          }elseif($_POST['loaikh'] == 'thue'){
                              $loaikhach = 1;
                          }else {
                              $loaikhach = 2;
                          }
                        }
                        if($_SESSION['dang_nhap']['loai_user'] == 1){
                          //kiểm tra chọn nhân viên cho khách
                          if(!isset($_POST['chon-nv'])){
                            $errors[]= 'chon-nv';
                          }else{
                            $id_nv = $_POST['chon-nv'];
                          }
                        }else {
                          $id_nv = $_SESSION['dang_nhap']['id_NV'];
                        }

                        $q = "UPDATE khachhang
                              SET
                                ten_KH = '{$ten_kh}',
                                sdt_KH= '{$sdt_kh}',
                                email_KH = '{$email_kh}',
                                diachi_KH = '{$diachi_kh}',
                                ttthem_KH = '{$ttthem_kh}',
                                loaikhach = {$loaikhach},
                                id_NV = {$id_nv}
                              WHERE id_KH = $id_kh";

                        $r = mysqli_query($dbc, $q);
                        confirm_query($r, $q);

                        //cap nhat vao log.
                        $id_nv = $_SESSION['dang_nhap']['id_NV'];
                        $q_log = "INSERT INTO Log (id_NV, ngay, ghi_chu)
                                      VALUES ($id_nv, NOW(), 'sửa khách hàng: {$khachhang['ten_KH']} thành : {$ten_kh}')";
                        $r_log = mysqli_query($dbc, $q_log);
                        confirm_query($r_log,$q_log);


                        if (mysqli_affected_rows($dbc) == 1) {
                            $mes = "<p class='success'>Sửa Khách Hàng Thành Công!</p>";
                            if($_SESSION['dang_nhap']['loai_user'] == 1){
                              header("location:danhsachkhachhang.php");
                            }else {
                              header("location:nv_dskh.php");
                            }
                        } else {
                            $mes = "<p class='warning'>Sửa Khách Hàng Không Thành Công. Vui lòng kiểm tra lại.</p>";
                        }

                    }//end main if condituon submit.
                    ?>
                    <h2 style="text-transform: uppercase; text-align: center; padding-top: 20px; font-weight: bold; padding-bottom: 20px">
                        Sửa Khách Hàng</h2>
                    <?php if(!empty($mes)) echo $mes; ?>
                    <form method="post">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="ho-ten">Họ & Tên</label>
                                <input type="text" name="ten-kh" placeholder="Nhập họ và tên khách hàng"
                                       class="form-control"
                                       value="<?php echo strip_tags($khachhang['ten_KH']) ?>">
                            </div>

                            <div class="col-md-6 form-group">
                                <label>Số Điện Thoại Khách Hàng</label>
                                <input type="text" name="sdt-kh" placeholder="Nhập Số Điện Thoại khách hàng"
                                       class="form-control"
                                       value="<?php echo strip_tags($khachhang['sdt_KH']) ?>">
                            </div>
                        </div>


                        <div class="form-group">
                            <label>Email Khách Hàng</label>
                            <input type="email" name="email-kh" id="email-kh"
                                   placeholder="Nhập vào email khách hàng."
                                   class="form-control"
                                   value="<?php echo strip_tags($khachhang['email_KH']) ?>">
                        </div>


                        <div class="form-group">
                            <label for="diachi">Địa chỉ khách hàng</label>
                            <textarea placeholder="Nhập địa chỉ khách hàng" rows="3"
                                      class="form-control" name="diachi-kh"
                                      value="<?php echo strip_tags($khachhang['diachi_KH']) ?>"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="diachi">Lưu Ý Khách Hàng</label>
                            <textarea placeholder="Lưu Ý Khách Hàng " rows="3"
                                      class="form-control" name="ttthem-kh"
                                      value="<?php  echo strip_tags($khachhang['ttthem_KH']) ?>"></textarea>
                        </div>

                        <div class="row">
                            <?php if($_SESSION['dang_nhap']['loai_user'] == 1): ?>
                              <div class="col-md-4" style="margin-bottom: 10px;">
                                  <select name="chon-nv" id="chon-nv" style="height: 40px; width: 100%;">
                                      <option>Chọn Nhân Viên</option>
                                      <?php
                                      $nv = "SELECT id_NV, ten_NV FROM nhanvien";
                                      $r_nv = mysqli_query($dbc, $nv);
                                      confirm_query($r_nv, $nv);
                                      while($soNhanVien = mysqli_fetch_array($r_nv)) {
                                          echo"<option value='{$soNhanVien['id_NV']}'> " .$soNhanVien['ten_NV']. "</option>";
                                      }
                                      ?>
                                  </select>
                              </div>
                          <?php endif; ?>

                            <div class="col-md-4">
                              <?php if (isset($errors) && in_array("loaikhach", $errors, true)) {
                                  echo "<p class='warning'>Chưa chọn loại khách</p>";
                              }?>
                                  <div class="checkbox checkbox-circle">
                                    <input id="checkbox7" type="checkbox" name="loaikh" value="thue">
                                    <label for="checkbox7">Khách Thuê</label>


                                    <input id="checkbox8" type="checkbox" name="loaikh" value="mua">
                                    <label for="checkbox8">Khách Mua</label>

                                    <input id="checkbox9" type="checkbox" name="loaikh" value="chuyen">
                                    <label for="checkbox9">Chuyển Nhưỡng</label>
                                  </div>
                            </div>

                            <div class="col-md-4">
                                <input type="submit" name="sua-kh" class="btn btn-lg btn-info" value="Cập nhật">
                            </div>
                        </div>
                    </form>
                </div><!--/.content-admin-->
            </div>
        </div>
    </div>
<?php include "includes/footer.php"; ?>
