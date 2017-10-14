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
          if (empty($_POST['ten-hang'])) {
            $errors[] = "ten-hang";
          } else {
            $ten_hang = mysqli_real_escape_string($dbc, strip_tags($_POST['ten-hang']));
          }
          if (empty($_POST['ma-hang'])) {
            $errors[] = "ma-hang";
          } else {
            $ma_hang = mysqli_real_escape_string($dbc, strip_tags($_POST['ma-hang']));
          }

          if (empty($_POST['dtich-hang'])) {
            $errors[] = 'dtich-hang';
          } else {
            $dtich_hang = mysqli_real_escape_string($dbc, $_POST['dtich-hang']);
          }

          if (empty($_POST['sluong-hang'])) {
            $errors[] = 'sluong-hang';
          } else {
            $sluong_hang = mysqli_real_escape_string($dbc, $_POST['sluong-hang']);
          }


          if (empty($_POST['ttthem-hang'])) {
            $errors[] = 'ttthem-hang';
          } else {
            $ttthem_hang = mysqli_real_escape_string($dbc, $_POST['ttthem-hang']);
          }

          if (empty($errors)) {
            //them loai hang
            $q = "INSERT INTO Hang (ma_hang, ten_hang, dtich_hang, sluong_hang, ttthem_hang)
            VALUES ('{$ten_hang}', '{$ma_hang}', '{$dtich_hang}', '{$sluong_hang}', '{$ttthem_hang}')";
            $r = mysqli_query($dbc, $q);
            confirm_query($r, $q);

            //cap nhat vao log.
            $id_nv = $_SESSION['dang_nhap']['id_NV'];
            $q_log = "INSERT INTO Log (id_NV, ngay, ghi_chu)
            VALUES ($id_nv, NOW(), 'thêm loại hàng: { $ten_hang}')";
            $r_log = mysqli_query($dbc, $q_log);
            confirm_query($r_log,$q_log);


            if (mysqli_affected_rows($dbc) == 1) {
              $mes = "<p class='success'>Thêm Nhân Viên Thành Công!</p>";
                sleep(5);
                header("Location: danhsachloaihangphp");
            } else {
              $mes = "<p class='warning'>Thêm Nhân Viên Không Thành Công. Vui lòng kiểm tra lại.</p>";
            }
          } else {
            $mes = "<p class='warning'> Vui Lòng Nhập Đầy Đủ Thông Tin.";
          }


        }//end main if condituon submit.

        ?>
        <h1 class="well" style="text-transform: uppercase; text-align: center; padding-top: 20px; font-weight: bold; padding-bottom: 20px">Thêm Loại Hàng Mới</h1>
        <?php if (isset($mes)) echo $mes; ?>
        <form method="post">
          <div class="row">
            <div class="col-md-6 form-group">
              <label for="ten-hang">Tên Loại Hàng
                <?php
                if (isset($errors) && in_array("ten-hang", $errors, true)) {
                  echo "<p class='warning'>Vui lòng nhập tên hàng. </p>";
                }

                ?>
              </label>
              <input type="text" placeholder="Nhập tên hàng"
              class="form-control" name="ten-hang" id="ten-hang" value="<?php if(isset($_POST['ten-hang']))echo strip_tags($_POST['ten-hang']) ?>">
            </div>

            <div class="col-md-6 form-group">
              <label for="ma-hang">Mã Hàng
                <?php
                if (isset($errors) && in_array("ma-hang", $errors, true)) {
                  echo "<p class='warning'>Vui lòng nhập mã hàng. </p>";
                }

                ?>
              </label>
              <input type="text" placeholder="Nhập mã hàng"
              class="form-control" name="ma-hang" id="ma-hang" value="<?php if(isset($_POST['ma-hang']))echo strip_tags($_POST['ma-hang']) ?>">
            </div>
          </div>

          <div class="row">
            <div class="col-md-6 form-group">
              <label for="dien-tich-hang">Diện Tích Hàng
                <?php
                if (isset($errors) && in_array("dtich-hang", $errors, true)) {
                  echo "<p class='warning'>Vui lòng nhập diện tích hàng. </p>";
                }

                ?>
              </label>
              <input type="text" name="dtich-hang" id="dtich-hang" placeholder="Nhập diện tích hàng"
              class="form-control" value="<?php if(isset($_POST['dtich-hang']))echo strip_tags($_POST['dtich-hang']) ?>">
            </div>

            <div class="col-md-6 form-group">
              <label for="so-luong-hang">Số Lượng Hàng
                <?php
                if (isset($errors) && in_array("sluong-hang", $errors, true)) {
                  echo "<p class='warning'>Vui lòng nhập số lượng hàng. </p>";
                }

                ?>
              </label>
              <input type="text" name="sluong-hang" id="sluong-hang" placeholder="Nhập số lượng hàng"
              class="form-control" value="<?php if(isset($_POST['sluong-hang']))echo strip_tags($_POST['sluong-hang']) ?>">
            </div>
          </div>

          <div class="form-group">
            <label for="thong-tin-them-hang">Thông Tin Thêm Hàng
              <?php
              if (isset($errors) && in_array("ttthem-hang", $errors, true)) {
                echo "<p class='warning'>Vui lòng nhập số lượng hàng. </p>";
              }

              ?>
            </label>
            <textarea placeholder="Thông tin thêm hàng" rows="3"
            class="form-control" name="ttthem-hang" id="ttthem-hang" value="<?php if(isset($_POST['ttthem-hang']))echo strip_tags($_POST['ttthem-hang']) ?>"></textarea>
          </div>


          <input type="submit" name="submit" class="btn btn-lg btn-info" value="Thêm Loại Hàng">
        </form>
      </div><!--/.content-->
    </div>
  </div>
</div>

<?php include "includes/footer.php"; ?>
