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
                    <div class="khachhang-moi">
                        <h2 style="text-transform: uppercase; text-align: center; padding-top: 20px; font-weight: bold; padding-bottom: 20px">
                            Kết quả tìm kiếm</h2>
                        <div class="table-responsive" style="overflow-x:auto;">
                            <table class="table table-inverse">
                                <thead>
                                <tr>
                                    <th>Họ & Tên</th>
                                    <th>Email</th>
                                    <th>Số Điện Thoại</th>
                                    <th>#</th>
                                </tr>
                                </thead>
                                <tbody>

                                <?php
                                // Nếu người dùng submit form thì thực hiện
                                if (isset($_GET['tim-kh'])) {
                                    // Gán hàm addslashes để chống sql injection
                                    $search = addslashes($_GET['search']);

                                    // Nếu $search rỗng thì báo lỗi, tức là người dùng chưa nhập liệu mà đã nhấn submit.
                                    if (empty($search)) {
                                        echo "Yeu cau nhap du lieu vao o trong";
                                    } else {
                                        // Dùng câu lênh like trong sql và sứ dụng toán tử % của php để tìm kiếm dữ liệu chính xác hơn.
                                        $q = "select * from khachhang where ten_KH like '%$search%'";
                                        $r = mysqli_query($dbc, $q);
                                        confirm_query($r, $q);
                                        $num = mysqli_num_rows($r);

                                        // Nếu có kết quả thì hiển thị, ngược lại thì thông báo không tìm thấy kết quả
                                        if ($num > 0 && $search != "") {
                                            // Dùng $num để đếm số dòng trả về.
                                            echo "$num ket qua tra ve voi tu khoa <b>$search</b>";

                                            // Vòng lặp while & mysql_fetch_assoc dùng để lấy toàn bộ dữ liệu có trong table và trả về dữ liệu ở dạng array.

                                            while ($row = mysqli_fetch_array($r)) {
                                                echo "
                                                 <tr>
                                                    <td>{$row['email_KH']}</td>
                                                    <td>{$row['sdt_KH']}</td>
                                                    <td>{$row['email_KH']}</td>
                                                    <td>
                                                        <a class='btn btn-primary' href='chitiet_khach_hang.php?id_kh={$row['id_KH']}&ten_kh={$row['ten_KH']}'>Chi Tiết</a>
                                                        <a class='btn btn-success' href='sua_khach_hang.php?id_kh={$row['id_KH']}'>Sửa</a>
                                                        <a class='btn btn-danger' href='xoa_khach_hang.php?id_kh={$row['id_KH']}&ten_kh={$row['ten_KH']}'>Xóa</a>
                                                    </td>
                                                </tr>
                                            ";
                                            }
                                        } else {
                                            echo "Khong tim thay ket qua!";
                                        }
                                    }
                                }
                                ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div><!--/.content-admin-->
            </div>
        </div>
    </div>
<?php include "includes/footer.php"; ?>