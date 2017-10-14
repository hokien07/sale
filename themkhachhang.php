<?php
include "includes/header.php";
include('includes/mysqli_connect.php');
include('includes/function.php');
include "includes/top-header.php";
//check session co ton tai khong.
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
        //id nhan vien hien tai -- nha vien them khach hang.
        $id_nv_ht = $_SESSION['dang_nhap']['id_NV'];

        if (isset($_POST['submit'])) {


          $errors = array();
          if (empty($_POST['ten-kh'])) {
            $errors[] = "ten-kh";
          } else {
            $ten_kh = mysqli_real_escape_string($dbc, strip_tags($_POST['ten-kh']));
          }
          if (empty($_POST['sdt-kh'])) {
            $errors[] = "sdt-kh";
          } else {
            $sdt_kh = mysqli_real_escape_string($dbc, strip_tags($_POST['sdt-kh']));
          }

          if (empty($_POST['email-kh'])) {
            $errors[] = 'email-kh';
          } else {

            $email_kh = mysqli_real_escape_string($dbc, $_POST['email-kh']);

          }

          if (empty($_POST['diachi-kh'])) {
            $errors[] = 'diachi-kh';
          } else {
            $diachi_kh = mysqli_real_escape_string($dbc, $_POST['diachi-kh']);
          }

          if (empty($_POST['ttthem-kh'])) {
            $errors[] = 'ttthem-kh';
          } else {
            $ttthem_kh = mysqli_real_escape_string($dbc, $_POST['ttthem-kh']);
          }

          if(!isset($_POST['chon-nv'])) {
            $errors[] = 'chon-nv';
          }else {
            //id cua nhan vien cham soc khach hang.
            $id_nv_cs = $_POST['chon-nv'];
          }

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

          $id_nv = $_SESSION['dang_nhap']['id_NV'];
          if (empty($errors)) {
            //them khach hang vao bang khach hang.
            $q = "INSERT INTO khachhang
            (
              ten_KH,
              sdt_KH,
              email_KH,
              diachi_KH,
              ttthem_KH,
              ngay_them,
              loaikhach,
              id_NV
            )
            VALUES (
              '{$ten_kh}',
              '{$sdt_kh}',
              '{$email_kh}',
              '{$diachi_kh}',
              '{$ttthem_kh}',
              NOW(),
              {$loaikhach},
              $id_nv_ht
            )";

            $r = mysqli_query($dbc, $q);
            confirm_query($r, $q);

            //them vao bang cham so khach hang.
            $idKH = "SELECT id_KH FROM khachhang ORDER BY id_KH DESC";
            $r_idKH = mysqli_query($dbc, $idKH);
            confirm_query($r_idKH, $idKH);
            $row_kh= mysqli_fetch_array($r_idKH);
            $id_KH = $row_kh['id_KH'];

            $qcskh = "INSERT INTO ChamSocKhacHang
            (id_KH, id_NV, ngay, daxem)
            VALUES ($id_KH, $id_nv_cs, NOW(), 0)";
            $r_cskh = mysqli_query($dbc, $qcskh);
            confirm_query($r_cskh, $qcskh);

            //cap nhat vao log.
            $id_nv = $_SESSION['dang_nhap']['id_NV'];
            $q_log = "INSERT INTO Log (id_NV, ngay, ghi_chu)
            VALUES ($id_nv, NOW(), 'thêm khách hàng: {$ten_kh}')";
            $r_log = mysqli_query($dbc, $q_log);
            confirm_query($r_log,$q_log);

            //kiem tra xem da them thnanh cong
            if (mysqli_affected_rows($dbc) == 1) {
              $mes = "<p class='success'>Thêm Khách Hàng Thành Công!</p>";
              header("Location: danhsachkhachhang.php");
            } else {
              $mes = "<p class='warning'>Thêm Khách Hàng Không Thành Công. Vui lòng kiểm tra lại.</p>";
            }
          } else {
            $mes = "<p class='warning'> Vui Lòng Nhập Đầy Đủ Thông Tin.";
          }


        }//end main if condituon submit.

        ?>

        <h1 class="well" style="text-transform: uppercase; text-align: center; padding-top: 20px; font-weight: bold; padding-bottom: 20px">Thêm Khách Hàng Mới</h1>

        <?php if (isset($mes)) echo $mes; ?>

        <form method="post">
          <div class="row">
            <div class="col-md-6 form-group">
              <label for="ho-ten-kh">Họ & Tên
                <?php
                if (isset($errors) && in_array("ten-kh", $errors, true)) {
                  echo "<p class='warning'>Vui lòng nhập họ tên. </p>";
                }

                ?>
              </label>
              <input type="text" name="ten-kh" id="ten-kh" placeholder="Nhập họ và tên khách hàng"
              class="form-control" value="<?php if(isset($_POST['ten-kh']))echo strip_tags($_POST['ten-kh']) ?>">
            </div>

            <div class="col-md-6 form-group">
              <label for="sdt-kh">Số Điện Thoại Khách Hàng
                <?php
                if (isset($errors) && in_array("sdt-kh", $errors, true)) {
                  echo "<p class='warning'>Vui lòng nhập họ tên. </p>";
                }

                ?>
              </label>
              <input type="text" name="sdt-kh" id="sdt-kh" placeholder="Nhập Số Điện Thoại Khách Hàng"
              class="form-control" value="<?php if(isset($_POST['sdt-kh']))echo strip_tags($_POST['sdt-kh']) ?>">
            </div>
          </div>


          <div class="form-group">
            <label for="email-kh">Email Khách Hàng
              <?php
              if (isset($errors) && in_array("email-kh", $errors, true)) {
                echo "<p class='warning'>Vui lòng nhập Email. </p>";
              }

              if(isset($email_mes)) echo $email_mes;

              ?>
            </label>
            <input type="email" name="email-kh" id="email-kh" placeholder="Nhập vào email Khách Hàng"
            class="form-control" value="<?php if(isset($_POST['email-kh']))echo strip_tags($_POST['email-kh']) ?>">
          </div>

          <div class="form-group">
            <label for="diachi-kh">Địa chỉ Khách Hàng
              <?php
              if (isset($errors) && in_array("diachi-kh", $errors, true)) {
                echo "<p class='warning'>Vui lòng nhập địa chỉ. </p>";
              }

              ?>
            </label>
            <textarea name="diachi-kh" id="diachi-kh" placeholder="Nhập địa chỉ khách hàng" rows="3"
            class="form-control" value="<?php if(isset($_POST['diachi-kh']))echo strip_tags($_POST['diachi-kh']) ?>"></textarea>
          </div>

          <div class="form-group">
            <label for="ttthem-kh">Thông Tin Thêm Khách Hàng
              <?php
              if (isset($errors) && in_array("ttthem-kh", $errors, true)) {
                echo "<p class='warning'>Vui lòng nhập thông tin thêm khách hàng. </p>";
              }

              ?>
            </label>
            <textarea name="ttthem-kh" id="ttthem-kh" placeholder="Thông tin thêm khách hàng" rows="3"
            class="form-control" value="<?php if(isset($_POST['ttthem-kh']))echo strip_tags($_POST['ttthem-kh']) ?>"></textarea>
          </div>

          <div class="row">
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
              <input type="submit" name="submit" class="btn btn-lg btn-info" value="Thêm Khách Hàng">
            </div>
          </div>
        </form>
      </div><!--/.content-->
    </div>
  </div>
</div>

<?php include "includes/footer.php"; ?>
