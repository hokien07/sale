<?php
define('BASE_URL', 'http://localhost/quanly/');
//kiemt ra ket qua tra ve
function confirm_query($resault, $query) {
    global $dbc;
    if(!$resault) {
        die("Query {$query} <br/><br/> MYSQL ERROR: ". mysqli_error($dbc));
    }
}

// Tai dinh huong nguoi dung ve trang mac dinh la index
function redirect_to($page = 'index.php') {
    $url = BASE_URL . $page;
    header("Location: $url");
    exit();
}


function active_page($page){
    if(basename($_SERVER['SCRIPT_NAME']) ==  $page){
        echo " active";
    }
}
?>