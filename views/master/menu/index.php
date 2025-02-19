<?php require_once __DIR__ . "/../../../model/master/user/get_group_user.php"; ?>
<?php require_once __DIR__ . "/../../templates/header.php"; ?>
<?php require_once __DIR__ . "/../../templates/navbar.php"; ?>
<?php require_once __DIR__ . "/../../templates/sidebar.php"; ?>


<!-- Content -->
<div class="page-wrapper pagehead">
    <div class="content">
        <!-- Menu -->
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
                <a id="add" href="#" class="btn btn-added" data-bs-toggle="modal" data-bs-target="#create"><img src="assets/img/icons/plus.svg" alt="img" class="me-1">Add Menu</a>
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
                                        <th>Menu</th>
                                        <th>Icon</th>
                                        <th>Url</th>
                                        <th>No Urut</th>
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
        </div>

        <!-- Sub Menu -->
        <div class="page-header">
            <div class="row">

            </div>

            <div class="page-btn">
                <a id="add-sub-menu" href="#" class="btn btn-added" data-bs-toggle="modal" data-bs-target="#create-sub-menu"><img src="assets/img/icons/plus.svg" alt="img" class="me-1">Add Sub Menu</a>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table  datanew " id="subMenuTable">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Sub Menu</th>
                                        <th>Menu</th>
                                        <th>Icon</th>
                                        <th>Url</th>
                                        <th>No Urut</th>
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
        </div>
        <!-- akhir isi content  -->
        <!-- End Of Content -->


        <!-- Modal Add Data Menu -->
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
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label>Menu</label>
                                        <input name="name" id="name" type="text" class="form-control" required autocomplete="off">
                                        <input name="id" id="id" type="hidden" class="form-control" required autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label>Icon</label>
                                        <input name="icon" id="icon" type="text" class="form-control" required autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label>Url</label>
                                        <input name="url" id="url" type="text" class="form-control" required autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label>No Urut</label>
                                        <input name="ordinal_number" id="ordinal_number" type="number" class="form-control" required autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12">
                                    <div class="form-group">
                                        <label>Active</label>
                                        <select name="is_active" id="is_active" class="form-control" required>
                                            <option>-Choose-</option>
                                            <option value="1">Aktif</option>
                                            <option value="0">Non-aktif</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="text-center mt-3">
                                <a class="btn btn-submit me-2" id="submit-menu">Submit</a>
                                <a class="btn btn-cancel" data-bs-dismiss="modal">Cancel</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- End Of Modal Add Data Menu -->

        <!-- Modal Add Data Sub Menu -->
        <div class="modal fade" id="create-sub-menu" tabindex="-1" aria-labelledby="create" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-lg modal-dialog-centered d-flex justify-content-center" role="document">
                <form action="" id="sub-menu">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title judul">Create</h5>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label>Sub Menu</label>
                                        <input name="name" id="name" type="text" class="form-control name" required autocomplete="off">
                                        <input name="id_sub_menu" id="id-sub-menu" type="hidden" class="form-control id-sub-menu" required autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label>Menu</label>
                                        <select name="menu_id" id="menu_id" class="form-control menu_id" required>
                                            <option>-Choose-</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label>Icon</label>
                                        <input name="icon" id="icon" type="text" class="form-control icon" required autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label>Url</label>
                                        <input name="url" id="url" type="text" class="form-control url" required autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label>No Urut</label>
                                        <input name="ordinal_number" id="ordinal_number" type="number" class="form-control ordinal_number" required autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label>Active</label>
                                        <select name="is_active" id="is_active" class="form-control is_active" required>
                                            <option>-Choose-</option>
                                            <option value="1">Aktif</option>
                                            <option value="0">Non-aktif</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="text-center mt-3">
                                <a class="btn btn-submit me-2 sub-submit" id="submit">Submit</a>
                                <a class="btn btn-cancel" data-bs-dismiss="modal">Cancel</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- End Of Modal Add Data Sub Menu -->

        <?php require_once __DIR__ . "/../../templates/footbar.php"; ?>
        <!-- Javascript -->
        <!-- Menu -->
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
                        "url": "get-menu",
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




            $(document).on('click', '#submit-menu', function() {

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
                    alert('uuuu')

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
                    url: "get-menu-by-id", // Pastikan path sudah benar
                    type: "POST",
                    data: {
                        id
                    },
                    dataType: "json",
                    success: function(response) {
                        console.log(response);


                        $('#id').val('')
                        $('#name').val('')
                        $('#icon').val('')
                        $('#url').val('')
                        $('#ordinal_number').val('')

                        if (response.status === "success") {

                            $('#id').val(response.data.id)
                            $('#name').val(response.data.name)
                            $('#icon').val(response.data.icon)
                            $('#url').val(response.data.url)
                            $('#ordinal_number').val(response.data.ordinal_number)
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

            $(document).on('click', '.delete-menu', function(e) {
                e.preventDefault()
                var q = $(this)
                var id = q.closest('tr').find('.delete-menu').data('id')
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
                            url: "delete-menu",
                            type: "POST",
                            data: {
                                id
                            },
                            dataType: "json",
                            success: function(response) {
                                if (response.status === "success") {
                                    $('#create').modal('hide'); // Tutup modal
                                    $('#userTable').DataTable().ajax.reload(null, false); // Reload tanpa reset paging
                                    $('#subMenuTable').DataTable().ajax.reload(null, false); // Reload tanpa reset paging

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
                    url: "add-menu", // Pastikan path sudah benar
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
                    url: "update-menu", // Pastikan path sudah benar
                    type: "POST",
                    data: formData,
                    dataType: "json",
                    success: function(response) {
                        if (response.status === "success") {
                            $('#create').modal('hide'); // Tutup modal
                            $('#userTable').DataTable().ajax.reload(null, false); // Reload tanpa reset paging
                            $('#subMenuTable').DataTable().ajax.reload(null, false); // Reload tanpa reset paging

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
        </script>


        <!-- Sub Menu -->
        <script>
            $(document).ready(function() {
                showMenu()

                if ($.fn.DataTable.isDataTable('#subMenuTable')) {
                    $('#subMenuTable').DataTable().destroy(); // Hancurkan DataTable jika sudah ada
                }

                $('#subMenuTable').DataTable({
                    "processing": false,
                    "serverSide": false,
                    "lengthChange": false, // Menyembunyikan "Show per page"
                    "ajax": {
                        "url": "get-sub-menu",
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


            $(document).on('click', '#add-sub-menu', function(e) {
                e.preventDefault()
                $('#sub-menu').trigger("reset");
                $('.modal-title').text('Create')
                $('.sub-submit').attr('action', 'add')

                showMenu()
            })

            $(document).on('click', '#submit', function() {

                var isValid = true;

                // Loop setiap input di dalam form
                $('#sub-menu input, #sub-menu select').each(function() {
                    if (($(this).val().trim() === '' || $(this).val() === '-Choose-') && $(this).attr('name') != 'id_sub_menu') {
                        isValid = false;
                        $(this).addClass('is-invalid'); // Tambahkan efek merah jika kosong
                    } else {
                        $(this).removeClass('is-invalid'); // Hapus efek merah jika diisi
                    }
                });

                if (!isValid) {
                    alert('lalalal')
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

                var formData = $('#sub-menu').serialize()
                var id = $('#id').val()
                if (action == 'add') {
                    addDataSubMenu(formData)
                }

                if (action == 'update') {
                    updateDataSubMenu(formData)
                }
            })

            $(document).on('click', '.edit-sub-menu', function(e) {
                e.preventDefault()
                var q = $(this)
                var id = q.closest('tr').find('.edit-sub-menu').data('id')
                $('#sub-menu').trigger("reset");
                $('.modal-title').text('Update')
                $('.sub-submit').attr('action', 'update')
                console.log('id :', id);


                $.ajax({
                    url: "get-sub-menu-by-id", // Pastikan path sudah benar
                    type: "POST",
                    data: {
                        id
                    },
                    dataType: "json",
                    success: function(response) {
                        console.log(response);


                        $('.id-sub-menu').val('')
                        $('.name').val('')
                        $('.menu_id').val('')
                        $('.icon').val('')
                        $('.url').val('')
                        $('.ordinal_number').val('')

                        if (response.status === "success") {

                            $('.id-sub-menu').val(response.data.id)
                            $('.name').val(response.data.name)
                            $('.menu_id').val(response.data.menu_id)
                            $('.icon').val(response.data.icon)
                            $('.url').val(response.data.url)
                            $('.ordinal_number').val(response.data.ordinal_number)
                            $('.is_active').val(response.data.is_active).trigger('change');

                        } else {
                            alert(response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                    }
                });

            })

            $(document).on('click', '.delete-sub-menu', function(e) {
                e.preventDefault()
                var q = $(this)
                var id = q.closest('tr').find('.delete-sub-menu').data('id')
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
                            url: "delete-sub-menu",
                            type: "POST",
                            data: {
                                id
                            },
                            dataType: "json",
                            success: function(response) {
                                if (response.status === "success") {
                                    $('#create').modal('hide'); // Tutup modal
                                    $('#userTable').DataTable().ajax.reload(null, false); // Reload tanpa reset paging
                                    $('#subMenuTable').DataTable().ajax.reload(null, false); // Reload tanpa reset paging

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

            function addDataSubMenu(formData) {
                $.ajax({
                    url: "add-sub-menu", // Pastikan path sudah benar
                    type: "POST",
                    data: formData,
                    dataType: "json",
                    success: function(response) {
                        if (response.status === "success") {
                            $('#create-sub-menu').modal('hide'); // Tutup modal
                            $('#subMenuTable').DataTable().ajax.reload(null, false); // Reload tanpa reset paging

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

            function updateDataSubMenu(formData) {
                console.log('formdata :', formData);

                $.ajax({
                    url: "update-sub-menu", // Pastikan path sudah benar
                    type: "POST",
                    data: formData,
                    dataType: "json",
                    success: function(response) {
                        if (response.status === "success") {
                            $('#create-sub-menu').modal('hide'); // Tutup modal
                            $('#subMenuTable').DataTable().ajax.reload(null, false); // Reload tanpa reset paging

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

            function showMenu() {
                $.ajax({
                    url: 'get-menus',
                    type: "GET",
                    dataType: "json",
                    success: function(response) {
                        console.log('data :', response);

                        if (response.status === "success") {

                            var opt = '<option>-Choose-</option>'
                            $.each(response.data, function(i, v) {
                                console.log(v.data);

                                opt += `<option value="${v.id}">${v.name}</option>`
                            })

                            $('#menu_id').html(opt)


                        } else {
                            alert(response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                    }
                })
            }
        </script>

        <!-- End Of Javascript -->
        <?php require_once __DIR__ . "/../../templates/footbarend.php"; ?>