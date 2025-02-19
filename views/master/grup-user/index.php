<?php require_once __DIR__ . "/../../../model/master/user/get_group_user.php"; ?>

<?php

$roles = mysqli_query($conn, "SELECT * FROM group_user");

$menus = mysqli_query($conn, "
    SELECT m.id as menu_id, m.name as menu_name, s.id as sub_menu_id, s.name as sub_menu_name 
    FROM menu m 
    LEFT JOIN sub_menu s ON m.id = s.menu_id 
    ORDER BY m.name, s.name
");

$menu_structure = [];
while ($menu = mysqli_fetch_assoc($menus)) {
    $menu_id = $menu['menu_id'];
    if (!isset($menu_structure[$menu_id]) && $menu_id != 1) {
        $menu_structure[$menu_id] = [
            'menu_name' => $menu['menu_name'],
            'sub_menus' => []
        ];
    }
    if ($menu['sub_menu_id']) {
        $menu_structure[$menu_id]['sub_menus'][] = [
            'sub_menu_id' => $menu['sub_menu_id'],
            'sub_menu_name' => $menu['sub_menu_name']
        ];
    }
}

// print_r($menu_structure);
// die;
?>
<?php require_once __DIR__ . "/../../templates/header.php"; ?>
<?php require_once __DIR__ . "/../../templates/navbar.php"; ?>
<?php require_once __DIR__ . "/../../templates/sidebar.php"; ?>

<style>
    .menu-list {
        list-style-type: none;
        /* Hilangkan bullet list */
        padding-left: 0;
    }

    .menu-list li {
        margin: 5px 0;
    }

    .menu-list .sub-menu {
        margin-left: 20px;
        /* Geser sub-menu ke dalam */
    }

    .sub-menu {
        margin-left: 20px;
        /* Geser submenu ke dalam */
        border-left: 2px solid #ddd;
        /* Garis untuk membedakan menu dan submenu */
        padding-left: 10px;
    }

    .menu-checkbox:checked+ul {
        display: block;
    }

    .sub-menu li:hover {
        background-color: #f5f5f5;
    }

    .equal-height {
        display: flex;
        align-items: stretch;
    }

    .equal-height .card {
        display: flex;
        flex-direction: column;
        width: 100%;
    }

    .equal-height .card-body {
        flex: 1;
    }
</style>


<!-- Content -->
<div class="page-wrapper pagehead">
    <div class="content">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title"><?= formatUrlLabel($main_page) . ' ' . formatUrlLabel($sub_page) ?></h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= $baseUrl ?>"><?= formatUrlLabel($main_page) ?? 'Dashboard' ?></a></li>
                        <li class="breadcrumb-item active"><?= formatUrlLabel($sub_page) ?? '' ?></li>
                    </ul>
                </div>
            </div>

            <div class="page-btn">
                <a id="add" href="#" class="btn btn-added" data-bs-toggle="modal" data-bs-target="#create"><img src="assets/img/icons/plus.svg" alt="img" class="me-1">Add Group User</a>
            </div>
        </div>
        <!-- isi content -->
        <div class="row equal-height">
            <!-- Kolom kanan -->
            <div class="col-sm-6">
                <div class="card">

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table  datanew " id="userTable">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Group User</th>
                                        <th>Is Active</th>
                                        <th>Create By</th>
                                        <th>Update By</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Kolom Kiri -->
            <div class="col-sm-6">

                <div class="card">
                    <div class="card-body">
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <select name="role" id="role-select" class="form-control w-300" required>
                                    <option>-Choose-</option>
                                </select>
                            </div>
                        </div>
                        <ul class="menu-list">
                            <?php foreach ($menu_structure as $menu_id => $menu) { ?>
                                <li>
                                    <input type="checkbox" class="menu-checkbox" data-menu="<?= $menu_id ?>"> <?= $menu['menu_name'] ?>
                                    <?php if (!empty($menu['sub_menus'])) { ?>
                                        <ul class="submenu sub-menu">
                                            <!-- Tambahkan class submenu -->
                                            <?php foreach ($menu['sub_menus'] as $sub) { ?>
                                                <li>
                                                    <input type="checkbox" class="sub-menu-checkbox" data-menu="<?= $menu_id ?>" data-submenu="<?= $sub['sub_menu_id'] ?>"> <?= $sub['sub_menu_name'] ?>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    <?php } ?>
                                </li>
                            <?php } ?>
                        </ul>

                        <div class="table-responsive">
                            <table class="table  " id="roleAccess">
                                <thead>
                                    <tr>
                                        <th style="width: 3px;">#</th>
                                        <th>Menu</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- akhir isi content  -->
        <!-- End Of Content -->


        <!-- Modal Add Data -->

        <!-- Modal -->
        <!-- Modal -->
        <div class="modal fade" id="create" tabindex="-1" aria-labelledby="create" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-lg modal-dialog-centered d-flex justify-content-center" role="document">
                <form action="" id="user-data">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Create</h5>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-12 col-sm-12">
                                    <div class="form-group">
                                        <label>Grup User</label>
                                        <input name="name" id="name" type="text" class="form-control w-300" required autocomplete="off">
                                        <input name="id" id="id" type="hidden" class="form-control w-300" required autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12">
                                    <div class="form-group">
                                        <label>Active</label>
                                        <select name="is_active" id="is_active" class="form-control w-300" required>
                                            <option>-Choose-</option>
                                            <option value="1">Aktif</option>
                                            <option value="0">Non-aktif</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="text-center mt-3">
                                <a class="btn btn-submit me-2">Submit</a>
                                <a class="btn btn-cancel" data-bs-dismiss="modal">Cancel</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>


        <!-- End Of Modal Add Data -->

        <?php require_once __DIR__ . "/../../templates/footbar.php"; ?>
        <!-- Javascript -->

        <script>
            $(document).ready(function() {
                replaceRole()


                if ($.fn.DataTable.isDataTable('#userTable')) {
                    $('#userTable').DataTable().destroy(); // Hancurkan DataTable jika sudah ada
                }

                $('#userTable').DataTable({
                    "processing": false,
                    "serverSide": false,
                    "lengthChange": false, // Menyembunyikan "Show per page"
                    "ajax": {
                        "url": "get-grup-user",
                        "type": "GET",
                        "dataSrc": function(json) {
                            console.log("Response Data:", json); // Log ke browser console
                            if (json.error) {
                                console.error("Error:", json.error);
                            }
                            return json.data;
                        },
                        "error": function(xhr, status, error) {
                            console.error("AJAX Error:", status, error);
                        }
                    },
                });

            });




            $(document).on('click', '.btn-submit', function() {

                var isValid = true;

                // Loop setiap input di dalam form
                $('#user-data input, #user-data select').each(function() {
                    if (($(this).val().trim() === '' || $(this).val() === '-Choose-') && $(this).attr('name') != 'id') {
                        isValid = false;
                        $(this).addClass('is-invalid'); // Tambahkan efek merah jika kosong
                    } else {
                        $(this).removeClass('is-invalid'); // Hapus efek merah jika diisi
                    }
                });

                if (!isValid) {
                    toastr.error('Harap isi semua field!', 'Error', {
                        closeButton: true,
                        progressBar: true,
                        positionClass: 'toast-top-right',
                        timeOut: 3000
                    });
                    return; // Hentikan proses jika ada field kosong
                }

                var action = $(this).attr('action')
                console.log(action);

                var formData = $('#user-data').serialize()
                var id = $('#id').val()
                if (action == 'add') {
                    addData(formData)
                }

                if (action == 'update') {
                    updateData(formData)
                }



            })


            $(document).on('click', '#add', function(e) {
                e.preventDefault()
                $('#user-data').trigger("reset");
                $('.modal-title').text('Create')
                $('.btn-submit').attr('action', 'add')
            })

            $(document).on('click', '.edit-data', function(e) {
                e.preventDefault()
                var q = $(this)
                var id = q.closest('tr').find('.edit-data').data('id')
                $('#user-data').trigger("reset");
                $('.modal-title').text('Update')
                $('.btn-submit').attr('action', 'update')
                console.log('id :', id);



                $.ajax({
                    url: "get-grup-user-by-id", // Pastikan path sudah benar
                    type: "POST",
                    data: {
                        id
                    },
                    dataType: "json",
                    success: function(response) {
                        console.log(response);


                        $('#id').val('')
                        $('#name').val('')

                        if (response.status === "success") {

                            $('#id').val(response.data.id)
                            $('#name').val(response.data.name)
                            $('#is_active').val(response.data.is_active).trigger('change');

                        } else {
                            alert(response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                    }
                });

            })

            $(document).on('click', '.delete-user', function(e) {
                e.preventDefault()
                var q = $(this)
                var id = q.closest('tr').find('.delete-user').data('id')
                console.log('ini id :', id);

                if (!id) {
                    Swal.fire("Error!", "ID tidak ditemukan!", "error");
                    return;
                }

                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "delete-grup-user",
                            type: "POST",
                            data: {
                                id
                            },
                            dataType: "json",
                            success: function(response) {
                                if (response.status === "success") {
                                    $('#create').modal('hide'); // Tutup modal
                                    $('#userTable').DataTable().ajax.reload(null, false); // Reload tanpa reset paging

                                    Swal.fire(
                                        'Berhasil!',
                                        'Data berhasil dihapus.',
                                        'success'
                                    );

                                    $('#user-data')[0].reset(); // Reset form setelah submit
                                } else {
                                    Swal.fire(
                                        'Gagal!',
                                        response.message,
                                        'error'
                                    );
                                }
                            },
                            error: function(xhr, status, error) {
                                console.log(xhr.responseText);
                            }
                        });
                    }
                });

            })


            function addData(formData) {
                $.ajax({
                    url: "add-grup-user", // Pastikan path sudah benar
                    type: "POST",
                    data: formData,
                    dataType: "json",
                    success: function(response) {
                        if (response.status === "success") {
                            $('#create').modal('hide'); // Tutup modal
                            $('#userTable').DataTable().ajax.reload(null, false); // Reload tanpa reset paging
                            replaceRole()
                            Swal.fire({
                                title: "Success!",
                                text: "Data berhasil disimpan.",
                                icon: "success"
                            });

                        } else {
                            alert(response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                    }
                });
            }

            $(document).on('change', '#role', function() {
                var id = $(this).val()
                $.ajax({
                    url: "get-access-menu-sub-menu", // Pastikan path sudah benar
                    type: "POST",
                    data: {
                        id
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.status === "success") {


                        } else {
                            alert(response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                    }
                });

            })


            function updateData(formData) {
                $.ajax({
                    url: "update-grup-user", // Pastikan path sudah benar
                    type: "POST",
                    data: formData,
                    dataType: "json",
                    success: function(response) {
                        if (response.status === "success") {
                            $('#create').modal('hide'); // Tutup modal
                            $('#userTable').DataTable().ajax.reload(null, false); // Reload tanpa reset paging
                            replaceRole()
                            Swal.fire({
                                title: "Success!",
                                text: "Data berhasil diupdate.",
                                icon: "success"
                            });

                        } else {
                            alert(response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                    }
                });

            }

            function replaceRole() {
                $.ajax({
                    url: "get-grup-users", // Pastikan path sudah benar
                    type: "POST",
                    dataType: "json",
                    success: function(response) {
                        if (response.status === "success") {
                            var opt = `<option>-Choose-</option>`
                            $.each(response.data, function(i, v) {
                                opt += `<option value="${v.id}">${v.name}</option>`
                            })
                            $('#role-select').html(opt)
                            let savedGroupUserId = localStorage.getItem("selectedGroupUser");
                            if (savedGroupUserId) {
                                $("#role-select").val(savedGroupUserId).trigger("change"); // Set nilai dan trigger change
                            }
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                    }
                });
            }
        </script>

        <!-- Role Access -->
        <script>
            $(document).ready(function() {
                function updateAccess(group_user_id, menu_id, sub_menu_id, isChecked) {
                    let url = isChecked ? "grant-access" : "revoke-access";
                    $.ajax({
                        url: url,
                        type: "POST",
                        data: {
                            group_user_id: group_user_id,
                            menu_id: menu_id,
                            sub_menu_id: sub_menu_id
                        },
                        dataType: "json",
                        success: function(response) {
                            console.log(response);
                            location.reload()

                        }
                    });
                }

                $(".sub-menu-checkbox").change(function() {
                    let group_user_id = $("#role-select").val();
                    let menu_id = $(this).data("menu");
                    let sub_menu_id = $(this).data("submenu");
                    let isChecked = $(this).prop("checked");

                    updateAccess(group_user_id, menu_id, sub_menu_id, isChecked);

                    if (isChecked) {
                        $(".menu-checkbox[data-menu='" + menu_id + "']").prop("checked", true);
                    }
                });

                $(".menu-checkbox").change(function() {
                    let group_user_id = $("#role-select").val();
                    let menu_id = $(this).data("menu");
                    let isChecked = $(this).prop("checked");
                    console.log('tess');


                    // $(".sub-menu-checkbox[data-menu='" + menu_id + "']").each(function() {
                    //     console.log('tess aa');

                    //     let sub_menu_id = $(this).data("submenu");
                    //     $(this).prop("checked", isChecked);
                    //     updateAccess(group_user_id, menu_id, sub_menu_id, isChecked);
                    // });
                    // Cek apakah menu ini punya sub-menu atau tidak
                    let subMenus = $(".sub-menu-checkbox[data-menu='" + menu_id + "']");

                    if (subMenus.length > 0) {
                        // Jika ada sub-menu, ubah semua sub-menu sesuai status menu utama
                        subMenus.each(function() {
                            let sub_menu_id = $(this).data("submenu");
                            $(this).prop("checked", isChecked);
                            updateAccess(group_user_id, menu_id, sub_menu_id, isChecked);
                        });
                    } else {
                        // Jika tidak ada sub-menu, langsung grant/revoke akses ke menu utama
                        updateAccess(group_user_id, menu_id, null, isChecked);
                    }
                });

                $("#role-select").change(function() {

                    let group_user_id = $(this).val();
                    $(".menu-checkbox, .sub-menu-checkbox").prop("checked", false);
                    localStorage.setItem("selectedGroupUser", group_user_id); // Simpan di localStorage

                    $.ajax({
                        url: "check-access",
                        type: "GET",
                        data: {
                            group_user_id: group_user_id
                        },
                        dataType: "json",
                        success: function(data) {
                            let menuSelected = {};
                            data.forEach(function(access) {
                                $(".sub-menu-checkbox[data-menu='" + access.menu_id + "'][data-submenu='" + access.sub_menu_id + "']")
                                    .prop("checked", true);
                                menuSelected[access.menu_id] = true;
                            });

                            Object.keys(menuSelected).forEach(function(menu_id) {
                                $(".menu-checkbox[data-menu='" + menu_id + "']").prop("checked", true);
                            });
                        }
                    });
                });
            });
        </script>

        <!-- End Of Javascript -->
        <?php require_once __DIR__ . "/../../templates/footbarend.php"; ?>