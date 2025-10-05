#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
Copy Images to Public Directory
نسخ الصور إلى مجلد public للعرض على الموقع
"""

import os
import shutil
from pathlib import Path

def copy_images_to_public():
    """نسخ جميع الصور من images/portfolio إلى public/images/portfolio"""
    
    # المسارات
    source_dir = Path("images/portfolio")
    target_dir = Path("public/images/portfolio")
    
    # إنشاء المجلد الهدف إذا لم يكن موجوداً
    target_dir.mkdir(parents=True, exist_ok=True)
    
    # البحث عن جميع الصور
    image_extensions = ['.jpg', '.jpeg', '.png', '.gif', '.webp']
    copied_count = 0
    
    print("=" * 50)
    print("نسخ الصور إلى مجلد public")
    print("=" * 50)
    
    for ext in image_extensions:
        for image_file in source_dir.glob(f"*{ext}"):
            try:
                target_file = target_dir / image_file.name
                shutil.copy2(image_file, target_file)
                print(f"✅ تم نسخ: {image_file.name}")
                copied_count += 1
            except Exception as e:
                print(f"❌ خطأ في نسخ {image_file.name}: {str(e)}")
    
    print(f"\nتم نسخ {copied_count} صورة بنجاح!")
    print("الصور جاهزة الآن للعرض على الموقع! 🌐")

if __name__ == "__main__":
    copy_images_to_public()
