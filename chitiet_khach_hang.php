<?php
include ("includes/header.php");
include("includes/mysqli_connect.php");
include("includes/function.php");
include ("includes/top-header.php");
if(empty($_SESSION)) {
  header('location:index.php');
}

//cap nhat lai khach hang khi nhan vien da xem
$id_nv = $_SESSION['dang_nhap']['id_NV'];
$id_kh = $_GET['id_kh'];
//cap nhat lại tinh trang xem khach hang.
$q_daxem = "UPDATE ChamSocKhacHang SET daxem = 1 WHERE id_NV = $id_nv AND id_KH = $id_kh";
$r_daxem = mysqli_query($dbc, $q_daxem);
confirm_query($r_daxem, $q_daxem);
?>
<div class="row">
  <div class="col-md-3">
    <?php include "includes/sidebar.php"; ?>
  </div>
  <div class="col-md-9">
    <div class="content">
      <?php
      //get id cua khach hang
      if ((isset($_GET['id_kh']) && (filter_var($_GET['id_kh'], FILTER_VALIDATE_INT, array('min_range' => 1))))) {
        $id_kh = $_GET['id_kh'];
        $q = "SELECT * FROM khachhang WHERE id_KH ={$id_kh}";
        $r = mysqli_query($dbc, $q);
        confirm_query($r, $q);
        $khachhang = mysqli_fetch_array($r);
      } else {
        header("location:danhsachkhachhang.php");
      }
      ?>
      <div class="panel panel-info">
        <div class="panel-heading">
          <h3 class="panel-title"></h3>
        </div>
        <div class="panel-body">
          <div class="table-responsive" style="overflow-x:auto;">

            <table class="table table-user-information">
              <tbody>
                <tr>
                  <td>Họ & Tên</td>
                  <td><?php echo $khachhang['ten_KH'] ?></td>
                </tr>
                <tr>
                  <td>Số Điện Thoại</td>
                  <td><?php echo "0".$khachhang['sdt_KH'] ?></td>
                </tr>
                <tr>
                  <td>Email</td>
                  <td><?php echo $khachhang['email_KH'] ?></td>
                </tr>
                <tr>
                  <td>Địa Chỉ</td>
                  <td><?php echo $khachhang['diachi_KH'] ?></td>
                </tr>
                <tr>
                  <td>Nhu Cầu</td>
                  <td><?php echo $khachhang['ttthem_KH'] ?></td>
                </tr>
              </tbody>
            </table>
          </div>

          <div class="row">
              <!--cạp nhật thông tin khách hàng-->
              <div class="col-md-3">
                  <a class="btn btn-success" href="nv_cskh.php?id_nv=<?php echo $_SESSION['dang_nhap']['id_NV']; ?>&id_kh=<?php echo $id_kh ?>"> Cập nhật mới</a>
              </div>
              <div class="col-md-3">
                  <a class="btn btn-danger" href="chot_khach.php?id_kh=<?php echo $id_kh ?>"> Chốt khách</a>
              </div>

          </div>
        </div>
      </div>
    </div><!--/.content-admin-->
  </div>
</div>
<?php include "includes/footer.php"; ?>
