<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../config/functions.php';

$grup_user_id = $_SESSION['group_user_id'];
// Ambil halaman yang sedang diakses

// Mendapatkan URI yang diminta
$current_page = basename($_SERVER['REQUEST_URI']);
// Mengambil nama folder aplikasi secara otomatis
$base_path = dirname($_SERVER['SCRIPT_NAME']); // Ambil nama subfolder aplikasi

// Menghapus base_path dari URI yang diminta
$current_page = str_replace($base_path, '', $request_uri);
$pages = explode('-', $current_page);
$main_page = $pages[0] ?? '';
$sub_page = $pages[1] ?? '';



// Ambil Menu Utama
$menu_query = "SELECT DISTINCT m.* FROM menu m 
               JOIN user_access ua ON m.id = ua.menu_id
               WHERE ua.group_user_id = $grup_user_id
               AND is_active = 1 ORDER BY ordinal_number ASC";

$menus = executeQuery($conn, $menu_query);
?>

<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="<?= $current_page == '/' ? 'active' : '' ?>">
                    <a href="<?= sanitizeUrl($baseUrl, '/')  ?>">
                        <i data-feather="home"></i>
                        <span> Dashboard</span>
                    </a>
                </li>

                <?php while ($menu = $menus->fetch_assoc()) : ?>
                    <?php
                    // Ambil Sub-Menu
                    $sub_menu_query = "SELECT DISTINCT sm.* FROM sub_menu sm
                                       JOIN user_access ua ON sm.id = ua.sub_menu_id
                                       WHERE ua.group_user_id = $grup_user_id AND sm.menu_id = " . $menu['id'] .
                        " AND is_active = 1 ORDER BY ordinal_number ASC";

                    $sub_menus = executeQuery($conn, $sub_menu_query);

                    if ($sub_menus->num_rows > 0) { ?>
                        <li class="submenu">
                            <a href="javascript:void(0);" class="<?= $current_page == $menu['url'] ? 'active subdrop' : '' ?> ">
                                <i <?= ($menu['icon']) ?>></i>
                                <span> <?= htmlspecialchars($menu['name']) ?></span>
                                <span class="menu-arrow"></span>
                            </a>
                            <ul>
                                <?php while ($sub_menu = $sub_menus->fetch_assoc()) : ?>
                                    <li><a class="<?= $current_page == $sub_menu['url'] ? 'active' : '' ?>" href="<?= sanitizeUrl($baseUrl, $sub_menu['url'])  ?>"><?= htmlspecialchars($sub_menu['name']) ?></a></li>
                                <?php endwhile; ?>
                            </ul>
                        </li>
                    <?php } else { ?>
                        <li class="<?= $current_page == $menu['url'] ? 'active' : '' ?>">
                            <a href="<?= sanitizeUrl($baseUrl, $menu['url'])  ?>">
                                <i <?= ($menu['icon']) ?>></i>
                                <span> <?= htmlspecialchars($menu['name']) ?></span>
                            </a>
                        </li>

                    <?php } ?>
                <?php endwhile; ?>
            </ul>
        </div>
    </div>
</div>