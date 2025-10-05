#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
Clean Portfolio - Remove Duplicates
تنظيف المعرض - إزالة التكرار
"""

import re
import shutil
from pathlib import Path
from datetime import datetime

def clean_portfolio():
    """تنظيف المعرض من التكرار"""
    
    base_dir = Path(__file__).parent
    home_file = base_dir / "resources" / "views" / "home.blade.php"
    backup_dir = base_dir / "backups"
    
    # إنشاء نسخة احتياطية
    backup_dir.mkdir(exist_ok=True)
    timestamp = datetime.now().strftime("%Y%m%d_%H%M%S")
    backup_file = backup_dir / f"home_backup_clean_{timestamp}.blade.php"
    shutil.copy2(home_file, backup_file)
    print(f"✅ تم إنشاء نسخة احتياطية: {backup_file}")
    
    # قراءة الملف
    with open(home_file, 'r', encoding='utf-8') as f:
        content = f.read()
    
    # المحتوى النظيف للمعرض
    clean_portfolio_content = '''
            <div class="infinity-portfolio-grid">
                <div class="portfolio-item" data-category="football">
                    <div class="portfolio-image">
                        <img src="{{ asset('images/portfolio/football_team_riyadh.jpg') }}" alt="فريق كرة قدم الرياض">
                        <div class="portfolio-overlay">
                            <div class="portfolio-content">
                                <h3>فريق كرة قدم الرياض</h3>
                                <p>تصميم متكامل لفريق كرة قدم محلي مع جيرسي وشورت وجوارب بألوان مميزة</p>
                                <a href="#" class="btn btn-primary">عرض المزيد</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="portfolio-item" data-category="football">
                    <div class="portfolio-image">
                        <img src="{{ asset('images/portfolio/football_academy_training.jpg') }}" alt="أكاديمية كرة القدم">
                        <div class="portfolio-overlay">
                            <div class="portfolio-content">
                                <h3>أكاديمية كرة القدم</h3>
                                <p>زي تدريب احترافي لأكاديمية كرة قدم مع شعار مخصص</p>
                                <a href="#" class="btn btn-primary">عرض المزيد</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="portfolio-item" data-category="football">
                    <div class="portfolio-image">
                        <img src="{{ asset('images/portfolio/football_kit_complete.jpg') }}" alt="طقم كرة قدم كامل">
                        <div class="portfolio-overlay">
                            <div class="portfolio-content">
                                <h3>طقم كرة قدم كامل</h3>
                                <p>طقم متكامل يشمل الجيرسي والشورت والجوارب والقفازات</p>
                                <a href="#" class="btn btn-primary">عرض المزيد</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="portfolio-item" data-category="basketball">
                    <div class="portfolio-image">
                        <img src="{{ asset('images/portfolio/basketball_team_ahli.jpg') }}" alt="نادي كرة السلة الأهلي">
                        <div class="portfolio-overlay">
                            <div class="portfolio-content">
                                <h3>نادي كرة السلة الأهلي</h3>
                                <p>تصميم احترافي لفريق كرة سلة محترف بألوان النادي المميزة</p>
                                <a href="#" class="btn btn-primary">عرض المزيد</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="portfolio-item" data-category="basketball">
                    <div class="portfolio-image">
                        <img src="{{ asset('images/portfolio/basketball_women_team.jpg') }}" alt="فريق كرة السلة النسائي">
                        <div class="portfolio-overlay">
                            <div class="portfolio-content">
                                <h3>فريق كرة السلة النسائي</h3>
                                <p>تصميم مخصص للفريق النسائي بألوان أنيقة ومناسبة</p>
                                <a href="#" class="btn btn-primary">عرض المزيد</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="portfolio-item" data-category="schools">
                    <div class="portfolio-image">
                        <img src="{{ asset('images/portfolio/school_uniform_riyadh_international.jpg') }}" alt="مدرسة الرياض الدولية">
                        <div class="portfolio-overlay">
                            <div class="portfolio-content">
                                <h3>مدرسة الرياض الدولية</h3>
                                <p>زي رياضي موحد للمدرسة بتصميم عصري وألوان مناسبة للطلاب</p>
                                <a href="#" class="btn btn-primary">عرض المزيد</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="portfolio-item" data-category="schools">
                    <div class="portfolio-image">
                        <img src="{{ asset('images/portfolio/university_sports_team.jpg') }}" alt="جامعة الملك سعود">
                        <div class="portfolio-overlay">
                            <div class="portfolio-content">
                                <h3>جامعة الملك سعود</h3>
                                <p>زي رياضي لفرق الجامعة مع شعار الجامعة وألوانها الرسمية</p>
                                <a href="#" class="btn btn-primary">عرض المزيد</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="portfolio-item" data-category="companies">
                    <div class="portfolio-image">
                        <img src="{{ asset('images/portfolio/corporate_uniform_stc.jpg') }}" alt="شركة الاتصالات السعودية">
                        <div class="portfolio-overlay">
                            <div class="portfolio-content">
                                <h3>شركة الاتصالات السعودية</h3>
                                <p>زي عمل احترافي لموظفي الشركة مع شعار الشركة وألوانها الرسمية</p>
                                <a href="#" class="btn btn-primary">عرض المزيد</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="portfolio-item" data-category="companies">
                    <div class="portfolio-image">
                        <img src="{{ asset('images/portfolio/corporate_uniform_aramco.jpg') }}" alt="شركة أرامكو السعودية">
                        <div class="portfolio-overlay">
                            <div class="portfolio-content">
                                <h3>شركة أرامكو السعودية</h3>
                                <p>زي عمل متخصص لموظفي الشركة مع معايير السلامة والأمان</p>
                                <a href="#" class="btn btn-primary">عرض المزيد</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="portfolio-item" data-category="medical">
                    <div class="portfolio-image">
                        <img src="{{ asset('images/portfolio/medical_uniform_king_fahd.jpg') }}" alt="مستشفى الملك فهد">
                        <div class="portfolio-overlay">
                            <div class="portfolio-content">
                                <h3>مستشفى الملك فهد</h3>
                                <p>زي طبي عالي الجودة للمستشفيات والعيادات مع معايير النظافة</p>
                                <a href="#" class="btn btn-primary">عرض المزيد</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="portfolio-item" data-category="medical">
                    <div class="portfolio-image">
                        <img src="{{ asset('images/portfolio/medical_uniform_emergency.jpg') }}" alt="زي طوارئ طبي">
                        <div class="portfolio-overlay">
                            <div class="portfolio-content">
                                <h3>زي طوارئ طبي</h3>
                                <p>زي متخصص لطاقم الطوارئ مع مواد مقاومة للبقع والجراثيم</p>
                                <a href="#" class="btn btn-primary">عرض المزيد</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="portfolio-item" data-category="sports">
                    <div class="portfolio-image">
                        <img src="{{ asset('images/portfolio/sports_wear_gym.jpg') }}" alt="ملابس رياضية للجيم">
                        <div class="portfolio-overlay">
                            <div class="portfolio-content">
                                <h3>ملابس رياضية للجيم</h3>
                                <p>ملابس رياضية عالية الجودة للتمارين الرياضية والنوادي</p>
                                <a href="#" class="btn btn-primary">عرض المزيد</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="portfolio-item" data-category="sports">
                    <div class="portfolio-image">
                        <img src="{{ asset('images/portfolio/sports_wear_outdoor.jpg') }}" alt="ملابس رياضية خارجية">
                        <div class="portfolio-overlay">
                            <div class="portfolio-content">
                                <h3>ملابس رياضية خارجية</h3>
                                <p>ملابس رياضية مناسبة للأنشطة الخارجية مع مواد مقاومة للعوامل الجوية</p>
                                <a href="#" class="btn btn-primary">عرض المزيد</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>'''
    
    # استبدال قسم المعرض
    pattern = r'<div class="infinity-portfolio-grid">.*?</div>\s*</div>'
    new_content = re.sub(pattern, clean_portfolio_content, content, flags=re.DOTALL)
    
    # كتابة الملف المحدث
    with open(home_file, 'w', encoding='utf-8') as f:
        f.write(new_content)
    
    print("✅ تم تنظيف المعرض وإزالة التكرار!")
    
    # التحقق من النتيجة
    with open(home_file, 'r', encoding='utf-8') as f:
        new_content = f.read()
    
    portfolio_items = re.findall(r'<div class="portfolio-item"', new_content)
    print(f"📊 عدد عناصر المعرض: {len(portfolio_items)}")
    
    if len(portfolio_items) == 13:
        print("🎉 تم تنظيف المعرض بنجاح!")
        return True
    else:
        print("❌ لا يزال هناك مشكلة!")
        return False

if __name__ == "__main__":
    clean_portfolio()
