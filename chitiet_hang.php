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
                ?>
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title"></h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">

                            <div class=" col-md-12 col-lg-12 ">
                                <div class="table-responsive" style="overflow-x:auto;">

                                    <table class="table table-user-information">
                                        <tbody>
                                        <tr>
                                            <td>Mã Hàng</td>
                                            <td><?php echo $hang['ma_hang'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>Tên Hàng</td>
                                            <td><?php echo $hang['ten_hang'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>Diện Tích Hàng</td>
                                            <td><?php echo $hang['dtich_hang'] ?></a></td>
                                        </tr>
                                        <tr>
                                            <td>Số Lượng Hàng</td>
                                            <td><?php echo $hang['sluong_hang'] ?></td>
                                        </tr>

                                        <tr>
                                        <tr>
                                            <td>Ghi Chú</td>
                                            <td><?php echo $hang['ttthem_hang'] ?></td>
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













