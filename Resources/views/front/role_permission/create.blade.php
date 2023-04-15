@extends('layouts.admin')

@section('content')
    <!-- CONTAINER -->
    <div class="main-container container-fluid">

    @include('account::front.role_permission.partial.header')

        <!-- ROW -->
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-header border-bottom">
                        <h3 class="card-title">افزودن نقش</h3>
                    </div>
                    <div class="card-body">

                        <form action="{{ route('admin.role-permission.store') }}" method="post" enctype="multipart/form-data" class="row g-3 needs-validation" novalidate>

                            <div class="col-md-6">
                                <label for="role" class="form-label">نام نقش</label>
                                <input type="text" name="role" class="form-control" id="role" required value="{{ old('role') }}">
                                <div class="invalid-feedback">لطفا نام نقش را وارد کنید</div>
                            </div>
                            <div class="col-md-6">
                                <label for="role" class="form-label">برند</label>
                                <select name="brand_id" class="form-control">
                                    <option value>انتخاب برند</option>
                                    @foreach($brands as $brand)
                                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">لطفا برند را انتخاب کنید</div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">دسترسی ها</label>
                                <select multiple class="form-control select2 form-select" data-placeholder="دسترسی ها" name="permission[]">
                                    <option value="RolePermission">نقش ها و دسترسی ها</option>
                                    <option value="users">مدیریت کاربران</option>
                                    <option value="slider">اسلایدر</option>
                                    <option value="products">محصولات</option>
                                    <option value="OtherProduct">سایر محصولات</option>
                                    <option value="service">خدمات</option>
                                    <option value="blogs">مقالات</option>
                                    <option value="news">اخبار</option>
                                    <option value="gallery">گالری</option>
                                    <option value="webinar">وبینار</option>
                                    <option value="LandingPage">صفحات لندینگ</option>
                                    <option value="Solution">راه حل ها</option>
                                    <option value="KnowledgeBase">پایگاه دانش</option>
                                    <option value="page">مدیریت صفحات</option>
                                    <option value="banner">بنر ها</option>
                                    <option value="job">فرصت های شغلی</option>
                                    <option value="newsletters">خبرنامه</option>
                                    <option value="contacts">تماس با ما</option>
                                    <option value="socials">شبکه های اجتماعی</option>
                                    <option value="tickets">تیکت ها</option>
                                    <option value="comments">دیدگاه کاربران</option>
                                    <option value="setting">تنظیمات</option>
                                </select>
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
