<?php include "includes/header.php"; ?>
<?php include('includes/mysqli_connect.php'); ?>
<?php include('includes/function.php'); ?>
<?php include "includes/top-header.php"; ?>
<?php
if (empty($_SESSION)) {
    header('location:index.php');
}

?>
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <?php include "includes/sidebar.php"; ?>
        </div>

        <div class="col-md-8">
            <div class="content-chot"
            <div class="khachhang-moi">
                <h2 style="text-transform: uppercase; text-align: center; padding-top: 20px; font-weight: bold; padding-bottom: 20px">
                    Trang khách hàng đã chốt</h2>

                <?php
                //chức năng lấy thông tin khách hàng đã chốt
                    /*if(isset($_POST['tt-khach'])) {
                        $q_ttk = "SELECT ten_kh, email_kh, sdt_kh
                                    FROM khachChot
                                    ORDER BY idChot DESC";
                        $r_ttk = mysqli_query($dbc, $q_ttk);
                        confirm_query($r_ttk, $q_ttk);

                        while($ttk = mysqli_fetch_array($r_ttk)) {
                            echo $ttk['ten_kh'];
                        }
                    }*/

                ?>


                <!--Loc ngày và loại khách hàng-->
                <form method="post">
                    <div class="row">
                        <div class="col-md-8">
                            <select name="thang" id="thang"
                                    style="width: 100%; height: 40px; background-color: #1e7e34; color: #fff; ">
                                <option value="0">Chọn Tháng</option>
                                <?php

                                $thang = 1;
                                while ($thang <= 12) {
                                    echo "<option value='{$thang}'";
                                    if (isset($_POST['thang']) && $_POST['thang'] == $thang)
                                        echo "selected = 'selected'";
                                    echo ">Tháng {$thang}</option>";
                                    $thang++;
                                }
                                ?>

                                ?>
                            </select>

                        </div>


                        <div class="col-md-4">
                            <input type="submit" name="submit" id="khach-chot" value="Chọn"
                                   style="width: 100%; height: 40px; background-color: #1e7e34; color: #fff; margin-left: -15px; margin-bottom: 20px;">
                        </div>
                        <!--//submit lay thong tin khac da chot
                        <div class="col-md-4">
                            <input type="submit" name="tt-khach" id="tt-khach" value="Lấy thông tin khách"
                                   style="width: 100%; height: 40px; background-color: #007bff; color: #fff; margin-left: -15px; margin-bottom: 20px;">
                        </div>
                        -->
                </form>

            </div>
        </div>


        <?php
        $display = 20;
        $ten_nv = $_SESSION['dang_nhap']['ten_NV'];

        if (isset($_GET['trang']) && filter_var($_GET['trang'], FILTER_VALIDATE_INT, array('min-range' => 1))) {
            $from = ($_GET['trang'] - 1) * $display;
        } else {
            $from = 0;
        }

        if (isset($_POST['thang'])) {

            $thang = $_POST['thang'];
            $thang < 10 ? $thang = "0" . $thang : $thang = $thang;

            $q = "SELECT *
                  FROM khachChot
                  WHERE ten_NV = '{$ten_nv}'
                  AND MONTH(date) = {$thang} 
                  ORDER BY idChot DESC LIMIT $from, $display";
        } else {
            $q = "SELECT *
                  FROM khachChot
                  WHERE ten_NV = '{$ten_nv}'
                  ORDER BY idChot DESC LIMIT $from, $display";
        }

        $r = mysqli_query($dbc, $q);
        confirm_query($r, $q); ?>

        <div class="table-responsive">
            <table class="table table-bordered">
                <tr>
                    <th style="background-color: #6c757d; color: #ffffff;">Nhân Viên</th>
                    <th style="background-color: #6c757d; color: #ffffff;">Khách</th>
                    <th style="background-color: #6c757d; color: #ffffff;">Căn Hộ</th>
                    <th style="background-color: #6c757d; color: #ffffff;">Mail Chủ Nhà</th>
                    <th style="background-color: #6c757d; color: #ffffff;">SĐT Chủ Nhà</th>
                    <th style="background-color: #6c757d; color: #ffffff;">Phí thu về</th>
                    <th style="background-color: #6c757d; color: #ffffff;">Ngày làm</th>
                    <th style="background-color: #6c757d; color: #ffffff;">Ngày nhận tiền</th>
                    <th style="background-color: #6c757d; color: #ffffff;">Ngày kết thúc</th>
                </tr>
                <?php while ($row = mysqli_fetch_array($r)): ?>

                    <tr>
                        <td style="background-color: #6c757d; color: #ffffff;"><?php echo $row['ten_NV'] ?></td>
                        <td style="background-color: #6c757d; color: #ffffff;"><?php echo $row['ten_kh'] ?></td>
                        <td style="background-color: #6c757d; color: #ffffff;"><?php echo $row['canho'] ?></td>
                        <td style="background-color: #6c757d;  color: #ffffff;"><?php echo $row['mailchunha'] ?></td>
                        <td style="background-color: #6c757d; color: #ffffff;"><?php echo $row['dtchunha'] ?></td>
                        <td style="background-color: #6c757d; color: #ffffff;"><?php echo $row['phithuve'] ?></td>
                        <td style="background-color: #6c757d; color: #ffffff;"><?php echo $row['ngaylamhopdong'] ?></td>
                        <td style="background-color: #6c757d; color: #ffffff;"><?php echo $row['ngaynhantien'] ?></td>
                        <td style="background-color: #6c757d; color: #ffffff;"><?php echo $row['ngayketthuchopdong'] ?></td>
                    </tr>
                <?php endwhile; ?>
            </table>

            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <?php
                    //lay tong so tin
                    $ts_tin = "SELECT idChot FROM khachChot";
                    $trang = mysqli_query($dbc, $ts_tin);
                    confirm_query($trang, $ts_tin);

                    $ts_tin = mysqli_num_rows($trang);
                    $soTrang = ceil($ts_tin / $display);
                    for ($i = 1; $i <= $soTrang; $i++) {
                        echo "<li class='page-item'><a class='page-link' href='khachchot.php?trang={$i}'>{$i}</a></li>";

                    }
                    ?>
                </ul>
            </nav>
        </div>
    </div>
</div><!--/.content-admin-->
</div>
</div>
<?php include "includes/footer.php"; ?>

