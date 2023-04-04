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
                        <h3 class="card-title">ویرایش نقش</h3>
                    </div>
                    <div class="card-body">

                        <form method="post" action="{{ route('admin.role-permission.update',$role_permission->id) }}" enctype="multipart/form-data" class="row g-3 needs-validation" novalidate>

                            @method("PUT")

                            <div class="col-md-6">
                                <label for="role" class="form-label">نام نقش</label>
                                <input type="text" name="role" class="form-control" id="role" required value="{{ old('role',$role_permission->name) }}">
                                <div class="invalid-feedback">لطفا نام نقش را وارد کنید</div>
                            </div>
                            <div class="col-md-6">
                                <label for="role" class="form-label">برند</label>
                                <select name="brand_id" class="form-control">
                                    <option value>انتخاب برند</option>
                                    @foreach($brands as $brand)
                                        <option value="{{ $brand->id }}" @if($role_permission->brand_id == $brand->id) selected @endif>{{ $brand->name }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">لطفا برند را انتخاب کنید</div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">دسترسی ها</label>
                                <select multiple class="form-control select2 form-select" data-placeholder="دسترسی ها" name="permission[]">
                                    <option @if(in_array('RolePermission', $permissions)) selected @endif value="RolePermission">نقش ها و دسترسی ها</option>
                                    <option @if(in_array('users', $permissions)) selected @endif value="users">مدیریت کاربران</option>
                                    <option @if(in_array('slider', $permissions)) selected @endif value="slider">اسلایدر</option>
                                    <option @if(in_array('products', $permissions)) selected @endif value="products">محصولات</option>
                                    <option @if(in_array('blogs', $permissions)) selected @endif value="blogs">مقالات</option>
                                    <option @if(in_array('news', $permissions)) selected @endif value="news">اخبار</option>
                                    <option @if(in_array('LandingPage', $permissions)) selected @endif value="LandingPage">صفحات لندینگ</option>
                                    <option @if(in_array('Solution', $permissions)) selected @endif value="Solution">راه حل ها</option>
                                    <option @if(in_array('KnowledgeBase', $permissions)) selected @endif value="KnowledgeBase">پایگاه دانش</option>
                                    <option @if(in_array('page', $permissions)) selected @endif value="page">مدیریت صفحات</option>
                                    <option @if(in_array('banner', $permissions)) selected @endif value="banner">بنر ها</option>
                                    <option @if(in_array('job', $permissions)) selected @endif value="job">فرصت های شغلی</option>
                                    <option @if(in_array('newsletters', $permissions)) selected @endif value="newsletters">خبرنامه</option>
                                    <option @if(in_array('contacts', $permissions)) selected @endif value="contacts">تماس با ما</option>
                                    <option @if(in_array('socials', $permissions)) selected @endif value="socials">شبکه های اجتماعی</option>
                                    <option @if(in_array('comments', $permissions)) selected @endif value="comments">دیدگاه کاربران</option>
                                    <option @if(in_array('setting', $permissions)) selected @endif value="setting">تنظیمات</option>
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
