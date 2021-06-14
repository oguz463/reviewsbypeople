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

    'accepted' => ':attribute alanı işaretlenmelidir.',
    'active_url' => ':attribute alanı geçerli URL yapısına sahip olmalıdır.',
    'after' => ':attribute alanı :date tarihinden sonra bir tarih olmalıdır.',
    'after_or_equal' => ':attribute alanı :date tarihiyle aynı veya sonra olmalıdır.',
    'alpha' => ':attribute alanı sadece harf içermelidir.',
    'alpha_dash' => ':attribute alanı sadece harf, sayı, tire ve alttire içerebilir.',
    'alpha_num' => ':attribute alanı sadece harf ve sayı içerebilir.',
    'array' => 'attribute alanı array yapısında olmalıdır.',
    'before' => ':attribute alanı :date tarihinden önce bir tarih olmalıdır.',
    'before_or_equal' => ':attribute alanı :date tarihiyle aynı veya önce bir tarih olmalıdır.',
    'between' => [
        'numeric' => ':attribute alanı :min ve :max arasında olmalıdır.',
        'file' => ':attribute alanı :min ve :max kilobyte aralığında olmalıdır.',
        'string' => ':attribute alanı :min ve :max karakter uzunluğunda olmalıdır.',
        'array' => ':attribute alanı :min ve :max arasında öğe bulundurabilir.',
    ],
    'boolean' => ':attribute alanı doğru veya yanlış olmalıdır.',
    'confirmed' => ':attribute onayı uyuşmuyor.',
    'date' => ':attribute alanı uygun bir tarih değil.',
    'date_equals' => ':attribute alanı şu tarih :date olmalıdır.',
    'date_format' => ':attribute alanı :format formatıyla uyuşmuyor.',
    'different' => ':attribute ve :other farklı olmalıdır',
    'digits' => ':attribute alanı sadece :digits rakam içerebilir.',
    'digits_between' => ':attribute alanı :min ve :max rakamları arasında olabilir.',
    'dimensions' => ':attribute alanı geçersiz boyutlara sahip.',
    'distinct' => ':attribute alanı tekrar eden değer içeriyor.',
    'email' => ':attribute alanı geçerli bir email olmalıdır.',
    'ends_with' => ':attribute alanı şunlarla bitmelidir: :values.',
    'exists' => 'Seçilen :attribute geçersiz.',
    'file' => ':attribute alanı sadece dosya içermelidir.',
    'filled' => ':attribute alanı doldurulmalıdır.',
    'gt' => [
        'numeric' => ':attribute alanı :value değerinden büyük olmalıdır.',
        'file' => ':attribute alanı :value kilobytetan büyük olmalıdır.',
        'string' => ':attribute alanı :value karakterden fazla olmalıdır.',
        'array' => ':attribute alanı :value öğeden fazla olmalıdır.',
    ],
    'gte' => [
        'numeric' => ':attribute alanı :value değerine eşit veya büyük olmalıdır.',
        'file' => ':attribute alanı :value kilobyte veya daha büyük olmalıdır.',
        'string' => ':attribute alanı :value karaktere eşit veya daha fazla olmalıdır.',
        'array' => ':attribute alanı :value öğe veya daha fazla öğe içermelidir.',
    ],
    'image' => ':attribute alanı resim olmalıdır.',
    'in' => 'Seçili :attribute alanı geçerli değil.',
    'in_array' => ':attribute alanı :other öğeleri içinde yer almıyor.',
    'integer' => ':attribute alanı integer olmalıdır.',
    'ip' => ':attribute alanı geçerli bir IP adresi olmalıdır.',
    'ipv4' => ':attribute alanı geçerli bir IPv4 adresi olmalıdır.',
    'ipv6' => ':attribute alanı geçerli bir IPv6 adresi olmalıdır.',
    'json' => ':attribute alanı geçerli bir JSON String olmalıdır.',
    'lt' => [
        'numeric' => ':attribute alanı :value değerinden küçük olmalıdır.',
        'file' => ':attribute alanı :value kilobytetan küçük olmalıdır.',
        'string' => ':attribute alanı :value karakterden az olmalıdır.',
        'array' => ':attribute alanı :value öğeden az olmalıdır.',
    ],
    'lte' => [
        'numeric' => ':attribute alanı :value değerine eşit veya küçük olmalıdır.',
        'file' => ':attribute alanı :value kilobyte veya daha az olmalıdır.',
        'string' => ':attribute alanı :value karaktere eşit veya daha az olmalıdır.',
        'array' => ':attribute alanı :value öğe veya daha az öğe içermelidir.',
    ],
    'max' => [
        'numeric' => ':attribute alanı :max değerinden büyük olmamalıdır.',
        'file' => ':attribute alanı :max kilobytetan fazla olmamalıdır.',
        'string' => ':attribute alanı :max karakterden fazla olmamalıdır.',
        'array' => ':attribute alanı en fazla :max öğe içerebilir.',
    ],
    'mimes' => ':attribute alanının içerebileceği dosya türleri: :values.',
    'mimetypes' => ':attribute alanının içerebileceği dosya tipleri: :values.',
    'min' => [
        'numeric' => ':attribute alanı :min değerinden az olmamalıdır.',
        'file' => ':attribute alanı :min kilobytetan az olmamalıdır.',
        'string' => ':attribute alanı :min karakterden az olmamalıdır.',
        'array' => ':attribute alanı en az :min öğe içermelidir.',
    ],
    'multiple_of' => ':attribute alanı :value katı olmalıdır.',
    'not_in' => 'Seçilen :attribute geçersiz.',
    'not_regex' => ':attribute formatı geçersiz.',
    'numeric' => ':attribute alanı sayı olmalıdır.',
    'password' => 'Şifre doğru değil.',
    'present' => ':attribute alanı eklenmelidir.',
    'regex' => ':attribute formatı geçersiz.',
    'required' => ':attribute alanı zorunludur.',
    'required_if' => ':attribute alanı, :other alanı :value olduğunda zorunludur.',
    'required_unless' => ':attribute alanı :other alanı :values içinde olduğu sürece zorunludur.',
    'required_with' => ':attribute alanı :values değerlerinden herhangi biri eklendiğinde zorunludur.',
    'required_with_all' => ':attribute alanı :values değerleri eklendiğinde zorunludur.',
    'required_without' => ':attribute alanı :values değerlerinden biri olmadığında zorunludur.',
    'required_without_all' => ':attribute alanı :values değerleri olmadığında zorunludur.',
    'prohibited' => ':attribute bu alan yasaktır.',
    'prohibited_if' => ':attribute alanı :other alanı :value olduğunda yasaktır.',
    'prohibited_unless' => ':attribute alanı :other alanı :values içinde olmadığında yasaktır.',
    'same' => ':attribute ve :other alanları aynı olmalıdır.',
    'size' => [
        'numeric' => ':attribute değeri :size olmalıdır.',
        'file' => ':attribute boyutu :size kilobyte olmalıdır.',
        'string' => ':attribute alanı :size karakter olmalıdır.',
        'array' => ':attribute alanı :size öğe içermelidir.',
    ],
    'starts_with' => ':attribute alanı belirtilen değerlerden biriyle başlamalıdır. Değerler: :values.',
    'string' => ':attribute alanı string olmalıdır.',
    'timezone' => ':attribute alanı zaman dilimi olmalıdır.',
    'unique' => ':attribute zaten mevcut.',
    'uploaded' => ':attribute yüklemesi başarısız.',
    'url' => ':attribute formatı yanlış.',
    'uuid' => ':attribute geçerli UUID olmalıdır.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
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
        "name" => "İsim",
        "email" =>"Eposta",
        "password" => "Şifre",
    ],

];
