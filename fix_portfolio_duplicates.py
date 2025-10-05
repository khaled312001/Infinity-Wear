#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
Fix Portfolio Duplicates
إصلاح تكرار عناصر المعرض
"""

import re
import shutil
from pathlib import Path
from datetime import datetime

class PortfolioFixer:
    def __init__(self):
        self.base_dir = Path(__file__).parent
        self.home_file = self.base_dir / "resources" / "views" / "home.blade.php"
        self.backup_dir = self.base_dir / "backups"
        
        # إنشاء مجلد النسخ الاحتياطية
        self.backup_dir.mkdir(exist_ok=True)
        
        # الصور الحقيقية المطلوبة (بدون تكرار)
        self.clean_portfolio_items = [
            {
                'category': 'football',
                'image': 'football_team_riyadh.jpg',
                'title': 'فريق كرة قدم الرياض',
                'description': 'تصميم متكامل لفريق كرة قدم محلي مع جيرسي وشورت وجوارب بألوان مميزة'
            },
            {
                'category': 'football',
                'image': 'football_academy_training.jpg',
                'title': 'أكاديمية كرة القدم',
                'description': 'زي تدريب احترافي لأكاديمية كرة قدم مع شعار مخصص'
            },
            {
                'category': 'football',
                'image': 'football_kit_complete.jpg',
                'title': 'طقم كرة قدم كامل',
                'description': 'طقم متكامل يشمل الجيرسي والشورت والجوارب والقفازات'
            },
            {
                'category': 'basketball',
                'image': 'basketball_team_ahli.jpg',
                'title': 'نادي كرة السلة الأهلي',
                'description': 'تصميم احترافي لفريق كرة سلة محترف بألوان النادي المميزة'
            },
            {
                'category': 'basketball',
                'image': 'basketball_women_team.jpg',
                'title': 'فريق كرة السلة النسائي',
                'description': 'تصميم مخصص للفريق النسائي بألوان أنيقة ومناسبة'
            },
            {
                'category': 'schools',
                'image': 'school_uniform_riyadh_international.jpg',
                'title': 'مدرسة الرياض الدولية',
                'description': 'زي رياضي موحد للمدرسة بتصميم عصري وألوان مناسبة للطلاب'
            },
            {
                'category': 'schools',
                'image': 'university_sports_team.jpg',
                'title': 'جامعة الملك سعود',
                'description': 'زي رياضي لفرق الجامعة مع شعار الجامعة وألوانها الرسمية'
            },
            {
                'category': 'companies',
                'image': 'corporate_uniform_stc.jpg',
                'title': 'شركة الاتصالات السعودية',
                'description': 'زي عمل احترافي لموظفي الشركة مع شعار الشركة وألوانها الرسمية'
            },
            {
                'category': 'companies',
                'image': 'corporate_uniform_aramco.jpg',
                'title': 'شركة أرامكو السعودية',
                'description': 'زي عمل متخصص لموظفي الشركة مع معايير السلامة والأمان'
            },
            {
                'category': 'medical',
                'image': 'medical_uniform_king_fahd.jpg',
                'title': 'مستشفى الملك فهد',
                'description': 'زي طبي عالي الجودة للمستشفيات والعيادات مع معايير النظافة'
            },
            {
                'category': 'medical',
                'image': 'medical_uniform_emergency.jpg',
                'title': 'زي طوارئ طبي',
                'description': 'زي متخصص لطاقم الطوارئ مع مواد مقاومة للبقع والجراثيم'
            },
            {
                'category': 'sports',
                'image': 'sports_wear_gym.jpg',
                'title': 'ملابس رياضية للجيم',
                'description': 'ملابس رياضية عالية الجودة للتمارين الرياضية والنوادي'
            },
            {
                'category': 'sports',
                'image': 'sports_wear_outdoor.jpg',
                'title': 'ملابس رياضية خارجية',
                'description': 'ملابس رياضية مناسبة للأنشطة الخارجية مع مواد مقاومة للعوامل الجوية'
            }
        ]
    
    def create_backup(self):
        """إنشاء نسخة احتياطية"""
        timestamp = datetime.now().strftime("%Y%m%d_%H%M%S")
        backup_file = self.backup_dir / f"home_backup_before_fix_{timestamp}.blade.php"
        shutil.copy2(self.home_file, backup_file)
        print(f"✅ تم إنشاء نسخة احتياطية: {backup_file}")
        return backup_file
    
    def generate_clean_portfolio_html(self):
        """إنشاء HTML نظيف للمعرض"""
        portfolio_items = []
        
        for item in self.clean_portfolio_items:
            html_item = f'''
                <div class="portfolio-item" data-category="{item['category']}">
                    <div class="portfolio-image">
                        <img src="{{{{ asset('images/portfolio/{item['image']}') }}}}" alt="{item['title']}">
                        <div class="portfolio-overlay">
                            <div class="portfolio-content">
                                <h3>{item['title']}</h3>
                                <p>{item['description']}</p>
                                <a href="#" class="btn btn-primary">عرض المزيد</a>
                            </div>
                        </div>
                    </div>
                </div>'''
            portfolio_items.append(html_item)
        
        return '\n'.join(portfolio_items)
    
    def fix_portfolio_section(self):
        """إصلاح قسم المعرض"""
        if not self.home_file.exists():
            print("❌ ملف home.blade.php غير موجود!")
            return False
        
        # إنشاء نسخة احتياطية
        self.create_backup()
        
        # قراءة الملف
        with open(self.home_file, 'r', encoding='utf-8') as f:
            content = f.read()
        
        # إنشاء المحتوى النظيف
        clean_portfolio_content = self.generate_clean_portfolio_html()
        
        # البحث عن قسم المعرض واستبداله
        pattern = r'(<div class="infinity-portfolio-grid">)(.*?)(</div>)'
        replacement = r'\1' + clean_portfolio_content + r'\3'
        
        new_content = re.sub(pattern, replacement, content, flags=re.DOTALL)
        
        # كتابة الملف المحدث
        with open(self.home_file, 'w', encoding='utf-8') as f:
            f.write(new_content)
        
        print("✅ تم إصلاح قسم المعرض وإزالة التكرار!")
        return True
    
    def verify_fix(self):
        """التحقق من الإصلاح"""
        if not self.home_file.exists():
            return False
        
        with open(self.home_file, 'r', encoding='utf-8') as f:
            content = f.read()
        
        # عد عناصر portfolio-item
        portfolio_items = re.findall(r'<div class="portfolio-item"', content)
        expected_count = len(self.clean_portfolio_items)
        
        print(f"\n📊 التحقق من الإصلاح:")
        print(f"   العناصر الموجودة: {len(portfolio_items)}")
        print(f"   العناصر المتوقعة: {expected_count}")
        
        if len(portfolio_items) == expected_count:
            print("✅ تم إصلاح التكرار بنجاح!")
            return True
        else:
            print("❌ لا يزال هناك تكرار!")
            return False
    
    def run(self):
        """تشغيل عملية الإصلاح"""
        print("=" * 60)
        print("إصلاح تكرار عناصر المعرض")
        print("=" * 60)
        
        # إصلاح قسم المعرض
        if self.fix_portfolio_section():
            # التحقق من الإصلاح
            if self.verify_fix():
                print("\n🎉 تم إصلاح المعرض بنجاح!")
                print("✅ تم إزالة التكرار")
                print("✅ تم تنظيم العناصر")
                print("✅ تم إنشاء نسخة احتياطية")
                print("\n🌐 يمكنك الآن زيارة الموقع لرؤية المعرض المنظم!")
                return True
        
        print("\n❌ فشل في إصلاح المعرض!")
        return False

def main():
    """الدالة الرئيسية"""
    try:
        fixer = PortfolioFixer()
        fixer.run()
    except Exception as e:
        print(f"حدث خطأ: {str(e)}")
        import traceback
        traceback.print_exc()

if __name__ == "__main__":
    main()
