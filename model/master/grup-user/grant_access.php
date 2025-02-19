<?php

require_once __DIR__ . "/../../../config/database.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $group_user_id = (int) $_POST['group_user_id'];
    $menu_id = (int) $_POST['menu_id'];
    $sub_menu_id = isset($_POST['sub_menu_id']) && $_POST['sub_menu_id'] !== "" ? (int) $_POST['sub_menu_id'] : 0;

    // Cek apakah akses sudah ada
    $query = "SELECT * FROM user_access WHERE group_user_id = $group_user_id AND menu_id = $menu_id AND (sub_menu_id = $sub_menu_id OR (sub_menu_id IS NULL AND $sub_menu_id IS NULL))";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        echo json_encode(["status" => "error", "message" => mysqli_error($conn)]);
        exit;
    }

    if (mysqli_num_rows($result) == 0) {
        $insert_query = "INSERT INTO user_access (group_user_id, menu_id, sub_menu_id) VALUES ($group_user_id, $menu_id, " . ($sub_menu_id === "NULL" ? "NULL" : $sub_menu_id) . ")";
        if (!mysqli_query($conn, $insert_query)) {
            echo json_encode(["status" => "error", "message" => mysqli_error($conn)]);
            exit;
        }
    }

    echo json_encode(["status" => "success"]);
}
