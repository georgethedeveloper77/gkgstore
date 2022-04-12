<template>
    <div class="flexbox-grid no-pd-none">
        <div class="flexbox-content">
            <div class="wrapper-content">
                <div class="pd-all-20 ws-nm">
                    <label class="title-product-main text-no-bold"><span
                        v-if="!is_promotion">{{ __('Create coupon code')}}</span><span v-if="is_promotion">{{ __('Create discount promotion') }}</span></label>
                    <a class="btn-change-link float-right" href="#" v-on:click="generateCouponCode($event)"
                       v-show="!is_promotion">{{ __('Generate coupon code')}}</a>
                    <div class="form-group mt15 mb0">
                        <input class="next-input coupon-code-input" name="code" type="text" v-model="code"
                               v-show="!is_promotion">
                        <input class="next-input" name="title" placeholder="Enter promotion name" type="text" v-model="title"
                               v-show="is_promotion">
                        <p class="type-subdued mt5 mb0" v-show="!is_promotion">{{ __('Customers will enter this coupon
                            code when they checkout')}}.</p>
                    </div>
                </div>
                <div class="pd-all-20 border-top-color">
                    <label class="title-product-main text-no-bold block-display">{{ __('Select type of discount')
                        }}</label>
                    <div class="ui-select-wrapper width-200-px-rsp-768 mt15">
                        <select @change="changeDiscountType()" class="ui-select" id="select-promotion" name="type"
                                v-model="type">
                            <option value="coupon">{{ __('Coupon code')}}</option>
                            <option value="promotion">{{ __('Promotion')}}</option>
                        </select>
                        <svg class="svg-next-icon svg-next-icon-size-16">
                            <use xlink:href="#select-chevron" xmlns:xlink="http://www.w3.org/1999/xlink"></use>
                        </svg>
                    </div>
                    <div class="form-group mt15 mb0" v-show="!is_promotion">
                        <label class="next-label">
                            <input class="hrv-checkbox" name="can_use_with_promotion" type="checkbox" v-model="can_use_with_promotion"
                                   value="1">
                            <span class="pre-line">{{ __('Can be used with promotion')}}</span>
                        </label>
                    </div>
                    <div class="form-group mb0 mt15" v-show="!is_promotion">
                        <label>
                            <input class="hrv-checkbox" name="is_unlimited" type="checkbox" v-model="is_unlimited"
                                   value="1">{{ __('Unlimited coupon')}}
                        </label>
                    </div>
                    <div class="form-group mb0 mt15" v-show="!is_promotion && !is_unlimited">
                        <label class="text-title-field">{{ __('Enter number') }}</label>
                        <div class="limit-input-group">
                            <input autocomplete="off" class="form-control pl5 p-r5" name="quantity" type="text"
                                   v-bind:disabled="is_unlimited" v-model="quantity">
                        </div>
                    </div>
                </div>
                <div class="pd-all-20 border-top-color">
                    <label class="title-product-main text-no-bold block-display">{{ __('Coupon type') }}</label>
                    <div class="form-inline form-group discount-input mt15 mb0 ws-nm">
                        <div class="ui-select-wrapper inline_block mb5" style="min-width: 200px;">
                            <select @change="handleChangeTypeOption()" class="ui-select" id="discount-type-option" name="type_option"
                                    v-model="type_option">
                                <option value="amount">{{ currency }}</option>
                                <option value="percentage">{{ __('Discount %')}}</option>
                                <option v-if="!is_promotion" value="shipping">{{ __('Free shipping')}}</option>
                                <option value="same-price">{{ __('Same price') }}</option>
                            </select>
                            <svg class="svg-next-icon svg-next-icon-size-16">
                                <use xlink:href="#select-chevron" xmlns:xlink="http://www.w3.org/1999/xlink"></use>
                            </svg>
                        </div>
                        <span class="lb-dis"> <span>{{ value_label }}</span></span>
                        <div class="inline width20-rsp-768 mb5">
                            <div class="next-input--stylized">
                                <input autocomplete="off" class="next-input next-input--invisible" name="value"
                                       placeholder="0" type="text" v-model="discount_value">
                                <span class="next-input-add-on next-input__add-on--after">{{ discountUnit }}</span>
                            </div>
                        </div>
                        <span class="lb-dis"
                              v-show="type_option !== 'shipping' && type_option"> {{ __('apply for') }}</span>
                        <div v-show="type_option !== 'shipping' && type_option">
                            <div @change="handleChangeTarget()" class="ui-select-wrapper inline_block mb5 min-width-150-px"
                                 style="margin-right: 10px;">
                                <select class="ui-select" id="select-offers" name="target" v-model="target">
                                    <option v-if="type_option !== 'same-price'" value="all-orders">{{ __('All orders')
                                        }}
                                    </option>
                                    <option v-if="type_option !== 'same-price'" value="amount-minimum-order">{{
                                        __('Order amount from')}}
                                    </option>
                                    <option value="group-products">{{ __('Product collection')}}</option>
                                    <option value="specific-product">{{ __('Product')}}</option>
                                    <option v-if="type_option !== 'same-price'" value="customer">{{ __('Customer')}}
                                    </option>
                                    <option value="product-variant">{{ __('Variant') }}</option>
                                </select>
                                <svg class="svg-next-icon svg-next-icon-size-16">
                                    <use xlink:href="#select-chevron" xmlns:xlink="http://www.w3.org/1999/xlink"></use>
                                </svg>
                            </div>
                            <div class="inline mb5" id="div-select-collection"
                                 style="margin-right: 10px;"
                                 v-if="target === 'group-products' && type_option !== 'shipping'">

                                <div class="ui-select-wrapper" style="min-width: 200px;">
                                    <select class="ui-select" name="product_collections"
                                            v-model="product_collection_id">
                                        <option v-bind:value="product_collection.id"
                                                v-for="product_collection in product_collections">{{ product_collection.name }}
                                        </option>
                                    </select>
                                    <svg class="svg-next-icon svg-next-icon-size-16">
                                        <use xlink:href="#select-chevron"
                                             xmlns:xlink="http://www.w3.org/1999/xlink"></use>
                                    </svg>
                                </div>
                            </div>
                            <div class="inline mb5" id="div-select-product"
                                 style="margin-right: 10px;"
                                 v-if="target === 'specific-product' && type_option !== 'shipping'">
                                <div class="drop-select-search drop-control dropdown dropdown-collection">
                                    <input name="products" type="hidden" v-model="product_id">
                                    <button @click="loadListProductsForSelect()" aria-expanded="false"
                                            aria-haspopup="true" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown"
                                            type="button">
                                        <span class="overflow-title max-250 p-r15">{{ product_text }}</span>
                                    </button>
                                    <div class="dropdown-menu">
                                        <div class="has-loading" v-show="loading">
                                            <i class="fa fa-spinner fa-spin"></i>
                                        </div>
                                        <a @click="handleSelectProducts(product)" class="dropdown-item"
                                           href="#" v-bind:value="product.id" v-for="product in products"
                                           v-show="!loading">{{ product.name }}</a>
                                    </div>
                                </div>
                            </div>

                            <div class="inline mb5" id="div-select-customer"
                                 v-if="target === 'customer' && type_option !== 'shipping'">
                                <div class="drop-select-search drop-control dropdown dropdown-collection">
                                    <input name="customers" type="hidden" v-model="customer_id">
                                    <button @click="loadListCustomersForSelect()" aria-expanded="false"
                                            aria-haspopup="true" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown"
                                            type="button">
                                        <span class="overflow-title max-250 p-r15">{{ customer_name }}</span>
                                    </button>
                                    <div class="dropdown-menu">
                                        <div class="has-loading" v-show="loading">
                                            <i class="fa fa-spinner fa-spin"></i>
                                        </div>
                                        <a @click="handleSelectCustomers(customer)" class="dropdown-item"
                                           href="#" v-bind:value="customer.id"
                                           v-for="customer in customers" v-show="!loading">{{ customer.name
                                            }}</a>
                                    </div>
                                </div>
                            </div>

                            <div class="inline mb5" id="div-select-product-variant"
                                 style="margin-right: 10px;"
                                 v-if="target === 'product-variant' && type_option !== 'shipping'">
                                <div class="box-search-advance product" style="min-width: 310px;">
                                    <input @click="loadListProductsForSearch()" @keyup="handleSearchProduct($event.target.value)"
                                           class="next-input textbox-advancesearch"
                                           placeholder="Search product"
                                           type="text">
                                    <div class="panel panel-default"
                                         v-bind:class="{ active: product_variants, hidden : hidden_product_search_panel }">
                                        <div class="panel-body">
                                            <div class="list-search-data">
                                                <div class="has-loading" v-show="loading">
                                                    <i class="fa fa-spinner fa-spin"></i>
                                                </div>
                                                <ul class="clearfix" v-show="!loading">
                                                    <li v-for="product_variant in product_variants.data"
                                                        v-if="product_variant.variations.length">
                                                        <div class="wrap-img inline_block vertical-align-t">
                                                            <img class="thumb-image"
                                                                 v-bind:src="product_variant.image_url"
                                                                 v-bind:title="product_variant.name">
                                                        </div>
                                                        <label class="inline_block ml10 mt10 ws-nm"
                                                               style="width:calc(100% - 50px); cursor: pointer;">{{
                                                            product_variant.name }}</label>
                                                        <div class="clear"></div>
                                                        <ul>
                                                            <li @click="selectProductVariant(product_variant, variation)"
                                                                class="clearfix product-variant"
                                                                v-for="variation in product_variant.variations">
                                                                <a class="color_green float-left">
                                                                    <span
                                                                        v-for="(variantItem, index) in variation.variation_items">
                                                                        {{ variantItem.attribute_title }}
                                                                        <span
                                                                            v-if="index !== variation.variation_items.length - 1">/</span>
                                                                    </span>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                    <li v-if="product_variants.data.length === 0">
                                                        <span>{{ __('No products found!') }}</span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="panel-footer"
                                             v-if="product_variants.next_page_url || product_variants.prev_page_url">
                                            <div class="btn-group float-right">
                                                <button @click="loadListProductsForSearch(1, (product_variants.prev_page_url ? product_variants.current_page - 1 : product_variants.current_page), true)"
                                                        type="button"
                                                        v-bind:class="{ 'btn btn-secondary': product_variants.current_page !== 1, 'btn btn-secondary disable': product_variants.current_page === 1}"
                                                        v-bind:disabled="product_variants.current_page === 1">
                                                    <svg class="svg-next-icon svg-next-icon-size-16 svg-next-icon-rotate-180"
                                                         role="img">
                                                        <use xlink:href="#next-chevron"
                                                             xmlns:xlink="http://www.w3.org/1999/xlink"></use>
                                                    </svg>
                                                </button>
                                                <button @click="loadListProductsForSearch(1, (product_variants.next_page_url ? product_variants.current_page + 1 : product_variants.current_page), true)"
                                                        type="button"
                                                        v-bind:class="{ 'btn btn-secondary': product_variants.next_page_url, 'btn btn-secondary disable': !product_variants.next_page_url }"
                                                        v-bind:disabled="!product_variants.next_page_url">
                                                    <svg class="svg-next-icon svg-next-icon-size-16" role="img">
                                                        <use xlink:href="#next-chevron"
                                                             xmlns:xlink="http://www.w3.org/1999/xlink"></use>
                                                    </svg>
                                                </button>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="inline mb5"
                                 v-if="!is_promotion && (target === 'group-products' || target === 'specific-product' || target === 'product-variant') && type_option === 'amount'">
                                <div class="ui-select-wrapper">
                                    <select class="ui-select" name="discount_on" v-model="discount_on">
                                        <option value="per-order">{{ __('One time per order') }}</option>
                                        <option value="per-every-item">{{ __('One time per product in cart') }}</option>
                                    </select>
                                    <svg class="svg-next-icon svg-next-icon-size-16">
                                        <use xlink:href="#select-chevron"
                                             xmlns:xlink="http://www.w3.org/1999/xlink"></use>
                                    </svg>
                                </div>
                            </div>
                            <div class="inline width-150-px mb5"
                                 v-if="target === 'amount-minimum-order' && type_option !== 'shipping'">
                                <div class="next-input--stylized">
                                    <input class="next-input next-input--invisible" name="min_order_price"
                                           type="text" v-model="min_order_price">
                                    <span class="next-input-add-on next-input__add-on--after">{{ currency }}</span>
                                </div>
                            </div>
                        </div>
                        <div style="margin: 10px 0;" v-show="is_promotion">
                            <span class="lb-dis">  {{ __('Number of products') }}: </span>
                            <input class="form-control width-100-px p-none-r" id="product-quantity" name="product_quantity"
                                   type="text" v-model="product_quantity">
                        </div>
                    </div>
                    <input name="variants" type="hidden" v-model="variant_ids">
                    <div class="clearfix" v-if="variants.length && target === 'product-variant'">
                        <div class="mt20"><label class="text-title-field">{{ __('Selected products')}}:</label></div>
                        <div class="table-wrapper p-none mt10 mb20 ps-relative">
                            <table class="table-normal">
                                <tbody>
                                <tr v-for="variant in variants">
                                    <td class="width-60-px min-width-60-px">
                                        <div class="wrap-img vertical-align-m-i"><img class="thumb-image"
                                                                                      v-bind:src="variant.image_url"
                                                                                      v-bind:title="variant.product_name">
                                        </div>
                                    </td>
                                    <td class="pl5 p-r5 min-width-200-px">
                                        <a class="hover-underline pre-line" target="_blank"
                                           v-bind:href="variant.product_link">{{ variant.product_name }}</a>
                                        <p class="type-subdued">
                                            <span v-for="(variantItem, index) in variant.variation_items">
                                                {{ variantItem.attribute_title }}
                                                <span v-if="index !== variant.variation_items.length - 1">/</span>
                                            </span>
                                        </p>
                                    </td>
                                    <td class="pl5 p-r5 text-right width-20-px min-width-20-px">
                                        <a @click="handleRemoveVariant($event, variant)" href="#">
                                            <svg class="svg-next-icon svg-next-icon-size-12">
                                                <use xlink:href="#next-remove"
                                                     xmlns:xlink="http://www.w3.org/1999/xlink"></use>
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <!--/ko-->
                    </div>
                </div>
            </div>
        </div>
        <div class="flexbox-content flexbox-right">
            <div class="wrapper-content">
                <div class="pd-all-20">
                    <label class="title-product-main text-no-bold">{{ __('Time') }}</label>
                </div>
                <div class="pd-all-10-20 form-group mb0">
                    <label class="text-title-field">{{ __('Start date')}}</label>
                    <div class="next-field__connected-wrapper z-index-9">
                        <div class="input-group date form_datetime form_datetime bs-datetime">
                            <input autocomplete="off" class="next-field--connected next-input z-index-9 datepicker" data-date-format="dd-mm-yyyy"
                                   name="start_date" placeholder="Select date..."
                                   type="text" v-model="start_date">
                            <span class="input-group-prepend">
                                <button class="btn default" type="button">
                                    <span class="fa fa-fw fa-calendar"></span>
                                </button>
                            </span>
                        </div>
                        <div class="input-group">
                            <input class="next-field--connected next-input z-index-9 time-picker timepicker timepicker-24" name="start_time" placeholder="Select time..." type="text"
                                   v-model="start_time">
                            <span class="input-group-prepend">
                                <button class="btn default" type="button">
                                    <i class="fa fa-clock"></i>
                                </button>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="pd-all-10-20 form-group mb0">
                    <label class="text-title-field">{{ __('End date')}}</label>
                    <div class="next-field__connected-wrapper z-index-9">
                        <div class="input-group date form_datetime form_datetime bs-datetime">
                            <input class="next-field--connected next-input z-index-9 datepicker" data-date-format="dd-mm-yyyy" name="end_date"
                                   placeholder="Select date..." type="text"
                                   v-bind:disabled="unlimited_time"
                                   v-model="end_date">
                            <span class="input-group-prepend">
                                <button class="btn default" type="button">
                                    <span class="fa fa-fw fa-calendar"></span>
                                </button>
                            </span>
                        </div>
                        <div class="input-group">
                            <input class="next-field--connected next-input z-index-9 time-picker timepicker timepicker-24" name="end_time" placeholder="Select time..." type="text"
                                   v-bind:disabled="unlimited_time"
                                   v-model="end_time">
                            <span class="input-group-prepend">
                                <button class="btn default" type="button">
                                    <i class="fa fa-clock"></i>
                                </button>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="pd-all-10-20">
                    <label class="next-label disable-input-date-discount">
                        <input class="hrv-checkbox" name="unlimited_time" type="checkbox" v-model="unlimited_time"
                               value="1">{{ __('Never expired')}}
                    </label>
                </div>
            </div>

            <br>
            <div class="wrapper-content">
                <div class="pd-all-20">
                    <a class="btn btn-secondary" href="#">{{ __('Cancel') }}</a>
                    <button class="btn btn-primary">{{ __('Save') }}</button>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    // let moment = require('moment');

    export default {
        data: () => {
            return {
                title: null,
                code: null,
                is_promotion: false,
                type: 'coupon',
                is_unlimited: 1,
                quantity: 0,
                unlimited_time: 1,
                start_date: null, //moment().format('DD-MM-Y'),
                start_time: null, //moment().format('H:mm'),
                end_date: null, //moment().format('DD-MM-Y'),
                end_time: '23:59',
                type_option: 'amount',
                discount_value: null,
                target: 'all-orders',
                can_use_with_promotion: false,
                value_label: 'Discount',
                product_variants: {
                    data: [],
                },
                variants: [],
                variant_ids: [],
                hidden_product_search_panel: true,
                product_collection_id: null,
                product_collections: [],
                discount_on: 'per-order',
                min_order_price: null,
                product_quantity: 1,
                product_id: null,
                products: [],
                product_keyword: null,
                product_text: 'Select product',
                customers: [],
                customer_id: null,
                customer_name: 'Select customer',
                loading: false,
                discountUnit: '$'
            }
        },
        props: {
            currency: {
                type: String,
                default: () => null,
                required: true
            },
        },
        mounted: function () {
            let context = this;
            $(document).on('click', 'body', (e) => {
                let container = $('.box-search-advance');

                if (!container.is(e.target) && container.has(e.target).length === 0) {
                    context.hidden_product_search_panel = true;
                }
            });

            this.discountUnit = this.currency;
        },
        methods: {
            generateCouponCode: function (event) {
                event.preventDefault();
                let context = this;
                axios
                    .post(route('discounts.generate-coupon'))
                    .then(res => {
                        context.code = res.data.data;
                        context.title = null;
                        $('.coupon-code-input').closest('div').find('.invalid-feedback').remove();
                    })
                    .catch(res => {
                        Botble.handleError(res.response.data);
                    });
            },
            changeDiscountType: function () {
                let context = this;
                if (context.type === 'coupon') {
                    context.is_promotion = false;
                    context.code = context.title;
                    context.title = null;
                } else {
                    context.is_promotion = true;
                    context.title = context.code;
                    context.code = null;
                }
            },
            handleChangeTypeOption: function () {
                let context = this;

                context.discountUnit = this.currency;
                context.value_label = 'Discount';

                switch (context.type_option) {
                    case 'amount':
                        context.target = 'all-orders';
                        break;
                    case 'percentage':
                        context.target = 'all-orders';
                        context.discountUnit = '%';
                        break;
                    case 'shipping':
                        context.value_label = 'when shipping fee less than';
                        break;
                    case 'same-price':
                        context.target = 'group-products';
                        context.value_label = 'Is';
                        context.getListProductCollections();
                        break;
                }
            },
            loadListProductsForSearch: function (include_variation = 1, page = 1, force = false) {
                let context = this;
                context.hidden_product_search_panel = false;
                $('.textbox-advancesearch').closest('.box-search-advance').find('.panel').removeClass('hidden');
                if (_.isEmpty(context.product_variants.data) || force) {
                    context.loading = true;
                    axios
                        .get(route('products.get-list-products-for-select', {
                            keyword: context.product_keyword,
                            include_variation: include_variation,
                            page: page
                        }))
                        .then(res => {
                            context.product_variants = res.data.data;
                            context.loading = false;
                        })
                        .catch(res => {
                            Botble.handleError(res.response.data);
                        });
                }
            },
            handleSearchProduct: function (value) {
                if (value !== this.product_keyword) {
                    let context = this;
                    this.product_keyword = value;
                    setTimeout(() => {
                        context.loadListProductsForSearch(1, 1, true);
                    }, 500);
                }
            },
            handleChangeTarget: function () {
                let context = this;
                switch (context.target) {
                    case 'group-products':
                        context.getListProductCollections();
                        break;
                    case 'specific-product':
                        context.variant_ids = [];
                        context.customer_id = null;
                        break;
                    case 'product-variant':
                        context.product_id = null;
                        context.customer_id = null;
                        break;
                    case 'customer':
                        context.product_id = null;
                        context.variant_ids = [];
                        break;
                }
            },
            getListProductCollections: function () {
                let context = this;
                if (_.isEmpty(context.product_collections)) {
                    context.loading = true;
                    axios
                        .get(route('product-collections.get-list-product-collections-for-select'))
                        .then(res => {
                            context.product_collections = res.data.data;
                            if (!_.isEmpty(res.data.data)) {
                                context.product_collection_id = _.first(res.data.data).id;
                            }
                            context.loading = false;
                        })
                        .catch(res => {
                            Botble.handleError(res.response.data);
                        });
                }
            },
            loadListProductsForSelect: function () {
                let context = this;
                if (_.isEmpty(context.products)) {
                    context.loading = true;
                    axios
                        .get(route('products.get-list-products-for-select'))
                        .then(res => {
                            context.products = res.data.data.data;
                            if (!_.isEmpty(res.data.data.data)) {
                                context.product_id = _.first(res.data.data.data).id;
                            }
                            context.loading = false;
                        })
                        .catch(res => {
                            Botble.handleError(res.response.data);
                        });
                }
            },
            loadListCustomersForSelect: function () {
                let context = this;
                if (_.isEmpty(context.customers)) {
                    context.loading = true;
                    axios
                        .get(route('customers.get-list-customers-for-select'))
                        .then(res => {
                            context.customers = res.data.data;
                            if (!_.isEmpty(res.data.data)) {
                                context.customer_id = _.first(res.data.data).id;
                            }
                            context.loading = false;
                        })
                        .catch(res => {
                            Botble.handleError(res.response.data);
                        });
                }
            },
            handleSelectProducts: function (product) {
                this.product_id = product.id;
                this.product_text = product.name;
            },
            handleSelectCustomers: function (customer) {
                this.customer_id = customer.id;
                this.customer_name = customer.name;
            },
            selectProductVariant: function (productVariant, variation) {
                if (!_.includes(this.variant_ids, variation.product_id)) {
                    let variantItem = variation;
                    variantItem.product_name = productVariant.name;
                    variantItem.image_url = productVariant.image_url;
                    variantItem.product_link = route('products.edit', variation.product_id);
                    this.variants.push(variantItem);
                    this.variant_ids.push(variation.product_id);
                }
                this.hidden_product_search_panel = true;
            },
            handleRemoveVariant: function ($event, variant) {
                $event.preventDefault();
                this.variant_ids = _.reject(this.variant_ids, (item) => {
                    return item === variant.product_id;
                });

                this.variants = _.reject(this.variants, (item) => {
                    return item.product_id === variant.product_id;
                });
            }
        }
    }
</script>
