<?php
include "includes/header.php";
include('includes/mysqli_connect.php');
include('includes/function.php');
include "includes/top-header.php";
if(empty($_SESSION)) {
  header('location:index.php');
}
?>

<div class="row">
  <div class="col-md-3">
    <?php include "includes/sidebar.php"; ?>
  </div>

  <div class="col-md-9">
    <div class="content">
      <?php
      //phan trang

      $display = 20;
      $id_nv = $_SESSION['dang_nhap']['id_NV'];
      //phan trang
      if (isset($_GET['trang']) && filter_var($_GET['trang'], FILTER_VALIDATE_INT, array('min-range' => 1))) {
        $from = ($_GET['trang'] - 1) * $display;
      } else {
        $from = 0;
      }
      ?>
      <!--Tìm kiếm khách hàng-->
      <form action="tim-khach-hang.php" method="get">
        <div class="col-sm-6 col-sm-offset-3">
          <div id="imaginary_container">
            <div class="input-group stylish-input-group">
              <input type="text" class="form-control" placeholder="Tìm khách hàng..."
              name="search">
              <span class="input-group-addon">
                <button type="submit" name="tim-kh" value="search">
                  <i class="fa fa-search"></i>
                </button>
              </span>
            </div>
          </div>
        </div>
      </form>

      <div class="khachhang-moi">
        <h2 style="text-transform: uppercase; text-align: center; padding-top: 20px; font-weight: bold; padding-bottom: 20px">
          Danh Sách Khách Hàng</h2>

          <!--Loc ngày và loại khách hàng-->
          <ul class="nav nav-tabs" id="pills-tab" role="tablist">
            <li class="nav-item col-md-4">
              <a class="nav-link active"
              id="home-tab" data-toggle="tab" href="#mua" role="tab" aria-controls="home"
              aria-expanded="true" style="background-color: #0c5460; color: #fff;">Dự Án (
              <?php
              $q_mua = "SELECT cskh.id_KH
                        FROM ChamSocKhacHang cskh
                        INNER JOIN khachhang kh ON kh.id_KH = cskh.id_KH
                        WHERE kh.loaikhach = 0 AND cskh.id_NV = {$id_nv}
                        ";
              $r_mua = mysqli_num_rows(mysqli_query($dbc, $q_mua));
              echo $r_mua . " Khách";
              ?>

              )</a>
            </li>
            <li class="nav-item col-md-4">
              <a class="nav-link" id="profile-tab" data-toggle="tab" href="#thue" role="tab"
              aria-controls="profile" style="background-color: #007bff; color: #fff;">Thuê (
              <?php
              $q_mua = "SELECT cskh.id_KH
                        FROM ChamSocKhacHang cskh
                        INNER JOIN khachhang kh ON kh.id_KH = cskh.id_KH
                        WHERE kh.loaikhach = 1 AND cskh.id_NV = {$id_nv}
                        ";
              $r_mua = mysqli_num_rows(mysqli_query($dbc, $q_mua));
              echo $r_mua . " Khách";
              ?>
              )</a>
            </li>
            <li class="nav-item col-md-4">
              <a class="nav-link" id="profile-tab" data-toggle="tab" href="#chuyen" role="tab"
              aria-controls="profile" style="background-color: #1e7e34; color: #fff;">Chuyển Nhuợng (
              <?php
              $q_mua = "SELECT cskh.id_KH
                        FROM ChamSocKhacHang cskh
                        INNER JOIN khachhang kh ON kh.id_KH = cskh.id_KH
                        WHERE kh.loaikhach = 2 AND cskh.id_NV = {$id_nv}";
              $r_mua = mysqli_num_rows(mysqli_query($dbc, $q_mua));
              echo $r_mua . " Khách";
              ?>
              )</a>
            </li>
          </ul>

          <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="mua" role="tabpanel" aria-labelledby="home-tab"
            style="padding: 10px;">
            <?php

            $q_mua = "SELECT *
            FROM ChamSocKhacHang cskh
            INNER JOIN khachhang kh ON kh.id_KH = cskh.id_KH
            WHERE kh.loaikhach = 0 AND cskh.id_NV = {$id_nv}
            ORDER BY cskh.id_KH DESC LIMIT $from, $display";
            $r_mua = mysqli_query($dbc, $q_mua);
            confirm_query($r_mua, $q_mua);
            $count2 = 0;
            while ($khachhang = mysqli_fetch_array($r_mua)): ?>
            <div style="border-bottom: 1px solid #111111; overflow: hidden; height: 40px; padding-top: 10px;">
              <div class="row">
                <div class="col-md-12">
                  <span data-toggle="collapse"
                  data-target="#collapse-<?php echo $count2?>" aria-expanded="false"
                  aria-controls="collapseExample" style="width: 100%; text-align: left">
                  <?php echo $khachhang['ten_KH'] . "--" . "0" . $khachhang['sdt_KH'] ?>

                </span>
              </div>
            </div>
          </div>

          <div class="collapse" id="collapse-<?php echo $count2 ?>">
            <div class="card card-block">
              <div class="meta">
                <p>Tên: <span><?php echo $khachhang['ten_KH'] ?>.</span></p>
                <p>Phone: <?php echo "0" . $khachhang['sdt_KH'] ?>.</p>
                <p>Email: <?php echo $khachhang['email_KH'] ?>.</p>
                <p>Ngày Thêm: <?php $phpdate = strtotime( $khachhang['ngay_them'] );
                echo $mysqldate = date( 'd-m-Y H:i:s', $phpdate ); ?>.</p>
                <p>Loại Khách:
                  <?php
                  if ($khachhang['loaikhach'] == 0) {
                    echo "Khách Mua";
                  } elseif ($khachhang['loaikhach'] == 1) {
                    echo "Khách Thuê";
                  } else {
                    echo "Chuyển Nhưỡng";
                  }
                  ?>.
                </p>
                <p>Thông tin thêm: <?php echo $khachhang['ttthem_KH'] ?></p>
                <div class="row">
                  <div class="col-md-4">
                    <a href="sua_khach_hang.php?id_kh=<?php echo $khachhang['id_KH'] ?>"
                      class="btn btn-primary">Cập Nhật Thông Tin</a>
                    </div>
                    <?php
                      if($_SESSION['dang_nhap']['loai_user'] == 1):
                    ?>
                    <div class="col-md-4">
                      <a href="xoa_khach_hang.php?id_kh=<?php echo $khachhang['id_KH']; ?>&ten_kh=<?php echo $khachhang['ten_KH']; ?>"
                        class="btn btn-danger">Xóa Khách Hàng Này</a>
                      </div>
                    <?php endif; ?>

                      <div class="col-md-4">
                        <a href="chot_khach.php?id_kh=<?php echo $khachhang['id_KH']; ?>"
                          class="btn btn-success">Chốt khách</a>

                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <?php $count2++; endwhile;
                ?>
                <nav aria-label="Page navigation example">
                  <ul class="pagination">
                    <?php
                    //lay tong so tin
                    $ts_tin = "SELECT id_KH FROM khachhang";
                    $trang = mysqli_query($dbc, $ts_tin);
                    confirm_query($trang, $ts_tin);

                    $ts_tin = mysqli_num_rows($trang);
                    $soTrang = ceil($ts_tin / $display);
                    for ($i = 1; $i <= $soTrang; $i++) {
                      echo "<li class='page-item'><a class='page-link' href='danhsachkhachhang.php?trang={$i}'>{$i}</a></li>";

                    }
                    ?>
                  </ul>
                </nav>
              </div>
              <div class="tab-pane fade" id="thue" role="tabpanel" aria-labelledby="profile-tab" style="padding: 10px;">
                <?php

                $q_thue = "SELECT *
                FROM ChamSocKhacHang cskh
                INNER JOIN khachhang kh ON kh.id_KH = cskh.id_KH
                WHERE kh.loaikhach = 1 AND cskh.id_NV = {$id_nv}
                ORDER BY cskh.id_KH DESC LIMIT $from, $display";
                $r_thue = mysqli_query($dbc, $q_thue);
                confirm_query($r_thue, $q_thue);
                $count1 = 0;
                while ($khachhang = mysqli_fetch_array($r_thue)): ?>
                <div style="border-bottom: 1px solid #111111; overflow: hidden; height: 40px; padding-top: 10px;">
                  <div class="row">
                    <div class="col-md-12">
                      <span data-toggle="collapse"
                      data-target="#collapse-<?php echo $count1 . "-thue" ?>" aria-expanded="false"
                      aria-controls="collapseExample" style="width: 100%; text-align: left">
                      <?php echo $khachhang['ten_KH'] . "--" . "0" . $khachhang['sdt_KH'] ?>

                    </span>
                  </div>
                </div>
              </div>

              <div class="collapse" id="collapse-<?php echo $count1 . "-thue" ?>">
                <div class="card card-block">
                  <div class="meta">
                    <p>Tên: <span><?php echo $khachhang['ten_KH'] ?>.</span></p>
                    <p>Phone: <?php echo "0" . $khachhang['sdt_KH'] ?>.</p>
                    <p>Email: <?php echo $khachhang['email_KH'] ?>.</p>
                    <p>Ngày Thêm: <?php $phpdate = strtotime( $khachhang['ngay_them'] );
                    echo $mysqldate = date( 'd-m-Y H:i:s', $phpdate ); ?>.</p>
                    <p>Loại Khách:
                      <?php
                      if ($khachhang['loaikhach'] == 0) {
                        echo "Khách Mua";
                      } elseif ($khachhang['loaikhach'] == 1) {
                        echo "Khách Thuê";
                      } else {
                        echo "Chuyển Nhưỡng";
                      }
                      ?>.
                    </p>
                    <p>Thông tin thêm: <?php echo $khachhang['ttthem_KH'] ?></p>
                    <div class="row">
                      <div class="col-md-4">
                        <a href="sua_khach_hang.php?id_kh=<?php echo $khachhang['id_KH'] ?>"
                          class="btn btn-primary">Cập Nhật Thông Tin</a>
                        </div>
                      <?php
                        if($_SESSION['dang_nhap']['loai_user'] == 1):
                      ?>
                      <div class="col-md-4">
                        <a href="xoa_khach_hang.php?id_kh=<?php echo $khachhang['id_KH']; ?>&ten_kh=<?php echo $khachhang['ten_KH']; ?>"
                          class="btn btn-danger">Xóa Khách Hàng Này</a>
                        </div>
                      <?php endif; ?>
                          <div class="col-md-4">
                            <a href="chot_khach.php?id_kh=<?php echo $khachhang['id_KH']; ?>"
                              class="btn btn-success">Chốt khách</a>

                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <?php $count1++; endwhile;
                    ?>
                    <nav aria-label="Page navigation example">
                      <ul class="pagination">
                        <?php
                        //lay tong so tin
                        $ts_tin = "SELECT id_KH FROM khachhang";
                        $trang = mysqli_query($dbc, $ts_tin);
                        confirm_query($trang, $ts_tin);

                        $ts_tin = mysqli_num_rows($trang);
                        $soTrang = ceil($ts_tin / $display);
                        for ($i = 1; $i <= $soTrang; $i++) {
                          echo "<li class='page-item'><a class='page-link' href='danhsachkhachhang.php?trang={$i}'>{$i}</a></li>";

                        }
                        ?>
                      </ul>
                    </nav>
                  </div>
                  <div class="tab-pane fade" id="chuyen" role="tablist" style="padding: 10px;">
                    <?php

                    $q_chuyen = "SELECT *
                    FROM ChamSocKhacHang cskh
                    INNER JOIN khachhang kh ON kh.id_KH = cskh.id_KH
                    WHERE kh.loaikhach = 2 AND cskh.id_NV = {$id_nv}
                    ORDER BY cskh.id_KH DESC LIMIT $from, $display";
                    $r_chuyen = mysqli_query($dbc, $q_chuyen);
                    confirm_query($r_chuyen, $q_chuyen);
                    $count3 = 0;
                    while ($khachhang = mysqli_fetch_array($r_chuyen)): ?>
                    <div style="border-bottom: 1px solid #111111; overflow: hidden; height: 40px; padding-top: 10px;">
                      <div class="row">
                        <div class="col-md-12">
                          <span data-toggle="collapse"
                          data-target="#collapse-<?php echo $count3 . "-chuyen" ?>" aria-expanded="false"
                          aria-controls="collapseExample" style="width: 100%; text-align: left">
                          <?php echo $khachhang['ten_KH'] . "--" . "0" . $khachhang['sdt_KH'] ?>
                        </span>
                      </div>
                    </div>
                  </div>

                  <div class="collapse" id="collapse-<?php echo $count3 . "-chuyen" ?>">
                    <div class="card card-block">
                      <div class="meta">
                        <p>Tên: <span><?php echo $khachhang['ten_KH'] ?>.</span></p>
                        <p>Phone: <?php echo "0" . $khachhang['sdt_KH'] ?>.</p>
                        <p>Email: <?php echo $khachhang['email_KH'] ?>.</p>
                        <p>Ngày Thêm: <?php
                        $phpdate = strtotime( $khachhang['ngay_them'] );
                        echo $mysqldate = date( 'd-m-Y H:i:s', $phpdate );
                        ?>.
                      </p>
                      <p>Loại Khách:
                        <?php
                        if ($khachhang['loaikhach'] == 0) {
                          echo "Khách Mua";
                        } elseif ($khachhang['loaikhach'] == 1) {
                          echo "Khách Thuê";
                        } else {
                          echo "Chuyển Nhưỡng";
                        }
                        ?>.
                      </p>
                      <p>Thông tin thêm: <?php echo $khachhang['ttthem_KH'] ?></p>
                      <div class="row">
                        <div class="col-md-4">
                          <a href="sua_khach_hang.php?id_kh=<?php echo $khachhang['id_KH'] ?>"
                            class="btn btn-primary">Cập Nhật Thông Tin</a>
                          </div>
                          <?php
                            if($_SESSION['dang_nhap']['loai_user'] == 1):
                          ?>
                          <div class="col-md-4">
                            <a href="xoa_khach_hang.php?id_kh=<?php echo $khachhang['id_KH']; ?>&ten_kh=<?php echo $khachhang['ten_KH']; ?>"
                              class="btn btn-danger">Xóa Khách Hàng Này</a>
                            </div>
                          <?php endif; ?>

                            <div class="col-md-4">
                              <a href="chot_khach.php?id_kh=<?php echo $khachhang['id_KH']; ?>"
                                class="btn btn-success">Chốt khách</a>

                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <?php $count3++; endwhile;
                      ?>
                      <nav aria-label="Page navigation example">
                        <ul class="pagination">
                          <?php
                          //lay tong so tin
                          $ts_tin = "SELECT id_KH FROM khachhang";
                          $trang = mysqli_query($dbc, $ts_tin);
                          confirm_query($trang, $ts_tin);

                          $ts_tin = mysqli_num_rows($trang);
                          $soTrang = ceil($ts_tin / $display);
                          for ($i = 1; $i <= $soTrang; $i++) {
                            echo "<li class='page-item'><a class='page-link' href='danhsachkhachhang.php?trang={$i}'>{$i}</a></li>";

                          }
                          ?>
                        </ul>
                      </nav>
                    </div>
                  </div>

                </div>
              </div>
            </div>
          </div>

          <?php include "includes/footer.php"; ?>
