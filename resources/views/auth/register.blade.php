@extends('layouts.app')

@section('title', 'إنشاء حساب جديد - Infinity Wear')
@section('description', 'أنشئ حسابك الجديد في إنفينيتي وير للوصول إلى جميع الخدمات والمميزات')

@section('styles')
<link href="{{ asset('css/infinity-home.css') }}" rel="stylesheet">
@endsection
@section('content')
    <!-- Registration Section -->
    <section class="infinity-contact" style="min-height: 100vh; padding: 8rem 0;">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">إنشاء حساب جديد</h2>
                <p class="section-subtitle">انضم إلى عائلة إنفينيتي وير وابدأ رحلتك معنا</p>
            </div>

            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6">
                    <div class="infinity-contact-form-container">
                        <form class="infinity-contact-form" method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="form-group">
                                <label for="name">الاسم الكامل *</label>
                                <input type="text" id="name" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                @error('name')
                                    <span class="field-error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="email">البريد الإلكتروني *</label>
                                <input type="email" id="email" name="email" value="{{ old('email') }}" required autocomplete="email">
                                @error('email')
                                    <span class="field-error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="phone">رقم الهاتف *</label>
                                <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" required autocomplete="tel">
                                @error('phone')
                                    <span class="field-error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="password">كلمة المرور *</label>
                                    <input type="password" id="password" name="password" required autocomplete="new-password">
                                    @error('password')
                                        <span class="field-error">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="password_confirmation">تأكيد كلمة المرور *</label>
                                    <input type="password" id="password_confirmation" name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="city">المدينة</label>
                                    <input type="text" id="city" name="city" value="{{ old('city') }}" autocomplete="address-level2">
                                    @error('city')
                                        <span class="field-error">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="address">العنوان</label>
                                    <input type="text" id="address" name="address" value="{{ old('address') }}" autocomplete="street-address">
                                    @error('address')
                                        <span class="field-error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="checkbox-label">
                                    <input type="checkbox" id="terms" required>
                                    <span class="checkmark"></span>
                                    أوافق على <a href="#" class="text-primary">الشروط والأحكام</a>
                                </label>
                            </div>

                            <button type="submit" class="btn btn-primary btn-large">
                                <i class="fas fa-user-plus"></i>
                                إنشاء الحساب
                            </button>

                            <div class="text-center mt-3">
                                <p>لديك حساب بالفعل؟ 
                                    <a href="{{ route('login') }}" class="text-primary">تسجيل الدخول</a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('scripts')
<script src="{{ asset('js/infinity-home.js') }}"></script>
@endsection
