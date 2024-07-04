<div class="">
    <div>
        <div class="text-center mb-4 pb-2">

            @if ($store_subscription?->package_id ==  $package->id)
            <h2 class="modal-title">{{translate('Renew_Subscription_Plan')}}</h2>
            @else
            <h2 class="modal-title">{{translate('Shift to New Subscription Plan')}}</h2>
            @endif

        </div>
        <div class="change-plan-wrapper align-items-center">
            @if ($store_business_model == 'commission'  )
            <div class="__plan-item">
                <div class="inner-div">
                    <div class="text-center">
                        <h3 class="title">{{ translate('commission')  }}</h3>
                        <h2 class="price">{{  $admin_commission }} %</h2>
                        {{-- <div class="day-count">{{ $store_subscription?->package?->validity }} {{ translate('days') }}</div> --}}
                    </div>
                </div>
            </div>
            <!-- Plan Seperator Arrow -->
            <div class="plan-seperator-arrow mx-auto">
                <img src="{{asset('/admin/img/exchange.svg')}}" alt="" class="w-100">
            </div>
            <!-- Plan Seperator Arrow -->

            @elseif(!in_array($store_business_model,['commission','none']))

            <div class="__plan-item {{ !$store_subscription  || $store_subscription?->package_id ==  $package->id ?  'active' : '' }}">
                <div class="inner-div">
                    <div class="text-center">
                        <h3 class="title">{{ $store_subscription?->package?->package_name  }}</h3>
                        <h2 class="price">{{  \App\CentralLogics\Helpers::format_currency($store_subscription?->package?->price) }}</h2>
                        <div class="day-count">{{ $store_subscription?->package?->validity }} {{ translate('days') }}</div>
                    </div>
                </div>
            </div>
                @if ( $store_subscription?->package_id !=  $package->id )
                <!-- Plan Seperator Arrow -->
                <div class="plan-seperator-arrow mx-auto">
                <img src="{{asset('/admin/img/exchange.svg')}}" alt="" class="w-100">
                </div>
                <!-- Plan Seperator Arrow -->
                @endif
            @endif


            @if ($store_subscription?->package_id !==  $package->id || $store_business_model == 'commission' )

            <div class="__plan-item active">
                <div class="inner-div">
                    <div class="text-center">
                        <h3 class="title">{{$package->package_name }}</h3>
                        <h2 class="price">{{ \App\CentralLogics\Helpers::format_currency($package?->price) }}</h2>
                        <div class="day-count">{{ $package?->validity }} {{ translate('days') }}</div>
                    </div>
                </div>
            </div>

            @endif
        </div>


        <div class="mb-2 mb-lg-3 subscription__plan-info-wrapper bg-ECEEF1 rounded-20">
            <div class="row g-3">
                <div class="col-md-{{ $pending_bill > 0 ? '3' :'4' }}">
                    <div class="subscription__plan-info">
                        <div class="info">
                            {{ translate('Validity') }}
                        </div>
                        <h4 class="subtitle">{{ $package?->validity }} {{ translate('days') }}</h4>
                    </div>
                </div>
                <div class="col-md-{{ $pending_bill > 0 ? '3' :'4' }}">
                    <div class="subscription__plan-info">
                        <div class="info">
                            {{ translate('Price') }}
                        </div>
                        <h4 class="subtitle">{{ \App\CentralLogics\Helpers::format_currency($package?->price) }}</h4>
                    </div>
                </div>
                @if ($pending_bill)
                <div class="col-md-3">
                    <div class="subscription__plan-info">
                        <div class="info">
                            {{ translate('pending_bill') }}
                        </div>
                        <h4 class="subtitle">{{ \App\CentralLogics\Helpers::format_currency($pending_bill) }}</h4>
                    </div>
                </div>

                @endif
                <div class="col-md-{{ $pending_bill > 0 ? '3' :'4' }}">
                    <div class="subscription__plan-info">
                        <div class="info">
                            {{ translate('Bill_status') }}
                        </div> <h4 class="subtitle">  {{  $store_business_model != 'commission' &&  $store_subscription?->package_id ==  $package->id ? translate('Renew') :  translate('Migrate_to_new_plan') }}  </h4> </div>
                </div>
            </div>
        </div>
        @if (data_get($cash_backs,'back_amount') > 0 )
        <div class="mb-2 mb-lg-3 subscription__plan-info-wrapper bg--10 rounded-20 py-2">
            <div class="row g-3">
            <div class="col-auto">
                <i class="tio-notice"></i>
                    {{ translate('You will get') }}  {{ \App\CentralLogics\Helpers::format_currency(data_get($cash_backs,'back_amount')) }} {{ translate('to_your_wallet_for_remaining') }}  {{ data_get($cash_backs,'days') }} {{ translate('messages.days_subscription_plan') }}
                </div>
            </div>
        </div>
        @endif
        <form action="{{ route('vendor.subscriptionackage.packageBuy') }}" method="post">
            @csrf
            @method('POST')
                <input type="hidden" value="{{ $package->id }}" name="package_id">
                <input type="hidden" value="{{ $store_id }}" name="store_id">
                <input type="hidden" value="{{ $store_subscription?->package_id ==  $package->id ? 'renew' : 'payment' }}" name="type">




        <h4 class="mb-4">{{ translate('Pay Via Online') }} <span class="font-regular text-body">({{ translate('Faster & secure way to pay bill') }})</span></h4>
        <div class="row g-3">
            @if ($balance > 0)

            <div class="col-md-6">
                <label class="payment-item">
                    <input type="radio" {{ $balance >= $package?->price ? '' :'disabled'  }} value="wallet"  class="d-none" name="payment_gateway">
                    <div  data-toggle="tooltip" data-placement="bottom" title="{{$balance >= $package?->price ? translate('pay_the_amount_via_wallet') : translate('You have not sufficient balance on you wallet! please add money to your wallet to purchase the packages') }}"  class="payment-item-inner">
                        <div class="check">
                            <img src="{{asset('assets/admin/img/check-1.png')}}" class="uncheck" alt="">
                            <img src="{{asset('assets/admin/img/check-2.png')}}" class="check" alt="">
                        </div>
                        <span>{{ translate('wallet') }}</span>
                        <span class="ml-auto" >{{ \App\CentralLogics\Helpers::format_currency($balance) }} </span>
                    </div>
                </label>
            </div>
            @endif


            @foreach ($payment_methods as $item)

            <div class="col-md-6">
                <label class="payment-item">
                    <input type="radio" class="d-none" value="{{ $item['gateway'] }}" name="payment_gateway">
                    <div class="payment-item-inner">
                        <div class="check">
                            <img src="{{asset('assets/admin/img/check-1.png')}}" class="uncheck" alt="">
                            <img src="{{asset('assets/admin/img/check-2.png')}}" class="check" alt="">
                        </div>
                        <span>{{ $item['gateway_title'] }}</span>
                        <img class="ml-auto"
                        src="{{ \App\CentralLogics\Helpers::onerror_image_helper(
                            $item['gateway_image'],
                            asset('storage/payment_modules/gateway_image').'/'.$item['gateway_image'],
                            asset('//admin/img/payment/placeholder.png'),
                            'payment_modules/gateway_image/',$item['storage']??'public'
                        ) }}"

                        width="30" alt="">
                    </div>
                </label>
            </div>

            @endforeach

        </div>
        <div class="btn--container justify-content-end mt-3">
            <button type="reset" data-dismiss="modal" class="btn btn--reset">{{ translate('Cancel') }}</button>
            @if ( $store_business_model != 'commission' && $store_subscription?->package_id ==  $package->id)
            <button type="submit" class="btn btn--primary">{{ translate('Renew Subscription Plan') }}</button>
            @else
            <button type="submit" class="btn btn--primary">{{ translate('Change_Plan') }}</button>
            @endif
        </div>
    </div>
</form>
</div>
