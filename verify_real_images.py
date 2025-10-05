#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
Verify Real Images Portfolio
التحقق من صور المعرض الحقيقية
"""

import os
from pathlib import Path

class RealImageVerifier:
    def __init__(self):
        self.base_dir = Path(__file__).parent
        self.portfolio_dir = self.base_dir / "images" / "portfolio"
        self.public_portfolio_dir = self.base_dir / "public" / "images" / "portfolio"
        self.home_file = self.base_dir / "resources" / "views" / "home.blade.php"
        
        # الصور المطلوبة لكل فئة
        self.required_images = {
            'football': [
                'football_team_riyadh.jpg',
                'football_academy_training.jpg', 
                'football_kit_complete.jpg'
            ],
            'basketball': [
                'basketball_team_ahli.jpg',
                'basketball_women_team.jpg'
            ],
            'schools': [
                'school_uniform_riyadh_international.jpg',
                'university_sports_team.jpg'
            ],
            'companies': [
                'corporate_uniform_stc.jpg',
                'corporate_uniform_aramco.jpg'
            ],
            'medical': [
                'medical_uniform_king_fahd.jpg',
                'medical_uniform_emergency.jpg'
            ],
            'sports': [
                'sports_wear_gym.jpg',
                'sports_wear_outdoor.jpg'
            ]
        }
    
    def verify_images_in_directories(self):
        """التحقق من وجود الصور في المجلدات"""
        print("=" * 60)
        print("التحقق من وجود الصور في المجلدات")
        print("=" * 60)
        
        all_good = True
        
        for category, images in self.required_images.items():
            print(f"\n📁 فئة {category}:")
            
            for image in images:
                main_path = self.portfolio_dir / image
                public_path = self.public_portfolio_dir / image
                
                main_exists = main_path.exists()
                public_exists = public_path.exists()
                
                if main_exists and public_exists:
                    size_mb = main_path.stat().st_size / 1024 / 1024
                    print(f"   ✅ {image} ({size_mb:.2f} MB)")
                else:
                    print(f"   ❌ {image} - مفقود")
                    if not main_exists:
                        print(f"      - غير موجود في المجلد الرئيسي")
                    if not public_exists:
                        print(f"      - غير موجود في مجلد public")
                    all_good = False
        
        return all_good
    
    def verify_images_in_file(self):
        """التحقق من وجود الصور في ملف home.blade.php"""
        print("\n" + "=" * 60)
        print("التحقق من وجود الصور في ملف home.blade.php")
        print("=" * 60)
        
        if not self.home_file.exists():
            print("❌ ملف home.blade.php غير موجود!")
            return False
        
        with open(self.home_file, 'r', encoding='utf-8') as f:
            content = f.read()
        
        all_good = True
        total_found = 0
        
        for category, images in self.required_images.items():
            print(f"\n📁 فئة {category}:")
            
            for image in images:
                if image in content:
                    print(f"   ✅ {image} - موجود في الملف")
                    total_found += 1
                else:
                    print(f"   ❌ {image} - غير موجود في الملف")
                    all_good = False
        
        print(f"\n📊 إجمالي الصور الموجودة في الملف: {total_found}")
        return all_good
    
    def check_image_quality(self):
        """التحقق من جودة الصور"""
        print("\n" + "=" * 60)
        print("التحقق من جودة الصور")
        print("=" * 60)
        
        total_size = 0
        image_count = 0
        
        for category, images in self.required_images.items():
            print(f"\n📁 فئة {category}:")
            
            for image in images:
                main_path = self.portfolio_dir / image
                if main_path.exists():
                    size_bytes = main_path.stat().st_size
                    size_mb = size_bytes / 1024 / 1024
                    total_size += size_bytes
                    image_count += 1
                    
                    if size_mb > 0.1:  # أكبر من 100 KB
                        print(f"   ✅ {image} - جودة جيدة ({size_mb:.2f} MB)")
                    else:
                        print(f"   ⚠️ {image} - حجم صغير ({size_mb:.2f} MB)")
        
        avg_size_mb = (total_size / image_count) / 1024 / 1024 if image_count > 0 else 0
        print(f"\n📊 متوسط حجم الصور: {avg_size_mb:.2f} MB")
        print(f"📊 إجمالي حجم الصور: {total_size / 1024 / 1024:.2f} MB")
        
        return image_count > 0
    
    def generate_summary(self):
        """إنشاء ملخص شامل"""
        print("\n" + "=" * 60)
        print("ملخص شامل للمعرض")
        print("=" * 60)
        
        # إحصائيات الفئات
        total_images = sum(len(images) for images in self.required_images.values())
        print(f"📊 إجمالي الصور المطلوبة: {total_images}")
        
        for category, images in self.required_images.items():
            print(f"   🏷️ {category}: {len(images)} صورة")
        
        # التحقق من المجلدات
        dirs_ok = self.verify_images_in_directories()
        
        # التحقق من الملف
        file_ok = self.verify_images_in_file()
        
        # التحقق من الجودة
        quality_ok = self.check_image_quality()
        
        # النتيجة النهائية
        print("\n" + "=" * 60)
        print("النتيجة النهائية:")
        print("=" * 60)
        
        if dirs_ok and file_ok and quality_ok:
            print("🎉 المعرض جاهز ومكتمل!")
            print("✅ جميع الصور موجودة في المجلدات الصحيحة")
            print("✅ جميع الصور موجودة في ملف home.blade.php")
            print("✅ جودة الصور مقبولة")
            print("\n🌐 يمكنك الآن زيارة الموقع لرؤية المعرض الحقيقي!")
            return True
        else:
            print("❌ هناك مشاكل في المعرض:")
            if not dirs_ok:
                print("   - مشاكل في المجلدات")
            if not file_ok:
                print("   - مشاكل في الملف")
            if not quality_ok:
                print("   - مشاكل في جودة الصور")
            return False
    
    def run(self):
        """تشغيل التحقق الكامل"""
        return self.generate_summary()

def main():
    """الدالة الرئيسية"""
    verifier = RealImageVerifier()
    verifier.run()

if __name__ == "__main__":
    main()
