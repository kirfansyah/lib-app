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
                <a id="add" href="#" class="btn btn-added" data-bs-toggle="modal" data-bs-target="#create"><img src="assets/img/icons/plus.svg" alt="img" class="me-1">Add Member</a>
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
                                        <th>Email</th>
                                        <th>No Hp</th>
                                        <th>Alamat</th>
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
                                        <label>Nama</label>
                                        <input name="nama_member" id="nama_member" type="text" class="form-control w-300" required autocomplete="off">
                                        <input name="id_member" id="id_member" type="hidden" class="form-control w-300" required autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input name="email" id="email" type="email" class="form-control w-300" required autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label>No Hp</label>
                                        <input name="no_hp" id="no_hp" type="number" class="form-control w-300" required autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label>Alamat</label>
                                        <input name="alamat" id="alamat" type="text" class="form-control w-300" required autocomplete="off">
                                    </div>
                                </div>

                                <div class="col-md-12 col-sm-12">
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


                if ($.fn.DataTable.isDataTable('#userTable')) {
                    $('#userTable').DataTable().destroy(); // Hancurkan DataTable jika sudah ada
                }

                $('#userTable').DataTable({
                    "processing": false,
                    "serverSide": false,
                    "lengthChange": false, // Menyembunyikan "Show per page"
                    "ajax": {
                        "url": "get-member",
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
                    if (($(this).val().trim() === '' || $(this).val() === '-Choose-') && $(this).attr('name') != 'id_member') {
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
                // console.log(action);

                var formData = $('#user-data').serialize()
                var id = $('#id_member').val()
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
                    url: "get-member-by-id", // Pastikan path sudah benar
                    type: "POST",
                    data: {
                        id_member: id
                    },
                    dataType: "json",
                    success: function(response) {
                        console.log(response);


                        $('#id_member').val('')
                        $('#nama_member').val('')
                        $('#email').val('')
                        $('#no_hp').val('')
                        $('#alamat').val('')
                        $('#is_active').val('').trigger('change')

                        if (response.status === "success") {

                            $('#id_member').val(response.data.id_member)
                            $('#nama_member').val(response.data.nama_member)
                            $('#email').val(response.data.email)
                            $('#no_hp').val(parseInt(response.data.no_hp))
                            $('#alamat').val(response.data.alamat)
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

            $(document).on('click', '.delete-data', function(e) {
                e.preventDefault()
                var q = $(this)
                var id = q.closest('tr').find('.delete-data').data('id')
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
                            url: "delete-member",
                            type: "POST",
                            data: {
                                id_member: id
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
                    url: "add-member", // Pastikan path sudah benar
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
                    url: "update-member", // Pastikan path sudah benar
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
        </script>

        <!-- End Of Javascript -->
        <?php require_once __DIR__ . "/../../templates/footbarend.php"; ?>