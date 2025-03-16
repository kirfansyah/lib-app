</div>


<script src="<?= $baseUrl ?>assets/js/jquery-3.6.0.min.js"></script>

<script src="<?= $baseUrl ?>assets/js/feather.min.js"></script>

<script src="<?= $baseUrl ?>assets/js/jquery.slimscroll.min.js"></script>

<script src="<?= $baseUrl ?>assets/js/jquery.dataTables.min.js"></script>
<script src="<?= $baseUrl ?>assets/js/dataTables.bootstrap4.min.js"></script>

<script src="<?= $baseUrl ?>assets/plugins/sweetalert/sweetalert2.all.min.js"></script>
<script src="<?= $baseUrl ?>assets/plugins/sweetalert/sweetalerts.min.js"></script>

<script src="<?= $baseUrl ?>assets/js/bootstrap.bundle.min.js"></script>

<script src="<?= $baseUrl ?>assets/plugins/toastr/toastr.min.js"></script>
<script src="<?= $baseUrl ?>assets/plugins/toastr/toastr.js"></script>

<script src="<?= $baseUrl ?>assets/js/script.js"></script>
<script src="<?= $baseUrl ?>assets/js/select2.min.js"></script>

<!-- Date Picker -->
<!-- <script src="<?= $baseUrl ?>assets/js/bootstrap-datepicker.min.js"></script> -->
<script src="<?= $baseUrl ?>assets/js/moment.min.js"></script>
<script src="<?= $baseUrl ?>assets/js/bootstrap-datetimepicker.min.js"></script>
<!-- <script src="<?= $baseUrl ?>assets/js/bootstrap-datepicker.id.min.js"></script> -->

<script>
    $(document).ready(function() {
        console.log($('.select2-search__field').prop('disabled')); // Harusnya false
        $('.select2-search__field').prop('readonly', false);

        $('.select2').select2({
            // allowClear: true,
            width: '100%',
            minimumResultsForSearch: 0
        });

        // $('.datepicker').datepicker({
        //     format: 'dd-mm-yyyy', // Format tanggal
        //     autoclose: true, // Menutup otomatis setelah pilih tanggal
        //     todayHighlight: true, // Menyoroti tanggal hari ini
        //     orientation: "bottom auto",
        //     language: "id" // Ubah ke bahasa Indonesia
        // }).on('show', function(e) {
        //     $('.datepicker').fadeIn(200); // Efek fade-in saat muncul
        // });

        $(".tanggal").on("keyup", function(event) {
            let value = $(this).val();

            // Hapus semua karakter kecuali angka
            value = value.replace(/\D/g, "");

            // Pisahkan angka menjadi format dd-mm-yyyy
            if (value.length >= 2) {
                value = value.substring(0, 2) + "-" + value.substring(2);
            }
            if (value.length >= 5) {
                value = value.substring(0, 5) + "-" + value.substring(5);
            }

            // Batasi panjang input agar tidak lebih dari 10 karakter (dd-mm-yyyy)
            $(this).val(value.substring(0, 10));
        });

        // Mencegah input selain angka (misal: copy-paste huruf)
        $(".tanggal").on("keyup", function(event) {
            let charCode = event.which ? event.which : event.keyCode;
            if (charCode < 48 || charCode > 57) {
                event.preventDefault();
            }
        });


        let requestUri = window.location.pathname;
        let basePath = window.location.pathname.substring(0, window.location.pathname.lastIndexOf('/'));
        requestUri = requestUri.replace(basePath, '');
        console.log(requestUri);
        if (requestUri !== '/master-grup-user') {
            localStorage.clear();
        }
    });
    var idleTime = 0; // Hitung waktu idle dalam menit
    var maxIdleTime = 5; // Logout setelah 5 menit

    // Reset waktu idle saat user beraktivitas
    $(document).on("mousemove keypress click scroll", function() {
        idleTime = 0;
    });

    // Set interval untuk mengecek waktu idle setiap 1 menit
    setInterval(function() {
        idleTime++;
        console.log(idleTime);


        if (idleTime >= maxIdleTime) {
            // alert("Session expired due to inactivity. Logging out...");
            window.location.href = "<?= $baseUrl ?>" + 'logout'; // Logout otomatis
        }
    }, 60000); // 1 menit
</script>