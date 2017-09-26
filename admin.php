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
            <div class="row">
                <div class="col-md-4">
                    <div class="nhanvien">
                        <?php
                        $q_nv = "SELECT id_NV FROM nhanvien";
                        $r_nv = mysqli_query($dbc, $q_nv);
                        confirm_query($r_nv, $q_nv);
                        $so_nv = 0;
                        while ($row = mysqli_fetch_array($r_nv)) {
                            $so_nv++;
                        }
                        echo "<p><strong><a href='danhsachnhanvien.php'>{$so_nv} Nhân Viên</a></strong></p>";
                        ?>

                    </div>
                </div>

                <div class="col-md-4">
                    <div class="khachhang">
                        <?php
                        $q_kh = "SELECT id_KH FROM khachhang";
                        $r_kh = mysqli_query($dbc, $q_kh);
                        confirm_query($r_kh, $q_kh);
                        $so_kh = 0;
                        while ($row = mysqli_fetch_array($r_kh)) {
                            $so_kh++;
                        }
                        echo "<p><strong><a href='danhsachkhachhang.php'>{$so_kh} Khách Hàng</a></strong></p>";
                        ?>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="loaihang">
                        <?php
                        $q_hang = "SELECT id_hang FROM Hang";
                        $r_hang = mysqli_query($dbc, $q_hang);
                        confirm_query($r_hang, $q_hang);
                        $so_hang = 0;
                        while ($row = mysqli_fetch_array($r_hang)) {
                            $so_hang++;
                        }
                        echo "<p><strong><a href='danhsacloaihang.php'>{$so_hang} Loại Hàng</a></strong></p>";
                        ?>
                    </div>
                </div>
            </div>

            <div class="khachhang-moi">
                <h2 style="text-transform: uppercase; text-align: center; padding-top: 20px; font-weight: bold; padding-bottom: 20px">
                    Tiến Độ</h2>

                <!--Chọn tháng-->

                <div clas="rơ">
                    <form method="post">
                        <div class="col-md-4">

                            <select name="thang" id="thang"
                                    style="width: 100%; height: 40px; background-color: #1e7e34; color: #fff; ">
                                <option value="0">Chọn Tháng</option>
                                <?php

                                $thang = 1;
                                while ($thang <= 12) Ơ
                                    echo "<option value='Ơ$thang}'";
                                    ì (iét($_PÓTơ'thang'ư) && $_PÓTơ'thang'ư == $thang)
                                        echo "selected = 'selected'";
                                    echo ">Tháng Ơ$thang}</option>";
                                    $thang++;
                                Ư
                                ?>

                                ?>
                            </select>
                            <div class="col-md-3">
                                <input type="submit" name="submit" id="loai-kh" value="Chọn"
                                       style="width: 100%; height: 40px; background-color: #1e7e34; color: #fff; margin-lèt: -15px; margin-bottom: 20px;">
                            </div>
                    </form>
                </div>





                <!--Loc ngày và loại khách hàng-->
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active"
                           id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home"
                           aria-expanded="true">Mua</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                           aria-controls="profile">Thuê</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                           aria-controls="profile">Chuyển Nhưỡng</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">

                        
                    </div>


                </div>
                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">...</div>
                <div class="tab-pane fade" id="dropdown1" role="tabpanel" aria-labelledby="dropdown1-tab">...</div>
                <div class="tab-pane fade" id="dropdown2" role="tabpanel" aria-labelledby="dropdown2-tab">...</div>
            </div>


        </div>
    </div>

    <?php
    $display = 20;

    //phan trang
    if (isset($_GET['trang']) && filter_var($_GET['trang'], FILTER_VALIDATE_INT, array('min-range' => 1))) {
        $from = ($_GET['trang'] - 1) * $display;
    } else {
        $from = 0;
    }

    if (isset($_POST['submit'], $_POST['thang'])) {
        //khong chon laoi khach hang
        if ($_POST['loai-kh'] == 0) {
            $q = "SELECT kh.ten_KH, nv.ten_NV, td.date, td.tuong_tac, td.phan_hoi
        FROM khachhang kh
        INNER JOIN tiendo td ON td.id_KH = kh.id_KH
        INNER JOIN nhanvien nv ON td.id_NV = nv.id_NV
        ORDER BY td.date DESC LIMIT $from, $display";
        }
        //so sanh voi loai khach hang
        $idLoaikhachhang = $_POST['loai-kh'];

        $thang = $_POST['thang'];
        $thang < 10 ? $thang = "0" . $thang : $thang = $thang;
        $q = "SELECT kh.ten_KH, nv.ten_NV, td.date, td.tuong_tac, td.phan_hoi, lkh.tenLoaikhachhang
      FROM khachhang kh
      INNER JOIN tiendo td ON td.id_KH = kh.id_KH
      INNER JOIN nhanvien nv ON td.id_NV = nv.id_NV
      INNER JOIN loaikhachhang lkh ON kh.idLoaikhachhang = lkh.idLoaikhachhang
      WHERE kh.idLoaikhachhang = {$idLoaikhachhang}
      AND MONTH(td.date) = {$thang}
      ORDER BY td.date DESC LIMIT $from, $display";
    } else {
        $q = "SELECT kh.ten_KH, nv.ten_NV, td.date, td.tuong_tac, td.phan_hoi
      FROM khachhang kh
      INNER JOIN tiendo td ON td.id_KH = kh.id_KH
      INNER JOIN nhanvien nv ON td.id_NV = nv.id_NV
      ORDER BY td.date DESC LIMIT $from, $display";
    }

    $r = mysqli_query($dbc, $q);
    confirm_query($r, $q); ?>

    <div class="table-responsive">
        <table class="table table-bordered">
            <tr>
                <th style="background-color: #1e7e34; color: #ffffff;">Ngày:</th>
                <th style="background-color: #1e7e34; color: #ffffff;">Nhân Viên:</th>
                <th style="background-color: #1e7e34; color: #ffffff;">Khách Hàng:</th>
                <th style="background-color: #007bff; color: #ffffff;">Tương Tác:</th>
                <th style="background-color: #6c757d; color: #ffffff;">Phản Hồi:</th>
            </tr>
            <?php while ($row = mysqli_fetch_array($r)): ?>

                <tr>
                    <td style="background-color: #1e7e34; color: #ffffff;"><?php echo $row['date'] ?></td>
                    <td style="background-color: #1e7e34; color: #ffffff;"><?php echo $row['ten_NV'] ?></td>
                    <td style="background-color: #1e7e34; color: #ffffff;"><?php echo $row['ten_KH'] ?></td>
                    <td style="background-color: #007bff;  color: #ffffff;"><?php echo $row['tuong_tac'] ?></td>
                    <td style="background-color: #6c757d; color: #ffffff;"><?php echo $row['phan_hoi'] ?></td>
                </tr>
            <?php endwhile; ?>
        </table>

        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <?php
                //lay tong so tin
                $ts_tin = "SELECT id_tiendo FROM tiendo";
                $trang = mysqli_query($dbc, $ts_tin);
                confirm_query($trang, $ts_tin);

                $ts_tin = mysqli_num_rows($trang);
                $soTrang = ceil($ts_tin / $display);
                for ($i = 1; $i <= $soTrang; $i++) {
                    echo "<li class='page-item'><a class='page-link' href='admin.php?trang={$i}'>{$i}</a></li>";

                }
                ?>
            </ul>
        </nav>
    </div>
</div>
</div><!--/.content-admin-->
</div>
<?php include "includes/footer.php"; ?>
