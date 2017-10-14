<?php include"includes/header.php";?>
<?php include('includes/mysqli_connect.php'); ?>
<?php include('includes/function.php'); ?>


    <div class="content_index">

        <?php
            if(isset($_POST['dang-nhap'])) {
                $email = mysqli_real_escape_string($dbc, $_POST['email']);
                $mat_khau = mysqli_real_escape_string($dbc, $_POST['matkhau']);

                //kiemt ra mat khau và emaill da nhap du chua
                if (!$email || !$mat_khau) {
                    $mess =  "Vui lòng nhập đầy đủ tên đăng nhập và mật khẩu.";
                    exit;
                }


                $q = "SELECT * FROM nhanvien WHERE email_NV = '{$email}'";
                $r = mysqli_query($dbc, $q);
                confirm_query($r, $q);

                $count = mysqli_num_rows($r);
                if($count==1){

                    $row = mysqli_fetch_array($r);

                    $_SESSION['dang_nhap']= $row;

                    if($_SESSION['dang_nhap']['loai_user'] == 1){
                        header("location:admin.php");
                    }else {
                        header("location:nv_tongquan.php");
                    }

                }
                else {
                    $mess =  "Sai tên đăng nhập hoặc mật khẩu";
                }
            }

        ?>
        <div class="text-center" style="padding:50px 0">
            <?php if(isset($mess)) echo $mess; ?>
            <div class="logo">Đăng Nhập Hệ Thống</div>
            <!-- Main Form -->
            <div class="login-form-1">
                <form id="login-form" class="text-left" method="post">
                    <div class="login-form-main-message"></div>
                    <div class="main-login-form">
                        <div class="login-group">
                            <div class="form-group">
                                <label for="lg_username" class="sr-only">Tài Khoản: </label>
                                <input type="email" class="form-control" id="gmail" name="email" placeholder="gmail của bạn">
                            </div>
                            <div class="form-group">
                                <label for="lg_password" class="sr-only">Mật KHẩu: </label>
                                <input type="password" class="form-control" id="matkhau" name="matkhau" placeholder="Nhập mật khẩu">
                            </div>
                            <div class="form-group login-group-checkbox">
                                <input type="checkbox" id="ghi-nho" name="ghi-nho">
                                <label for="lg_remember">Ghi Nhớ</label>
                            </div>
                        </div>
                        <button type="submit" class="login-button" name="dang-nhap"><i class="fa fa-chevron-right"></i></button>
                    </div>
                    <div class="etc-login-form">
                        <p><a href="#">Bạn quên mật khẩu? </a></p>
                    </div>
                </form>
            </div>
            <!-- end:Main Form -->
        </div>
    </div>
    <!--/.content-->
<?php include"includes/footer_index.php";?>
