<?php include "includes/header.php"; ?>
<?php include('includes/mysqli_connect.php'); ?>
<?php include('includes/function.php'); ?>
<?php include "includes/top-header.php"; ?>
<?php
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

                    <div class="khachhang-moi">
                        <h2 style="text-transform: uppercase; text-align: center; padding-top: 20px; font-weight: bold; padding-bottom: 20px">
                            Danh Sách Nhân Viên</h2>


                        <?php

                        $q = "SELECT * 
                              FROM nhanvien
                              ORDER BY id_NV";
                        $r = mysqli_query($dbc, $q);
                        confirm_query($r, $q);

                        $count = 0;
                        while ($nhanvien = mysqli_fetch_array($r)):  ?>
                            <p>
                                <button class="btn btn-default" type="button" data-toggle="collapse"
                                        data-target="#collapse-<?php echo $count ?>" aria-expanded="false"
                                        aria-controls="collapseExample" style="width: 100%; text-align: left">
                                    <?php echo $nhanvien['ten_NV'] . "---" . "0". $nhanvien['sdt_NV']; ?>
                                </button>
                            </p>

                            <div class="collapse" id="collapse-<?php echo $count ?>">
                                <div class="card card-block">
                                    <div class="meta">
                                        <img src="upload/<?php echo $nhanvien['avatar'] ?>" alt="Avatar"
                                             style="width:90px">
                                        <p><span><?php echo $nhanvien['ten_NV'] ?>.</span></p>
                                        <p>Phone: <?php echo "0". $nhanvien['sdt_NV'] ?>.</p>
                                        <p>Email: <?php echo $nhanvien['email_NV'] ?>.</p>
                                        <p>Chức vụ:
                                            <?php

                                            if($nhanvien['loai_user'] == 1)
                                                echo "Quản Lý";
                                            else
                                                echo "Nhân Viên";

                                            ?>.
                                        </p>
                                        <p><?php echo $nhanvien['ttthem_NV'] ?></p>
                                        <p>
                                            <a href="sua_nhan_vien.php?id_nv=<?php echo $nhanvien['id_NV'] ?>"
                                               class="btn btn-success">Cập Nhật Thông Tin</a>
                                            <a href="xoa_nhan_vien.php?id_nv=<?php echo $nhanvien['id_NV']; ?>&ten_nv=<?php echo $nhanvien['ten_NV']; ?>"
                                               class="btn btn-danger">Xóa Nhân Viên</a>
                                        </p>
                                    </div>

                                </div>
                            </div>
                            <?php $count++; endwhile;
                         ?>
                    </div>
                </div><!--/.content-admin-->
            </div>
        </div>

<?php include "includes/footer.php"; ?>