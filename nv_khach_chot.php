<?php include "includes/header.php"; ?>
<?php include('includes/mysqli_connect.php'); ?>
<?php include('includes/function.php'); ?>
<?php include "includes/top-header.php"; ?>
<?php
if (empty($_SESSION)) {
    header('location:index.php');
}

?>


<div class="row">
    <div class="col-md-3">
        <?php include "includes/sidebar.php"; ?>
    </div>

    <div class="col-md-9">
        <div class="content">
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
            <?php
            $display = 20;
            $ten_nv = $_SESSION['dang_nhap']['ten_NV'];
            $id_nv = $_SESSION['dang_nhap']['id_NV'];

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
                  WHERE MONTH(date) = {$thang}  AND id_NV = $id_nv
                  ORDER BY idChot DESC LIMIT $from, $display";
            } else {
                $q = "SELECT *
                  FROM khachChot
                  WHERE id_NV = $id_nv
                  ORDER BY idChot DESC LIMIT $from, $display";
            }

            $r = mysqli_query($dbc, $q);
            confirm_query($r, $q); ?>

            <?php
            //tinh tỏng phí thu:
            $q_tongthu = "SELECT phithuve FROM khachChot WHERE id_NV = $id_nv";
            $r_tongthu = mysqli_query($dbc, $q_tongthu);
            confirm_query($r_tongthu, $q_tongthu);
            $tongs = 0;
            while ($tong = mysqli_fetch_array($r_tongthu)) {
                $tongs += $tong['phithuve'];
            }
            echo "<p style='color: blue; width: 30%; float: left;'> Tổng Thu: " . number_format($tongs) . " VNĐ</p>";
            echo "<p style='color: #47cacd; width: 30%; float: left;'> Số Khách Chốt: " . mysqli_num_rows($r_tongthu) . "</p>";

            if (isset($_POST['thang'])) {
                $q_tongthu_thang = "SELECT phithuve FROM khachChot WHERE MONTH(date) AND  id_NV = $id_nv";
                $r_tongthu_thang = mysqli_query($dbc, $q_tongthu);
                confirm_query($r_tongthu_thang, $q_tongthu_thang);
                $tong_thang = 0;
                while ($tong = mysqli_fetch_array($r_tongthu_thang)) {
                    $tong_thang += $tong['phithuve'];
                }
                echo "<p style='color: blue; width: 30%; float: left;'> Tổng Thu Tháng này: " . number_format($tong_thang) . "</p>";
            }

            ?>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <tr>
                        <th>Nhân Viên</th>
                        <th>Khách</th>
                        <th>Căn Hộ</th>
                        <th>Mail Chủ Nhà</th>
                        <th>SĐT Chủ Nhà</th>
                        <th>Phí thu về</th>
                        <th>Ngày làm hợp đồng</th>
                        <th>Ngày nhận tiền</th>
                        <th>Ngày kết thúc hợp đồng</th>
                    </tr>
                    <?php
                    $count = 1;
                    while ($row = mysqli_fetch_array($r)): ?>

                        <tr>
                            <td><?php echo $row['ten_NV'] ?></td>
                            <td>

                                <button type="button" class="btn btn-info" data-toggle="modal"
                                        data-target="#khachhang-<?php echo $count; ?>">
                                    <?php echo $row['ten_kh'] ?>
                                </button>
                                <!-- Modal -->
                                <div class="modal fade" id="khachhang-<?php echo $count; ?>" tabindex="-1" role="dialog"
                                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel" style="color: #117a8b">Thông
                                                    tin khách hàng: <?php echo $row['ten_kh'] ?></h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <?php echo "<p style='color: #117a8b'> Email Khách Hàng:  {$row['email_kh']} </p>" ?>
                                                <?php echo "<p style='color: #117a8b'> Số Điện Thoại:  {$row['sdt_kh']} </p>" ?>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </td>
                            <td><?php echo $row['canho'] ?></td>
                            <td><?php echo $row['mailchunha'] ?></td>
                            <td><?php echo "0" . number_format($row['dtchunha'], 0, ' ', ' ') ?></td>
                            <td><?php echo number_format($row['phithuve']) ?></td>
                            <td><?php
                                $phpdate = strtotime( $row['ngaylamhopdong'] );
                                echo $mysqldate = date( 'd-m-Y H:i:s', $phpdate );
                                ?>
                            </td>
                            <td><?php
                                $phpdate = strtotime( $row['ngaynhantien'] );
                                echo $mysqldate = date( 'd-m-Y H:i:s', $phpdate );
                                ?>
                            </td>
                            <td><?php
                                $phpdate = strtotime( $row['ngayketthuchopdong'] );
                                echo $mysqldate = date( 'd-m-Y H:i:s', $phpdate );
                                ?></td>
                        </tr>
                        <?php $count++; endwhile; ?>
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
    </div>

</div>
</div>

<?php include "includes/footer.php"; ?>

