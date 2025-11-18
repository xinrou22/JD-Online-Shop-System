<?php
include('connect/config.php');

if (isset($_POST['country_id'])) {
    $c_id = $_POST['country_id'];
    $fetch_query = mysqli_query($conn, "SELECT * FROM states WHERE country_id='$c_id'");
    $result = "";
    while ($res_arr = mysqli_fetch_array($fetch_query)) {
        $result .= '<option value=' . $res_arr['id'] . '>' . $res_arr['name'] . '</option>';
    }
    echo $result;
}

if (isset($_POST['state_id']) && $_POST['type'] == 'state') {
    $s_id = $_POST['state_id'];
    $fetch_query = mysqli_query($conn, "SELECT * FROM cities WHERE state_id='$s_id'");
    $result = "";
    while ($res_arr = mysqli_fetch_array($fetch_query)) {
        $result .= '<option value=' . $res_arr['id'] . '>' . $res_arr['name'] . '</option>';
    }
    echo $result;
}
?>
