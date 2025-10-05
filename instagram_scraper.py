#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
Instagram Scraper for Infinity Wear
أداة متقدمة لتنزيل الصور من حساب إنستغرام
"""

import os
import sys
import json
import time
import shutil
from pathlib import Path
from datetime import datetime

try:
    import instaloader
    INSTALOADER_AVAILABLE = True
except ImportError:
    INSTALOADER_AVAILABLE = False

class InstagramScraper:
    def __init__(self):
        self.base_dir = Path(__file__).parent
        self.portfolio_dir = self.base_dir / "images" / "portfolio"
        self.downloads_dir = self.base_dir / "images" / "instagram_downloads"
        self.backup_dir = self.base_dir / "backups"
        
        # إنشاء المجلدات
        self.create_directories()
        
        # إعدادات إنستغرام
        self.username = "infinityw.sa"
        self.session_file = self.base_dir / "instagram_session"
        
        # فئات الصور
        self.categories = {
            'football': ['كرة قدم', 'football', 'soccer', 'جيرسي', 'jersey', 'فريق'],
            'basketball': ['كرة سلة', 'basketball', 'سلة', 'basket'],
            'school': ['مدرسة', 'school', 'uniform', 'زي مدرسي', 'طلاب'],
            'corporate': ['شركة', 'corporate', 'company', 'عمل', 'موظف'],
            'medical': ['طبي', 'medical', 'مستشفى', 'عيادة', 'دكتور'],
            'sports': ['رياضي', 'sports', 'رياضة', 'نادي']
        }
    
    def create_directories(self):
        """إنشاء المجلدات المطلوبة"""
        directories = [self.portfolio_dir, self.downloads_dir, self.backup_dir]
        for directory in directories:
            directory.mkdir(parents=True, exist_ok=True)
            print(f"تم إنشاء المجلد: {directory}")
    
    def install_instaloader(self):
        """تثبيت مكتبة instaloader"""
        print("تثبيت مكتبة instaloader...")
        os.system("pip install instaloader")
        print("تم التثبيت بنجاح!")
    
    def download_from_instagram(self, username=None, max_posts=20):
        """تنزيل الصور من حساب إنستغرام"""
        if not INSTALOADER_AVAILABLE:
            print("مكتبة instaloader غير مثبتة. جاري التثبيت...")
            self.install_instaloader()
            return False
        
        if username is None:
            username = self.username
        
        try:
            # إنشاء مثيل من Instaloader
            L = instaloader.Instaloader(
                download_pictures=True,
                download_videos=False,
                download_video_thumbnails=False,
                download_geotags=False,
                download_comments=False,
                save_metadata=False,
                compress_json=False
            )
            
            # إعداد مجلد التنزيل
            download_folder = self.downloads_dir / username
            download_folder.mkdir(exist_ok=True)
            
            print(f"بدء تنزيل الصور من @{username}...")
            
            # تنزيل المنشورات
            profile = instaloader.Profile.from_username(L.context, username)
            
            downloaded_count = 0
            for post in profile.get_posts():
                if downloaded_count >= max_posts:
                    break
                
                try:
                    # تنزيل الصورة
                    L.download_post(post, target=download_folder)
                    downloaded_count += 1
                    print(f"تم تنزيل المنشور {downloaded_count}: {post.shortcode}")
                    
                    # تأخير لتجنب الحظر
                    time.sleep(2)
                    
                except Exception as e:
                    print(f"خطأ في تنزيل المنشور {post.shortcode}: {str(e)}")
                    continue
            
            print(f"تم تنزيل {downloaded_count} منشور بنجاح!")
            return download_folder
            
        except Exception as e:
            print(f"خطأ في تنزيل الصور من إنستغرام: {str(e)}")
            return None
    
    def process_downloaded_images(self, download_folder):
        """معالجة الصور المنزلة وإضافتها للمعرض"""
        if not download_folder or not download_folder.exists():
            print("مجلد التنزيل غير موجود!")
            return []
        
        processed_images = []
        
        # البحث عن الصور في المجلد
        image_extensions = ['.jpg', '.jpeg', '.png', '.webp']
        image_files = []
        
        for ext in image_extensions:
            image_files.extend(download_folder.glob(f"*{ext}"))
        
        print(f"تم العثور على {len(image_files)} صورة")
        
        for i, image_file in enumerate(image_files):
            try:
                # إنشاء اسم جديد للصورة
                new_name = f"instagram_{i+1:03d}_{int(time.time())}.jpg"
                
                # نسخ الصورة إلى مجلد المعرض
                target_path = self.portfolio_dir / new_name
                shutil.copy2(image_file, target_path)
                
                # تحديد فئة الصورة
                category = self.determine_category_from_image(image_file)
                
                # إنشاء معلومات الصورة
                image_info = {
                    'filename': new_name,
                    'category': category,
                    'title': self.generate_title(category),
                    'description': self.generate_description(category),
                    'original_name': image_file.name
                }
                
                processed_images.append(image_info)
                print(f"تم معالجة الصورة: {new_name}")
                
            except Exception as e:
                print(f"خطأ في معالجة الصورة {image_file.name}: {str(e)}")
                continue
        
        return processed_images
    
    def determine_category_from_image(self, image_path):
        """تحديد فئة الصورة من اسم الملف أو المحتوى"""
        filename = image_path.name.lower()
        
        for category, keywords in self.categories.items():
            for keyword in keywords:
                if keyword.lower() in filename:
                    return category
        
        # فئة افتراضية
        return 'sports'
    
    def generate_title(self, category):
        """إنشاء عنوان للصورة"""
        titles = {
            'football': 'تصميم فريق كرة قدم',
            'basketball': 'تصميم فريق كرة سلة',
            'school': 'زي مدرسي رياضي',
            'corporate': 'زي شركة',
            'medical': 'زي طبي',
            'sports': 'ملابس رياضية'
        }
        return titles.get(category, 'تصميم إنفينيتي وير')
    
    def generate_description(self, category):
        """إنشاء وصف للصورة"""
        descriptions = {
            'football': 'تصميم متكامل لفريق كرة قدم مع جيرسي وشورت وجوارب',
            'basketball': 'تصميم احترافي لفريق كرة سلة بألوان مميزة',
            'school': 'زي رياضي موحد للمدارس بتصميم عصري',
            'corporate': 'زي عمل احترافي للشركات والمؤسسات',
            'medical': 'زي طبي عالي الجودة للمستشفيات والعيادات',
            'sports': 'ملابس رياضية عالية الجودة من إنفينيتي وير'
        }
        return descriptions.get(category, 'تصميم مخصص من إنفينيتي وير')
    
    def update_portfolio_section(self, new_images):
        """تحديث قسم المعرض في ملف home.blade.php"""
        home_file = self.base_dir / "resources" / "views" / "home.blade.php"
        
        if not home_file.exists():
            print("ملف home.blade.php غير موجود!")
            return False
        
        # إنشاء نسخة احتياطية
        timestamp = datetime.now().strftime("%Y%m%d_%H%M%S")
        backup_file = self.backup_dir / f"home_backup_{timestamp}.blade.php"
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
        
        # البحث عن قسم المعرض وإضافة العناصر الجديدة
        portfolio_grid_pattern = r'(<div class="infinity-portfolio-grid">)'
        
        if re.search(portfolio_grid_pattern, content):
            # إضافة العناصر الجديدة قبل إغلاق div
            new_content = re.sub(
                r'(<div class="infinity-portfolio-grid">)(.*?)(</div>)',
                r'\1\2' + new_portfolio_content + r'\3',
                content,
                flags=re.DOTALL
            )
        else:
            print("لم يتم العثور على قسم المعرض في الملف!")
            return False
        
        # كتابة المحتوى المحدث
        with open(home_file, 'w', encoding='utf-8') as f:
            f.write(new_content)
        
        print("تم تحديث قسم المعرض بنجاح!")
        return True
    
    def get_portfolio_stats(self):
        """الحصول على إحصائيات المعرض"""
        images = list(self.portfolio_dir.glob('*.{jpg,jpeg,png,gif,webp}'))
        categories = {}
        total_size = 0
        
        for image in images:
            category = self.determine_category_from_image(image)
            categories[category] = categories.get(category, 0) + 1
            total_size += image.stat().st_size
        
        return {
            'total_images': len(images),
            'categories': categories,
            'total_size_mb': round(total_size / 1024 / 1024, 2)
        }
    
    def run(self, max_posts=20):
        """تشغيل العملية الكاملة"""
        print("=" * 60)
        print("أداة تنزيل صور إنستغرام المتقدمة - إنفينيتي وير")
        print("=" * 60)
        
        # عرض الإحصائيات الحالية
        stats = self.get_portfolio_stats()
        print(f"الصور الحالية: {stats['total_images']}")
        print(f"حجم الملفات: {stats['total_size_mb']} MB")
        print(f"الفئات: {list(stats['categories'].keys())}")
        print()
        
        # تنزيل الصور من إنستغرام
        print(f"بدء تنزيل الصور من @{self.username}...")
        download_folder = self.download_from_instagram(max_posts=max_posts)
        
        if download_folder:
            # معالجة الصور المنزلة
            print("معالجة الصور المنزلة...")
            processed_images = self.process_downloaded_images(download_folder)
            
            if processed_images:
                print(f"تم معالجة {len(processed_images)} صورة بنجاح!")
                
                # تحديث قسم المعرض
                print("تحديث قسم المعرض...")
                if self.update_portfolio_section(processed_images):
                    print("تم تحديث الموقع بنجاح!")
                else:
                    print("فشل في تحديث الموقع!")
            else:
                print("لم يتم معالجة أي صور!")
        else:
            print("فشل في تنزيل الصور من إنستغرام!")
        
        # عرض الإحصائيات النهائية
        print("\nالإحصائيات النهائية:")
        final_stats = self.get_portfolio_stats()
        print(f"إجمالي الصور: {final_stats['total_images']}")
        print(f"حجم الملفات: {final_stats['total_size_mb']} MB")
        print(f"الفئات: {final_stats['categories']}")

def main():
    """الدالة الرئيسية"""
    try:
        scraper = InstagramScraper()
        
        # يمكن تغيير عدد المنشورات المراد تنزيلها
        max_posts = 15  # تنزيل آخر 15 منشور
        
        scraper.run(max_posts=max_posts)
        
    except KeyboardInterrupt:
        print("\nتم إيقاف العملية بواسطة المستخدم")
    except Exception as e:
        print(f"حدث خطأ: {str(e)}")
        import traceback
        traceback.print_exc()

if __name__ == "__main__":
    main()
