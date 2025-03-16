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
                <a id="add" href="#" class="btn btn-added" data-bs-toggle="modal" data-bs-target="#create"><img src="assets/img/icons/plus.svg" alt="img" class="me-1">Add Transaction</a>
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
                                        <th>Judul Buku</th>
                                        <th>Status</th>
                                        <th>Tanggal Pinjam</th>
                                        <th>Tanggal Pengembalian Seharusnya</th>
                                        <th>Tanggal Dikembalikan Actual</th>
                                        <th>Denda</th>
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
                                        <select name="id_member" id="id_member" class="form-control w-300 select2" required>
                                            <option>-Choose-</option>
                                        </select>
                                        <input name="id_peminjaman" id="id_peminjaman" type="hidden" class="form-control w-300" required autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label>Judul Buku</label>
                                        <select name="id_buku" id="id_buku" class="form-control w-300 select2" required>
                                            <option>-Choose-</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label>Tanggal Pinjam </label>
                                        <div class="input-groupicon">
                                            <input name="tanggal_pinjam" id="tanggal_pinjam" type="text" placeholder="DD-MM-YYYY" class="datetimepicker tanggal">
                                            <div class="addonset">
                                                <img src="<?= $baseUrl ?>assets/img/icons/calendars.svg" alt="img">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label>Tanggal Pengembalian Seharusnya </label>
                                        <div class="input-groupicon">
                                            <input name="tanggal_pengembalian_seharusnya" id="tanggal_pengembalian_seharusnya" type="text" placeholder="DD-MM-YYYY" class="datetimepicker tanggal">
                                            <div class="addonset">
                                                <img src="<?= $baseUrl ?>assets/img/icons/calendars.svg" alt="img">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 col-sm-12 hidden-item">
                                    <div class="form-group">
                                        <label>Tanggal Dikembalikan Actual </label>
                                        <div class="input-groupicon">
                                            <input name="tanggal_kembali" id="tanggal_kembali" type="text" placeholder="DD-MM-YYYY" class="datetimepicker tanggal">
                                            <div class="addonset">
                                                <img src="<?= $baseUrl ?>assets/img/icons/calendars.svg" alt="img">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 col-sm-12 hidden-item">
                                    <div class="form-group">
                                        <label>Denda</label>
                                        <input name="denda" id="denda" type="text" class="form-control w-300" required autocomplete="off" readonly>
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
                getMember()
                getBuku()
                // $('.hidden-item').hide()


                if ($.fn.DataTable.isDataTable('#userTable')) {
                    $('#userTable').DataTable().destroy(); // Hancurkan DataTable jika sudah ada
                }

                $('#userTable').DataTable({
                    "processing": false,
                    "serverSide": false,
                    "lengthChange": false, // Menyembunyikan "Show per page"
                    "ajax": {
                        "url": "get-loans",
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
                    if (($(this).val().trim() === '' || $(this).val() === '-Choose-') && $(this).attr('name') != 'id_peminjaman' && $(this).attr('name') != 'tanggal_kembali' && $(this).attr('name') != 'denda') {
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
                    Swal.fire({
                        title: "Simpan Transaksi Ini ?",
                        text: "Setelah ini, kamu ga bisa edit transaksi!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Simpan!"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            addData(formData)
                        }
                    });
                }

                if (action == 'update') {
                    Swal.fire({
                        title: "Update Transaksi Ini ?",
                        text: "Setelah ini, kamu ga bisa edit transaksi!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Ya, Update!"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            updateData(formData)
                        }
                    });
                }



            })


            $(document).on('click', '#add', function(e) {
                e.preventDefault()
                $('#user-data').trigger("reset");
                $('.modal-title').text('Create')
                $('.btn-submit').attr('action', 'add')

                $('#id_member').prop('readonly', false)
                $('#id_buku').prop('readonly', false)
                $('#tanggal_pinjam').prop('readonly', false)
                $('#tanggal_pinjam').prop('readonly', false)
                $('#tanggal_pengembalian_seharusnya').prop('readonly', false)
                $('#tanggal_kembali').prop('readonly', true)
                $('#denda').prop('readonly', true)
            })

            $(document).on('click', '.edit-data', function(e) {
                e.preventDefault()
                var q = $(this)
                var id = q.closest('tr').find('.edit-data').data('id')
                $('#user-data').trigger("reset");
                $('.modal-title').text('Update')
                $('.btn-submit').attr('action', 'update')

                $('#id_member').prop('readonly', true)
                $('#id_buku').prop('readonly', true)
                $('#tanggal_pinjam').prop('readonly', true)
                $('#tanggal_pengembalian_seharusnya').prop('readonly', true)
                $('#tanggal_kembali').prop('readonly', false)
                $('#denda').prop('readonly', true)


                $.ajax({
                    url: "get-loan-by-id", // Pastikan path sudah benar
                    type: "POST",
                    data: {
                        id_peminjaman: id
                    },
                    dataType: "json",
                    success: function(response) {
                        console.log('res: ', response);


                        $('#id_member').val('').trigger('change')
                        $('#id_peminjaman').val('')
                        $('#id_buku').val('').trigger('change')
                        $('#tanggal_pinjam').val('')
                        $('#tanggal_pengembalian_seharusnya').val('')
                        $('#tanggal_kembali').val('')
                        $('#denda').val('')

                        if (response.status === "success") {

                            $('#id_member').val(response.data.id_member).trigger('change');
                            $('#id_peminjaman').val(response.data.id_peminjaman)
                            $('#id_buku').val(response.data.id_buku).trigger('change');
                            var tanggal
                            $('#tanggal_pinjam').val(response.data.tanggal_pinjam.split('-').reverse().join('-'))
                            $('#tanggal_pengembalian_seharusnya').val(response.data.tanggal_pengembalian_seharusnya.split('-').reverse().join('-'))
                            // $('#tanggal_kembali').val((response.data.tanggal_kembali.split('-').reverse().join('-')))
                            // $('#denda').val(parseInt(response.data.denda))

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
                    url: "add-loan", // Pastikan path sudah benar
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
                    url: "update-loan", // Pastikan path sudah benar
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


            function getMember() {
                $.ajax({
                    url: "get-members", // Pastikan path sudah benar
                    type: "GET",
                    dataType: "json",
                    success: function(response) {

                        if (response.status === "success") {
                            let opt = `<option>-Choose-</option>`
                            $.each(response.data, function(i, v) {
                                opt += `<option value="${v.id_member}">${v.nama_member}</option>`
                            })

                            $('#id_member').html(opt)

                        } else {
                            alert(response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                    }
                });
            }

            function getBuku() {
                $.ajax({
                    url: "get-bukus", // Pastikan path sudah benar
                    type: "GET",
                    dataType: "json",
                    success: function(response) {

                        if (response.status === "success") {
                            let opt = `<option>-Choose-</option>`
                            $.each(response.data, function(i, v) {
                                opt += `<option value="${v.id_buku}">${v.judul_buku}</option>`
                            })
                            $('#id_buku').html(opt)

                        } else {
                            alert(response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                    }
                });
            }

            $(document).on('click', '#denda', function() {


                var tglSeharusnya = $("#tanggal_pengembalian_seharusnya").val();
                var tglAktual = $("#tanggal_kembali").val();

                console.log("Tanggal Seharusnya (raw):", tglSeharusnya);
                console.log("Tanggal Aktual (raw):", tglAktual);

                if (tglSeharusnya && tglAktual) {
                    var tglSeharusnyaFormatted = formatTanggal(tglSeharusnya);
                    var tglAktualFormatted = formatTanggal(tglAktual);

                    console.log("Tanggal Seharusnya (formatted):", tglSeharusnyaFormatted);
                    console.log("Tanggal Aktual (formatted):", tglAktualFormatted);

                    var dateSeharusnya = new Date(tglSeharusnyaFormatted);
                    var dateAktual = new Date(tglAktualFormatted);

                    console.log("Date Object Seharusnya:", dateSeharusnya);
                    console.log("Date Object Aktual:", dateAktual);

                    if (dateAktual > dateSeharusnya) {
                        var selisihHari = Math.ceil((dateAktual - dateSeharusnya) / (1000 * 60 * 60 * 24));
                        var denda = selisihHari * 1000;
                        $("#denda").val(denda);
                    } else {
                        $("#denda").val(0);
                    }
                }


            })

            function formatTanggal(tgl) {
                var parts = tgl.split("-"); // Pisahkan berdasarkan "-"
                return parts[2] + "-" + parts[1] + "-" + parts[0]; // Susun ulang jadi YYYY-MM-DD
            }
        </script>

        <!-- End Of Javascript -->
        <?php require_once __DIR__ . "/../../templates/footbarend.php"; ?>