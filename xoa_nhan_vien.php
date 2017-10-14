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
                    <?php
                    if (isset($_GET['id_nv'], $_GET['ten_nv']) && filter_var($_GET['id_nv'], FILTER_VALIDATE_INT, array('min_range' => 1))) {
                        $id_nv = $_GET['id_nv'];
                        $ten_nv = $_GET['ten_nv'];
                        // Neu cid va cat_name ton tai, thi se xoa category khoi csdl
                        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                            // Xu ly form
                            if (isset($_POST['delete']) && ($_POST['delete'] == 'yes')) {
                                // Neu muon delete category
                                $q = "DELETE FROM nhanvien WHERE id_NV = {$id_nv} LIMIT 1";
                                $r = mysqli_query($dbc, $q);
                                confirm_query($r, $q);

                                //cap nhat vao log.
                                $id_nv = $_SESSION['dang_nhap']['id_NV'];
                                $q_log = "INSERT INTO Log (id_NV, ngay, ghi_chu)  
                                      VALUES ($id_nv, NOW(), 'xóa nhân viên: {$ten_nv}')";
                                $r_log = mysqli_query($dbc, $q_log);
                                confirm_query($r_log,$q_log);

                                if (mysqli_affected_rows($dbc) == 1) {
                                    // Xoa thanh cong, bao cho nguoi dung biet
                                    $messages = "<p class='success'>Xóa Nhân Viên Thành công</p>";

                                } else {
                                    $messages = "<p class='warning'>Không thể xóa nhân viên này.</p>";

                                }
                            } else {
                                // Ko muon delete category
                                $messages = "<p class='warning'>Bạn không muốn xóa nhân viên này.</p>";
                            }
                        }
                    } else {
                        // Neu CID va cat_name khong ton tai, hoac khong dung dinh dang mong muon
                        header("location:danhsachnhanvien.php");
                    }
                    ?>
                    <h2 style="text-transform: uppercase; text-align: center; padding-top: 20px; font-weight: bold; padding-bottom: 20px">
                        Xóa Nhân Viên</h2>
                    <form action="" method="post">
                        <fieldset id="content_xoa" style="text-align: center">
                            <?php if(!empty($messages)) echo $messages; ?>
                            <legend>Xóa Nhân Viên</legend>
                            <label for="delete">bạn xác nhận xóa nhân
                                viên: <strong><?php if (isset($ten_nv)) echo htmlentities($ten_nv, ENT_COMPAT, 'UTF-8') ?></strong></label>
                            <div class="checkbox checkbox-circle">
                                <input id="checkbox7" type="checkbox" name="delete" value="no">
                                <label for="checkbox7">Không</label>

                                <input id="checkbox8" type="checkbox" name="delete" value="yes">
                                <label for="checkbox8">Có</label>
                            </div>
                            <div class="action_button"><input class="btn btn-danger" type="submit" name="submit" value="Xóa Nhân Viên"
                                        onclick="return confirm('Bạn chắc chắn chứ?');"/></div>
                        </fieldset>
                    </form>
                </div><!--/.content-admin-->
            </div>
        </div>
    </div>
<?php include "includes/footer.php"; ?>