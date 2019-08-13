<script>

    $(document).ready(function () {
        $('.fa.fa-spinner.fa-spin').show();
        localStorage.removeItem("token");
        document.location.href = site_url+'login';
    })
</script>