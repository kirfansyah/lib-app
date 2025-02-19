<?php

require_once __DIR__ . "/../../../config/database.php";

if (isset($_GET['group_user_id'])) {
    $group_user_id = $_GET['group_user_id'];

    $query = "SELECT menu_id, sub_menu_id FROM user_access WHERE group_user_id = $group_user_id";
    $result = mysqli_query($conn, $query);

    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }

    echo json_encode($data);
}
