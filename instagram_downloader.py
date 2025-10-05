#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
Instagram Images Downloader for Infinity Wear
تنزيل صور إنستغرام وإضافتها لمعرض الأعمال
"""

import os
import sys
import requests
import json
import time
import re
from urllib.parse import urlparse
from pathlib import Path
import shutil

class InstagramDownloader:
    def __init__(self):
        self.base_dir = Path(__file__).parent
        self.portfolio_dir = self.base_dir / "images" / "portfolio"
        self.downloads_dir = self.base_dir / "images" / "instagram_downloads"
        self.backup_dir = self.base_dir / "backups"
        
        # إنشاء المجلدات المطلوبة
        self.create_directories()
        
        # قائمة بصور إنستغرام للتنزيل (يمكن إضافة المزيد)
        self.instagram_images = [
            # إضافة روابط الصور هنا
            # مثال: "https://example.com/instagram_image_1.jpg"
        ]
        
        # فئات الصور
        self.categories = {
            'football': ['كرة قدم', 'football', 'soccer', 'جيرسي', 'jersey'],
            'basketball': ['كرة سلة', 'basketball', 'سلة'],
            'school': ['مدرسة', 'school', 'uniform', 'زي مدرسي'],
            'corporate': ['شركة', 'corporate', 'company', 'عمل'],
            'medical': ['طبي', 'medical', 'مستشفى', 'عيادة'],
            'sports': ['رياضي', 'sports', 'رياضة']
        }
    
    def create_directories(self):
        """إنشاء المجلدات المطلوبة"""
        directories = [self.portfolio_dir, self.downloads_dir, self.backup_dir]
        for directory in directories:
            directory.mkdir(parents=True, exist_ok=True)
            print(f"تم إنشاء المجلد: {directory}")
    
    def download_image(self, url, filename):
        """تنزيل صورة من رابط"""
        try:
            headers = {
                'User-Agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36'
            }
            
            response = requests.get(url, headers=headers, timeout=30)
            response.raise_for_status()
            
            filepath = self.downloads_dir / filename
            with open(filepath, 'wb') as f:
                f.write(response.content)
            
            print(f"تم تنزيل الصورة: {filename}")
            return filepath
            
        except Exception as e:
            print(f"خطأ في تنزيل الصورة {filename}: {str(e)}")
            return None
    
    def determine_category(self, filename):
        """تحديد فئة الصورة من اسم الملف"""
        filename_lower = filename.lower()
        
        for category, keywords in self.categories.items():
            for keyword in keywords:
                if keyword.lower() in filename_lower:
                    return category
        
        return 'sports'  # فئة افتراضية
    
    def generate_title(self, filename):
        """إنشاء عنوان للصورة"""
        category = self.determine_category(filename)
        
        titles = {
            'football': 'تصميم فريق كرة قدم',
            'basketball': 'تصميم فريق كرة سلة',
            'school': 'زي مدرسي رياضي',
            'corporate': 'زي شركة',
            'medical': 'زي طبي',
            'sports': 'ملابس رياضية'
        }
        
        return titles.get(category, 'تصميم إنفينيتي وير')
    
    def generate_description(self, filename):
        """إنشاء وصف للصورة"""
        category = self.determine_category(filename)
        
        descriptions = {
            'football': 'تصميم متكامل لفريق كرة قدم مع جيرسي وشورت وجوارب',
            'basketball': 'تصميم احترافي لفريق كرة سلة بألوان مميزة',
            'school': 'زي رياضي موحد للمدارس بتصميم عصري',
            'corporate': 'زي عمل احترافي للشركات والمؤسسات',
            'medical': 'زي طبي عالي الجودة للمستشفيات والعيادات',
            'sports': 'ملابس رياضية عالية الجودة من إنفينيتي وير'
        }
        
        return descriptions.get(category, 'تصميم مخصص من إنفينيتي وير')
    
    def copy_to_portfolio(self, source_path, new_name):
        """نسخ الصورة إلى مجلد المعرض"""
        try:
            target_path = self.portfolio_dir / new_name
            shutil.copy2(source_path, target_path)
            print(f"تم نسخ الصورة إلى المعرض: {new_name}")
            return True
        except Exception as e:
            print(f"خطأ في نسخ الصورة: {str(e)}")
            return False
    
    def download_sample_images(self):
        """تنزيل صور تجريبية (يمكن استبدالها بصور حقيقية من إنستغرام)"""
        sample_images = [
            {
                'url': 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=800&h=600&fit=crop',
                'filename': 'football_team_sample_1.jpg',
                'category': 'football'
            },
            {
                'url': 'https://images.unsplash.com/photo-1546519638-68e109498ffc?w=800&h=600&fit=crop',
                'filename': 'basketball_team_sample_1.jpg',
                'category': 'basketball'
            },
            {
                'url': 'https://images.unsplash.com/photo-1581833971358-2c8b550f87b3?w=800&h=600&fit=crop',
                'filename': 'school_uniform_sample_1.jpg',
                'category': 'school'
            },
            {
                'url': 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=800&h=600&fit=crop',
                'filename': 'corporate_uniform_sample_1.jpg',
                'category': 'corporate'
            },
            {
                'url': 'https://images.unsplash.com/photo-1559757148-5c350d0d3c56?w=800&h=600&fit=crop',
                'filename': 'medical_uniform_sample_1.jpg',
                'category': 'medical'
            }
        ]
        
        downloaded_images = []
        
        for image_info in sample_images:
            print(f"تنزيل: {image_info['filename']}")
            filepath = self.download_image(image_info['url'], image_info['filename'])
            
            if filepath:
                # نسخ إلى المعرض
                portfolio_name = f"instagram_{image_info['filename']}"
                if self.copy_to_portfolio(filepath, portfolio_name):
                    downloaded_images.append({
                        'filename': portfolio_name,
                        'category': image_info['category'],
                        'title': self.generate_title(portfolio_name),
                        'description': self.generate_description(portfolio_name)
                    })
            
            time.sleep(1)  # تأخير بين التنزيلات
        
        return downloaded_images
    
    def update_portfolio_section(self, new_images):
        """تحديث قسم المعرض في ملف home.blade.php"""
        home_file = self.base_dir / "resources" / "views" / "home.blade.php"
        
        if not home_file.exists():
            print("ملف home.blade.php غير موجود!")
            return False
        
        # إنشاء نسخة احتياطية
        backup_file = self.backup_dir / f"home_backup_{int(time.time())}.blade.php"
        shutil.copy2(home_file, backup_file)
        print(f"تم إنشاء نسخة احتياطية: {backup_file}")
        
        # قراءة الملف الحالي
        with open(home_file, 'r', encoding='utf-8') as f:
            content = f.read()
        
        # إنشاء عناصر المعرض الجديدة
        portfolio_items = []
        for image in new_images:
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
        with open(home_file, 'w', encoding='utf-8') as f:
            f.write(new_content)
        
        print("تم تحديث قسم المعرض بنجاح!")
        return True
    
    def get_portfolio_stats(self):
        """الحصول على إحصائيات المعرض"""
        images = list(self.portfolio_dir.glob('*.{jpg,jpeg,png,gif}'))
        categories = {}
        total_size = 0
        
        for image in images:
            category = self.determine_category(image.name)
            categories[category] = categories.get(category, 0) + 1
            total_size += image.stat().st_size
        
        return {
            'total_images': len(images),
            'categories': categories,
            'total_size_mb': round(total_size / 1024 / 1024, 2)
        }
    
    def run(self):
        """تشغيل العملية الكاملة"""
        print("=" * 50)
        print("أداة تنزيل صور إنستغرام - إنفينيتي وير")
        print("=" * 50)
        
        # عرض الإحصائيات الحالية
        stats = self.get_portfolio_stats()
        print(f"الصور الحالية: {stats['total_images']}")
        print(f"حجم الملفات: {stats['total_size_mb']} MB")
        print(f"الفئات: {list(stats['categories'].keys())}")
        print()
        
        # تنزيل الصور
        print("بدء تنزيل الصور...")
        downloaded_images = self.download_sample_images()
        
        if downloaded_images:
            print(f"تم تنزيل {len(downloaded_images)} صورة بنجاح!")
            
            # تحديث قسم المعرض
            print("تحديث قسم المعرض...")
            if self.update_portfolio_section(downloaded_images):
                print("تم تحديث الموقع بنجاح!")
            else:
                print("فشل في تحديث الموقع!")
        else:
            print("لم يتم تنزيل أي صور!")
        
        # عرض الإحصائيات النهائية
        print("\nالإحصائيات النهائية:")
        final_stats = self.get_portfolio_stats()
        print(f"إجمالي الصور: {final_stats['total_images']}")
        print(f"حجم الملفات: {final_stats['total_size_mb']} MB")
        print(f"الفئات: {final_stats['categories']}")

def main():
    """الدالة الرئيسية"""
    try:
        downloader = InstagramDownloader()
        downloader.run()
    except KeyboardInterrupt:
        print("\nتم إيقاف العملية بواسطة المستخدم")
    except Exception as e:
        print(f"حدث خطأ: {str(e)}")

if __name__ == "__main__":
    main()
