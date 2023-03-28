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

        $('#btn-add-product-row').click(function () {
            $.LoadingOverlay('show');

            $.ajax({
                url: @json(route('admin.ajax.render_product_row_in_post')),
                method: 'GET',
                data: {
                    post_id: @json($post->id ?? null)
                },
                success: function (data) {
                    let divContainerSector = '#div-product-row';
                    $(divContainerSector).show();
                    $(divContainerSector).append(data);
                    CKEDITOR.replaceAll('ckeditor');
                    renderSelect2Product();
                    $.LoadingOverlay('hide');
                }
            });
        });

        function renderProductSelectAjax(id, value, page) {
            if (value !== '') {
                $.LoadingOverlay('show');
                $.ajax({
                    url: @json(route('admin.ajax.get_product_select')),
                    type: 'GET',
                    data: {
                        search: value,
                        id: id,
                        page
                    },
                    success: function (data) {
                        $(`.div-search-product-ajax[data-id=${id}]`).html(data);
                        $.LoadingOverlay('hide');
                    }
                })
            }
        }

        $('.btn-search-product-ajax').click(function () {
            let id = $(this).attr('data-id');
            let value = $(`.input-search-product-ajax[data-id=${id}]`).val();
            renderProductSelectAjax(id, value, 1);
        });

        $('.input-search-product-ajax').keydown(function (event) {
            if (event.keyCode === 13) {
                event.preventDefault();
                let id = $(this).attr('data-id');
                let value = $(this).val();
                renderProductSelectAjax(id, value, 1);
            }
        });

        $('body').on('click', '.btn-change-page-product-select-ajax', function () {
            let id = $(this).attr('data-id');
            let value = $(`.input-search-product-ajax[data-id=${id}]`).val();
            renderProductSelectAjax(id, value, $(this).attr('data-page'));
        });
    });
</script>
