@extends('layouts.admin')

@section('content')
    <!-- CONTAINER -->
    <div class="main-container container-fluid">

    @include('account::front.manage_user.partial.header')

        <!-- ROW -->
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-header border-bottom">
                        <h3 class="card-title">افزودن کاربر</h3>
                    </div>
                    <div class="card-body">

                        <form action="{{ route('admin.manage-user.store') }}" method="post" enctype="multipart/form-data" class="row g-3 needs-validation" novalidate>

                            <div class="col-md-6">
                                <label for="FirstName" class="form-label">نام</label>
                                <input type="text" name="FirstName" class="form-control" id="FirstName" required value="{{ old('FirstName') }}">
                                <div class="invalid-feedback">لطفا نام خود را وارد کنید</div>
                            </div>

                            <div class="col-md-6">
                                <label for="LastName" class="form-label">نام خانوادگی</label>
                                <input type="text" name="LastName" class="form-control" id="LastName" required value="{{ old('LastName') }}">
                                <div class="invalid-feedback">لطفا نام خانوادگی را وارد کنید</div>
                            </div>

                            <div class="col-md-6">
                                <label for="mobile" class="form-label">شماره تماس</label>
                                <input type="text" name="mobile" class="form-control" id="mobile" required value="{{ old('mobile') }}">
                                <div class="invalid-feedback">لطفا شماره تماس را وارد کنید</div>
                            </div>

                            <div class="col-md-6">
                                <label for="email" class="form-label">ایمیل</label>
                                <input type="text" name="email" class="form-control" id="email" required value="{{ old('email') }}">
                                <div class="invalid-feedback">لطفا ایمیل را وارد کنید</div>
                            </div>

                            <div class="col-md-6">
                                <label for="role" class="form-label">برند</label>
                                <select name="brand_id" class="form-control" onchange="role_show(this)">
                                    <option label="انتخاب کنید"></option>
                                    @foreach($brands as $brand)
                                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">لطفا برند را انتخاب کنید</div>
                            </div>

                            <div id="role" class="col-md-6">
                                <label for="role" class="form-label">نقش</label>
                                <select name="role" class="form-control roles" required>
                                    <option label="انتخاب کنید"></option>
{{--                                    @foreach($roles as $role)--}}
{{--                                        <option value="{{ $role->id }}">{{ $role->name }}</option>--}}
{{--                                    @endforeach--}}
                                </select>
                                <div class="invalid-feedback">لطفا نقش را انتخاب کنید</div>
                            </div>

                            <div class="col-md-6">
                                <label for="role" class="form-label">وضعیت</label>
                                <select name="role" class="form-control">
                                    <option label="انتخاب کنید"></option>
                                    <option value="1">تایید شده</option>
                                    <option value="0">در انتظار تایید</option>
                                    <option value="-1">مسدود شده</option>
                                </select>
                                <div class="invalid-feedback">لطفا وضعیت را انتخاب کنید</div>
                            </div>

                            <div class="col-md-6">
                                <label for="password" class="form-label">رمز عبور</label>
                                <input type="text" name="password" class="form-control" id="password" required value="{{ old('password') }}">
                                <div class="invalid-feedback">لطفا رمز عبور را وارد کنید</div>
                            </div>

                            <div class="col-md-6">
                                <label for="photo" class="form-label">تصویر پروفایل</label>
                                <input type="file" name="photo" class="form-control" aria-label="تصویر پروفایل" accept="image/*">
                                <div class="invalid-feedback">لطفا یک تصویر انتخاب کنید</div>
                            </div>

                            <div class="col-12">
                                <button class="btn btn-primary" type="submit">ارسال فرم</button>
                                @csrf
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- ROW CLOSED -->


    </div>
@endsection

@push('scripts')
    <script>
        let roles = '<?php echo $roles; ?>';
        const role_show = (selector) => {
            $('.roles').empty();
            let id = $(selector).find("option:selected").val();
            if (id == ''){
                id = null;
            }
            $.each(JSON.parse(roles), function (index, data){
                if (data['brand_id'] == id){
                    $('.roles').append('<option value="'+data['slug']+'">'+data['name']+'</option>')
                }
            });
        }
    </script>
@endpush
