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
                    if ((isset($_GET['id_kh'], $_GET['id_nv'])) && (filter_var($_GET['id_kh'], FILTER_VALIDATE_INT, array('min_range' => 1)))) {
                        $id_kh = $_GET['id_kh'];
                        $id_nv = $_GET['id_nv'];

                        $q = "SELECT * FROM ChamSocKhacHang WHERE id_KH ={$id_kh} AND id_NV = {$id_nv}";
                        $r = mysqli_query($dbc, $q);
                        confirm_query($r, $q);
                        $khachhang = mysqli_fetch_array($r);
                    } else {
                        // Neu CID va cat_name khong ton tai, hoac khong dung dinh dang mong muon
                        header("location:chamsockhachhang.php");
                    }


                    //cap nhat thong tin nhan vien
                    if(isset($_POST['sua-kh'])) {
                        $cskh = mysqli_real_escape_string($dbc, $_POST['cskh']);
                        $phkh = mysqli_real_escape_string($dbc, $_POST['phkh']);

                        $q = "INSERT INTO tiendo (id_KH, id_NV, tuong_tac, phan_hoi, date) VALUES ({$id_kh}, {$id_nv}, '{$cskh}', '{$phkh}', NOW())";
                        $r = mysqli_query($dbc, $q);
                        confirm_query($r, $q);


                        if (mysqli_affected_rows($dbc) == 1) {
                            $mes = "<p class='success'>Cập nhật thành công!</p>";
                        } else {
                            $mes = "<p class='warning'>Cập nhật không thành công. Vui lòng kiểm tra lại.</p>";
                        }

                    }//end main if condituon submit.
                    ?>
                    <h2 style="text-transform: uppercase; text-align: center; padding-top: 20px; font-weight: bold; padding-bottom: 20px">Chăm Sóc Khách hàng</h2>
                    <?php if(!empty($mes)) echo $mes; ?>
                    <form method="post">

                        <div class="form-group">
                            <label for="tuong_tac">Tương Tác</label>
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

                        <input type="submit" name="sua-kh" class="btn btn-lg btn-info" value="Cập Nhật">
                    </form>
                </div><!--/.content-admin-->
            </div>
        </div>
    </div>
<?php include "includes/footer.php"; ?>