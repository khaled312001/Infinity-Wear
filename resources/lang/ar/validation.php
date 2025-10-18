<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => 'يجب قبول :attribute.',
    'active_url'           => ':attribute ليس رابط صحيح.',
    'after'                => ':attribute يجب أن يكون تاريخ بعد :date.',
    'after_or_equal'       => ':attribute يجب أن يكون تاريخ بعد أو يساوي :date.',
    'alpha'                => ':attribute يجب أن يحتوي على أحرف فقط.',
    'alpha_dash'           => ':attribute يجب أن يحتوي على أحرف وأرقام وشرطات فقط.',
    'alpha_num'            => ':attribute يجب أن يحتوي على أحرف وأرقام فقط.',
    'array'                => ':attribute يجب أن يكون مصفوفة.',
    'before'               => ':attribute يجب أن يكون تاريخ قبل :date.',
    'before_or_equal'      => ':attribute يجب أن يكون تاريخ قبل أو يساوي :date.',
    'between'              => [
        'numeric' => ':attribute يجب أن يكون بين :min و :max.',
        'file'    => ':attribute يجب أن يكون بين :min و :max كيلوبايت.',
        'string'  => ':attribute يجب أن يكون بين :min و :max حرف.',
        'array'   => ':attribute يجب أن يحتوي على :min إلى :max عنصر.',
    ],
    'boolean'              => ':attribute يجب أن يكون صحيح أو خطأ.',
    'confirmed'            => 'تأكيد :attribute غير متطابق.',
    'date'                 => ':attribute ليس تاريخ صحيح.',
    'date_equals'          => ':attribute يجب أن يكون تاريخ يساوي :date.',
    'date_format'          => ':attribute لا يطابق الصيغة :format.',
    'different'            => ':attribute و :other يجب أن يكونا مختلفين.',
    'digits'               => ':attribute يجب أن يكون :digits رقم.',
    'digits_between'       => ':attribute يجب أن يكون بين :min و :max رقم.',
    'dimensions'           => ':attribute له أبعاد صورة غير صحيحة.',
    'distinct'             => ':attribute له قيمة مكررة.',
    'email'                => ':attribute يجب أن يكون عنوان بريد إلكتروني صحيح.',
    'ends_with'            => ':attribute يجب أن ينتهي بأحد القيم التالية: :values.',
    'exists'               => ':attribute المحدد غير صحيح.',
    'file'                 => ':attribute يجب أن يكون ملف.',
    'filled'               => ':attribute يجب أن يحتوي على قيمة.',
    'gt'                   => [
        'numeric' => ':attribute يجب أن يكون أكبر من :value.',
        'file'    => ':attribute يجب أن يكون أكبر من :value كيلوبايت.',
        'string'  => ':attribute يجب أن يكون أكبر من :value حرف.',
        'array'   => ':attribute يجب أن يحتوي على أكثر من :value عنصر.',
    ],
    'gte'                  => [
        'numeric' => ':attribute يجب أن يكون أكبر من أو يساوي :value.',
        'file'    => ':attribute يجب أن يكون أكبر من أو يساوي :value كيلوبايت.',
        'string'  => ':attribute يجب أن يكون أكبر من أو يساوي :value حرف.',
        'array'   => ':attribute يجب أن يحتوي على :value عنصر أو أكثر.',
    ],
    'image'                => ':attribute يجب أن يكون صورة.',
    'in'                   => ':attribute المحدد غير صحيح.',
    'in_array'             => ':attribute غير موجود في :other.',
    'integer'              => ':attribute يجب أن يكون رقم صحيح.',
    'ip'                   => ':attribute يجب أن يكون عنوان IP صحيح.',
    'ipv4'                 => ':attribute يجب أن يكون عنوان IPv4 صحيح.',
    'ipv6'                 => ':attribute يجب أن يكون عنوان IPv6 صحيح.',
    'json'                 => ':attribute يجب أن يكون نص JSON صحيح.',
    'lt'                   => [
        'numeric' => ':attribute يجب أن يكون أصغر من :value.',
        'file'    => ':attribute يجب أن يكون أصغر من :value كيلوبايت.',
        'string'  => ':attribute يجب أن يكون أصغر من :value حرف.',
        'array'   => ':attribute يجب أن يحتوي على أقل من :value عنصر.',
    ],
    'lte'                  => [
        'numeric' => ':attribute يجب أن يكون أصغر من أو يساوي :value.',
        'file'    => ':attribute يجب أن يكون أصغر من أو يساوي :value كيلوبايت.',
        'string'  => ':attribute يجب أن يكون أصغر من أو يساوي :value حرف.',
        'array'   => ':attribute يجب أن يحتوي على :value عنصر أو أقل.',
    ],
    'max'                  => [
        'numeric' => ':attribute لا يجب أن يكون أكبر من :max.',
        'file'    => ':attribute لا يجب أن يكون أكبر من :max كيلوبايت.',
        'string'  => ':attribute لا يجب أن يكون أكبر من :max حرف.',
        'array'   => ':attribute لا يجب أن يحتوي على أكثر من :max عنصر.',
    ],
    'mimes'                => ':attribute يجب أن يكون ملف من نوع: :values.',
    'mimetypes'            => ':attribute يجب أن يكون ملف من نوع: :values.',
    'min'                  => [
        'numeric' => ':attribute يجب أن يكون على الأقل :min.',
        'file'    => ':attribute يجب أن يكون على الأقل :min كيلوبايت.',
        'string'  => ':attribute يجب أن يكون على الأقل :min حرف.',
        'array'   => ':attribute يجب أن يحتوي على :min عنصر على الأقل.',
    ],
    'not_in'               => ':attribute المحدد غير صحيح.',
    'not_regex'            => 'صيغة :attribute غير صحيحة.',
    'numeric'              => ':attribute يجب أن يكون رقم.',
    'present'              => ':attribute يجب أن يكون موجود.',
    'regex'                => 'صيغة :attribute غير صحيحة.',
    'required'             => ':attribute مطلوب.',
    'required_if'          => ':attribute مطلوب عندما :other يساوي :value.',
    'required_unless'      => ':attribute مطلوب ما لم يكن :other في :values.',
    'required_with'        => ':attribute مطلوب عندما :values موجود.',
    'required_with_all'    => ':attribute مطلوب عندما :values موجود.',
    'required_without'     => ':attribute مطلوب عندما :values غير موجود.',
    'required_without_all' => ':attribute مطلوب عندما لا يوجد أي من :values.',
    'same'                 => ':attribute و :other يجب أن يكونا متطابقين.',
    'size'                 => [
        'numeric' => ':attribute يجب أن يكون :size.',
        'file'    => ':attribute يجب أن يكون :size كيلوبايت.',
        'string'  => ':attribute يجب أن يكون :size حرف.',
        'array'   => ':attribute يجب أن يحتوي على :size عنصر.',
    ],
    'starts_with'          => ':attribute يجب أن يبدأ بأحد القيم التالية: :values.',
    'string'               => ':attribute يجب أن يكون نص.',
    'timezone'             => ':attribute يجب أن يكون منطقة زمنية صحيحة.',
    'unique'               => ':attribute مستخدم بالفعل.',
    'uploaded'             => 'فشل في رفع :attribute.',
    'url'                  => 'صيغة :attribute غير صحيحة.',
    'uuid'                 => ':attribute يجب أن يكون UUID صحيح.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "rule.attribute" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [
        'title' => 'العنوان',
        'description' => 'الوصف',
        'board_id' => 'اللوحة',
        'column_id' => 'العمود',
        'priority' => 'الأولوية',
        'due_date' => 'تاريخ الاستحقاق',
        'assigned_to' => 'المعين إليه',
        'assigned_to_type' => 'نوع المعين إليه',
        'labels' => 'التسميات',
        'tags' => 'العلامات',
        'estimated_hours' => 'الساعات المقدرة',
        'color' => 'اللون',
    ],

];
