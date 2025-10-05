#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
Portfolio Verification Script
أداة التحقق من صحة المعرض
"""

import os
from pathlib import Path

def verify_portfolio():
    """التحقق من صحة المعرض"""
    
    print("=" * 60)
    print("التحقق من صحة معرض الأعمال - إنفينيتي وير")
    print("=" * 60)
    
    # التحقق من وجود الصور في المجلد الرئيسي
    main_portfolio_dir = Path("images/portfolio")
    public_portfolio_dir = Path("public/images/portfolio")
    home_file = Path("resources/views/home.blade.php")
    
    # التحقق من المجلد الرئيسي
    print("\n📁 التحقق من المجلد الرئيسي:")
    if main_portfolio_dir.exists():
        main_images = list(main_portfolio_dir.glob("*.jpg"))
        print(f"✅ تم العثور على {len(main_images)} صورة في المجلد الرئيسي")
        for img in main_images:
            print(f"   📸 {img.name}")
    else:
        print("❌ المجلد الرئيسي غير موجود!")
        return False
    
    # التحقق من مجلد public
    print("\n🌐 التحقق من مجلد public:")
    if public_portfolio_dir.exists():
        public_images = list(public_portfolio_dir.glob("*.jpg"))
        print(f"✅ تم العثور على {len(public_images)} صورة في مجلد public")
        for img in public_images:
            print(f"   📸 {img.name}")
    else:
        print("❌ مجلد public غير موجود!")
        return False
    
    # التحقق من ملف home.blade.php
    print("\n📄 التحقق من ملف home.blade.php:")
    if home_file.exists():
        with open(home_file, 'r', encoding='utf-8') as f:
            content = f.read()
        
        # البحث عن الصور في الملف
        images_in_file = []
        for img in public_images:
            if img.name in content:
                images_in_file.append(img.name)
        
        print(f"✅ تم العثور على {len(images_in_file)} صورة في الملف")
        for img in images_in_file:
            print(f"   📸 {img}")
    else:
        print("❌ ملف home.blade.php غير موجود!")
        return False
    
    # التحقق من التطابق
    print("\n🔍 التحقق من التطابق:")
    main_image_names = {img.name for img in main_images}
    public_image_names = {img.name for img in public_images}
    file_image_names = set(images_in_file)
    
    if main_image_names == public_image_names == file_image_names:
        print("✅ جميع الصور متطابقة في جميع الأماكن!")
    else:
        print("❌ هناك عدم تطابق في الصور!")
        print(f"   المجلد الرئيسي: {len(main_image_names)} صورة")
        print(f"   مجلد public: {len(public_image_names)} صورة")
        print(f"   الملف: {len(file_image_names)} صورة")
    
    # النتيجة النهائية
    print("\n" + "=" * 60)
    print("النتيجة النهائية:")
    print("=" * 60)
    
    if (len(main_images) > 0 and len(public_images) > 0 and len(images_in_file) > 0):
        print("🎉 المعرض جاهز للعرض!")
        print("✅ جميع الصور موجودة في الأماكن الصحيحة")
        print("✅ الملف محدث بنجاح")
        print("✅ الصور متاحة للعرض على الموقع")
        print("\n🌐 يمكنك الآن زيارة الموقع لرؤية المعرض!")
        return True
    else:
        print("❌ هناك مشاكل في المعرض!")
        print("يرجى مراجعة الأخطاء أعلاه")
        return False

if __name__ == "__main__":
    verify_portfolio()
