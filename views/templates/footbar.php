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

<script>
    $(document).ready(function() {
        $('.select2').select2();

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