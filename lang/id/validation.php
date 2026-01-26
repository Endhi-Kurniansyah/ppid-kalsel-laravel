<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Baris Bahasa Validasi
    |--------------------------------------------------------------------------
    |
    | Baris-baris berikut berisi pesan kesalahan standar yang digunakan oleh
    | kelas validator. Beberapa aturan memiliki beberapa versi seperti
    | aturan ukuran. Silakan ubah pesan-pesan ini sesuai kebutuhan.
    |
    */

    'accepted'        => ':Attribute harus diterima.',
    'active_url'      => ':Attribute bukan URL yang valid.',
    'after'           => ':Attribute harus berisi tanggal setelah :date.',
    'after_or_equal'  => ':Attribute harus berisi tanggal setelah atau sama dengan :date.',
    'alpha'           => ':Attribute hanya boleh berisi huruf.',
    'alpha_dash'      => ':Attribute hanya boleh berisi huruf, angka, strip, dan garis bawah.',
    'alpha_num'       => ':Attribute hanya boleh berisi huruf dan angka.',
    'array'           => ':Attribute harus berupa array.',
    'before'          => ':Attribute harus berisi tanggal sebelum :date.',
    'before_or_equal' => ':Attribute harus berisi tanggal sebelum atau sama dengan :date.',
    'between'         => [
        'numeric' => ':Attribute harus bernilai antara :min sampai :max.',
        'file'    => ':Attribute harus berukuran antara :min sampai :max kilobita.',
        'string'  => ':Attribute harus berisi antara :min sampai :max karakter.',
        'array'   => ':Attribute harus memiliki :min sampai :max item.',
    ],
    'boolean'         => ':Attribute harus bernilai true atau false.',
    'confirmed'       => 'Konfirmasi :attribute tidak cocok.',
    'date'            => ':Attribute bukan tanggal yang valid.',
    'date_equals'     => ':Attribute harus berisi tanggal yang sama dengan :date.',
    'date_format'     => ':Attribute tidak cocok dengan format :format.',
    'different'       => ':Attribute dan :other harus berbeda.',
    'digits'          => ':Attribute harus terdiri dari :digits angka.',
    'digits_between'  => ':Attribute harus terdiri dari :min sampai :max angka.',
    'dimensions'      => ':Attribute tidak memiliki dimensi gambar yang valid.',
    'distinct'        => ':Attribute memiliki nilai yang duplikat.',
    'email'           => ':Attribute harus berupa alamat email yang valid.',
    'ends_with'       => ':Attribute harus diakhiri salah satu dari berikut: :values',
    'exists'          => ':Attribute yang dipilih tidak valid.',
    'file'            => ':Attribute harus berupa file.',
    'filled'          => ':Attribute harus memiliki nilai.',
    'gt'              => [
        'numeric' => ':Attribute harus bernilai lebih besar dari :value.',
        'file'    => ':Attribute harus berukuran lebih besar dari :value kilobita.',
        'string'  => ':Attribute harus berisi lebih besar dari :value karakter.',
        'array'   => ':Attribute harus memiliki lebih dari :value item.',
    ],
    'gte'             => [
        'numeric' => ':Attribute harus bernilai lebih besar dari atau sama dengan :value.',
        'file'    => ':Attribute harus berukuran lebih besar dari atau sama dengan :value kilobita.',
        'string'  => ':Attribute harus berisi lebih besar dari atau sama dengan :value karakter.',
        'array'   => ':Attribute harus memiliki :value item atau lebih.',
    ],
    'image'           => ':Attribute harus berupa gambar.',
    'in'              => ':Attribute yang dipilih tidak valid.',
    'in_array'        => ':Attribute tidak ada di dalam :other.',
    'integer'         => ':Attribute harus berupa bilangan bulat.',
    'ip'              => ':Attribute harus berupa alamat IP yang valid.',
    'ipv4'            => ':Attribute harus berupa alamat IPv4 yang valid.',
    'ipv6'            => ':Attribute harus berupa alamat IPv6 yang valid.',
    'json'            => ':Attribute harus berupa JSON string yang valid.',
    'lt'              => [
        'numeric' => ':Attribute harus bernilai lebih kecil dari :value.',
        'file'    => ':Attribute harus berukuran lebih kecil dari :value kilobita.',
        'string'  => ':Attribute harus berisi lebih kecil dari :value karakter.',
        'array'   => ':Attribute harus memiliki kurang dari :value item.',
    ],
    'lte'             => [
        'numeric' => ':Attribute harus bernilai lebih kecil dari atau sama dengan :value.',
        'file'    => ':Attribute harus berukuran lebih kecil dari atau sama dengan :value kilobita.',
        'string'  => ':Attribute harus berisi lebih kecil dari atau sama dengan :value karakter.',
        'array'   => ':Attribute tidak boleh memiliki lebih dari :value item.',
    ],
    'max'             => [
        'numeric' => ':Attribute maksimal bernilai :max.',
        'file'    => ':Attribute maksimal berukuran :max kilobita.',
        'string'  => ':Attribute maksimal berisi :max karakter.',
        'array'   => ':Attribute maksimal terdiri dari :max item.',
    ],
    'mimes'           => ':Attribute harus berupa file bertipe: :values.',
    'mimetypes'       => ':Attribute harus berupa file bertipe: :values.',
    'min'             => [
        'numeric' => ':Attribute minimal bernilai :min.',
        'file'    => ':Attribute minimal berukuran :min kilobita.',
        'string'  => ':Attribute minimal berisi :min karakter.',
        'array'   => ':Attribute minimal terdiri dari :min item.',
    ],
    'not_in'          => ':Attribute yang dipilih tidak valid.',
    'not_regex'       => 'Format :attribute tidak valid.',
    'numeric'         => ':Attribute harus berupa angka.',
    'password'        => 'Password salah.',
    'present'         => ':Attribute wajib ada.',
    'regex'           => 'Format :attribute tidak valid.',
    'required'        => 'Kolom :attribute wajib diisi.',
    'required_if'     => 'Kolom :attribute wajib diisi bila :other adalah :value.',
    'required_unless' => 'Kolom :attribute wajib diisi kecuali :other memiliki nilai :values.',
    'required_with'   => 'Kolom :attribute wajib diisi bila terdapat :values.',
    'required_with_all' => 'Kolom :attribute wajib diisi bila terdapat :values.',
    'required_without' => 'Kolom :attribute wajib diisi bila tidak terdapat :values.',
    'required_without_all' => 'Kolom :attribute wajib diisi bila sama sekali tidak terdapat :values.',
    'same'            => ':Attribute dan :other harus sama.',
    'size'            => [
        'numeric' => ':Attribute harus berukuran :size.',
        'file'    => ':Attribute harus berukuran :size kilobita.',
        'string'  => ':Attribute harus berisi :size karakter.',
        'array'   => ':Attribute harus mengandung :size item.',
    ],
    'starts_with'     => ':Attribute harus diawali salah satu dari berikut: :values',
    'string'          => ':Attribute harus berupa string.',
    'timezone'        => ':Attribute harus berupa zona waktu yang valid.',
    'unique'          => ':Attribute sudah ada sebelumnya.',
    'uploaded'        => ':Attribute gagal diupload.',
    'url'             => 'Format :attribute tidak valid.',
    'uuid'            => ':Attribute harus merupakan UUID yang valid.',
    
    // Custom Keys
    'captcha' => 'Kode keamanan yang Anda masukkan salah.',

    /*
    |--------------------------------------------------------------------------
    | Kustomisasi Bahasa Validasi
    |--------------------------------------------------------------------------
    |
    | Di sini Anda dapat menentukan pesan validasi kustom untuk atribut dengan menggunakan
    | konvensi "attribute.rule" dalam penamaan barisnya. Hal ini mempercepat dalam
    | menentukan baris bahasa kustom yang spesifik untuk aturan atribut yang diberikan.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Kustomisasi Atribut Validasi
    |--------------------------------------------------------------------------
    |
    | Baris-baris berikut digunakan untuk menukar 'placeholder' atribut dengan sesuatu
    | yang lebih mudah dimengerti oleh pembaca seperti "Alamat E-Mail" daripada
    | "email" saja. Ini sangat membantu kita dalam membuat pesan lebih ekspresif.
    |
    */

    'attributes' => [
        'email' => 'Email',
        'password' => 'Password',
        'captcha' => 'Kode Keamanan',
        'title' => 'Judul',
        'content' => 'Konten',
        'body' => 'Isi',
        'name' => 'Nama',
        'description' => 'Deskripsi',
        'image' => 'Gambar',
    ],
];
