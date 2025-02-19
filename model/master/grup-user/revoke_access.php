<?php

require_once __DIR__ . "/../../../config/database.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $group_user_id = $_POST['group_user_id'];
    $menu_id = $_POST['menu_id'];
    $sub_menu_id = $_POST['sub_menu_id'];

    $delete_query = "DELETE FROM user_access WHERE group_user_id = $group_user_id AND menu_id = $menu_id AND sub_menu_id = $sub_menu_id";
    mysqli_query($conn, $delete_query);

    echo json_encode(["status" => "success"]);
}
