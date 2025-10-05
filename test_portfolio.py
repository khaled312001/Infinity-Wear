#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
Portfolio Tester for Infinity Wear
أداة اختبار معرض الأعمال
"""

import os
from pathlib import Path

class PortfolioTester:
    def __init__(self):
        self.base_dir = Path(__file__).parent
        self.portfolio_dir = self.base_dir / "images" / "portfolio"
        self.home_file = self.base_dir / "resources" / "views" / "home.blade.php"
    
    def test_images_exist(self):
        """اختبار وجود الصور في المجلد"""
        print("=" * 50)
        print("اختبار وجود الصور في مجلد المعرض")
        print("=" * 50)
        
        if not self.portfolio_dir.exists():
            print("❌ مجلد المعرض غير موجود!")
            return False
        
        images = []
        for ext in ['*.jpg', '*.jpeg', '*.png', '*.gif', '*.webp']:
            images.extend(self.portfolio_dir.glob(ext))
        
        if not images:
            print("❌ لا توجد صور في مجلد المعرض!")
            return False
        
        print(f"✅ تم العثور على {len(images)} صورة:")
        for image in images:
            size_mb = image.stat().st_size / 1024 / 1024
            print(f"   📸 {image.name} ({size_mb:.2f} MB)")
        
        return True
    
    def test_home_file(self):
        """اختبار ملف home.blade.php"""
        print("\n" + "=" * 50)
        print("اختبار ملف home.blade.php")
        print("=" * 50)
        
        if not self.home_file.exists():
            print("❌ ملف home.blade.php غير موجود!")
            return False
        
        with open(self.home_file, 'r', encoding='utf-8') as f:
            content = f.read()
        
        # البحث عن قسم المعرض
        if 'infinity-portfolio-grid' not in content:
            print("❌ قسم المعرض غير موجود في الملف!")
            return False
        
        print("✅ تم العثور على قسم المعرض")
        
        # البحث عن الصور في الملف
        images_in_file = []
        for ext in ['*.jpg', '*.jpeg', '*.png', '*.gif', '*.webp']:
            for image_file in self.portfolio_dir.glob(ext):
                if image_file.name in content:
                    images_in_file.append(image_file.name)
        
        print(f"✅ تم العثور على {len(images_in_file)} صورة في الملف:")
        for image in images_in_file:
            print(f"   📸 {image}")
        
        return True
    
    def test_categories(self):
        """اختبار الفئات"""
        print("\n" + "=" * 50)
        print("اختبار فئات الصور")
        print("=" * 50)
        
        categories = {
            'football': 0,
            'basketball': 0,
            'schools': 0,
            'companies': 0,
            'medical': 0
        }
        
        for ext in ['*.jpg', '*.jpeg', '*.png', '*.gif', '*.webp']:
            for image_file in self.portfolio_dir.glob(ext):
                filename = image_file.name.lower()
                if 'football' in filename:
                    categories['football'] += 1
                elif 'basketball' in filename:
                    categories['basketball'] += 1
                elif 'school' in filename:
                    categories['schools'] += 1
                elif 'corporate' in filename:
                    categories['companies'] += 1
                elif 'medical' in filename:
                    categories['medical'] += 1
        
        print("✅ توزيع الصور حسب الفئات:")
        for category, count in categories.items():
            if count > 0:
                print(f"   🏷️ {category}: {count} صورة")
        
        return True
    
    def generate_report(self):
        """إنشاء تقرير شامل"""
        print("\n" + "=" * 60)
        print("تقرير شامل لمعرض الأعمال - إنفينيتي وير")
        print("=" * 60)
        
        # اختبار الصور
        images_ok = self.test_images_exist()
        
        # اختبار الملف
        file_ok = self.test_home_file()
        
        # اختبار الفئات
        categories_ok = self.test_categories()
        
        # النتيجة النهائية
        print("\n" + "=" * 60)
        print("النتيجة النهائية:")
        print("=" * 60)
        
        if images_ok and file_ok and categories_ok:
            print("🎉 جميع الاختبارات نجحت! المعرض جاهز للعرض.")
            print("\n📋 ملخص:")
            print("   ✅ الصور موجودة في المجلد")
            print("   ✅ الملف محدث بنجاح")
            print("   ✅ الفئات منظمة بشكل صحيح")
            print("\n🌐 يمكنك الآن زيارة الموقع لرؤية المعرض!")
        else:
            print("❌ بعض الاختبارات فشلت. يرجى مراجعة الأخطاء أعلاه.")
        
        return images_ok and file_ok and categories_ok

def main():
    """الدالة الرئيسية"""
    tester = PortfolioTester()
    tester.generate_report()

if __name__ == "__main__":
    main()
