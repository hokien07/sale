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
            <div class="content">

                <div class="khachhang-moi">
                    <h2 style="text-transform: uppercase; text-align: center; padding-top: 20px; font-weight: bold; padding-bottom: 20px">Ghi chú Tổng Thể</h2>


            <?php
            $display = 20;

            if (isset($_GET['trang']) && filter_var($_GET['trang'], FILTER_VALIDATE_INT, array('min-range' => 1))) {
                $from = ($_GET['trang'] - 1) * $display;
            } else {
                $from = 0;
            }


            $q = "SELECT nv.ten_NV, Log.*
                            FROM nhanvien nv
                            INNER JOIN Log  ON nv.id_NV = Log.id_NV
                            ORDER BY Log.id_log DESC LIMIT $from, $display";


            $r = mysqli_query($dbc, $q);
            confirm_query($r, $q); ?>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <tr>
                        <th style="background-color: #1e7e34; color: #ffffff;">Ngày:</th>
                        <th style="background-color: #1e7e34; color: #ffffff;">Nhân Viên:</th>
                        <th style="background-color: #6c757d; color: #ffffff;">Ghi chú</th>
                    </tr>
                    <?php while ($row = mysqli_fetch_array($r)): ?>

                        <tr>
                            <td style="background-color: #1e7e34; color: #ffffff;"><?php echo $row['ngay'] ?></td>
                            <td style="background-color: #1e7e34; color: #ffffff;"><?php echo $row['ten_NV'] ?></td>
                            <td style="background-color: #6c757d; color: #ffffff;"><?php echo $row['ghi_chu'] ?></td>
                        </tr>
                    <?php endwhile; ?>
                </table>

                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <?php
                        //lay tong so tin
                        $ts_tin = "SELECT id_log FROM Log";
                        $trang = mysqli_query($dbc, $ts_tin);
                        confirm_query($trang, $ts_tin);

                        $ts_tin = mysqli_num_rows($trang);
                        $soTrang = ceil($ts_tin / $display);
                        for ($i = 1; $i <= $soTrang; $i++) {
                            echo "<li class='page-item'><a class='page-link' href='xem_log.php?trang={$i}'>{$i}</a></li>";

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

