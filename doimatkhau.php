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
                    if((isset($_GET['id_nv']) && (filter_var($_GET['id_nv'], FILTER_VALIDATE_INT, array('min_range' => 1))))) {
                        $id_nv = $_GET['id_nv'];
                    }

                    if(isset($_POST['submit_change_pass'])) {

                        // Nhận dữ liệu và gán vào các biến đồng thời xử lý chuỗi
                        $old_pass = $_POST['old_pass'];
                        $new_pass = $_POST['new_pass'];
                        $re_new_pass = $_POST['re_new_pass'];

                        // Nếu mật khẩu cũ nhậ đúng
                        if ($old_pass != $_SESSION['dang_nhap']['password'])
                        {
                            $show_alert = 'Mật khẩu cũ nhập không chính xác, đảm bảo đã tắt caps lock.';
                        }
                        // Ngược lại nếu độ dài mật khẩu mới nhỏ hơn 6 ký tự
                        else if (strlen($new_pass) < 6)
                        {
                            $show_alert = 'Mật khẩu quá ngắn, hãy thử với mật khẩu khác an toàn hơn.';
                        }
                        // Ngược lại nếu mật khẩu mởi nhập lại không khớp
                        else if ($new_pass != $re_new_pass)
                        {
                            $show_alert = 'Nhập lại mật khẩu mới không khớp, đảm bảo đã tắt caps lock.';
                        }
                        // Ngược lại
                        else
                        {
                            $new_pass = md5($new_pass); // Mã hoá mật khẩu sang MD5
                            // Lệnh SQL đổi mật khẩu
                            $q = "UPDATE nhanvien SET password = '$new_pass' WHERE id_NV = '$id_nv'";
                            $r = mysqli_query($dbc, $q);
                            confirm_query($r, $q);

                            if(mysqli_affected_rows($dbc)==1) {
                                $show_alert = "Đổi Mật Khâủ Thành công";
                            }else {
                                $show_alert = "Đổi Mật Khâủ Không Thành công";
                            }
                        }
                    }

                    ?>
                    <div class="row">
                        <div class="col-md-12">
                            <h3 class="text-primary">Đổi mật khẩu</h3>
                            <form method="POST"  id="formChangePass">
                                <div class="form-group">
                                    <label for="user_signin">Mật khẩu cũ</label>
                                    <input type="password" class="form-control" id="old_pass" name="old_pass">
                                </div>
                                <div class="form-group">
                                    <label for="user_signin">Mật khẩu mới</label>
                                    <input type="password" class="form-control" id="new_pass" name="new_pass">
                                </div>
                                <div class="form-group">
                                    <label for="user_signin">Nhập lại mật khẩu mới</label>
                                    <input type="password" class="form-control" id="re_new_pass" name="re_new_pass">
                                </div>
                                <a href="index.php" class="btn btn-default">
                                    <span class="glyphicon glyphicon-arrow-left"></span> Trở về
                                </a>
                                <button class="btn btn-primary" id="submit_change_pass" name="submit_change_pass">
                                    <span class="glyphicon glyphicon-ok" ></span> Thay đổi
                                </button>
                                <br><br>
                                <div class="alert alert-danger hidden"> <?php if(!empty($show_alert)) echo $show_alert; ?></div>
                            </form>
                        </div>
                    </div>
                </div><!--/.content-admin-->
            </div>
        </div>
    </div>
<?php include "includes/footer.php"; ?>