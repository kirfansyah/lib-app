<?php
session_start();

// Jika session user_id tidak ada, kirim "expired"
if (!isset($_SESSION['user_id'])) {
    echo "expired";
} else {
    echo "active"; // Jika session masih ada
}
