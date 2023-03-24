<script>
    $(document).ready(function () {
        $('#form-main').submit(function (event) {
            event.preventDefault();
            let formData = new FormData(document.getElementById('form-main'));
            $.LoadingOverlay('show');

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
            $('#form-group-product-rows').append(`@include('admin.post.include.product_field.row')`).ready(function () {
                applyCkeditorAndSelect2();

                $('.select2-product').select2({
                    ajax: {
                        url: @json(route('admin.ajax.get_product_select')),
                        dataType: "json",
                        type: "GET",
                        data: function (params) {
                            return {
                                term: params.term
                            }
                        },
                        processResults: function (data) {
                            return {
                                results: $.map(data, function (item) {
                                    if (item.hasOwnProperty('productName')) {
                                        return {
                                            text: item.productName,
                                            id: JSON.stringify(item)
                                        }
                                    }
                                })
                            };
                        }
                    }
                });
            });
        });
    });
</script>
