@extends('backend.app')
@section('content')
    <style>
        .active-varient {
            margin-left: 11px;
            color: #000;
            padding: 5px 10px;
            border-radius: 8px;
            display: inline-block !important;

            label {
                cursor: pointer;
            }
        }

        .product-variant {
            margin-left: 15px;
        }
    </style>

    <x-page-title title="Coupon Create" />

    <div class="page-wrapper mt-3">
        <div class="row">
            <div class="col-md-12">


                <form id="saveButton" action="{{ route('admin.coupons.store') }}" method="POST">
                    @csrf
                    <div class="row coupon-form">

                        <div class="col-md-5">
                            <div class="form-group mb-3">
                                <label for="coupon_name">Coupon Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" id="coupon_name"
                                    placeholder="Enter Coupon Name">
                            </div>
                            <div class="form-group mb-3">
                                <label for="code">Coupon Code <span class="text-danger">*</span></label>
                                <input type="text" name="code" class="form-control" id="code"
                                    placeholder="Enter Coupon Code">
                            </div>
                            <div class="form-group mb-3">
                                <label for="description">Description <span class="text-danger">*</span></label>
                                <input type="text" name="description" class="form-control" id="description"
                                    placeholder="Enter description">
                            </div>

                            <div class="form-group mb-3">
                                <label for="type">Type <span class="text-danger">*</span></label>
                                <select id="type" name="type" class="custom-select2">
                                    <option value="fixed">Fixed</option>
                                    <option value="percentage">Percentage</option>
                                </select>
                            </div>

                            <div class="form-group mb-3">
                                <label for="discount_value">Discount Amount <span class="text-danger">*</span> </label>
                                <input type="number" name="discount_value" class="form-control" id="discount_value"
                                    placeholder="Enter discount amount">
                            </div>
                            <div class="form-group mb-3">
                                <label for="max_discount_value">Max Discount Amount </label>
                                <input type="text" name="max_discount_value" class="form-control" id="max_discount_value"
                                    placeholder="Enter max discount amount">
                            </div>
                            <div class="form-group mb-3">
                                <label for="min_purchase">Minimum Purchase <span class="text-danger">*</span></label>
                                <input type="text" name="min_purchase" class="form-control" id="min_purchase"
                                    placeholder="Enter minimum purchase">
                            </div>
                            <div class="form-group mb-3">
                                <label for="max_purchase">Maximum Purchase <span class="text-danger">*</span></label>
                                <input type="text" name="max_purchase" class="form-control" id="max_purchase"
                                    placeholder="Enter maximum purchase">
                            </div>
                            <div class="form-group mb-3">
                                <label for="usage_limit_per_user">Usage limit per user <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="usage_limit_per_user" class="form-control"
                                    id="usage_limit_per_user" placeholder="Enter usage limit per user">
                            </div>
                            <div class="form-group mb-3">
                                <label for="usage_limit_total">Usage limit total <span class="text-danger">*</span></label>
                                <input type="text" name="usage_limit_total" class="form-control" id="usage_limit_total"
                                    placeholder="Enter usage limit total">
                            </div>
                            <div class="form-group mb-3">
                                <label for="type">Coupon type <span class="text-danger">*</span></label>
                                <select id="coupon_type_id" name="coupon_type_id" class="custom-select2">
                                    @foreach ($coupon_types as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group mb-3">
                                <label for="status">Status <span class="text-danger">*</span></label>
                                <select id="status" name="status" class="custom-select2">
                                    <option value="active">Active</option>
                                    <option value="inactive">InActive</option>
                                </select>
                            </div>
                            <x-common.button label="Create" />
                        </div>
                        <div class="col-md-7">

                            <div class="form-group mb-3">
                                <label for="start_date">Start date <span class="text-danger">*</span></label>
                                <input type="date" name="start_date" class="form-control" id="start_date"
                                    placeholder="Enter start date">
                            </div>
                            <div class="form-group mb-3">
                                <label for="end_date">End Date <span class="text-danger">*</span></label>
                                <input type="date" name="end_date" class="form-control" id="end_date"
                                    placeholder="Enter End Date">
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label for="merchant_type">Merchant Type</label>
                                        <select id="merchant_type" name="merchant_type" class="custom-select2">
                                            <option value="" selected>-- select type -- </option>
                                            <option value="1">Exclude</option>
                                            <option value="2">Include</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label for="category_type">Category Type</label>
                                        <select id="category_type" name="category_type"
                                            class="form-control custom-select2">
                                            <option value="" selected>-- select type -- </option>
                                            <option value="1">Exclude</option>
                                            <option value="2">Include</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label for="brand_type">Brand Type</label>
                                        <select id="brand_type" name="brand_type" class="form-control custom-select2">
                                            <option value="" selected>-- select type -- </option>
                                            <option value="1">Exclude</option>
                                            <option value="2">Include</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label for="product_type">Product Type</label>
                                        <select id="product_type" name="product_type"
                                            class="form-control custom-select2">
                                            <option value="" selected>-- select type -- </option>
                                            <option value="1">Exclude</option>
                                            <option value="2">Include</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="items">
                                <div id="merchant" class="form-group mb-3 d-none">
                                    <label for="merchant_id">Merchants</label>
                                    <select name="merchant_ids[]" class="form-control manyselect2" multiple="multiple"
                                        id="merchant_id">
                                    </select>
                                </div>
                                <div id="category" class="form-group mb-3 d-none">
                                    <label for="category_id">Categories</label>
                                    <select name="category_ids[]" class="form-control many_select2" multiple="multiple"
                                        id="category_id">
                                        @foreach ($categories as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div id="brand" class="form-group mb-3 d-none">
                                    <label for="brand_id">Brands</label>
                                    <select name="brand_ids[]" class="form-control brands_select2" multiple="multiple"
                                        id="brand_id">
                                    </select>
                                </div>
                                <div id="product" class="form-group mb-3 d-none">
                                    <label for="product_id">Products</label>
                                    <select name="product_ids[]" class="form-control products_select2"
                                        multiple="multiple" id="product_id">
                                    </select>
                                </div>
                                <div id="variant" class="form-group mb-3">

                                </div>
                            </div>

                        </div>

                    </div>

                </form>


            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).on('submit', '#saveButton', async function(e) {
            e.preventDefault();
            let form = $(this);
            let actionUrl = form.attr('action');
            const result = await AllScript.submitFormAsync(form, actionUrl, 'POST');
            if (result) {
                window.location.href = "{{ route('admin.coupons.index') }}";
            }
        })


        function toggleVisibility(selectId, targetId) {
            const selectElement = $(`#${selectId}`);
            const targetElement = $(`#${targetId}`);

            selectElement.change(function() {
                if ($(this).val() !== '') {
                    targetElement.removeClass('d-none');
                } else {
                    targetElement.addClass('d-none');
                }
            });
        }

        // Initialize toggling for all select fields
        toggleVisibility('merchant_type', 'merchant');
        toggleVisibility('category_type', 'category');
        toggleVisibility('brand_type', 'brand');
        toggleVisibility('product_type', 'product');

        // Initialize Select2 for enhanced dropdowns
        $('.custom-select2, .many_select2').select2();


        $('.many_select2').select2({
            placeholder: "Select...",
            theme: "bootstrap-5",
        })

        $('.manyselect2').select2({
            placeholder: "Select merchant...",
            theme: "bootstrap-5",
            templateResult: formatOption,
            templateSelection: formatOption,
            ajax: {
                url: "{{ route('admin.merchant.order.list') }}",
                type: 'GET',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        search: params.term,
                        type: 'merchant',
                    };
                },
                processResults: function(res) {
                    let data = res.data || [];
                    return {
                        results: data.map(function(item) {
                            return {
                                id: item.id,
                                text: item.name,
                            };
                        })
                    };
                }
            },
        }).on('select2:unselect', function(e) {
            let submitBtn = $('#submit-button');
            submitBtn.prop('disabled', true);
            const unselectedMerchantId = e.params.data.id;
            const currentMerchantType = $('#merchant_type').val();

            let selectedProducts = $('.products_select2').select2('data');

            $.ajax({
                url: "{{ route('admin.merchant.category.products') }}",
                type: 'GET',
                data: {
                    merchant_type: currentMerchantType,
                    merchant_ids: [unselectedMerchantId],
                },
                success: function(merchantProducts) {
                    submitBtn.prop('disabled', false);
                    const merchantProductIds = merchantProducts.map(product => product.id.toString());

                    const remainingProducts = selectedProducts.filter(product =>
                        !merchantProductIds.includes(product.id.toString())
                    );

                    $('.products_select2').val(remainingProducts.map(p => p.id));
                    $('.products_select2').trigger('change');
                },
                error: function(xhr, status, error) {
                    submitBtn.prop('disabled', false);
                    console.error(`Error fetching merchant products: ${error}`);
                }
            });
        });

        function formatOption(option) {
            if (!option.id) {
                return option.text;
            }
            var $option = $(
                '<span class="payment-option">' + option.text + '</span>'
            );
            return $option;
        }


        $('.products_select2').select2({
            placeholder: "Select products...",
            theme: "bootstrap-5",
            templateResult: productOption,
            templateSelection: productOption,
            ajax: {
                url: "{{ route('admin.merchant.category.products') }}",
                type: 'GET',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        search: params.term,
                        merchant_type: $('#merchant_type').val(),
                        category_type: $('#category_type').val(),
                        merchant_ids: $('#merchant_id').val(),
                        category_ids: $('#category_id').val(),

                    };
                },
                processResults: function(res) {
                    let data = res || [];
                    return {
                        results: data.map(function(item) {
                            return {
                                id: item.id,
                                text: item.name,
                                image: item.thumbnail
                            };
                        })
                    };
                }
            },
        });

        function productOption(option) {
            if (!option.id) {
                return option.text;
            }
            var imageUrl = option.image;
            var $option = $(
                '<span class="payment-option"><img src="' + imageUrl +
                '" class="img-option" alt="icon" style="width: 32px; height: 32px; margin-right: 8px;">' +
                option.text + '</span>'
            );
            return $option;
        }

        $('.brands_select2').select2({
            placeholder: "Select brands...",
            theme: "bootstrap-5",
            templateResult: brandOption,
            templateSelection: brandOption,
            ajax: {
                url: "{{ route('admin.merchant.brands') }}",
                type: 'GET',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        search: params.term,
                        merchant_type: $('#merchant_type').val(),
                        merchant_ids: $('#merchant_id').val(),
                    };
                },
                processResults: function(res) {
                    let data = res.data || [];
                    return {
                        results: data.map(function(item) {
                            return {
                                id: item.id,
                                text: item.name,
                            };
                        })
                    };
                }
            },
        });

        function brandOption(option) {
            if (!option.id) {
                return option.text;
            }
            var $option = $(
                '<span class="payment-option">' + option.text + '</span>'
            );
            return $option;
        }

        $(function() {
            $('#type').on('change', function() {
                $('#discount_value').val(0);
                if ($('#type').val() == 'percentage') {
                    $('#discount_value').attr('max', 100);
                } else {
                    $('#discount_value').removeAttr("max");
                }
            })

            $('#discount_value').on('input', function() {
                if ($('#type').val() == 'percentage') {
                    const max = $(this).attr('max');
                    const value = parseInt($(this).val());

                    if (max && value > max) {
                        $(this).val(max);
                    }
                }

            })
        });


        // version one of product variant selection but full function is completed
        // let product_ids = [];
        // $('#product_id').change(function() {

        //     let newId = $(this).val();
        //     let addedIds = newId.filter(id => !product_ids.includes(id));
        //     product_ids = newId; 
        //     if (!addedIds[0]) {
        //         return;
        //     }

        //     $.ajax({
        //         url: `/product/${addedIds[0]}/variant`, 
        //         method: 'GET',
        //         dataType: 'json',
        //         success: function(response) {
        //             if (response.variant.length > 0) {
        //                 handleVariantData(response);
        //             }
        //         },
        //         error: function(xhr, status, error) {
        //             console.error(`Error fetching variants: ${error}`);
        //         }
        //     })

        // });
        // function handleVariantData(data) {

        //     let variant = ''

        //     data.variant.map((option) => {
        //         variant += `<div class="product-variant form-check active-varient">
        //                     <input class="form-check-input" type="checkbox" id="varient_${option.id}" name="varient[${data.id}][]"  value="${option.id}">
        //                     <label class="form-check-label" for="varient_${option.id}">
        //                         ${option.variant}
        //                     </label>
        //                 </div>`
        //     })

        //     const productElement =`<div class="product${data.id}"><b>${data.name} : </b>${variant}</div>`;
        //     $('#variant').append(productElement)                
        // }

        // $('#product_id').on('select2:unselect', function(e) {
        //     let removedId = e.params.data.id;
        //     removeVariantData(removedId);
        // });

        // function removeVariantData(removedId) {
        //     $(`.product${removedId}`).remove();
        // }
    </script>
@endpush
