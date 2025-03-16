<?php
// Routing untuk aplikasi
return [
    // Dashbord
    '/'                           => 'views/index.php',

    // Master User
    '/master-user'                => 'views/master/user/index.php',
    '/get-users'                  => 'model/master/user/get_users.php',
    '/add-user'                   => 'model/master/user/add_user.php',
    '/delete-user'                => 'model/master/user/delete_user.php',
    '/get-user-by-id'             => 'model/master/user/get_user_by_id.php',
    '/update-user'                => 'model/master/user/update_user.php',
    '/check-user'                 => 'model/master/user/check_user.php',

    // Master Grup User
    '/master-grup-user'           => 'views/master/grup-user/index.php',
    '/get-grup-user'              => 'model/master/grup-user/get_grup_user.php',
    '/get-grup-users'             => 'model/master/grup-user/get_grup_users.php',
    '/add-grup-user'              => 'model/master/grup-user/add_grup_user.php',
    '/get-grup-user-by-id'        => 'model/master/grup-user/get_grup_user_by_id.php',
    '/get-grup-user-by-uuid/{id}' => 'views/master/grup-user/role_akses.php',
    '/update-grup-user'           => 'model/master/grup-user/update_grup_user.php',
    '/delete-grup-user'           => 'model/master/grup-user/delete_grup_user.php',
    '/get-access-menu-sub-menu'   => 'model/master/grup-user/get_access_menu_sub_menu.php',
    '/grant-access'               => 'model/master/grup-user/grant_access.php',
    '/revoke-access'              => 'model/master/grup-user/revoke_access.php',
    '/check-access'               => 'model/master/grup-user/check_access.php',


    // Master Menu - Sub Menu
    '/master-menu'                => 'views/master/menu/index.php',
    '/get-menu'                   => 'model/master/menu/get_menu.php',
    '/add-menu'                   => 'model/master/menu/add_menu.php',
    '/get-menu-by-id'             => 'model/master/menu/get_menu_by_id.php',
    '/update-menu'                => 'model/master/menu/update_menu.php',
    '/delete-menu'                => 'model/master/menu/delete_menu.php',

    // Sub Menu
    '/get-sub-menu'               => 'model/master/menu/get_sub_menu.php',
    '/get-menus'                  => 'model/master/menu/get_menus.php',
    '/add-sub-menu'               => 'model/master/menu/add_sub_menu.php',
    '/get-sub-menu-by-id'         => 'model/master/menu/get_sub_menu_by_id.php',
    '/update-sub-menu'            => 'model/master/menu/update_sub_menu.php',
    '/delete-sub-menu'            => 'model/master/menu/delete_sub_menu.php',

    // Master Kategori
    '/master-kategori'            => 'views/master/kategori/index.php',
    '/get-kategori'               => 'model/master/kategori/get_kategori.php',
    '/add-kategori'               => 'model/master/kategori/add_kategori.php',
    '/delete-kategori'            => 'model/master/kategori/delete_kategori.php',
    '/get-kategori-by-id'         => 'model/master/kategori/get_kategori_by_id.php',
    '/update-kategori'            => 'model/master/kategori/update_kategori.php',


    // Master Buku
    '/master-buku'                => 'views/master/buku/index.php',
    '/get-buku'                   => 'model/master/buku/get_buku.php',
    '/get-bukus'                  => 'model/master/buku/get_bukus.php',
    '/add-buku'                   => 'model/master/buku/add_buku.php',
    '/delete-buku'                => 'model/master/buku/delete_buku.php',
    '/get-buku-by-id'             => 'model/master/buku/get_buku_by_id.php',
    '/update-buku'                => 'model/master/buku/update_buku.php',
    '/get-kategori-buku'          => 'model/master/buku/get_kategori_buku.php',

    // Transaksi Member
    '/member-perpus'              => 'views/transaksi/member/index.php',
    '/get-member'                 => 'model/transaksi/member/get_member.php',
    '/get-members'                 => 'model/transaksi/member/get_members.php',
    '/add-member'                 => 'model/transaksi/member/add_member.php',
    '/delete-member'              => 'model/transaksi/member/delete_member.php',
    '/get-member-by-id'           => 'model/transaksi/member/get_member_by_id.php',
    '/update-member'              => 'model/transaksi/member/update_member.php',
    '/get-kategori-member'        => 'model/transaksi/member/get_kategori_member.php',

    // Transaksi Peminjaman dan Pengembakian
    '/peminjaman-buku'            => 'views/transaksi/peminjaman/index.php',
    '/get-loan'                   => 'model/transaksi/peminjaman/get_loan.php',
    '/get-loans'                  => 'model/transaksi/peminjaman/get_loans.php',
    '/add-loan'                   => 'model/transaksi/peminjaman/add_loan.php',
    '/delete-loan'                => 'model/transaksi/peminjaman/delete_loan.php',
    '/get-loan-by-id'             => 'model/transaksi/peminjaman/get_loan_by_id.php',
    '/update-loan'                => 'model/transaksi/peminjaman/update_loan.php',


    // Utilities
    '/forbidden-accesss'          => '403.php',
    '/login'                      => 'views/auth/login.php',
    '/verify-login'               => 'model/auth/verify_login.php',
    '/logout'                     => 'model/auth/logout.php',

];
