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
                if ((isset($_GET['id_kh']) && (filter_var($_GET['id_kh'], FILTER_VALIDATE_INT, array('min_range' => 1))))) {
                    $id_kh = $_GET['id_kh'];
                    $q = "SELECT * FROM khachhang WHERE id_KH ={$id_kh}";
                    $r = mysqli_query($dbc, $q);
                    confirm_query($r, $q);
                    $khachhang = mysqli_fetch_array($r);
                } else {
                    // Neu CID va cat_name khong ton tai, hoac khong dung dinh dang mong muon
                    redirect_to('danhsachkhachhang.php');
                }
                ?>
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title"></h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-3 col-lg-3 " align="center">
                                <img alt="User Pic"
                                     src="http://babyinfoforyou.com/wp-content/uploads/2014/10/avatar-300x300.png"
                                     class="img-circle img-responsive"></div>

                            <div class=" col-md-9 col-lg-9 ">
                                <div class="table-responsive" style="overflow-x:auto;">

                                    <table class="table table-user-information">
                                        <tbody>
                                        <tr>
                                            <td>Họ & Tên</td>
                                            <td><?php echo $khachhang['ten_KH'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>Số Điện Thoại</td>
                                            <td><?php echo $khachhang['sdt_KH'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>Email</td>
                                            <td>
                                                <a href="mailto:<?php echo $khachhang['email_KH'] ?>"><?php echo $khachhang['email_KH'] ?></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Địa Chỉ</td>
                                            <td><?php echo $khachhang['diachi_KH'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>Thông Tin Thêm</td>
                                            <td><?php echo $khachhang['ttthem_KH'] ?></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div><!--/.content-admin-->
        </div>
    </div>
</div>
<?php include "includes/footer.php"; ?>













