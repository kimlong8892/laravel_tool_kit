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
                let array_item_ids_except = [];

                $('.input-product').each(function () {
                    if ($(this).val() !== '') {
                        let product = JSON.parse($(this).val());

                        if (product.hasOwnProperty('itemId') && product.hasOwnProperty('id') && id !== product.id) {
                            array_item_ids_except.push(product.itemId);
                        }
                    }
                });

                $.LoadingOverlay('show');
                $.ajax({
                    url: @json(route('admin.ajax.get_product_select')),
                    type: 'GET',
                    data: {
                        search: value,
                        id: id,
                        page: page,
                        array_item_ids_except: array_item_ids_except
                    },
                    success: function (data) {
                        $(`.div-search-product-ajax[data-id=${id}]`).html(data);
                        $.LoadingOverlay('hide');
                    }
                })
            }
        }

        $('body').on('click', '.btn-search-product-ajax', function () {
            let id = $(this).attr('data-id');
            let value = $(`.input-search-product-ajax[data-id=${id}]`).val();
            renderProductSelectAjax(id, value, 1);
        });

        $('body').on('keydown', '.input-search-product-ajax', function (event) {
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

        $('body').on('click', '.btn-chose-product-ajax', function () {
            let id = $(this).attr('data-id');
            $(`.input-product[data-id=${id}]`).val($(this).attr('data-value'));
            $(`.input-product[data-id=${id}]`).closest('div').find('a').text($(this).attr('data-name'));
            $(`.input-product[data-id=${id}]`).closest('div').find('div img').attr('src', $(this).attr('data-image'));
        });

        $('.btn-remove-image').click(function () {
            let is_remove = $(this).attr('data-is-remove');

            if (is_remove === '1') {
                $(this).closest('.col').find('img').fadeOut();
                $(this).closest('.col').find('input').val(1);
                $(this).html('<i class="fa fa-arrow-left"></i>');
                $(this).attr('data-is-remove', '0');
            } else {
                $(this).closest('.col').find('img').fadeIn();
                $(this).closest('.col').find('input').val(0);
                $(this).html('<i class="fa fa-close"></i>');
                $(this).attr('data-is-remove', '1');
            }
        });
    });
</script>
