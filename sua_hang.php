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
                    if ((isset($_GET['id_hang']) && (filter_var($_GET['id_hang'], FILTER_VALIDATE_INT, array('min_range' => 1))))) {
                        $id_hang = $_GET['id_hang'];
                        $q = "SELECT * FROM Hang WHERE id_hang ={$id_hang}";
                        $r = mysqli_query($dbc, $q);
                        confirm_query($r, $q);
                        $hang = mysqli_fetch_array($r);
                    } else {
                        // Neu CID va cat_name khong ton tai, hoac khong dung dinh dang mong muon
                        redirect_to('danhsachloaihang.php');
                    }


                    //cap nhat thong tin nhan vien
                    if(isset($_POST['sua-hang'])) {

                        $ma_hang = mysqli_real_escape_string($dbc, strip_tags($_POST['ma-hang']));
                        $ten_hang = mysqli_real_escape_string($dbc, strip_tags($_POST['ten-hang']));
                        $dtich_hang = mysqli_real_escape_string($dbc, $_POST['dtich-hang']);
                        $sluong_hang = mysqli_real_escape_string($dbc, $_POST['sluong-hang']);
                        $ttthem_hang = mysqli_real_escape_string($dbc, $_POST['ttthem_hang']);

                        $q = "UPDATE Hang 
                                  SET ma_hang = '{$ma_hang}', ten_hang= '{$ten_hang}', dtich_hang = '{$dtich_hang}', ttthem_hang = '{$ttthem_hang}' 
                                  WHERE id_hang = $id_hang";

                        $r = mysqli_query($dbc, $q);
                        confirm_query($r, $q);

                        //cap nhat vao log.
                        $id_nv = $_SESSION['dang_nhap']['id_NV'];
                        $q_log = "INSERT INTO Log (id_NV, ngay, ghi_chu)  
                                      VALUES ($id_nv, NOW(), 'sửa khách hàng: {$hang['ten_hang']} thành : {$ten_hang}')";
                        $r_log = mysqli_query($dbc, $q_log);
                        confirm_query($r_log,$q_log);



                        if (mysqli_affected_rows($dbc) == 1) {
                            $mes = "<p class='success'>Sửa Hàng Thành Công!</p>";
                        } else {
                            $mes = "<p class='warning'>Sửa Hàng Không Thành Công. Vui lòng kiểm tra lại.</p>";
                        }

                    }//end main if condituon submit.
                    ?>
                    <h2 style="text-transform: uppercase; text-align: center; padding-top: 20px; font-weight: bold; padding-bottom: 20px">
                        Sửa Loại Hàng</h2>
                    <?php if(!empty($mes)) echo $mes; ?>
                    <form method="post">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="ho-ten">Mã Hàng</label>
                                <input type="text" name="ma-hang" placeholder="Nhập mã hàng"
                                       class="form-control"
                                       value="<?php echo strip_tags($hang['ma_hang']) ?>">
                            </div>

                            <div class="col-md-6 form-group">
                                <label>Tên Hàng</label>
                                <input type="text" name="ten-hang" placeholder="Nhập tên hàng"
                                       class="form-control"
                                       value="<?php echo strip_tags($hang['ten_hang']) ?>">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label>Diện Tích Hàng</label>
                                <input type="text" name="dtich-hang" id="email-nv"
                                       placeholder="Nhập diện tích hàng."
                                       class="form-control"
                                       value="<?php echo strip_tags($hang['dtich_hang']) ?>">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Số Lượng Hàng</label>
                                <input type="text" name="sluong-hang" placeholder="Nhập sô lượng hàng"
                                       class="form-control"
                                       value="<?php echo strip_tags($hang['sluong_hang']) ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="diachi">Thông Tin Thêm Hàng</label>
                            <textarea placeholder="thông tin thêm hàng " rows="3"
                                      class="form-control" name="ttthem_hang"
                                      value="<?php  echo strip_tags($hang['ttthem_hang']) ?>"></textarea>
                        </div>

                        <input type="submit" name="sua-hang" class="btn btn-lg btn-info" value="Cập Nhật Hàng">
                    </form>
                </div><!--/.content-admin-->
            </div>
        </div>
    </div>
<?php include "includes/footer.php"; ?>