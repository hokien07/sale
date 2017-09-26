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
                    if (isset($_GET['id_hang'], $_GET['ten_hang']) && filter_var($_GET['id_hang'], FILTER_VALIDATE_INT, array('min_range' => 1))) {
                        $id_hang = $_GET['id_hang'];
                        $ten_hang = $_GET['ten_hang'];
                        // Neu cid va cat_name ton tai, thi se xoa category khoi csdl
                        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                            // Xu ly form
                            if (isset($_POST['delete']) && ($_POST['delete'] == 'yes')) {
                                // Neu muon delete category
                                $q = "DELETE FROM Hang WHERE id_hang = {$id_hang} LIMIT 1";
                                $r = mysqli_query($dbc, $q);
                                confirm_query($r, $q);

                                //cap nhat vao log.
                                $id_nv = $_SESSION['dang_nhap']['id_NV'];
                                $q_log = "INSERT INTO Log (id_NV, ngay, ghi_chu)  
                                      VALUES ($id_nv, NOW(), 'xóa hàng: {$ten_hang}')";
                                $r_log = mysqli_query($dbc, $q_log);
                                confirm_query($r_log,$q_log);

                                if (mysqli_affected_rows($dbc) == 1) {
                                    // Xoa thanh cong, bao cho nguoi dung biet
                                    $messages = "<p class='success'>Xóa Thành Công</p>";
                                    sleep(5);
                                    header("Location: danhsachloaihang.php");

                                } else {
                                    $messages = "<p class='warning'>xóa Không Thành Công.</p>";

                                }
                            } else {
                                // Ko muon delete category
                                $messages = "<p class='warning'>Bạn không muốn xóa loại hàng này.</p>";
                            }
                        }
                    } else {
                        // Neu CID va cat_name khong ton tai, hoac khong dung dinh dang mong muon
                        redirect_to('danhsachloaihang.php');
                    }
                    ?>
                    <h2 style="text-transform: uppercase; text-align: center; padding-top: 20px; font-weight: bold; padding-bottom: 20px">
                        Xóa Loại Hàng</h2>
                    <form action="" method="post">
                        <fieldset id="content_xoa" style="text-align: center">
                            <?php if(!empty($messages)) echo $messages; ?>
                            <legend>Xóa Loại Hàng</legend>
                            <label for="delete">bạn xác nhận xóa loại hàng: <strong><?php if (isset($ten_hang)) echo htmlentities($ten_hang, ENT_COMPAT, 'UTF-8') ?></strong></label>
                            <div class="checkbox checkbox-circle">
                                <input id="checkbox7" type="checkbox" name="delete" value="no">
                                <label for="checkbox7">Không</label>

                                <input id="checkbox8" type="checkbox" name="delete" value="yes">
                                <label for="checkbox8">Có</label>
                            </div>
                            <div class="action_button"><input class="btn btn-danger" type="submit" name="submit" value="Xóa Loại Hàng"
                                                              onclick="return confirm('Bạn chắc chắn chứ?');"/></div>
                        </fieldset>
                    </form>
                </div><!--/.content-admin-->
            </div>
        </div>
    </div>
<?php include "includes/footer.php"; ?>