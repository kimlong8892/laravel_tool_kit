<script>
    $(document).ready(function () {
        $('#type').change(function () {
            if ($(this).val() === 'DEFAULT' || $(this).val() === 'ACCESSTRADE') {
                $('#api_url_container').hide();
            } else {
                $('#api_url_container').show();
            }
        });
        $('#type').change();
    });
</script>
