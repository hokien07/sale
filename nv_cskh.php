<?php
include "includes/header.php";
include('includes/mysqli_connect.php');
include('includes/function.php');
include "includes/top-header.php";
if(empty($_SESSION)) {
  header('location:index.php');
}
?>

<div class="row">
    <div class="col-md-3">
      <?php include "includes/sidebar.php"; ?>
    </div>

    <div class="col-md-9">
      <div class="content">

        <?php //lay thong tin nhan vien
        if ((isset($_GET['id_kh'], $_GET['id_nv'])) && (filter_var($_GET['id_kh'], FILTER_VALIDATE_INT, array('min_range' => 1)))) {
          $id_kh = $_GET['id_kh'];
          $id_nv = $_GET['id_nv'];

          $q = "SELECT * FROM ChamSocKhacHang WHERE id_KH ={$id_kh} AND id_NV = {$id_nv}";
          $r = mysqli_query($dbc, $q);
          confirm_query($r, $q);
          $khachhang = mysqli_fetch_array($r);
        } else {
          // Neu CID va cat_name khong ton tai, hoac khong dung dinh dang mong muon
          header("location:admin.php");
        }


        //cap nhat cham soc khach hang
        if(isset($_POST['sua-kh'])) {
          //cap nhat vao tien do
          $cskh = mysqli_real_escape_string($dbc, $_POST['cskh']);
          $phkh = mysqli_real_escape_string($dbc, $_POST['phkh']);

          $q = "INSERT INTO tiendo (id_KH, id_NV, tuong_tac, phan_hoi, date) VALUES ({$id_kh}, {$id_nv}, '{$cskh}', '{$phkh}', NOW())";
          $r = mysqli_query($dbc, $q);
          confirm_query($r, $q);

          //cap nhat da cham soc
          $q_khach_dcs = "UPDATE khachhang SET cs = 1 WHERE id_KH = $id_kh";
          $r_khach_dcs =  mysqli_query($dbc, $q_khach_dcs);
          confirm_query( $r_khach_dcs, $q_khach_dcs);


          //cap nhat loại khach hang neu khach khong co nhu cau
          if(isset($_POST['khach'])){
            $q_update_khach = "UPDATE khachhang SET loaikhach = 4 WHERE id_KH = $id_kh";
            $r_upate_khach =  mysqli_query($dbc, $q_update_khach);
            confirm_query($r_upate_khach, $q_update_khach);
          }

          //cap nhat vao chm soc moi nhat.
          $q_csmn = "SELECT id_moinhat FROM csMoiNhat WHERE id_NV = $id_nv AND id_KH = $id_kh";
          $r_csmn = mysqli_query($dbc, $q_csmn);
          confirm_query($r_csmn, $q_csmn);
          if(mysqli_num_rows($r_csmn) == 0) {
            $qMoiNhat = "INSERT INTO csMoiNhat (id_KH, id_NV, csTuongTac, csPhanHoi, csNgay) VALUES ({$id_kh}, {$id_nv}, '{$cskh}', '{$phkh}', NOW())";
          }else {
            $qMoiNhat = "UPDATE csMoiNhat
            SET id_KH = {$id_kh},
            id_NV = {$id_nv},
            csTuongTac = '{$cskh}',
            csPhanHoi = '{$phkh}',
            csNgay = NOW()";
          }
          $rMoiNhat = mysqli_query($dbc, $qMoiNhat);
          confirm_query($rMoiNhat, $qMoiNhat);


          if (mysqli_affected_rows($dbc) == 1) {
            $mes = "<p class='success'>Cập nhật thành công!</p>";
            header("location:chamsockhachhang.php");
          } else {
            $mes = "<p class='warning'>Cập nhật không thành công. Vui lòng kiểm tra lại.</p>";
          }
        }//end main if condituon submit.
        ?>
        <h2 style="text-transform: uppercase; text-align: center; padding-top: 20px; font-weight: bold; padding-bottom: 20px">Chăm Sóc Khách hàng</h2>
        <?php if(!empty($mes)) echo $mes; ?>

        <?php
        $q_ttk ="SELECT ten_KH FROM khachhang WHERE id_KH = $id_kh";
        $r_ttk = mysqli_query($dbc, $q_ttk);
        confirm_query($r_ttk, $q_ttk);
        $ten_khach = mysqli_fetch_array($r_ttk);
        ?>
        <h3>khách hàng: <strong><?php echo $ten_khach ['ten_KH']; ?></strong></h3>
        <form method="post">

          <div class="form-group">
            <label for="tuong_tac">Nhu Cầu</label>
            <textarea placeholder="Hoạt động của nhân viên" rows="3"
            class="form-control" name="cskh"
            value=""></textarea>

          </div>

          <div class="form-group">
            <label for="phan_hoi">Phản hồi của khách hàng</label>
            <textarea placeholder="phản hồi của khách hàng" rows="3"
            class="form-control" name="phkh"
            value=""></textarea>
          </div>

          <div class="checkbox checkbox-circle">
            <input id="checkbox7" type="checkbox" name="khach" value="khach_dis">
            <label for="checkbox7">khách không có nhu cầu</label>
          </div>
        </div>
        <input type="submit" name="sua-kh" class="btn btn-lg btn-info" value="Cập Nhật">
      </form>
    </div><!--/.content-admin-->
  </div>

<?php include "includes/footer.php"; ?>
