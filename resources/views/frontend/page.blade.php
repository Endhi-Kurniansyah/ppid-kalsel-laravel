@extends('layouts.frontend')

@section('content')
<div class="container py-5" style="margin-top: 60px;">

    <div class="text-center mb-5">
        <h2 class="fw-bold text-primary">{{ $page->title }}</h2>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">

                    <div class="ck-content">
                        {!! $page->content !!}
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Agar konten tidak melebar keluar layar */
    .ck-content {
        max-width: 100%;
        overflow-x: hidden;
        color: #333;
        line-height: 1.6; /* Jarak antar baris biar enak dibaca */
    }

    /* KUNCI UTAMA: Gambar maksimal 100% lebar layar */
    .ck-content img {
        max-width: 100% !important;
        height: auto !important;
        display: block;
        margin: 20px auto; /* Rata tengah */
        border-radius: 8px; /* Sudut melengkung */
        box-shadow: 0 4px 10px rgba(0,0,0,0.1); /* Bayangan halus */
    }

    /* Merapikan Keterangan Gambar (Caption) */
    .ck-content figure {
        margin: 0;
        display: block;
        text-align: center;
        width: 100% !important;
    }

    /* Merapikan Tabel (Kalau ada) */
    .ck-content table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 1rem;
    }
    .ck-content table td, .ck-content table th {
        border: 1px solid #ddd;
        padding: 8px;
    }
</style>
@endsection
