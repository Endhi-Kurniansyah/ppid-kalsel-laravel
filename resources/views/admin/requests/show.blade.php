@extends('layouts.admin')

@section('page-title', 'Proses Permohonan')

@section('content')
<div class="row">

    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-light">
                <h5 class="mb-0">Detail Permohonan: <span class="text-primary">{{ $req->ticket_number }}</span></h5>
            </div>
            <div class="card-body">

                <h6 class="text-muted mb-3">Data Pemohon</h6>
                <table class="table table-borderless table-sm">
                    <tr>
                        <td width="30%">Nama Lengkap</td>
                        <td>: <strong>{{ $req->name }}</strong></td>
                    </tr>
                    <tr>
                        <td>NIK</td>
                        <td>: {{ $req->nik }}</td>
                    </tr>
                    <tr>
                        <td>Kontak</td>
                        <td>: {{ $req->email }} / {{ $req->phone }}</td>
                    </tr>
                    <tr>
                        <td>Pekerjaan</td>
                        <td>: {{ $req->job ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td>: {{ $req->address }}</td>
                    </tr>
                </table>

                <hr>

                <h6 class="text-muted mb-3">Informasi yang Diminta</h6>
                <div class="alert alert-secondary">
                    <strong>Rincian:</strong><br>
                    {{ $req->details }}
                </div>
                <div class="alert alert-secondary">
                    <strong>Tujuan Penggunaan:</strong><br>
                    {{ $req->purpose }}
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <small class="text-muted">Metode Perolehan:</small><br>
                        <strong>{{ strtoupper($req->get_method) }}</strong>
                    </div>
                    <div class="col-md-6">
                        <small class="text-muted">Metode Pengiriman:</small><br>
                        <strong>{{ strtoupper($req->delivery_method) }}</strong>
                    </div>
                </div>

            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h6 class="mb-0">Lampiran KTP</h6>
            </div>
            <div class="card-body text-center">
                @if($req->ktp_file)
                    <img src="{{ asset('storage/' . $req->ktp_file) }}" class="img-fluid rounded shadow-sm" style="max-height: 400px;">
                @else
                    <span class="text-danger">Tidak ada lampiran KTP</span>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-primary shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0 text-white"><i class="bi bi-pencil-square"></i> Tindakan Admin</h5>
            </div>
            <div class="card-body">

                <form action="{{ route('admin.requests.update', $req->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label fw-bold">Update Status</label>
                        <select name="status" class="form-select bg-light">
                            <option value="pending" {{ $req->status == 'pending' ? 'selected' : '' }}>Menunggu (Pending)</option>
                            <option value="processed" {{ $req->status == 'processed' ? 'selected' : '' }}>Sedang Diproses</option>
                            <option value="finished" {{ $req->status == 'finished' ? 'selected' : '' }}>Selesai (Diterima)</option>
                            <option value="rejected" {{ $req->status == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Catatan / Balasan Admin</label>
                        <textarea name="admin_note" class="form-control" rows="5" placeholder="Tulis balasan atau alasan penolakan di sini...">{{ $req->admin_note }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Lampiran Balasan (Opsional)</label>
                        <input type="file" name="reply_file" class="form-control">
                        <small class="text-muted" style="font-size: 11px;">Upload dokumen yang diminta (PDF/Doc) jika ada.</small>
                    </div>

                    <hr>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary fw-bold">Simpan Proses</button>
                        <a href="{{ route('admin.requests.index') }}" class="btn btn-outline-secondary">Kembali</a>
                    </div>

                </form>

            </div>
        </div>
    </div>

</div>
@endsection
