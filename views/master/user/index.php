<?php require_once __DIR__ . "/../../../model/master/user/get_group_user.php"; ?>
<?php require_once __DIR__ . "/../../templates/header.php"; ?>
<?php require_once __DIR__ . "/../../templates/navbar.php"; ?>
<?php require_once __DIR__ . "/../../templates/sidebar.php"; ?>


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
                <a id="add" href="#" class="btn btn-added" data-bs-toggle="modal" data-bs-target="#create"><img src="assets/img/icons/plus.svg" alt="img" class="me-1">Add User</a>
            </div>
        </div>
        <!-- isi content -->
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <!-- <div class="card-header">
                        <h4 class="card-title">Default Datatable</h4>
                        <p class="card-text">
                            This is the most basic example of the datatables with zero configuration. Use the <code>.datatable</code> class to initialize datatables.
                        </p>
                    </div> -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table  datanew " id="userTable">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>ID</th>
                                        <th>Username</th>
                                        <th>Password</th>
                                        <th>Group User</th>
                                        <th>Create By</th>
                                        <th>Update By</th>
                                        <th>Is Active</th>
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
        </div>
        <!-- akhir isi content  -->
        <!-- End Of Content -->


        <!-- Modal Add Data -->

        <!-- Modal -->
        <div class="modal fade" id="create" tabindex="-1" aria-labelledby="create" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">

            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
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
                                <div class="col-lg-6 col-sm-12 col-12">
                                    <div class="form-group">
                                        <label>Nama</label>
                                        <input name="name" id="name" type="text" class="form-control" required autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12 col-12">
                                    <div class="form-group">
                                        <label>Id</label>
                                        <input name="id_number" id="id_number" type="text" class="form-control" required placeholder="ID Member / ID KTP">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12 col-12">
                                    <div class="form-group">
                                        <label>Username</label>
                                        <input name="username" id="username" type="text" class="form-control" required>
                                        <input name="id" id="id" type="hidden" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12 col-12">
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input name="password" id="password" type="text" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12 col-12">
                                    <div class="form-group">
                                        <label>Group User</label>
                                        <select name="group_user_id" id="group_user_id" id="" class="form-control" required>
                                            <option>-Choose-</option>
                                            <?php foreach ($data_group_user as $dt) : ?>
                                                <option value="<?= $dt['id'] ?>"><?= $dt['name'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12 col-12">
                                    <div class="form-group">
                                        <label>Active User</label>
                                        <select name="is_active" id="is_active" class="form-control" required>
                                            <option>-Choose-</option>
                                            <option value="1">Aktif</option>
                                            <option value="0">Non-aktif</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
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

                if ($.fn.DataTable.isDataTable('#userTable')) {
                    $('#userTable').DataTable().destroy(); // Hancurkan DataTable jika sudah ada
                }

                $('#userTable').DataTable({
                    "processing": false,
                    "serverSide": false,
                    "lengthChange": false, // Menyembunyikan "Show per page"
                    "ajax": {
                        "url": "get-users",
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

            let isUsernameExists = false;
            $(document).on('change', '#username', function() {
                var v = $(this).val().trim()
                var q = $(this)

                if (v !== '') {
                    $.ajax({
                        url: "check-user", // Pastikan path sudah benar
                        type: "POST",
                        data: {
                            username: v
                        },
                        dataType: "json",
                        success: function(response) {
                            if (response.status === "success") {
                                toastr.error('Username Sudah Ada!', 'Error', {
                                    closeButton: true,
                                    progressBar: true,
                                    positionClass: 'toast-top-right',
                                    timeOut: 3000
                                });
                                q.addClass('is-invalid');
                                isUsernameExists = true;
                            } else {
                                q.removeClass('is-invalid');
                                isUsernameExists = false;
                                // alert(response.message);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.log(xhr.responseText);
                        }
                    });

                }
            })




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

                if (isUsernameExists) {
                    toastr.warning('Form tidak dapat dikirim karena username sudah digunakan!', 'Peringatan', {
                        closeButton: true,
                        progressBar: true,
                        positionClass: 'toast-top-right',
                        timeOut: 3000
                    });
                    return
                }

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
                    url: "get-user-by-id", // Pastikan path sudah benar
                    type: "POST",
                    data: {
                        id
                    },
                    dataType: "json",
                    success: function(response) {
                        console.log(response);


                        $('#id').val('')
                        $('#name').val('')
                        $('#id_number').val('')
                        $('#username').val('')
                        $('#password').val('')

                        if (response.status === "success") {

                            $('#id').val(response.data.id)
                            $('#name').val(response.data.name)
                            $('#id_number').val(response.data.id_number)
                            $('#username').val(response.data.username)
                            $('#password').val(response.data.password)
                            $('#group_user_id').val(response.data.group_user_id).trigger('change');
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
                            url: "delete-user",
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
                    url: "add-user", // Pastikan path sudah benar
                    type: "POST",
                    data: formData,
                    dataType: "json",
                    success: function(response) {
                        if (response.status === "success") {
                            $('#create').modal('hide'); // Tutup modal
                            $('#userTable').DataTable().ajax.reload(null, false); // Reload tanpa reset paging

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


            function updateData(formData) {
                $.ajax({
                    url: "update-user", // Pastikan path sudah benar
                    type: "POST",
                    data: formData,
                    dataType: "json",
                    success: function(response) {
                        if (response.status === "success") {
                            $('#create').modal('hide'); // Tutup modal
                            $('#userTable').DataTable().ajax.reload(null, false); // Reload tanpa reset paging

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

            $(document).on('change', '#name', function() {
                if ($('.btn-submit').attr('action') == 'add') {

                    var name = $(this).val().trim().split(' ')
                    $('#username').val(name[0].toUpperCase()).trigger('change')
                    $('#password').val(name[0].toUpperCase() + '1234')
                    $('#is_active').val(1).trigger('change')
                }

            })
        </script>

        <!-- End Of Javascript -->
        <?php require_once __DIR__ . "/../../templates/footbarend.php"; ?>