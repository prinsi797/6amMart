@extends('layouts.vendor.app')
@section('title',translate('messages.Store_Subscription'))
@section('subscriberList')
active
@endsection
@push('css_or_js')

@endpush

@section('content')
<div class="content container-fluid">



    @if ($store->store_business_model == 'commission' &&  \App\CentralLogics\Helpers::commission_check())

    <div class="page-header">
        <div class="d-flex flex-wrap justify-content-between align-items-center py-2">
            <div class="flex-grow-1">
                <div class="d-flex align-items-start">
                    <img src="{{asset('assets/admin/img/store.png')}}" width="24" alt="img">
                    <div class="w-0 flex-grow pl-2">
                        <h1 class="page-header-title">{{ $store->name }} {{translate('Business_Plan')}} &nbsp; &nbsp;

                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if ($store->store_all_sub_trans_count > 0)


    <div class="js-nav-scroller hs-nav-scroller-horizontal mb-4">
        <ul class="nav nav-tabs border-0 nav--tabs nav--pills">
            <li class="nav-item">
                <a href="#" class="nav-link active">{{ translate('Business_Details') }} </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('vendor.subscriptionackage.subscriberTransactions',$store->id) }}" class="nav-link">{{ translate('Transactions') }}</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('vendor.subscriptionackage.subscriberWalletTransactions') }}" class="nav-link">{{ translate('Subscription_Refunds') }}</a>
            </li>
        </ul>
    </div>

    @endif

    <div class="card mb-3">
        <div class="card-header border-0 align-items-center">
            <h4 class="card-title align-items-center gap-2">
                <span class="card-header-icon">
                    <img width="25" src="{{asset('/admin/img/subscription-plan/subscribed-user.png')}}" alt="">
                </span>
                <span>{{ translate('Overview') }}</span>
            </h4>
        </div>
        <div class="card-body pt-0">
            <div class="__bg-F8F9FC-card __plan-details">
                <div class="d-flex flex-wrap flex-md-nowrap justify-content-between __plan-details-top">
                    <div class="w-100">
                        <h2 class="name text--primary">{{ translate('Commission Base Plan') }}</h2>
                        <h4 class="title mt-2"><span class="text-180">{{ $admin_commission }} %</span> {{ translate('messages.Commission_per_order') }}</h4>
                        <div class="info-text ">
                            {{ translate('Store will pay') }} {{ $store->comission > 0 ?  $store->comission :  $admin_commission }}% {{ translate('commission to') }} <strong>{{ $business_name }}</strong> {{ translate('from each order. You will get access of all the features and options  in store panel , app and interaction with user.') }}
                        </div>

                    </div>
                </div>

            </div>
            @if (\App\CentralLogics\Helpers::subscription_check() )
                <div class="btn--container justify-content-end mt-3">
                    <button type="button" data-toggle="modal" data-target="#plan-modal" class="btn btn--primary">{{ translate('Change Business Plan') }}</button>
                </div>
            @endif
        </div>
    </div>
    @elseif (in_array($store->store_business_model,[ 'subscription' ,'unsubscribed']) && $store?->store_sub_update_application)
        <div class="page-header">
            <div class="d-flex flex-wrap justify-content-between align-items-center py-2">
                <div class="flex-grow-1">
                    <div class="d-flex align-items-start">
                        <img src="{{asset('assets/admin/img/store.png')}}" width="24" alt="img">
                        <div class="w-0 flex-grow pl-2">
                            <h1 class="page-header-title">{{ $store->name }} {{translate('Subscription')}} &nbsp; &nbsp;
                                @if($store?->store_sub_update_application?->status == 0)
                                <span class=" badge badge-pill badge-danger">  &nbsp; {{ translate('Expired') }}  &nbsp; </span>
                                @elseif ($store?->store_sub_update_application?->is_canceled == 1)
                                <span class=" badge badge-pill badge-warning">  &nbsp; {{ translate('canceled') }}  &nbsp; </span>
                                @elseif($store?->store_sub_update_application?->status == 1)
                                <span class=" badge badge-pill badge-success">  &nbsp; {{ translate('Active') }}  &nbsp; </span>
                                @endif
                            </h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="js-nav-scroller hs-nav-scroller-horizontal mb-4">
            <ul class="nav nav-tabs border-0 nav--tabs nav--pills">
                <li class="nav-item">
                    <a href="#" class="nav-link active">{{ translate('Subscription_Details') }} </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('vendor.subscriptionackage.subscriberTransactions',$store->id) }}" class="nav-link">{{ translate('Transactions') }}</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('vendor.subscriptionackage.subscriberWalletTransactions') }}" class="nav-link">{{ translate('Subscription_Refunds') }}</a>
                </li>
            </ul>
        </div>

        <div class="card mb-20">
            <div class="card-header border-0 align-items-center">
                <h4 class="card-title align-items-center gap-2">
                    <span class="card-header-icon">
                        <img src="{{asset('/admin/img/billing.png')}}" alt="">
                    </span>
                    <span class="text-title">{{ translate('Billing') }}</span>
                </h4>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-sm-6 col-lg-4">
                        <a class="__card-2 __bg-1 flex-row align-items-center gap-4" href="#">
                            <img src="{{asset('/admin/img/expiring.png')}}" alt="report/new" class="w-60px">
                            <div class="w-0 flex-grow-1 py-md-3">
                                <span class="text-body">{{ translate('Expire Date') }}</span>
                                <h4 class="title m-0">{{  \App\CentralLogics\Helpers::date_format($store?->store_sub_update_application?->expiry_date_parsed) }}</h4>
                            </div>
                        </a>
                    </div>
                    <div class="col-sm-6 col-lg-4">
                        <a class="__card-2 __bg-8 flex-row align-items-center gap-4" href="#">
                            <img src="{{asset('/admin/img/total-bill.png')}}" alt="report/new" class="w-60px">
                            <div class="w-0 flex-grow-1 py-md-3">
                                <span class="text-body">{{ translate('Total_Bill') }}</span>
                                <h4 class="title m-0">{{  \App\CentralLogics\Helpers::format_currency($store?->store_sub_update_application?->package?->price * ($store?->store_sub_update_application?->total_package_renewed + 1) ) }}</h4>
                            </div>
                        </a>
                    </div>
                    <div class="col-sm-6 col-lg-4">
                        <a class="__card-2 __bg-4 flex-row align-items-center gap-4" href="#">
                            <img src="{{asset('/admin/img/number.png')}}" alt="report/new" class="w-60px">
                            <div class="w-0 flex-grow-1 py-md-3">
                                <span class="text-body">{{ translate('Number of Uses') }}</span>
                                <h4 class="title m-0">{{ $store?->store_sub_update_application?->total_package_renewed + 1 }}</h4>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-3">
            <div class="card-header border-0 align-items-center">
                <h4 class="card-title align-items-center gap-2">
                    <span class="card-header-icon">
                        <img width="25" src="{{asset('/admin/img/subscription-plan/subscribed-user.png')}}" alt="">
                    </span>
                    <span>{{ translate('Package Overview') }}</span>
                </h4>
            </div>
            <div class="card-body pt-0">
                <div class="__bg-F8F9FC-card __plan-details">
                    <div class="d-flex flex-wrap flex-md-nowrap justify-content-between __plan-details-top">
                        <div class="left">
                            <h3 class="name">{{ $store?->store_sub_update_application?->package?->package_name }}</h3>
                            <div class="font-medium text--title">{{ $store?->store_sub_update_application?->package?->text }}</div>
                        </div>
                        <h3 class="right">{{ \App\CentralLogics\Helpers::format_currency($store?->store_sub_update_application?->last_transcations?->price) }} /<small class="font-medium text--title">{{ $store?->store_sub_update_application?->last_transcations?->validity }} {{ translate('messages.Days') }}</small></h3>
                    </div>


                    <div class="check--grid-wrapper mt-3 max-w-850px">


                        <div>
                            <div class="d-flex align-items-center gap-2">
                                <img src="{{asset('assets/admin/img/subscription-plan/check.png')}}" alt="">
                                @if ( $store?->store_sub_update_application?->max_order == 'unlimited' )
                                <span class="form-check-label text-dark">{{ translate('messages.unlimited_orders') }}</span>
                                @else
                                <span class="form-check-label text-dark"> {{ $store?->store_sub_update_application?->package?->max_order }} {{
                                    translate('messages.Orders') }} <small>({{ $store?->store_sub_update_application?->max_order }} {{ translate('left') }}) </small> </span>
                                @endif
                            </div>
                        </div>

                        <div>
                            <div class="d-flex align-items-center gap-2">
                                @if ( $store?->store_sub_update_application?->pos == 1 )
                                <img src="{{asset('assets/admin/img/subscription-plan/check.png')}}" alt="">
                                @else
                                <img src="{{asset('assets/admin/img/subscription-plan/check-1.png')}}" alt="">
                                @endif
                                <span class="form-check-label text-dark">{{ translate('messages.POS') }}</span>
                            </div>
                        </div>

                        <div>
                            <div class="d-flex align-items-center gap-2">
                                @if ( $store?->store_sub_update_application?->mobile_app == 1 )
                                <img src="{{asset('assets/admin/img/subscription-plan/check.png')}}" alt="">
                                @else
                                <img src="{{asset('assets/admin/img/subscription-plan/check-1.png')}}" alt="">
                                @endif
                                <span class="form-check-label text-dark">{{ translate('messages.Mobile_App') }}</span>
                            </div>
                        </div>
                        <div>
                            <div class="d-flex align-items-center gap-2">
                                @if ( $store?->store_sub_update_application?->self_delivery == 1 )
                                <img src="{{asset('assets/admin/img/subscription-plan/check.png')}}" alt="">
                                @else
                                <img src="{{asset('assets/admin/img/subscription-plan/check-1.png')}}" alt="">
                                @endif
                                <span class="form-check-label text-dark">{{ translate('messages.self_delivery') }}</span>
                            </div>
                        </div>

                        <div>
                            <div class="d-flex align-items-center gap-2">
                                <img src="{{asset('assets/admin/img/subscription-plan/check.png')}}" alt="">
                                @if ( $store?->store_sub_update_application?->max_product == 'unlimited' )
                                <span class="form-check-label text-dark">{{ translate('messages.unlimited_item_Upload')
                                    }}</span>
                                @else
                                <span class="form-check-label text-dark"> {{ $store?->store_sub_update_application?->max_product }} {{
                                    translate('messages.product_Upload') }} <small>({{ $store?->store_sub_update_application?->max_product  - $store->items_count > 0 ? $store?->store_sub_update_application?->max_product  - $store->items_count : 0 }} {{ translate('left') }}) </small></span>
                                @endif
                            </div>
                        </div>

                        <div>
                            <div class="d-flex align-items-center gap-2">
                                @if ( $store?->store_sub_update_application?->review == 1 )
                                <img src="{{asset('assets/admin/img/subscription-plan/check.png')}}" alt="">
                                @else
                                <img src="{{asset('assets/admin/img/subscription-plan/check-1.png')}}" alt="">
                                @endif
                                <span class="form-check-label text-dark">{{ translate('messages.review') }}</span>
                            </div>
                        </div>

                        <div>
                            <div class="d-flex align-items-center gap-2">
                                @if ( $store?->store_sub_update_application?->chat == 1 )
                                <img src="{{asset('assets/admin/img/subscription-plan/check.png')}}" alt="">
                                @else
                                <img src="{{asset('assets/admin/img/subscription-plan/check-1.png')}}" alt="">
                                @endif
                                <span class="form-check-label text-dark">{{ translate('messages.chat') }}</span>
                            </div>
                        </div>

                    </div>
                </div>
                {{-- {{ dd($store?->store_sub_update_application) }} --}}
                <div class="btn--container justify-content-end mt-3">
                    @if ( $store?->store_sub_update_application?->is_canceled == 0 && $store?->store_sub_update_application?->status == 1  )
                        <button type="button"  data-url="{{route('vendor.subscriptionackage.cancelSubscription',$store?->id)}}" data-message="{{translate('If_you_cancel_the_subscription,_after_')}} {{  Carbon\Carbon::now()->subDays(1)->diffInDays($store?->store_sub_update_application?->expiry_date_parsed->format('Y-m-d'), false); }} {{ translate('days_the_you_will_no_longer_be_able_to_run_the_business_before_subscribe_a_new_plan.') }} "
                        class="btn btn--danger text-white status_change_alert">{{ translate('Cancel Subscription') }}</button>
                    @endif

                    <button type="button" data-toggle="modal" data-target="#plan-modal" class="btn btn--primary">{{ translate('Change / Renew Subscription Plan') }}</button>

                </div>
            </div>
        </div>
        @else

        <div class="card">
            <div class="card-body text-center py-5">
                <div class="max-w-542 mx-auto py-sm-5 py-4">
                    <img class="mb-4" src="{{asset('assets/admin/img/empty-subscription.svg')}}" alt="img">
                    <h4 class="mb-3">{{translate('Chose Subscription Plan')}}</h4>
                    <p class="mb-4">
                        {{translate('Chose a subscription packages from the list. So that Stores get more options to join the business for the growth and success.')}}<br>
                    </p>
                    <button type="button" data-toggle="modal" data-target="#plan-modal" class="btn btn--primary">{{ translate('Chose Subscription Plan') }}</button>
                </div>
            </div>
        </div>

        @endif
    </div>
    <div class="modal fade show" id="plan-modal">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header px-3 pt-3">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true" class="tio-clear"></span>
                    </button>
                </div>
                <div class="modal-body px-4 pt-0">
                    <div>
                        <div class="text-center">
                            <h2 class="modal-title">{{ translate('Change Subscription Plan') }}</h2>
                        </div>
                        <div class="text-center text-14 mb-4 pb-3">
                           {{ translate('Renew or shift your plan to get better experience!') }}
                        </div>
                        <div class="plan-slider owl-theme owl-carousel owl-refresh">
                            @if (\App\CentralLogics\Helpers::commission_check())
                            <div class="__plan-item hover {{ $store->store_business_model == 'commission'  ? 'active' : ''}} ">
                                <div class="inner-div">
                                    <div class="text-center">
                                        <h3 class="title">{{ translate('Commission Base') }}</h3>
                                        <h2 class="price">{{ $admin_commission }}%</h2>
                                    </div>
                                    <div class="py-5 mt-4">
                                        <div class="info-text text-center">
                                            {{ translate('Store will pay') }} {{ $admin_commission }}% {{ translate('commission to') }} {{ $business_name }} {{ translate('from each order. You will get access of all the features and options  in store panel , app and interaction with user.') }}
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        @if ($store->store_business_model == 'commission')
                                        <button type="button" class="btn btn--secondary">{{ translate('Current_Plan') }}</button>
                                        @else
                                        <button type="button" data-url="{{route('vendor.subscriptionackage.switchToCommission',$store->id)}}" data-message="{{translate('You_Want_To_Migrate_To_Commission')}}" class="btn btn--primary shift_to_commission">{{ translate('Shift in this plan') }}</button>
                                        @endif

                                    </div>
                                </div>
                            </div>
                            @endif


                            @forelse ($packages as $package)

                            <div class="__plan-item hover {{ $store?->store_sub_update_application?->package_id == $package->id  && $store->store_business_model != 'commission'  ? 'active' : ''}}">
                                <div class="inner-div">
                                    <div class="text-center">
                                        <h3 class="title">{{ $package->package_name }}</h3>
                                        <h2 class="price">{{ \App\CentralLogics\Helpers::format_currency($package->price)}}</h2>
                                        <div class="day-count">{{ $package->validity }} {{ translate('messages.days') }}</div>
                                    </div>
                                    <ul class="info">

                                        @if ($package->pos)
                                        <li>
                                            <i class="tio-checkmark-circle"></i> <span>  {{ translate('messages.POS') }} </span>
                                        </li>
                                        @endif
                                        @if ($package->mobile_app)
                                        <li>
                                            <i class="tio-checkmark-circle"></i> <span>  {{ translate('messages.mobile_app') }} </span>
                                        </li>
                                        @endif
                                        @if ($package->chat)
                                        <li>
                                            <i class="tio-checkmark-circle"></i> <span>  {{ translate('messages.chatting_options') }} </span>
                                        </li>
                                        @endif
                                        @if ($package->review)
                                        <li>
                                            <i class="tio-checkmark-circle"></i> <span>  {{ translate('messages.review_section') }} </span>
                                        </li>
                                        @endif
                                        @if ($package->self_delivery)
                                        <li>
                                            <i class="tio-checkmark-circle"></i> <span>  {{ translate('messages.self_delivery') }} </span>
                                        </li>
                                        @endif
                                        @if ($package->max_order == 'unlimited')
                                        <li>
                                            <i class="tio-checkmark-circle"></i> <span>  {{ translate('messages.Unlimited_Orders') }} </span>
                                        </li>
                                        @else
                                        <li>
                                            <i class="tio-checkmark-circle"></i> <span>  {{ $package->max_order }} {{ translate('messages.Orders') }} </span>
                                        </li>
                                        @endif
                                        @if ($package->max_product == 'unlimited')
                                        <li>
                                            <i class="tio-checkmark-circle"></i> <span>  {{ translate('messages.Unlimited_uploads') }} </span>
                                        </li>
                                        @else
                                        <li>
                                            <i class="tio-checkmark-circle"></i> <span>  {{ $package->max_product }} {{ translate('messages.uploads') }} </span>
                                        </li>
                                        @endif

                                    </ul>
                                    <div class="text-center">
                                        {{-- <button type="button" class="btn btn--primary" data-dismiss="modal" data-toggle="modal" data-target="#shift-modal">Shift in this plan</button> --}}

                                        @if (  $store?->store_business_model != 'commission'  &&  $store?->store_sub_update_application?->package_id == $package->id)
                                        <button data-id="{{ $package->id }}"  data-url="{{route('vendor.subscriptionackage.packageView',[$package->id,$store->id ])}}"
                                            data-target="#package_detail" id="package_detail" type="button" class="btn btn--warning text-white renew-btn package_detail">{{ translate('messages.Renew') }}</button>
                                        @else
                                        <button data-id="{{ $package->id }}" data-url="{{route('vendor.subscriptionackage.packageView',[$package->id,$store->id ])}}"
                                            data-target="#package_detail" id="package_detail" type="button" class="btn btn--primary shift-btn package_detail">{{ translate('messages.Shift_in_this_plan') }}</button>
                                        @endif


                                    </div>
                                </div>
                            </div>
                            @empty

                            @endforelse
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- subscription Plan Modal 2 -->
    <div class="modal fade __modal" id="subscription-renew-modal">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body px-4 pt-0">
                    <div class="data_package" id="data_package">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="product_warning">
        <div class="modal-dialog modal-dialog-centered status-warning-modal">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true" class="tio-clear"></span>
                    </button>
                </div>
                <div class="modal-body pb-5 pt-0">
                    <div class="max-349 mx-auto mb-20">
                        <div>
                            <div class="text-center">
                                <img src="{{asset('assets/admin/img/subscription-plan/package-status-disable.png')}}" class="mb-20">
                                <h5 class="modal-title" ></h5>
                            </div>
                            <div class="text-center">
                                <h3>{{ translate('Are_You_Sure_You_want_To_switch_to_this_plan?') }}</h3>
                                <p>{{ translate('You_are_about_to_downgrade_your_plan.After_subscribing_to_this_plan_your_oldest_') }} <span id="disable_item_count"></span> {{ translate('Items_will_be_inactivated.') }} </p>
                            </div>
                        </div>
                        <div class="btn--container justify-content-center">
                            <button  id="continue_btn" class="btn btn-outline-primary min-w-120" data-dismiss="modal" >
                                {{translate("Continue")}}
                            </button>
                            <button  class="btn btn--primary min-w-120  shift_package"  id="back_to_planes" data-dismiss="modal" >{{translate('Go_Back')}}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('script_2')
    <script>
        $('.plan-slider').owlCarousel({
            loop: false,
            margin: 30,
            responsiveClass:true,
            nav:false,
            dots:false,
            items: 3,
            center: true,
            startPosition: '{{ $index }}',

            responsive:{
                0: {
                    items:1.1,
                    margin: 10,
                },
                375: {
                    items:1.3,
                    margin: 30,
                },
                576: {
                    items:1.7,
                },
                768: {
                    items:2.2,
                    margin: 40,
                },
                992: {
                    items: 3,
                    margin: 40,
                },
                1200: {
                    items: 4,
                    margin: 40,
                }
            }
        })

        "use strict";
            $('.status_change_alert').on('click', function (event) {

            let url = $(this).data('url');
            let message = $(this).data('message');
            status_change_alert(url, message, event)
        })

        function status_change_alert(url, message, e) {
            e.preventDefault();
            Swal.fire({
                title: '{{ translate('Are_you_sure?') }}',
                text: message,
                type: 'warning',
                showCancelButton: true,
                cancelButtonColor: 'default',
                confirmButtonColor: '#FC6A57',
                cancelButtonText: '{{ translate('no') }}',
                confirmButtonText: '{{ translate('yes') }}',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.post({
                        url: url,
                        data: {
                            id: '{{ $store->id }}',
                            subscription_id:'{{ $store?->store_sub_update_application?->id }}',
                        },
                        beforeSend: function () {
                            $('#loading').show()
                        },
                        success: function (data) {
                            toastr.success('{{ translate('Successfully_canceled_the_subscription') }}!');
                        },
                        complete: function () {
                            $('#loading').hide();
                            location.reload();
                        }
                    });
                }
            })
        }

        $('.shift_to_commission').on('click', function (event) {
            let url = $(this).data('url');
            let message = $(this).data('message');
            shift_to_commission(url, message, event)
        })

        function shift_to_commission(url, message, e) {
            e.preventDefault();
            Swal.fire({
                title: '{{ translate('Are_you_sure?') }}',
                text: message,
                type: 'warning',
                showCancelButton: true,
                cancelButtonColor: 'default',
                confirmButtonColor: '#FC6A57',
                cancelButtonText: '{{ translate('no') }}',
                confirmButtonText: '{{ translate('yes') }}',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.post({
                        url: url,
                        data: {
                            id: '{{ $store->id }}',
                        },
                        beforeSend: function () {
                            $('#loading').show()
                        },
                        success: function (data) {
                            toastr.success('{{ translate('Successfully_Switched_To_Commission') }}!');
                        },
                        complete: function () {
                            $('#loading').hide();
                            location.reload();
                        }
                    });
                }
            })
        }

        $(document).on('click', '.package_detail', function () {
            var url = $(this).attr('data-url');
            package_pay(url);
        });
        $(document).on('click', '#continue_btn', function () {
            $('#subscription-renew-modal').modal('show')
        });

        $(document).on('click', '#back_to_planes', function () {
            $('#plan-modal').modal('show')
        });


        function package_pay(url){
            $.ajax({
                url: url,
                method: 'get',
                beforeSend: function() {
                            $('#loading').show();
                            $('#plan-modal').modal('hide')
                            },
                success: function(data){
                    $('#data_package').html(data.view);
                    if(data.disable_item_count !== null && data.disable_item_count > 0){
                        $('#product_warning').modal('show')
                        $('#disable_item_count').text(data.disable_item_count)
                    } else{
                        $('#subscription-renew-modal').modal('show')
                    }
                },
                complete: function() {
                        $('#loading').hide();
                    },

            });
        }

        @if (request()?->renew_now == true)
        var url = '{{ route('vendor.subscriptionackage.packageView',[$store?->store_sub?->package_id,$store->id ]) }}';
        package_pay(url);
            var url = new URL(window.location.href);
            var searchParams = new URLSearchParams(url.search);
            searchParams.delete('renew_now');
            var newUrl = url.origin + url.pathname + '?' + searchParams.toString();
            if (!searchParams.toString()) {
                newUrl = url.origin + url.pathname;
            }
            window.history.replaceState(null, '', newUrl);
        @endif

        @if (request()?->open_plans == true)
        $('#plan-modal').modal('show');
            var url = new URL(window.location.href);
            var searchParams = new URLSearchParams(url.search);
            searchParams.delete('open_plans');
            var newUrl = url.origin + url.pathname + '?' + searchParams.toString();
            if (!searchParams.toString()) {
                newUrl = url.origin + url.pathname;
            }
            window.history.replaceState(null, '', newUrl);
        @endif

    </script>
@endpush

