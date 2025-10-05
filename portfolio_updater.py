#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
Portfolio Updater for Infinity Wear
أداة تحديث معرض الأعمال بالصور الجديدة
"""

import os
import sys
import json
import time
import shutil
import re
from pathlib import Path
from datetime import datetime

class PortfolioUpdater:
    def __init__(self):
        self.base_dir = Path(__file__).parent
        self.portfolio_dir = self.base_dir / "images" / "portfolio"
        self.backup_dir = self.base_dir / "backups"
        self.home_file = self.base_dir / "resources" / "views" / "home.blade.php"
        
        # إنشاء المجلدات
        self.create_directories()
        
        # صور تجريبية عالية الجودة
        self.sample_images = [
            {
                'url': 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=800&h=600&fit=crop&q=80',
                'filename': 'football_team_1.jpg',
                'category': 'football',
                'title': 'فريق كرة قدم الرياض',
                'description': 'تصميم متكامل لفريق كرة قدم مع جيرسي وشورت وجوارب'
            },
            {
                'url': 'https://images.unsplash.com/photo-1546519638-68e109498ffc?w=800&h=600&fit=crop&q=80',
                'filename': 'basketball_team_1.jpg',
                'category': 'basketball',
                'title': 'نادي كرة السلة الأهلي',
                'description': 'تصميم احترافي لفريق كرة سلة بألوان مميزة'
            },
            {
                'url': 'https://images.unsplash.com/photo-1581833971358-2c8b550f87b3?w=800&h=600&fit=crop&q=80',
                'filename': 'school_uniform_1.jpg',
                'category': 'schools',
                'title': 'مدرسة الرياض الدولية',
                'description': 'زي رياضي موحد للمدرسة بتصميم عصري'
            },
            {
                'url': 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=800&h=600&fit=crop&q=80',
                'filename': 'corporate_uniform_1.jpg',
                'category': 'companies',
                'title': 'شركة الاتصالات السعودية',
                'description': 'زي عمل احترافي لموظفي الشركة'
            },
            {
                'url': 'https://images.unsplash.com/photo-1559757148-5c350d0d3c56?w=800&h=600&fit=crop&q=80',
                'filename': 'medical_uniform_1.jpg',
                'category': 'medical',
                'title': 'مستشفى الملك فهد',
                'description': 'زي طبي عالي الجودة للمستشفيات والعيادات'
            },
            {
                'url': 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=800&h=600&fit=crop&q=80',
                'filename': 'football_team_2.jpg',
                'category': 'football',
                'title': 'أكاديمية كرة القدم',
                'description': 'زي تدريب لأكاديمية كرة قدم'
            },
            {
                'url': 'https://images.unsplash.com/photo-1546519638-68e109498ffc?w=800&h=600&fit=crop&q=80',
                'filename': 'basketball_team_2.jpg',
                'category': 'basketball',
                'title': 'فريق كرة السلة النسائي',
                'description': 'تصميم مخصص للفريق النسائي'
            },
            {
                'url': 'https://images.unsplash.com/photo-1581833971358-2c8b550f87b3?w=800&h=600&fit=crop&q=80',
                'filename': 'school_uniform_2.jpg',
                'category': 'schools',
                'title': 'جامعة الملك سعود',
                'description': 'زي رياضي لفرق الجامعة'
            }
        ]
    
    def create_directories(self):
        """إنشاء المجلدات المطلوبة"""
        directories = [self.portfolio_dir, self.backup_dir]
        for directory in directories:
            directory.mkdir(parents=True, exist_ok=True)
            print(f"تم إنشاء المجلد: {directory}")
    
    def download_image(self, url, filename):
        """تنزيل صورة من رابط"""
        try:
            import requests
            
            headers = {
                'User-Agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36'
            }
            
            response = requests.get(url, headers=headers, timeout=30)
            response.raise_for_status()
            
            # حفظ في مجلد المعرض الرئيسي
            filepath = self.portfolio_dir / filename
            with open(filepath, 'wb') as f:
                f.write(response.content)
            
            # نسخ إلى مجلد public للعرض على الموقع
            public_portfolio_dir = self.base_dir / "public" / "images" / "portfolio"
            public_portfolio_dir.mkdir(parents=True, exist_ok=True)
            public_filepath = public_portfolio_dir / filename
            shutil.copy2(filepath, public_filepath)
            
            print(f"تم تنزيل الصورة: {filename}")
            print(f"تم نسخ الصورة إلى public: {filename}")
            return True
            
        except Exception as e:
            print(f"خطأ في تنزيل الصورة {filename}: {str(e)}")
            return False
    
    def backup_home_file(self):
        """إنشاء نسخة احتياطية من ملف home.blade.php"""
        if not self.home_file.exists():
            print("ملف home.blade.php غير موجود!")
            return False
        
        timestamp = datetime.now().strftime("%Y%m%d_%H%M%S")
        backup_file = self.backup_dir / f"home_backup_{timestamp}.blade.php"
        shutil.copy2(self.home_file, backup_file)
        print(f"تم إنشاء نسخة احتياطية: {backup_file}")
        return True
    
    def update_portfolio_section(self):
        """تحديث قسم المعرض في ملف home.blade.php"""
        if not self.home_file.exists():
            print("ملف home.blade.php غير موجود!")
            return False
        
        # إنشاء نسخة احتياطية
        self.backup_home_file()
        
        # قراءة الملف الحالي
        with open(self.home_file, 'r', encoding='utf-8') as f:
            content = f.read()
        
        # إنشاء عناصر المعرض الجديدة
        portfolio_items = []
        for image in self.sample_images:
            item = f'''
                <div class="portfolio-item" data-category="{image['category']}">
                    <div class="portfolio-image">
                        <img src="{{{{ asset('images/portfolio/{image['filename']}') }}}}" alt="{image['title']}">
                        <div class="portfolio-overlay">
                            <div class="portfolio-content">
                                <h3>{image['title']}</h3>
                                <p>{image['description']}</p>
                                <a href="#" class="btn btn-primary">عرض المزيد</a>
                            </div>
                        </div>
                    </div>
                </div>'''
            portfolio_items.append(item)
        
        # إضافة العناصر الجديدة إلى المحتوى
        new_portfolio_content = '\n'.join(portfolio_items)
        
        # البحث عن قسم المعرض واستبداله
        pattern = r'(<div class="infinity-portfolio-grid">)(.*?)(</div>)'
        replacement = r'\1' + new_portfolio_content + r'\3'
        
        new_content = re.sub(pattern, replacement, content, flags=re.DOTALL)
        
        # كتابة المحتوى المحدث
        with open(self.home_file, 'w', encoding='utf-8') as f:
            f.write(new_content)
        
        print("تم تحديث قسم المعرض بنجاح!")
        return True
    
    def get_portfolio_stats(self):
        """الحصول على إحصائيات المعرض"""
        images = list(self.portfolio_dir.glob('*.{jpg,jpeg,png,gif,webp}'))
        categories = {}
        total_size = 0
        
        for image in images:
            # تحديد الفئة من اسم الملف
            filename = image.name.lower()
            if 'football' in filename:
                category = 'football'
            elif 'basketball' in filename:
                category = 'basketball'
            elif 'school' in filename:
                category = 'schools'
            elif 'corporate' in filename:
                category = 'companies'
            elif 'medical' in filename:
                category = 'medical'
            else:
                category = 'sports'
            
            categories[category] = categories.get(category, 0) + 1
            total_size += image.stat().st_size
        
        return {
            'total_images': len(images),
            'categories': categories,
            'total_size_mb': round(total_size / 1024 / 1024, 2)
        }
    
    def run(self):
        """تشغيل العملية الكاملة"""
        print("=" * 60)
        print("أداة تحديث معرض الأعمال - إنفينيتي وير")
        print("=" * 60)
        
        # عرض الإحصائيات الحالية
        stats = self.get_portfolio_stats()
        print(f"الصور الحالية: {stats['total_images']}")
        print(f"حجم الملفات: {stats['total_size_mb']} MB")
        print(f"الفئات: {list(stats['categories'].keys())}")
        print()
        
        # تنزيل الصور
        print("بدء تنزيل الصور...")
        downloaded_count = 0
        
        for image in self.sample_images:
            print(f"تنزيل: {image['filename']}")
            if self.download_image(image['url'], image['filename']):
                downloaded_count += 1
            time.sleep(1)  # تأخير بين التنزيلات
        
        print(f"تم تنزيل {downloaded_count} صورة بنجاح!")
        
        # تحديث قسم المعرض
        print("تحديث قسم المعرض...")
        if self.update_portfolio_section():
            print("تم تحديث الموقع بنجاح!")
        else:
            print("فشل في تحديث الموقع!")
        
        # عرض الإحصائيات النهائية
        print("\nالإحصائيات النهائية:")
        final_stats = self.get_portfolio_stats()
        print(f"إجمالي الصور: {final_stats['total_images']}")
        print(f"حجم الملفات: {final_stats['total_size_mb']} MB")
        print(f"الفئات: {final_stats['categories']}")
        
        print("\nتم الانتهاء! يمكنك الآن زيارة الموقع لرؤية الصور الجديدة في قسم 'أعمالنا السابقة'")

def main():
    """الدالة الرئيسية"""
    try:
        updater = PortfolioUpdater()
        updater.run()
    except KeyboardInterrupt:
        print("\nتم إيقاف العملية بواسطة المستخدم")
    except Exception as e:
        print(f"حدث خطأ: {str(e)}")
        import traceback
        traceback.print_exc()

if __name__ == "__main__":
    main()
