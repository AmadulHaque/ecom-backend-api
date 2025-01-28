@php
$logo = '';
$favicon = '';

$keyToValue = array_column($shop_settings, 'value', 'key');

if (isset($keyToValue['site_logo'])) {
$logo = $keyToValue['site_logo'];
}
if (isset($keyToValue['site_favicon'])) {
$favicon = $keyToValue['site_favicon'];
}
@endphp
<div class="barnd-logo d-flex justify-content-center align-items-center ">
    <a href="{{ route('admin.dashboard') }}" class="not-collpsed">
        <img src="{{  asset($logo ? 'storage/'. $logo : 'backend/images/brand/logo.png') }}" alt="">
    </a>
    <a href="{{ route('admin.dashboard') }}" class="with-collpsed ">
        <img src="{{asset($favicon ? 'storage/'. $favicon : 'backend/images/brand/icon.png') }}" alt="">
    </a>
</div>

<div class="vertical-menu mm-active">
    <div data-simplebar="init" class="h-100 mm-show simplebar-scrollable-y">
        <div class="simplebar-wrapper" style="margin: 0px;">
            <div class="simplebar-height-auto-observer-wrapper">
                <div class="simplebar-height-auto-observer"></div>
            </div>
            <div class="simplebar-mask">
                <div class="simplebar-offset">
                    <div class="simplebar-content-wrapper" tabindex="0" role="region" aria-label="scrollable content">
                        <div class="simplebar-content">
                            <!--- Sidemenu -->
                            <div id="sidebar-menu" class="mm-active">
                                <!-- Left Menu Start -->
                                <ul class="d-flex flex-column gap-2 metismenu mm-show" id="side-menu">
                                    <li>
                                        <a href="{{ route('admin.dashboard') }}" class="waves-effect">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path class="dashboard"
                                                    d="M2 18C2 16.4596 2 15.6893 2.34673 15.1235C2.54074 14.8069 2.80693 14.5407 3.12353 14.3467C3.68934 14 4.45956 14 6 14C7.54044 14 8.31066 14 8.87647 14.3467C9.19307 14.5407 9.45926 14.8069 9.65327 15.1235C10 15.6893 10 16.4596 10 18C10 19.5404 10 20.3107 9.65327 20.8765C9.45926 21.1931 9.19307 21.4593 8.87647 21.6533C8.31066 22 7.54044 22 6 22C4.45956 22 3.68934 22 3.12353 21.6533C2.80693 21.4593 2.54074 21.1931 2.34673 20.8765C2 20.3107 2 19.5404 2 18Z"
                                                    stroke="#475569" stroke-width="1.5" />
                                                <path class="dashboard"
                                                    d="M14 18C14 16.4596 14 15.6893 14.3467 15.1235C14.5407 14.8069 14.8069 14.5407 15.1235 14.3467C15.6893 14 16.4596 14 18 14C19.5404 14 20.3107 14 20.8765 14.3467C21.1931 14.5407 21.4593 14.8069 21.6533 15.1235C22 15.6893 22 16.4596 22 18C22 19.5404 22 20.3107 21.6533 20.8765C21.4593 21.1931 21.1931 21.4593 20.8765 21.6533C20.3107 22 19.5404 22 18 22C16.4596 22 15.6893 22 15.1235 21.6533C14.8069 21.4593 14.5407 21.1931 14.3467 20.8765C14 20.3107 14 19.5404 14 18Z"
                                                    stroke="#475569" stroke-width="1.5" />
                                                <path class="dashboard"
                                                    d="M2 6C2 4.45956 2 3.68934 2.34673 3.12353C2.54074 2.80693 2.80693 2.54074 3.12353 2.34673C3.68934 2 4.45956 2 6 2C7.54044 2 8.31066 2 8.87647 2.34673C9.19307 2.54074 9.45926 2.80693 9.65327 3.12353C10 3.68934 10 4.45956 10 6C10 7.54044 10 8.31066 9.65327 8.87647C9.45926 9.19307 9.19307 9.45926 8.87647 9.65327C8.31066 10 7.54044 10 6 10C4.45956 10 3.68934 10 3.12353 9.65327C2.80693 9.45926 2.54074 9.19307 2.34673 8.87647C2 8.31066 2 7.54044 2 6Z"
                                                    stroke="#475569" stroke-width="1.5" />
                                                <path class="dashboard"
                                                    d="M14 6C14 4.45956 14 3.68934 14.3467 3.12353C14.5407 2.80693 14.8069 2.54074 15.1235 2.34673C15.6893 2 16.4596 2 18 2C19.5404 2 20.3107 2 20.8765 2.34673C21.1931 2.54074 21.4593 2.80693 21.6533 3.12353C22 3.68934 22 4.45956 22 6C22 7.54044 22 8.31066 21.6533 8.87647C21.4593 9.19307 21.1931 9.45926 20.8765 9.65327C20.3107 10 19.5404 10 18 10C16.4596 10 15.6893 10 15.1235 9.65327C14.8069 9.45926 14.5407 9.19307 14.3467 8.87647C14 8.31066 14 7.54044 14 6Z"
                                                    stroke="#475569" stroke-width="1.5" />
                                            </svg>
                                            <span>Dashboard</span>
                                        </a>
                                    </li>

                                    <li class="">
                                        <a href="javascript: void(0);" class="has-arrow waves-effect"
                                            aria-expanded="false">
                                            <svg width="24" height="25" viewBox="0 0 24 25" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path class="products"
                                                    d="M12 22.0703C11.1818 22.0703 10.4002 21.7401 8.83693 21.0798C4.94564 19.436 3 18.6141 3 17.2316C3 16.8445 3 10.1348 3 7.07031M12 22.0703C12.8182 22.0703 13.5998 21.7401 15.1631 21.0798C19.0544 19.436 21 18.6141 21 17.2316V7.07031M12 22.0703V11.4251"
                                                    stroke="#475569" stroke-width="1.5" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                                <path class="products"
                                                    d="M8.32592 9.76169L5.40472 8.34816C3.80157 7.57241 3 7.18454 3 6.57031C3 5.95608 3.80157 5.56821 5.40472 4.79246L8.32592 3.37893C10.1288 2.50652 11.0303 2.07031 12 2.07031C12.9697 2.07031 13.8712 2.50651 15.6741 3.37893L18.5953 4.79246C20.1984 5.56821 21 5.95608 21 6.57031C21 7.18454 20.1984 7.57241 18.5953 8.34816L15.6741 9.76169C13.8712 10.6341 12.9697 11.0703 12 11.0703C11.0303 11.0703 10.1288 10.6341 8.32592 9.76169Z"
                                                    stroke="#475569" stroke-width="1.5" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                                <path class="products" d="M6 12.0703L8 13.0703" stroke="#475569"
                                                    stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                <path class="products" d="M17 4.07031L7 9.07031" stroke="#475569"
                                                    stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                            <span>Orders</span>
                                        </a>
                                        <ul class="sub-menu mm-collapse mm-show" aria-expanded="false"
                                            style="height: 0px;">
                                            @permission('order-list')
                                                <li>
                                                    <a href="{{ route('admin.orders.index') }}" class=" waves-effect">
                                                        <span>Order List</span>
                                                    </a>
                                                </li>
                                            @endpermission
                                            <li>
                                                <a href="{{ route('admin.merchant.order.list') }}"
                                                    class=" waves-effect">
                                                    <span>Merchant Orders</span>
                                                </a>
                                            </li>
                                            @permission('order-payment-list')
                                                {{-- <li>
                                                    <a href="{{ route('admin.payments.index') }}">
                                                        <span> Order Payments</span>
                                                    </a>
                                                </li> --}}
                                            @endpermission
                                        </ul>
                                    </li>
                                    @permission(['product-request-list', 'shop-product-list'])
                                    <li>
                                        <a href="javascript: void(0);" class="has-arrow waves-effect"
                                            aria-expanded="false">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path class="products"
                                                    d="M2 13.0191V7.33203H22V13.0191C22 17.2522 22 19.3687 20.6983 20.6836C19.3965 21.9987 17.3013 21.9987 13.1111 21.9987H10.8889C6.69863 21.9987 4.60349 21.9987 3.30175 20.6836C2 19.3687 2 17.2522 2 13.0191Z"
                                                    stroke="#64748B" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                                <path class="products"
                                                    d="M2 7.33333L2.96153 5.28205C3.70727 3.69117 4.08012 2.89573 4.83589 2.44787C5.59167 2 6.56112 2 8.5 2H15.5C17.4389 2 18.4083 2 19.1641 2.44787C19.9199 2.89573 20.2928 3.69117 21.0384 5.28205L22 7.33333"
                                                    stroke="#64748B" stroke-width="2" stroke-linecap="round" />
                                                <path class="products" d="M10 11.332H14" stroke="#64748B"
                                                    stroke-width="2" stroke-linecap="round" />
                                            </svg>

                                            <span>Product</span>
                                        </a>
                                        <ul class="sub-menu mm-collapse" aria-expanded="false" style="height: 0px;">
                                            @permission('product-request-list')
                                            <li>
                                                <a href="{{ route('admin.request.products') }}" class=" waves-effect">
                                                    <span>Product Request</span>
                                                </a>
                                            </li>
                                            @endpermission
                                            @permission('shop-product-list')
                                            <li>
                                                <a href="{{ route('admin.shop.products') }}" class=" waves-effect">
                                                    <span>Shop Product </span>
                                                </a>
                                            </li>
                                            @endpermission
                                        </ul>
                                    </li>
                                    @endpermission

                                    <li>
                                        <a href="{{ route('admin.payout-requests.index') }}">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <rect x="2" y="7" width="20" height="10" rx="2" stroke="#64748B" stroke-width="1.5" />
                                                <path d="M12 10.5C12.8284 10.5 13.5 11.1716 13.5 12C13.5 12.8284 12.8284 13.5 12 13.5C11.1716 13.5 10.5 12.8284 10.5 12C10.5 11.1716 11.1716 10.5 12 10.5Z" fill="#64748B" />
                                                <path d="M8 9C8 9.55228 7.55228 10 7 10C6.44772 10 6 9.55228 6 9C6 8.44772 6.44772 8 7 8C7.55228 8 8 8.44772 8 9Z" fill="#64748B" />
                                                <path d="M18 15C18 15.5523 17.5523 16 17 16C16.4477 16 16 15.5523 16 15C16 14.4477 16.4477 14 17 14C17.5523 14 18 14.4477 18 15Z" fill="#64748B" />
                                            </svg>
                                            
                                            <span>Payout Requests</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('admin.categories.index') }}">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <rect x="2" y="7" width="20" height="10" rx="2" stroke="#64748B" stroke-width="1.5" />
                                                <path d="M12 10.5C12.8284 10.5 13.5 11.1716 13.5 12C13.5 12.8284 12.8284 13.5 12 13.5C11.1716 13.5 10.5 12.8284 10.5 12C10.5 11.1716 11.1716 10.5 12 10.5Z" fill="#64748B" />
                                                <path d="M8 9C8 9.55228 7.55228 10 7 10C6.44772 10 6 9.55228 6 9C6 8.44772 6.44772 8 7 8C7.55228 8 8 8.44772 8 9Z" fill="#64748B" />
                                                <path d="M18 15C18 15.5523 17.5523 16 17 16C16.4477 16 16 15.5523 16 15C16 14.4477 16.4477 14 17 14C17.5523 14 18 14.4477 18 15Z" fill="#64748B" />
                                            </svg>
                                            <span>Categories</span>
                                        </a>
                                    </li>
                                    @permission('merchant-list')
                                    <li>
                                        <a href="{{ route('admin.merchant.index') }}">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path class="marchant"
                                                    d="M13 7C13 9.20914 11.2091 11 9 11C6.79086 11 5 9.20914 5 7C5 4.79086 6.79086 3 9 3C11.2091 3 13 4.79086 13 7Z"
                                                    stroke="#64748B" stroke-width="1.5" />
                                                <path class="marchant"
                                                    d="M15 11C17.2091 11 19 9.20914 19 7C19 4.79086 17.2091 3 15 3"
                                                    stroke="#64748B" stroke-width="1.5" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                                <path class="marchant"
                                                    d="M11 14H7C4.23858 14 2 16.2386 2 19C2 20.1046 2.89543 21 4 21H14C15.1046 21 16 20.1046 16 19C16 16.2386 13.7614 14 11 14Z"
                                                    stroke="#64748B" stroke-width="1.5" stroke-linejoin="round" />
                                                <path class="marchant"
                                                    d="M17 14C19.7614 14 22 16.2386 22 19C22 20.1046 21.1046 21 20 21H18.5"
                                                    stroke="#64748B" stroke-width="1.5" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                            </svg>

                                            <span>Merchants</span>
                                        </a>
                                    </li>
                                    @endpermission
                                    @permission('prime-view-list')
                                    <li>
                                        <a href="{{ route('admin.prime-views.index') }}">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <g clip-path="url(#clip0_4118_2968)">
                                                    <path class="prime_views"
                                                        d="M16.8524 13.0763L17.4023 14.1853C17.4773 14.3396 17.6773 14.4877 17.846 14.5161L18.8428 14.683C19.4802 14.7902 19.6302 15.2564 19.1709 15.7164L18.396 16.4977C18.2647 16.63 18.1929 16.8852 18.2335 17.068L18.4553 18.0352C18.6303 18.8007 18.2272 19.0969 17.5554 18.6967L16.6212 18.1391C16.4524 18.0383 16.1743 18.0383 16.0025 18.1391L15.0682 18.6967C14.3995 19.0969 13.9933 18.7976 14.1683 18.0352L14.3902 17.068C14.4308 16.8852 14.3589 16.63 14.2277 16.4977L13.4528 15.7164C12.9966 15.2564 13.1434 14.7902 13.7808 14.683L14.7776 14.5161C14.9432 14.4877 15.1432 14.3396 15.2182 14.1853L15.7681 13.0763C16.0681 12.4746 16.5555 12.4746 16.8524 13.0763Z"
                                                        stroke="#64748B" stroke-width="0.75" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                </g>
                                                <path d="M4 3H20" class="prime_views" stroke="#64748B"
                                                    stroke-width="1.5" stroke-linecap="round" />
                                                <path class="prime_views" d="M4 9H20" stroke="#64748B"
                                                    stroke-width="1.5" stroke-linecap="round" />
                                                <path class="prime_views" d="M4 15H9" stroke="#64748B"
                                                    stroke-width="1.5" stroke-linecap="round" />
                                                <defs>
                                                    <clipPath id="clip0_4118_2968">
                                                        <rect width="7.5" height="7.5" fill="white"
                                                            transform="translate(12.5625 12)" />
                                                    </clipPath>
                                                </defs>
                                            </svg>

                                            <span>Prime Views</span>
                                        </a>
                                    </li>
                                    @endpermission
                                    @permission('prime-view-product-list')
                                    <li>
                                        <a href="{{ route('admin.prime-view-products.index') }}">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path class="prime_products"
                                                    d="M2 12C2 7.52166 2 5.28249 3.39124 3.89124C4.78249 2.5 7.02166 2.5 11.5 2.5C15.9783 2.5 18.2175 2.5 19.6088 3.89124C21 5.28249 21 7.52166 21 12C21 16.4783 21 18.7175 19.6088 20.1088C18.2175 21.5 15.9783 21.5 11.5 21.5C7.02166 21.5 4.78249 21.5 3.39124 20.1088C2 18.7175 2 16.4783 2 12Z"
                                                    stroke="#64748B" stroke-width="1.5" stroke-linejoin="round" />
                                                <path class="prime_products"
                                                    d="M12.3638 7.72209L13.2437 9.49644C13.3637 9.74344 13.6837 9.98035 13.9536 10.0257L15.5485 10.2929C16.5684 10.4643 16.8083 11.2103 16.0734 11.9462L14.8335 13.1964C14.6236 13.4081 14.5086 13.8164 14.5736 14.1087L14.9285 15.6562C15.2085 16.8812 14.5636 17.355 13.4887 16.7148L11.9939 15.8226C11.7239 15.6613 11.2789 15.6613 11.004 15.8226L9.50913 16.7148C8.43925 17.355 7.78932 16.8761 8.06929 15.6562L8.42425 14.1087C8.48925 13.8164 8.37426 13.4081 8.16428 13.1964L6.92442 11.9462C6.1945 11.2103 6.42947 10.4643 7.44936 10.2929L9.04419 10.0257C9.30916 9.98035 9.62912 9.74344 9.74911 9.49644L10.629 7.72209C11.109 6.7593 11.8889 6.7593 12.3638 7.72209Z"
                                                    stroke="#64748B" stroke-width="1.5" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                            </svg>

                                            <span>PrimeView Product</span>
                                        </a>
                                    </li>
                                    @endpermission
                                    @permission('slider-list')
                                    <li>
                                        <a href="{{ route('admin.sliders.index') }}">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path class="slider"
                                                    d="M7 8C7 5.64298 7 4.46447 7.73223 3.73223C8.46447 3 9.64298 3 12 3C14.357 3 15.5355 3 16.2678 3.73223C17 4.46447 17 5.64298 17 8V16C17 18.357 17 19.5355 16.2678 20.2678C15.5355 21 14.357 21 12 21C9.64298 21 8.46447 21 7.73223 20.2678C7 19.5355 7 18.357 7 16V8Z"
                                                    stroke="#64748B" stroke-width="1.5" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                                <path class="slider"
                                                    d="M2 7C2.54697 7.10449 2.94952 7.28931 3.26777 7.61621C4 8.36835 4 9.5789 4 12C4 14.4211 4 15.6316 3.26777 16.3838C2.94952 16.7107 2.54697 16.8955 2 17"
                                                    stroke="#64748B" stroke-width="1.5" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                                <path class="slider"
                                                    d="M22 7C21.453 7.10449 21.0505 7.28931 20.7322 7.61621C20 8.36835 20 9.5789 20 12C20 14.4211 20 15.6316 20.7322 16.3838C21.0505 16.7107 21.453 16.8955 22 17"
                                                    stroke="#64748B" stroke-width="1.5" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                            </svg>

                                            <span>Slider</span>
                                        </a>
                                    </li>
                                    @endpermission
                                    @permission('customer-list')
                                    <li>
                                        <a href="{{ route('admin.customers.index') }}">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path class="customer"
                                                    d="M15 8C15 9.65685 13.6569 11 12 11C10.3431 11 9 9.65685 9 8C9 6.34315 10.3431 5 12 5C13.6569 5 15 6.34315 15 8Z"
                                                    stroke="#64748B" stroke-width="1.5" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                                <path class="customer"
                                                    d="M16 4C17.6568 4 19 5.34315 19 7C19 8.22309 18.268 9.27523 17.2183 9.7423"
                                                    stroke="#64748B" stroke-width="1.5" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                                <path class="customer"
                                                    d="M13.7143 14H10.2857C7.91878 14 6 15.9188 6 18.2857C6 19.2325 6.76751 20 7.71428 20H16.2857C17.2325 20 18 19.2325 18 18.2857C18 15.9188 16.0812 14 13.7143 14Z"
                                                    stroke="#64748B" stroke-width="1.5" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                                <path class="customer"
                                                    d="M17.7148 13C20.0817 13 22.0005 14.9188 22.0005 17.2857C22.0005 18.2325 21.233 19 20.2862 19"
                                                    stroke="#64748B" stroke-width="1.5" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                                <path class="customer"
                                                    d="M8 4C6.34315 4 5 5.34315 5 7C5 8.22309 5.73193 9.27523 6.78168 9.7423"
                                                    stroke="#64748B" stroke-width="1.5" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                                <path class="customer"
                                                    d="M3.71429 19C2.76751 19 2 18.2325 2 17.2857C2 14.9188 3.91878 13 6.28571 13"
                                                    stroke="#64748B" stroke-width="1.5" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                            </svg>

                                            <span>Customers</span>
                                        </a>
                                    </li>
                                    @endpermission
                                    @permission('reason-list')
                                    <li>
                                        <a href="{{ route('admin.reasons.index') }}">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M12 17H12.01" stroke="#64748B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                <path
                                                    d="M12 11C13.1046 11 14 10.1046 14 9C14 7.89543 13.1046 7 12 7C10.8954 7 10 7.89543 10 9M12 11V12"
                                                    stroke="#64748B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                <path
                                                    d="M3 12C3 7.58172 3 5.37258 4.34315 4.02944C5.68629 2.68629 7.89543 2 12 2C16.1046 2 18.3137 2.68629 19.6569 4.02944C21 5.37258 21 7.58172 21 12C21 16.4183 21 18.6274 19.6569 19.9706C18.3137 21.3137 16.1046 22 12 22C7.89543 22 5.68629 21.3137 4.34315 19.9706C3 18.6274 3 16.4183 3 12Z"
                                                    stroke="#64748B" stroke-width="1.5" />
                                            </svg>
                                            

                                            <span>Reason</span>
                                        </a>
                                    </li>
                                    @endpermission
                                    @permission('location-list')
                                    <li>
                                        <a href="{{ route('admin.locations.index') }}">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path class="location"
                                                    d="M7 18C5.17107 18.4117 4 19.0443 4 19.7537C4 20.9943 7.58172 22 12 22C16.4183 22 20 20.9943 20 19.7537C20 19.0443 18.8289 18.4117 17 18"
                                                    stroke="#64748B" stroke-width="1.5" stroke-linecap="round" />
                                                <path class="location"
                                                    d="M14.5 9C14.5 10.3807 13.3807 11.5 12 11.5C10.6193 11.5 9.5 10.3807 9.5 9C9.5 7.61929 10.6193 6.5 12 6.5C13.3807 6.5 14.5 7.61929 14.5 9Z"
                                                    stroke="#64748B" stroke-width="1.5" />
                                                <path class="location"
                                                    d="M13.2574 17.4936C12.9201 17.8184 12.4693 18 12.0002 18C11.531 18 11.0802 17.8184 10.7429 17.4936C7.6543 14.5008 3.51519 11.1575 5.53371 6.30373C6.6251 3.67932 9.24494 2 12.0002 2C14.7554 2 17.3752 3.67933 18.4666 6.30373C20.4826 11.1514 16.3536 14.5111 13.2574 17.4936Z"
                                                    stroke="#64748B" stroke-width="1.5" />
                                            </svg>

                                            <span>Locations</span>
                                        </a>
                                    </li>
                                    @endpermission
                                    <li>
                                        <a href="{{ route('admin.coupon-types.index') }}">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M4 7C4 5.89543 4.89543 5 6 5H18C19.1046 5 20 5.89543 20 7V9C18.8954 9 18 9.89543 18 11C18 12.1046 18.8954 13 20 13V15C18.8954 15 18 15.8954 18 17C18 18.1046 18.8954 19 20 19V21C20 22.1046 19.1046 23 18 23H6C4.89543 23 4 22.1046 4 21V19C5.10457 19 6 18.1046 6 17C6 15.8954 5.10457 15 4 15V13C5.10457 13 6 12.1046 6 11C6 9.89543 5.10457 9 4 9V7Z"
                                                      stroke="#64748B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M12 10L13.09 12.26L15.5 12.54L13.81 14.22L14.18 16.61L12 15.5L9.82 16.61L10.19 14.22L8.5 12.54L10.91 12.26L12 10Z"
                                                      stroke="#64748B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" fill="#EAB308"/>
                                            </svg>
                                            

                                            <span>CouponType</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('admin.coupons.index') }}">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M3 7C3 5.89543 3.89543 5 5 5H19C20.1046 5 21 5.89543 21 7V9C20.4477 9 20 9.44772 20 10C20 10.5523 20.4477 11 21 11V13C20.4477 13 20 13.4477 20 14C20 14.5523 20.4477 15 21 15V17C21 18.1046 20.1046 19 19 19H5C3.89543 19 3 18.1046 3 17V15C3.55228 15 4 14.5523 4 14C4 13.4477 3.55228 13 3 13V11C3.55228 11 4 10.5523 4 10C4 9.44772 3.55228 9 3 9V7Z" 
                                                      stroke="#64748B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                <circle cx="8" cy="12" r="1" fill="#64748B"/>
                                                <circle cx="16" cy="12" r="1" fill="#64748B"/>
                                            </svg>
                                            

                                            <span>Coupons</span>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="javascript: void(0);" class="has-arrow waves-effect" aria-expanded="false">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M21 4H3C2.44772 4 2 4.44772 2 5V15C2 15.5523 2.44772 16 3 16H16L19 19V5C19 4.44772 18.5523 4 18 4H3Z"
                                                    stroke="#64748B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                <path
                                                    d="M12 9C12.5523 9 13 8.55228 13 8C13 7.44772 12.5523 7 12 7C11.4477 7 11 7.44772 11 8C11 8.55228 11.4477 9 12 9Z"
                                                    stroke="#64748B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                <path
                                                    d="M12 12C12.5523 12 13 11.4477 13 11C13 10.4477 12.5523 10 12 10C11.4477 10 11 10.4477 11 11C11 11.4477 11.4477 12 12 12Z"
                                                    stroke="#64748B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                <path
                                                    d="M12 15C12.5523 15 13 14.4477 13 14C13 13.4477 12.5523 13 12 13C11.4477 13 11 13.4477 11 14C11 14.4477 11.4477 15 12 15Z"
                                                    stroke="#64748B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                            <span>Help/Request</span>
                                        </a>
                                        
                                        
                                        <ul class="sub-menu mm-collapse" aria-expanded="false" style="height: 0px;">
                                            <li>
                                                <a href="{{ route('admin.category-create-requests.index') }}" class=" waves-effect">
                                                    <span>Category Request</span>
                                                </a>
                                            </li>

                                            <li>
                                                <a href="{{ route('admin.help-requests.index') }}" class=" waves-effect">
                                                    <span>Help Request</span>
                                                </a>
                                            </li>

                                        </ul>
                                    </li>
                                    <li>
                                        <a href="{{ route('admin.settings.index') }}">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path class="setting"
                                                    d="M15.5 12C15.5 13.933 13.933 15.5 12 15.5C10.067 15.5 8.5 13.933 8.5 12C8.5 10.067 10.067 8.5 12 8.5C13.933 8.5 15.5 10.067 15.5 12Z"
                                                    stroke="#64748B" stroke-width="1.5" />
                                                <path class="setting"
                                                    d="M21.011 14.0949C21.5329 13.9542 21.7939 13.8838 21.8969 13.7492C22 13.6147 22 13.3982 22 12.9653V11.0316C22 10.5987 22 10.3822 21.8969 10.2477C21.7938 10.1131 21.5329 10.0427 21.011 9.90194C19.0606 9.37595 17.8399 7.33687 18.3433 5.39923C18.4817 4.86635 18.5509 4.59992 18.4848 4.44365C18.4187 4.28738 18.2291 4.1797 17.8497 3.96432L16.125 2.98509C15.7528 2.77375 15.5667 2.66808 15.3997 2.69058C15.2326 2.71308 15.0442 2.90109 14.6672 3.27709C13.208 4.73284 10.7936 4.73278 9.33434 3.277C8.95743 2.90099 8.76898 2.71299 8.60193 2.69048C8.43489 2.66798 8.24877 2.77365 7.87653 2.98499L6.15184 3.96423C5.77253 4.17959 5.58287 4.28727 5.51678 4.44351C5.45068 4.59976 5.51987 4.86623 5.65825 5.39916C6.16137 7.33686 4.93972 9.37599 2.98902 9.90196C2.46712 10.0427 2.20617 10.1131 2.10308 10.2476C2 10.3822 2 10.5987 2 11.0316V12.9653C2 13.3982 2 13.6147 2.10308 13.7492C2.20615 13.8838 2.46711 13.9542 2.98902 14.0949C4.9394 14.6209 6.16008 16.66 5.65672 18.5976C5.51829 19.1305 5.44907 19.3969 5.51516 19.5532C5.58126 19.7095 5.77092 19.8172 6.15025 20.0325L7.87495 21.0118C8.24721 21.2231 8.43334 21.3288 8.6004 21.3063C8.76746 21.2838 8.95588 21.0957 9.33271 20.7197C10.7927 19.2628 13.2088 19.2627 14.6689 20.7196C15.0457 21.0957 15.2341 21.2837 15.4012 21.3062C15.5682 21.3287 15.7544 21.223 16.1266 21.0117L17.8513 20.0324C18.2307 19.8171 18.4204 19.7094 18.4864 19.5531C18.5525 19.3968 18.4833 19.1304 18.3448 18.5975C17.8412 16.66 19.0609 14.621 21.011 14.0949Z"
                                                    stroke="#64748B" stroke-width="1.5" stroke-linecap="round" />
                                            </svg>

                                            <span>Settings</span>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="javascript: void(0);" class="has-arrow waves-effect" aria-expanded="false">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <!-- Shield base representing security/permissions -->
                                                <path d="M4 7L12 3L20 7C20 12.1932 17.2157 19 12 19C6.78428 19 4 12.1932 4 7Z" 
                                                    stroke="#64748B" 
                                                    stroke-width="2" 
                                                    stroke-linecap="round" 
                                                    stroke-linejoin="round"/>
                                                
                                                <!-- Key hole representing access control -->
                                                <path d="M12 8C12.8284 8 13.5 8.67157 13.5 9.5C13.5 10.3284 12.8284 11 12 11C11.1716 11 10.5 10.3284 10.5 9.5C10.5 8.67157 11.1716 8 12 8Z" 
                                                    stroke="#64748B" 
                                                    stroke-width="2"/>
                                                
                                                <!-- Access line -->
                                                <path d="M12 11V14" 
                                                    stroke="#64748B" 
                                                    stroke-width="2" 
                                                    stroke-linecap="round"/>
                                            </svg>
                                            <span>Role & Permission</span>
                                        </a>
                                        
                                        <ul class="sub-menu mm-collapse" aria-expanded="false" style="height: 0px;">
                                            <li>
                                                <a href="{{ route('roles.index') }}" class=" waves-effect">
                                                    <span>Role</span>
                                                </a>
                                            </li>

                                            <li>
                                                <a href="{{ route('users.index') }}" class=" waves-effect">
                                                    <span>Users</span>
                                                </a>
                                            </li>

                                        </ul>
                                    </li>


                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="simplebar-placeholder"></div>
        </div>

    </div>
</div>
<div class="sidebar-backdrop"></div>