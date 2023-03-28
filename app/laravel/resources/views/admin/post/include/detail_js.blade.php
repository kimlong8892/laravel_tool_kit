<script>
    $(document).ready(function () {
        $('#form-main').submit(function (event) {
            event.preventDefault();
            let formData = new FormData(document.getElementById('form-main'));
            $.LoadingOverlay('show');

            $('.ckeditor').each(function () {
                formData.append($(this).attr('name'), CKEDITOR.instances[$(this).attr('name')].getData());
            });

            axios.post($(this).attr('action'), formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }).then(function (response) {
                if (response.data.success) {
                    window.location.replace(response.data.url);
                }
            }).catch(function (err) {
                let mess_errors = err.response.data.errors;
                let scroll_flag = false;
                $.LoadingOverlay('hide');
                $('.error-text').text('');

                Object.keys(mess_errors).forEach(function (key) {
                    if (!scroll_flag) {
                        scroll_flag = true;

                        document.getElementById(`${key}-error`).scrollIntoView({
                            behavior: 'smooth',
                            block: 'center'
                        });
                    }

                    $(`#${key}-error`).text(mess_errors[key]);
                });
            });
        });
    });
</script>
