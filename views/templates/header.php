<?php
require_once __DIR__ . "/../../config/check_access.php";
require_once __DIR__ . "/../../config/config.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description" content="POS - Bootstrap Admin Template">
    <meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern,  html5, responsive">
    <meta name="author" content="Dreamguys - Bootstrap Admin Template">
    <meta name="robots" content="noindex, nofollow">
    <title>BookVault</title>

    <link rel="shortcut icon" type="image/x-icon" href="<?= $baseUrl ?>assets/img/favicon.jpg">

    <link rel="stylesheet" href="<?= $baseUrl ?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= $baseUrl ?>assets/plugins/toastr/toatr.css">

    <link rel="stylesheet" href="<?= $baseUrl ?>assets/css/animate.css">

    <link rel="stylesheet" href="<?= $baseUrl ?>assets/css/dataTables.bootstrap4.min.css">

    <link rel="stylesheet" href="<?= $baseUrl ?>assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="<?= $baseUrl ?>assets/plugins/fontawesome/css/all.min.css">

    <link rel="stylesheet" href="<?= $baseUrl ?>assets/css/style.css">
    <link rel="stylesheet" href="<?= $baseUrl ?>assets/css/sweetalert2.min.css">
    <link rel="stylesheet" href="<?= $baseUrl ?>assets/css/select2.min.css">

    <link rel="stylesheet" href="<?= $baseUrl ?>assets/css/style.css">

    <!-- DatePicker -->
    <link rel="stylesheet" href="<?= $baseUrl ?>assets/css/bootstrap-datepicker.min.css">

    <style>
        /* --- Styling utama datepicker (lebih kecil) --- */
        .datepicker {
            font-family: 'Arial', sans-serif;
            background: #ffffff;
            border-radius: 6px;
            border: 1px solid #ddd;
            box-shadow: 0px 3px 8px rgba(0, 0, 0, 0.12);
            padding: 8px;
            width: 260px;
            /* Perkecil ukuran box */
        }

        /* --- Header (Bulan & Tahun) lebih kecil --- */
        .datepicker-days th {
            background-color: #007bff;
            color: white;
            font-size: 12px;
            padding: 6px;
            text-transform: uppercase;
            text-align: center;
        }

        /* --- Ukuran table lebih kecil & seimbang --- */
        .datepicker-days table {
            width: 100%;
            text-align: center;
        }

        /* --- Kolom tanggal lebih kecil & rata --- */
        .datepicker-days td,
        .datepicker-days th {
            width: 32px;
            height: 32px;
            line-height: 32px;
            font-size: 12px;
            text-align: center;
        }

        /* --- Warna hover pada tanggal --- */
        .datepicker-days td:hover {
            background: #007bff;
            color: white;
            border-radius: 50%;
            transition: all 0.2s ease-in-out;
        }

        /* --- Warna tanggal yang dipilih --- */
        .datepicker-days td.active,
        .datepicker-days td.active:hover {
            background: #28a745 !important;
            color: white !important;
            border-radius: 50%;
        }

        /* --- Warna highlight hari ini --- */
        .datepicker-days td.today {
            background: #ffcc00 !important;
            color: #000 !important;
            font-weight: bold;
            border-radius: 50%;
        }

        /* --- Tombol navigasi bulan (lebih kecil) --- */
        .datepicker .prev,
        .datepicker .next {
            color: #007bff !important;
            font-size: 14px;
            text-align: center;
        }

        /* --- Header (Bulan & Tahun) lebih rapi --- */
        .datepicker .datepicker-switch {
            background-color: #007bff;
            color: white;
            font-size: 14px;
            padding: 8px;
            font-weight: bold;
            text-align: center;
            border-radius: 5px;
            cursor: pointer;
        }

        /* --- Hover efek pada tombol bulan/tahun --- */
        .datepicker .datepicker-switch:hover {
            background-color: #0056b3;
        }

        /* --- Navigasi bulan & tahun (panah kiri/kanan) --- */
        .datepicker .prev,
        .datepicker .next {
            color: #007bff !important;
            font-size: 14px;
            text-align: center;
        }

        /* --- Pemilihan bulan (grid 3x4) agar simetris --- */
        .datepicker-months td,
        .datepicker-years td {
            text-align: center;
        }

        .datepicker-months span,
        .datepicker-years span {
            width: 72px;
            /* Ukuran lebih kecil */
            height: 40px;
            line-height: 40px;
            font-size: 13px;
            text-align: center;
            display: inline-block;
            border-radius: 5px;
            margin: 3px;
            cursor: pointer;
        }

        /* --- Hover dan Active untuk bulan/tahun --- */
        .datepicker-months span:hover,
        .datepicker-years span:hover {
            background: #007bff;
            color: white;
        }

        .datepicker-months span.active,
        .datepicker-years span.active {
            background: #28a745 !important;
            color: white !important;
            font-weight: bold;
        }

        /* --- Grid bulan lebih kecil dan simetris --- */
        .datepicker-months table,
        .datepicker-years table {
            width: 100%;
            text-align: center;
        }

        .select2-search--dropdown {
            display: block !important;
        }

        .select2-search__field {
            pointer-events: auto !important;
            opacity: 1 !important;
            cursor: text !important;
        }

        /* Pastikan panah navigasi terlihat */
        .datepicker .prev,
        .datepicker .next {
            color: white !important;
            /* Warna lebih kontras */
            font-size: 18px !important;
            /* Ukuran lebih besar */
            width: 32px;
            height: 32px;
            line-height: 32px;
            text-align: center;
            /* border-radius: 50%; */
            background: #007bff;
            /* Warna latar belakang */
        }

        Hover efek pada navigasi .datepicker .prev:hover,
        .datepicker .next:hover {
            background: #0056b3;
            color: #0056b3;
        }

        /* Hover bulan & tahun */
        .datepicker-months span:hover,
        .datepicker-years span:hover {
            background: #007bff !important;
            color: white !important;
            font-weight: bold;
        }

        /* Jika active (bulan/tahun yang dipilih) */
        .datepicker-months span.active,
        .datepicker-years span.active {
            background: #28a745 !important;
            color: white !important;
            font-weight: bold;
            border-radius: 5px;
        }
    </style>

</head>