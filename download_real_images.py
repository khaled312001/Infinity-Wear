#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
Download Real Images for Portfolio
تنزيل صور حقيقية ومخصصة لكل عمل
"""

import os
import requests
import shutil
from pathlib import Path
from datetime import datetime

class RealImageDownloader:
    def __init__(self):
        self.base_dir = Path(__file__).parent
        self.portfolio_dir = self.base_dir / "images" / "portfolio"
        self.public_portfolio_dir = self.base_dir / "public" / "images" / "portfolio"
        
        # إنشاء المجلدات
        self.portfolio_dir.mkdir(parents=True, exist_ok=True)
        self.public_portfolio_dir.mkdir(parents=True, exist_ok=True)
        
        # صور حقيقية ومخصصة لكل عمل
        self.real_images = {
            'football': [
                {
                    'url': 'https://images.unsplash.com/photo-1574629810360-7efbbe195018?w=800&h=600&fit=crop&q=80',
                    'filename': 'football_team_riyadh.jpg',
                    'title': 'فريق كرة قدم الرياض',
                    'description': 'تصميم متكامل لفريق كرة قدم محلي مع جيرسي وشورت وجوارب بألوان مميزة'
                },
                {
                    'url': 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=800&h=600&fit=crop&q=80',
                    'filename': 'football_academy_training.jpg',
                    'title': 'أكاديمية كرة القدم',
                    'description': 'زي تدريب احترافي لأكاديمية كرة قدم مع شعار مخصص'
                },
                {
                    'url': 'https://images.unsplash.com/photo-1551698618-1dfe5d97d256?w=800&h=600&fit=crop&q=80',
                    'filename': 'football_kit_complete.jpg',
                    'title': 'طقم كرة قدم كامل',
                    'description': 'طقم متكامل يشمل الجيرسي والشورت والجوارب والقفازات'
                }
            ],
            'basketball': [
                {
                    'url': 'https://images.unsplash.com/photo-1546519638-68e109498ffc?w=800&h=600&fit=crop&q=80',
                    'filename': 'basketball_team_ahli.jpg',
                    'title': 'نادي كرة السلة الأهلي',
                    'description': 'تصميم احترافي لفريق كرة سلة محترف بألوان النادي المميزة'
                },
                {
                    'url': 'https://images.unsplash.com/photo-1519861531473-9200262188bf?w=800&h=600&fit=crop&q=80',
                    'filename': 'basketball_women_team.jpg',
                    'title': 'فريق كرة السلة النسائي',
                    'description': 'تصميم مخصص للفريق النسائي بألوان أنيقة ومناسبة'
                }
            ],
            'schools': [
                {
                    'url': 'https://images.unsplash.com/photo-1581833971358-2c8b550f87b3?w=800&h=600&fit=crop&q=80',
                    'filename': 'school_uniform_riyadh_international.jpg',
                    'title': 'مدرسة الرياض الدولية',
                    'description': 'زي رياضي موحد للمدرسة بتصميم عصري وألوان مناسبة للطلاب'
                },
                {
                    'url': 'https://images.unsplash.com/photo-1503676260728-1c00da094a0b?w=800&h=600&fit=crop&q=80',
                    'filename': 'university_sports_team.jpg',
                    'title': 'جامعة الملك سعود',
                    'description': 'زي رياضي لفرق الجامعة مع شعار الجامعة وألوانها الرسمية'
                }
            ],
            'companies': [
                {
                    'url': 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=800&h=600&fit=crop&q=80',
                    'filename': 'corporate_uniform_stc.jpg',
                    'title': 'شركة الاتصالات السعودية',
                    'description': 'زي عمل احترافي لموظفي الشركة مع شعار الشركة وألوانها الرسمية'
                },
                {
                    'url': 'https://images.unsplash.com/photo-1560472354-b33ff0c44a43?w=800&h=600&fit=crop&q=80',
                    'filename': 'corporate_uniform_aramco.jpg',
                    'title': 'شركة أرامكو السعودية',
                    'description': 'زي عمل متخصص لموظفي الشركة مع معايير السلامة والأمان'
                }
            ],
            'medical': [
                {
                    'url': 'https://images.unsplash.com/photo-1559757148-5c350d0d3c56?w=800&h=600&fit=crop&q=80',
                    'filename': 'medical_uniform_king_fahd.jpg',
                    'title': 'مستشفى الملك فهد',
                    'description': 'زي طبي عالي الجودة للمستشفيات والعيادات مع معايير النظافة'
                },
                {
                    'url': 'https://images.unsplash.com/photo-1612349317150-e413f6a5b16d?w=800&h=600&fit=crop&q=80',
                    'filename': 'medical_uniform_emergency.jpg',
                    'title': 'زي طوارئ طبي',
                    'description': 'زي متخصص لطاقم الطوارئ مع مواد مقاومة للبقع والجراثيم'
                }
            ],
            'sports': [
                {
                    'url': 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=800&h=600&fit=crop&q=80',
                    'filename': 'sports_wear_gym.jpg',
                    'title': 'ملابس رياضية للجيم',
                    'description': 'ملابس رياضية عالية الجودة للتمارين الرياضية والنوادي'
                },
                {
                    'url': 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=800&h=600&fit=crop&q=80',
                    'filename': 'sports_wear_outdoor.jpg',
                    'title': 'ملابس رياضية خارجية',
                    'description': 'ملابس رياضية مناسبة للأنشطة الخارجية مع مواد مقاومة للعوامل الجوية'
                }
            ]
        }
    
    def download_image(self, url, filename):
        """تنزيل صورة من رابط"""
        try:
            headers = {
                'User-Agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36'
            }
            
            response = requests.get(url, headers=headers, timeout=30)
            response.raise_for_status()
            
            # حفظ في المجلد الرئيسي
            filepath = self.portfolio_dir / filename
            with open(filepath, 'wb') as f:
                f.write(response.content)
            
            # نسخ إلى مجلد public
            public_filepath = self.public_portfolio_dir / filename
            shutil.copy2(filepath, public_filepath)
            
            print(f"✅ تم تنزيل: {filename}")
            return True
            
        except Exception as e:
            print(f"❌ خطأ في تنزيل {filename}: {str(e)}")
            return False
    
    def download_all_images(self):
        """تنزيل جميع الصور"""
        print("=" * 60)
        print("تنزيل صور حقيقية ومخصصة لكل عمل")
        print("=" * 60)
        
        total_downloaded = 0
        
        for category, images in self.real_images.items():
            print(f"\n📁 تنزيل صور {category}:")
            
            for image_info in images:
                print(f"   تنزيل: {image_info['title']}")
                if self.download_image(image_info['url'], image_info['filename']):
                    total_downloaded += 1
                
                # تأخير بين التنزيلات
                import time
                time.sleep(1)
        
        print(f"\n🎉 تم تنزيل {total_downloaded} صورة بنجاح!")
        return total_downloaded
    
    def generate_portfolio_html(self):
        """إنشاء HTML للمعرض"""
        portfolio_items = []
        
        for category, images in self.real_images.items():
            for image_info in images:
                item = f'''
                <div class="portfolio-item" data-category="{category}">
                    <div class="portfolio-image">
                        <img src="{{{{ asset('images/portfolio/{image_info['filename']}') }}}}" alt="{image_info['title']}">
                        <div class="portfolio-overlay">
                            <div class="portfolio-content">
                                <h3>{image_info['title']}</h3>
                                <p>{image_info['description']}</p>
                                <a href="#" class="btn btn-primary">عرض المزيد</a>
                            </div>
                        </div>
                    </div>
                </div>'''
                portfolio_items.append(item)
        
        return '\n'.join(portfolio_items)
    
    def update_home_file(self):
        """تحديث ملف home.blade.php"""
        home_file = self.base_dir / "resources" / "views" / "home.blade.php"
        
        if not home_file.exists():
            print("❌ ملف home.blade.php غير موجود!")
            return False
        
        # إنشاء نسخة احتياطية
        backup_file = self.base_dir / "backups" / f"home_backup_{datetime.now().strftime('%Y%m%d_%H%M%S')}.blade.php"
        backup_file.parent.mkdir(exist_ok=True)
        shutil.copy2(home_file, backup_file)
        print(f"✅ تم إنشاء نسخة احتياطية: {backup_file}")
        
        # قراءة الملف
        with open(home_file, 'r', encoding='utf-8') as f:
            content = f.read()
        
        # إنشاء المحتوى الجديد
        new_portfolio_content = self.generate_portfolio_html()
        
        # استبدال قسم المعرض
        import re
        pattern = r'(<div class="infinity-portfolio-grid">)(.*?)(</div>)'
        replacement = r'\1' + new_portfolio_content + r'\3'
        
        new_content = re.sub(pattern, replacement, content, flags=re.DOTALL)
        
        # كتابة الملف المحدث
        with open(home_file, 'w', encoding='utf-8') as f:
            f.write(new_content)
        
        print("✅ تم تحديث ملف home.blade.php بنجاح!")
        return True
    
    def verify_images(self):
        """التحقق من الصور"""
        print("\n" + "=" * 60)
        print("التحقق من الصور المنزلة")
        print("=" * 60)
        
        total_images = 0
        for category, images in self.real_images.items():
            print(f"\n📁 {category}:")
            for image_info in images:
                filename = image_info['filename']
                main_path = self.portfolio_dir / filename
                public_path = self.public_portfolio_dir / filename
                
                if main_path.exists() and public_path.exists():
                    print(f"   ✅ {filename} - {image_info['title']}")
                    total_images += 1
                else:
                    print(f"   ❌ {filename} - مفقود")
        
        print(f"\n📊 إجمالي الصور المتاحة: {total_images}")
        return total_images
    
    def run(self):
        """تشغيل العملية الكاملة"""
        print("🚀 بدء تنزيل الصور الحقيقية والمخصصة")
        
        # تنزيل الصور
        downloaded = self.download_all_images()
        
        if downloaded > 0:
            # تحديث الملف
            self.update_home_file()
            
            # التحقق من النتائج
            self.verify_images()
            
            print("\n🎉 تم الانتهاء بنجاح!")
            print("🌐 يمكنك الآن زيارة الموقع لرؤية الصور الحقيقية!")
        else:
            print("❌ لم يتم تنزيل أي صور!")

def main():
    """الدالة الرئيسية"""
    try:
        downloader = RealImageDownloader()
        downloader.run()
    except KeyboardInterrupt:
        print("\nتم إيقاف العملية بواسطة المستخدم")
    except Exception as e:
        print(f"حدث خطأ: {str(e)}")
        import traceback
        traceback.print_exc()

if __name__ == "__main__":
    main()
