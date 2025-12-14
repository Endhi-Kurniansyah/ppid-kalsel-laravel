@extends('layouts.frontend')

@section('content')
<div class="container py-5" style="margin-top: 80px;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-lg">
                <div class="card-header bg-primary text-white text-center py-4">
                    <h3 class="mb-0 text-white">Formulir Permohonan Informasi</h3>
                    <p class="mb-0">Silakan isi data diri dan informasi yang dibutuhkan</p>
                </div>
                <div class="card-body p-5">

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('requests.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <h5 class="text-primary mb-3">1. Identitas Pemohon</h5>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">NIK (KTP)</label>
                                <input type="number" name="nik" class="form-control" required placeholder="16 digit NIK" value="{{ old('nik') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" name="name" class="form-control" required placeholder="Sesuai KTP" value="{{ old('name') }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Upload Foto KTP</label>
                            <input type="file" name="ktp_file" class="form-control" accept="image/*" required>
                            <small class="text-muted" style="font-size: 12px;">Format: JPG/PNG. Maksimal 2MB.</small>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" required value="{{ old('email') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">No. WhatsApp/HP</label>
                                <input type="number" name="phone" class="form-control" required value="{{ old('phone') }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Alamat Lengkap</label>
                            <textarea name="address" class="form-control" rows="2" required>{{ old('address') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Pekerjaan</label>
                            <input type="text" name="job" class="form-control" value="{{ old('job') }}">
                        </div>

                        <hr class="my-4">

                        <h5 class="text-primary mb-3">2. Rincian Informasi</h5>
                        <div class="mb-3">
                            <label class="form-label">Rincian Informasi yang Dibutuhkan</label>
                            <textarea name="details" class="form-control" rows="3" required placeholder="Contoh: Data Aset Dinas Pertanian Tahun 2024...">{{ old('details') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tujuan Penggunaan Informasi</label>
                            <textarea name="purpose" class="form-control" rows="2" required placeholder="Contoh: Untuk keperluan penelitian skripsi...">{{ old('purpose') }}</textarea>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Cara Memperoleh Info</label>
                                <select name="get_method" class="form-select">
                                    <option value="softcopy">Softcopy (File Digital)</option>
                                    <option value="hardcopy">Hardcopy (Cetak Kertas)</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Cara Mendapatkan Salinan</label>
                                <select name="delivery_method" class="form-select">
                                    <option value="email">Kirim via Email</option>
                                    <option value="langsung">Ambil Langsung ke Kantor</option>
                                </select>
                            </div>
                        </div>

                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-primary btn-lg rounded-pill shadow">
                                <i class="bi bi-send-fill"></i> Kirim Permohonan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
