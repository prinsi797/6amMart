@extends('layouts.admin.app')
@section('title',translate('Employee Add'))
@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
<div class="content container-fluid">
    <!-- Page Heading -->
    <div class="page-header">
        <h1 class="page-header-title">
            <span class="page-header-icon">
                <img src="{{asset('assets/admin/img/role.png')}}" class="w--26" alt="">
            </span>
            <span>
                {{translate('messages.add_new_employee')}}
            </span>
        </h1>
    </div>
    <!-- Content Row -->
    <form action="{{route('admin.users.employee.add-new')}}" method="post" enctype="multipart/form-data" class="js-validate">
        @csrf
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title">
                    <span class="card-header-icon">
                        <i class="tio-user"></i>
                    </span>
                    <span>{{translate('messages.general_information')}}</span>
                </h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-8">
                        <div class="row g-3">
                            <div class="col-sm-6">
                                <label class="input-label qcont" for="fname">{{translate('messages.first_name')}}<span class="form-label-secondary text-danger"
                                                        data-toggle="tooltip" data-placement="right"
                                                        data-original-title="{{ translate('messages.Required.')}}"> *
                                                        </span>
                                                    </label>
                                <input type="text" name="f_name" class="form-control" id="fname"
                                    placeholder="{{translate('messages.first_name')}}" value="{{old('f_name')}}" required>
                            </div>
                            <div class="col-sm-6">
                                <label class="input-label qcont" for="lname">{{translate('messages.last_name')}}<span class="form-label-secondary text-danger"
                                                        data-toggle="tooltip" data-placement="right"
                                                        data-original-title="{{ translate('messages.Required.')}}"> *
                                                        </span>
                                                     </label>
                                <input type="text" name="l_name" class="form-control" id="lname" value="{{old('l_name')}}"
                                    placeholder="{{translate('messages.last_name')}}" value="{{old('name')}}">
                            </div>
                            <div class="col-sm-6">
                                <div >
                                    <label class="input-label" for="title">{{translate('messages.zone')}}<span class="form-label-secondary text-danger"
                                                        data-toggle="tooltip" data-placement="right"
                                                        data-original-title="{{ translate('messages.Required.')}}"> *
                                                        </span>
                                                                    </label>
                                    <select name="zone_id" id="zone_id" class="form-control js-select2-custom">
                                        @if(!isset(auth('admin')->user()->zone_id))
                                        <option value="" {{!isset($e->zone_id)?'selected':''}}>{{translate('messages.all')}}</option>
                                        @endif
                                        @foreach($zones as $zone)
                                            <option value="{{$zone['id']}}">{{$zone['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div >
                                    <label class="input-label qcont" for="role_id">{{translate('messages.Role')}}<span class="form-label-secondary text-danger"
                                                        data-toggle="tooltip" data-placement="right"
                                                        data-original-title="{{ translate('messages.Required.')}}"> *
                                                        </span>
                                            </label>
                                    <select class="form-control js-select2-custom w-100" name="role_id" id="role_id" required>
                                        <option value="" selected disabled>{{translate('messages.select_Role')}}</option>
                                        @foreach($roles as $role)
                                            <option value="{{$role->id}}">{{$role->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="input-label qcont" for="phone">{{translate('messages.phone')}}<span class="form-label-secondary text-danger"
                                                        data-toggle="tooltip" data-placement="right"
                                                        data-original-title="{{ translate('messages.Required.')}}"> *
                                                        </span>
                                    </label>
                                <input type="number" name="phone" value="{{old('phone')}}" class="form-control" id="phone"
                                        placeholder="{{ translate('messages.Ex:') }} +88017********" required>
                                </div>
                            </div>
                        </div>
                    <div class="col-md-4">
                        <label class="h-100 d-flex flex-column">
                            <div class="text-center input-label qcont py-3 my-auto">
                                {{ translate('messages.Employee_image') }} <small  class="text-danger">* ( {{ translate('messages.ratio') }} 1:1 )</small>

                            </div>
                            <div class="text-center py-3 my-auto">
                                <img class="img--100" id="viewer"
                                src="{{asset('assets\admin\img\400x400\img2.jpg')}}" alt="Employee thumbnail"/>
                            </div>
                            <div class="custom-file">
                                <input type="file" name="image" id="customFileUpload" class="custom-file-input"
                                    accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*" value="{{old('image')}}" required>
                                <div class="custom-file-label">{{translate('messages.choose_file')}}</div>
                            </div>
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">
                    <span class="card-header-icon">
                        <i class="tio-user"></i>
                    </span>
                    <span>{{translate('messages.account_information')}}</span>
                </h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="input-label qcont" for="email">{{translate('messages.email')}} <span class="form-label-secondary text-danger"
                            data-toggle="tooltip" data-placement="right"
                            data-original-title="{{ translate('messages.Required.')}}"> *
                            </span>
</label>
                        <input type="email" name="email" value="{{old('email')}}" class="form-control" id="email"
                                placeholder="{{ translate('messages.Ex:') }} ex@gmail.com" required>
                    </div>
                    <div class="col-md-4">
                        <div class="js-form-message form-group mb-0">
                            <label class="input-label" for="signupSrPassword">{{translate('messages.password')}}<span class="form-label-secondary" data-toggle="tooltip" data-placement="top"
        data-original-title="{{ translate('messages.Must_contain_at_least_one_number_and_one_uppercase_and_lowercase_letter_and_symbol,_and_at_least_8_or_more_characters') }}"><img src="{{ asset('assets/admin/img/info-circle.svg') }}" alt="{{ translate('messages.Must_contain_at_least_one_number_and_one_uppercase_and_lowercase_letter_and_symbol,_and_at_least_8_or_more_characters') }}"></span> <span class="form-label-secondary text-danger"
                            data-toggle="tooltip" data-placement="top"
                            data-original-title="{{ translate('messages.Required.')}}"> *
                            </span> </label>

                            <div class="input-group input-group-merge">
                                <input type="password" class="js-toggle-password form-control" name="password" id="signupSrPassword" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="{{ translate('messages.Must_contain_at_least_one_number_and_one_uppercase_and_lowercase_letter_and_symbol,_and_at_least_8_or_more_characters') }}"
                                placeholder="{{ translate('messages.password_length_placeholder', ['length' => '8+']) }}"
                                aria-label="8+ characters required" required
                                data-msg="Your password is invalid. Please try again."
                                data-hs-toggle-password-options='{
                                "target": [".js-toggle-password-target-1", ".js-toggle-password-target-2"],
                                "defaultClass": "tio-hidden-outlined",
                                "showClass": "tio-visible-outlined",
                                "classChangeTarget": ".js-toggle-passowrd-show-icon-1"
                                }'>
                                <div class="js-toggle-password-target-1 input-group-append">
                                    <a class="input-group-text" href="javascript:">
                                        <i class="js-toggle-passowrd-show-icon-1 tio-visible-outlined"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="js-form-message form-group mb-0">
                            <label class="input-label" for="signupSrConfirmPassword">{{translate('messages.confirm_password')}} <span class="form-label-secondary text-danger"
                            data-toggle="tooltip" data-placement="right"
                            data-original-title="{{ translate('messages.Required.')}}"> *
                            </span> </label>
                            <div class="input-group input-group-merge">
                            <input type="password" class="js-toggle-password form-control" name="confirmPassword" id="signupSrConfirmPassword" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="{{ translate('messages.Must_contain_at_least_one_number_and_one_uppercase_and_lowercase_letter_and_symbol,_and_at_least_8_or_more_characters') }}"
                            placeholder="{{ translate('messages.password_length_placeholder', ['length' => '8+']) }}"
                            aria-label="8+ characters required" required
                                    data-msg="Password does not match the confirm password."
                                    data-hs-toggle-password-options='{
                                    "target": [".js-toggle-password-target-1", ".js-toggle-password-target-2"],
                                    "defaultClass": "tio-hidden-outlined",
                                    "showClass": "tio-visible-outlined",
                                    "classChangeTarget": ".js-toggle-passowrd-show-icon-2"
                                    }'>
                                <div class="js-toggle-password-target-2 input-group-append">
                                    <a class="input-group-text" href="javascript:">
                                    <i class="js-toggle-passowrd-show-icon-2 tio-visible-outlined"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="btn--container justify-content-end mt-4">
            <button type="reset" id="reset_btn" class="btn btn--reset">{{translate('messages.reset')}}</button>
            <button type="submit" class="btn btn--primary">{{translate('messages.submit')}}</button>
        </div>
    </form>
</div>
@endsection

@push('script_2')
    <script src="{{asset('/admin')}}/js/view-pages/employee.js"></script>
<script>
    "use strict";
    $(document).on('ready', function () {
        // INITIALIZATION OF SHOW PASSWORD
        // =======================================================
        $('.js-toggle-password').each(function () {
            new HSTogglePassword(this).init()
        });


        // INITIALIZATION OF FORM VALIDATION
        // =======================================================
        $('.js-validate').each(function() {
            $.HSCore.components.HSValidation.init($(this), {
                rules: {
                    confirmPassword: {
                        equalTo: '#signupSrPassword'
                    }
                }
            });
        });
    });
        $('#reset_btn').click(function(){
            $('#viewer').attr('src', "{{ asset('/admin/img/400x400/img2.jpg') }}");
            $('#customFileUpload').val(null);
            $('#zone_id').val(null).trigger('change');
            $('#role_id').val(null).trigger('change');
        })
    </script>
@endpush
