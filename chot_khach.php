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
            <div class="them-nhan-vien">
                <div class="content"><!--form thêm nhân viên-->
                    <?php
                        if(isset($_GET['id_kh'])  && filter_var($_GET['id_kh'], FILTER_VALIDATE_INT, array('min_range' => 1))) {
                            $id_kh = $_GET['id_kh'];

                            $q_kh = "SELECT ten_KH, sdt_KH, email_KH FROM khachhang WHERE id_KH = {$id_kh}";
                            $r_kh = mysqli_query($dbc, $q_kh);
                            confirm_query($r_kh, $q_kh);
                            $kh = mysqli_fetch_array($r_kh);
                            $ten_kh = $kh['ten_KH'];
                            $sdt = $kh['sdt_KH'];
                            $email_kh = $kh['email_KH'];
                        }

                        if (isset($_POST['submit'])) {


                            $errors = array();
                            if (empty($_POST['can-ho'])) {
                                $errors[] = "can-ho";
                            } else {
                                $can_ho = mysqli_real_escape_string($dbc, strip_tags($_POST['can-ho']));
                            }
                            if (empty($_POST['mail-chu-nha'])) {
                                $errors[] = "mail-chu-nha";
                            } else {
                                $mail_chu_nha = mysqli_real_escape_string($dbc, strip_tags($_POST['mail-chu-nha']));
                            }

                            if (empty($_POST['dt-chu-nha'])) {
                                $errors[] = 'dt-chu-nha';
                            } else {

                                $dt_chu_nha = mysqli_real_escape_string($dbc, $_POST['dt-chu-nha']);

                            }

                            if (empty($_POST['phi-thu-ve'])) {
                                $errors[] = 'phi-thu-ve';
                            } else {
                                $phi_thu_ve = mysqli_real_escape_string($dbc, $_POST['phi-thu-ve']);
                            }


                            $ngay_lam_hd = mysqli_real_escape_string($dbc, $_POST['ngay-lam-hop-dong']);

                            $ngay_thu_tien= $_POST['ngay-nhan-tien'];

                            $ngay_kt_dh = $_POST['ngay-ket-thuc-hop-dong'];
                            $ten_nv = $_SESSION['dang_nhap']['ten_NV'];

                            if (empty($errors)) {
                                //them khach hang vao bang khach hang.
                                $q = "INSERT INTO khachChot 
                                        ( ten_NV,
                                          ten_KH, 
                                          sdt_KH, 
                                          email_KH, 
                                          canho, 
                                          mailchunha, 
                                          dtchunha, 
                                          phithuve, 
                                          ngaylamhopdong, 
                                          ngaynhantien, 
                                          ngayketthuchopdong
                                        ) 
                                      VALUES 
                                        (
                                        '{$ten_nv}',
                                        '{$ten_kh}',
                                        '{$sdt}',
                                        '{$email_kh}', 
                                        '{$can_ho}',
                                        '{$mail_chu_nha}',
                                        '{$dt_chu_nha}',
                                        '{$phi_thu_ve}',
                                        '{$ngay_lam_hd}', 
                                        '{$ngay_thu_tien}', 
                                        '{$ngay_kt_dh}'
                                        )";
                                $r = mysqli_query($dbc, $q);
                                confirm_query($r, $q);

                                //cap nhat vao log.
                                $id_nv = $_SESSION['dang_nhap']['id_NV'];
                                $q_log = "INSERT INTO Log (id_NV, ngay, ghi_chu)  
                                          VALUES ($id_nv, NOW(), 'chốt khách hàng: {$ten_kh}') và xóa khác hàng: {$ten_kh}";
                                $r_log = mysqli_query($dbc, $q_log);
                                confirm_query($r_log,$q_log);


                                //delete khach hang khoi danh sach khach hang.
                                $q_dkh = "DELETE FROM khachhang WHERE id_KH = {$id_kh} LIMIT 1";
                                $r_dkh= mysqli_query($dbc, $q_dkh);
                                confirm_query($r, $q);


                                //kiem tra xem da them thnanh cong
                                if (mysqli_affected_rows($dbc) == 1) {
                                    $mes = "<p class='success'>Chốt Thành Công!</p>";
                                } else {
                                    $mes = "<p class='warning'>Chốt Không Thành Công. Vui lòng kiểm tra lại.</p>";
                                }
                            } else {
                                $mes = "<p class='warning'> Vui Lòng Nhập Đầy Đủ Thông Tin.";
                            }


                        }//end main if condituon submit.

                    ?>

                    <h1 class="well" style="text-transform: uppercase; text-align: center; padding-top: 20px; font-weight: bold; padding-bottom: 20px">Trang Chốt Khác Hàng</h1>

                    <?php if (isset($mes)) echo $mes; ?>

                    <form method="post">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="can-ho">Căn Hộ
                                    <?php
                                    if (isset($errors) && in_array("can-ho", $errors, true)) {
                                        echo "<p class='warning'>Vui lòng nhập họ tên. </p>";
                                    }

                                    ?>
                                </label>
                                <input type="text" name="can-ho" id="can-ho" placeholder="Nhập căn hộ"
                                       class="form-control" value="<?php if(isset($_POST['can-ho']))echo strip_tags($_POST['can-ho']) ?>">
                            </div>

                            <div class="col-md-6 form-group">
                                <label for="sdt-kh">Email chủ nhà
                                    <?php
                                    if (isset($errors) && in_array("mail-chu-nha", $errors, true)) {
                                        echo "<p class='warning'>Vui lòng nhập họ tên. </p>";
                                    }

                                    ?>
                                </label>
                                <input type="text" name="mail-chu-nha" id="mail-chu-nha" placeholder="Nhập mail chủ nhà"
                                       class="form-control" value="<?php if(isset($_POST['mail-chu-nha']))echo strip_tags($_POST['mail-chu-nha']) ?>">
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="email-kh">Điện thoại chủ nhà
                                <?php
                                    if (isset($errors) && in_array("dt-chu-nha", $errors, true)) {
                                        echo "<p class='warning'>Vui lòng nhập Email. </p>";
                                    }

                                    if(isset($email_mes)) echo $email_mes;

                                ?>
                            </label>
                            <input type="text" name="dt-chu-nha" id="dt-chu-nha" placeholder="Nhập Sô điện thoại chủ nhà"
                                   class="form-control" value="<?php if(isset($_POST['dt-chu-nha']))echo "0". strip_tags($_POST['dt-chu-nha']) ?>">
                        </div>


                        <div class="form-group">
                            <label for="diachi-kh">Phí thu về
                                <?php
                                if (isset($errors) && in_array("phi-thu-ve", $errors, true)) {
                                    echo "<p class='warning'>Vui lòng nhập thông tin </p>";
                                }

                                ?>
                            </label>
                            <input type="text" name="phi-thu-ve" id="phi-thu-ve" placeholder="Phí thu về"
                                   class="form-control" value="<?php if(isset($_POST['phi-thu-ve']))echo  strip_tags($_POST['phi-thu-ve']) ?>">
                        </div>

                        <div class="form-group">
                            <label for="ngay-lam-hop-dong">Ngày làm hợp đồng
                                <?php
                                if (isset($errors) && in_array("ngay-lam-hop-dong", $errors, true)) {
                                    echo "<p class='warning'>Vui lòng nhập thông tin</p>";
                                }

                                ?>
                            </label>
                            <input type="date" name="ngay-lam-hop-dong" id="ngay-lam-hop-dong"
                                   class="form-control" value="<?php if(isset($_POST['ngay-lam-hop-dong']))echo  strip_tags($_POST['ngay-lam-hop-dong']) ?>">
                        </div>

                        <div class="form-group">
                            <label for="ngay-nhan-tien">Ngày nhận tiền
                                <?php
                                if (isset($errors) && in_array("ngay-nhan-tien", $errors, true)) {
                                    echo "<p class='warning'>Vui lòng nhập thông tin</p>";
                                }

                                ?>
                            </label>
                            <input type="date" name="ngay-nhan-tien" id="ngay-nhan-tien"
                                   class="form-control" value="<?php if(isset($_POST['ngay-nhan-tien']))echo  strip_tags($_POST['ngay-nhan-tien']) ?>">
                        </div>

                        <div class="form-group">
                            <label for="ngay-ket-thuc-hop-dong">Ngày kết thúc hợp đồng
                                <?php
                                if (isset($errors) && in_array("ngay-ket-thuc-hop-dong", $errors, true)) {
                                    echo "<p class='warning'>Vui lòng nhập thông tin</p>";
                                }

                                ?>
                            </label>
                            <input type="date" name="ngay-ket-thuc-hop-dong" id="ngay-ket-thuc-hop-dong"
                                   class="form-control" value="<?php if(isset($_POST['úcngay-ket-thuc-hop-dong']))echo  strip_tags($_POST['ngay-ket-thuc-hop-dong']) ?>">
                        </div>

                        <input type="submit" name="submit" class="btn btn-lg btn-info" value="Chốt Khách Hàng">

                    </form>
                </div><!--/.content-->
            </div>
        </div>
    </div>
</div>
<?php include "includes/footer.php"; ?>
