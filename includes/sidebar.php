<div class="sidebar">
    <div class="list-group">
        <?php
            if($_SESSION['dang_nhap']['loai_user'] == 1):
        ?>
            <a href="admin.php" class="list-group-item <?php if(basename($_SERVER['SCRIPT_NAME']) ==  'admin.php') echo " active"; ?>">Tổng Quan Ứng Dụng</a>
            <a href="themnhanvien.php?ten=them-nhan-vien" class="list-group-item list-group-item-action <?php if(basename($_SERVER['SCRIPT_NAME']) ==  'themnhanvien.php') echo " active"; ?>">Thêm Nhân Viên</a>
            <a href="themkhachhang.php" class="list-group-item list-group-item-action <?php if(basename($_SERVER['SCRIPT_NAME']) ==  'themkhachhang.php') echo " active"; ?>">Thêm Khách Hàng</a>
            <a href="themloaihang.php" class="list-group-item list-group-item-action <?php if(basename($_SERVER['SCRIPT_NAME']) ==  'themloaihang.php') echo " active"; ?>">Thêm Loại Hàng</a>
            <a href="danhsachnhanvien.php" class="list-group-item list-group-item-action <?php if(basename($_SERVER['SCRIPT_NAME']) ==  'danhsachnhanvien.php') echo " active"; ?>">Danh Sách Nhân Viên</a>
            <a href="danhsacloaihang.php" class="list-group-item list-group-item-action <?php if(basename($_SERVER['SCRIPT_NAME']) ==  'danhsacloaihang.php') echo " active"; ?>">Danh Sách Loại Hàng</a>
            <a href="danhsachkhachhang.php" class="list-group-item list-group-item-action <?php if(basename($_SERVER['SCRIPT_NAME']) ==  'danhsachkhachhang.php') echo " active"; ?>">Danh Sách Khách Hàng</a>
            <a href="chamsockhachhang.php" class="list-group-item list-group-item-action <?php if(basename($_SERVER['SCRIPT_NAME']) ==  'chamsockhachhang.php') echo " active"; ?>">Chăm Sóc Khách Hàng</a>
            <a href="khachchot.php" class="list-group-item list-group-item-action <?php if(basename($_SERVER['SCRIPT_NAME']) ==  'khachchot.php') echo " active"; ?>">Khách Hàng Đã Chốt</a>
            <a href="xem_log.php" class="list-group-item list-group-item-action <?php if(basename($_SERVER['SCRIPT_NAME']) ==  'xem_logphp') echo " active"; ?>">LOG</a>

        <?php elseif($_SESSION['dang_nhap']['loai_user'] == 0): ?>
            <a href="nv_tongquan.php" class="list-group-item list-group-item-action <?php if(basename($_SERVER['SCRIPT_NAME']) ==  'nv_tongquan.php') echo " active"; ?>">Tổng Quan</a>
            <a href="chamsockhachhang.php" class="list-group-item list-group-item-action <?php if(basename($_SERVER['SCRIPT_NAME']) ==  'chamsockhachhang.php') echo " active"; ?>">Chăm Sóc Khách Hàng</a>
            <a href="nv_them_kh.php" class="list-group-item list-group-item-action <?php if(basename($_SERVER['SCRIPT_NAME']) ==  'nv_them_kh.php') echo " active"; ?>">Thêm Khách Hàng</a>
            <a href="nv_dskh.php" class="list-group-item list-group-item-action <?php if(basename($_SERVER['SCRIPT_NAME']) ==  'nv_dskh.php') echo " active"; ?>">Danh Sách Khách Hàng</a>
            <a href="nv_khach_chot.php" class="list-group-item list-group-item-action <?php if(basename($_SERVER['SCRIPT_NAME']) ==  'nv_khach_chot.php') echo " active"; ?>">Khách Chốt</a>

        <?php endif; ?>
    </div>
</div>