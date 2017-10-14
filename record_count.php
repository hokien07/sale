<?php
  session_start();
  include "includes/mysqli_connect.php";
  include "includes/function.php";
 ?>
<?php
$id_nv = $_SESSION['dang_nhap']['id_NV'];
$q = "SELECT * FROM ChamSocKhacHang WHERE id_NV = $id_nv ORDER BY id_cskh DESC";
$r = mysqli_query($dbc, $q);
confirm_query($r, $q);

if(mysqli_num_rows($r) > 0) {
    $row = mysqli_fetch_array($r);
      if($row['daxem'] == 0): ?>

      <div class="alert alert-warning alert-dismissible fade show" role="alert" style="position: fixed; top: 10px; right: 10px; width: 350px; height: 100px;">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
          <p style='font-weight: bold; font-size: 16px;'>Phần mềm quản lý nhân viên.</p>
          <p><a href="chitiet_khach_hang.php?id_kh=<?php echo $row['id_KH']; ?>">Bạn có thêm khách hàng mới</a></p>

      </div>
      <?php endif; ?>
<?php } ?>
