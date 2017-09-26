<?php session_start(); ?>
<?php include('includes/mysqli_connect.php'); ?>
<?php include('includes/function.php'); ?>
<?php
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
         if(isset($_FILES['image'])){
             //tao 1 array lưu biên slooix
             $errors = array();

             //kiểm tra file upload có đúng định dạng không.
             $allowed = array('image/jpg', 'image/jpeg', 'image/png', 'image/x-png');

             //kiểm tra upload có đúng định dạng không.e
             if(in_array(strtolower($_FILES['image']['type']), $allowed)) {

                 //tach lay phan mo rong
                 $ext = explode('.', $_FILES['image']['name']);
                 $file_extension = end($ext);
                 $rename =  uniqid(rand(), true) . '.' . "$file_extension";

                 if(!move_uploaded_file($_FILES['image']['tmp_name'],'upload/'.$rename )) {
                    echo "<p class='error'>Chưa up load</p>";
                 }
             }else {
                 echo "<p class='error'>file khong dung dinh dang</p>";
             }
         }//end isset file

        // Check for an error
        if($_FILES['image']['error'] > 0) {
            $errors[] = "<p class='error'>The file could not be uploaded because: <strong>";

            // Print the message based on the error
            switch ($_FILES['image']['error']) {
                case 1:
                    $errors[] .= "The file exceeds the upload_max_filesize setting in php.ini";
                    break;

                case 2:
                    $errors[] .= "The file exceeds the MAX_FILE_SIZE in HTML form";
                    break;

                case 3:
                    $errors[] .= "The was partially uploaded";
                    break;

                case 4:
                    $errors[] .= "NO file was uploaded";
                    break;

                case 6:
                    $errors[] .= "No temporary folder was available";
                    break;

                case 7:
                    $errors[] .= "Unable to write to the disk";
                    break;

                case 8:
                    $errors[] .= "File upload stopped";
                    break;

                default:
                    $errors[] .= "a system error has occured.";
                    break;
            } // END of switch

            $errors[] .= "</strong></p>";
        } // END of error IF

        // Xoa file da duoc upload va ton tai trong thu muc tam
        if(isset($_FILES['image']['tmp_name']) && is_file($_FILES['image']['tmp_name']) && file_exists($_FILES['image']['tmp_name'])) {
            unlink($_FILES['image']['tmp_name']);
        }
    }//end if main

    if(empty($errors)) {
        // Update cSDL
        $q = "UPDATE nhanvien SET avatar = '{$rename}' WHERE id_NV = {$_SESSION['dang_nhap']['id_NV']} LIMIT 1";
        $r = mysqli_query($dbc, $q); confirm_query($r, $q);

        if(mysqli_affected_rows($dbc) > 0) {
            // Update thanh cong, chuyen huong nguoi dung ve trang edit_profile
            header("location:chitiet_nhan_vien.php");
        }
    }

    if(!empty($message)) echo $message;

?>