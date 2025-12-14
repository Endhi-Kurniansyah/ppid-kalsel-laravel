@extends('layouts.admin')

@section('page-title', 'Proses Keberatan')

@section('content')
<div class="row">

    <div class="col-md-7">
        <div class="card border-danger shadow-sm">
            <div class="card-header bg-danger text-white">
                <h6 class="mb-0 text-white">Detail Keberatan: {{ $objection->objection_code }}</h6>
            </div>
            <div class="card-body">

                <div class="mb-3">
                    <small class="text-muted fw-bold">Alasan Keberatan:</small>
                    <p class="fs-5 fw-bold">{{ $objection->reason }}</p>
                </div>

                <div class="mb-3">
                    <small class="text-muted fw-bold">Kasus Posisi (Kronologi):</small>
                    <div class="alert alert-light border">
                        {{ $objection->description }}
                    </div>
                </div>

                <hr>

                <h6 class="text-muted mb-3">Data Permohonan Asal ({{ $objection->request->ticket_number }})</h6>
                <table class="table table-sm table-borderless">
                    <tr>
                        <td width="30%">Nama Pemohon</td>
                        <td>: {{ $objection->request->name }}</td>
                    </tr>
                    <tr>
                        <td>Informasi Diminta</td>
                        <td>: {{ $objection->request->details }}</td>
                    </tr>
                    <tr>
                        <td>Status Awal</td>
                        <td>: <span class="badge bg-secondary">{{ $objection->request->status }}</span></td>
                    </tr>
                </table>

            </div>
        </div>
    </div>

    <div class="col-md-5">
        <div class="card shadow-sm">
            <div class="card-header bg-light">
                <h6 class="mb-0 fw-bold">Tanggapan Atasan PPID</h6>
            </div>
            <div class="card-body">

                <form action="{{ route('admin.objections.update', $objection->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label fw-bold">Keputusan</label>
                        <select name="status" class="form-select" required>
                            <option value="pending" {{ $objection->status == 'pending' ? 'selected' : '' }}>Menunggu</option>
                            <option value="processed" {{ $objection->status == 'processed' ? 'selected' : '' }}>Sedang Diproses</option>
                            <option value="finished" {{ $objection->status == 'finished' ? 'selected' : '' }}>Keberatan Diterima (Selesai)</option>
                            <option value="rejected" {{ $objection->status == 'rejected' ? 'selected' : '' }}>Keberatan Ditolak</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Isi Tanggapan / Keputusan</label>
                        <textarea name="admin_note" class="form-control" rows="6" placeholder="Masukkan tanggapan resmi atas keberatan ini..." required>{{ $objection->admin_note }}</textarea>
                        <small class="text-muted">Tanggapan ini akan bisa dilihat oleh pemohon.</small>
                    </div>

                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" class="btn btn-primary fw-bold">Simpan Keputusan</button>
                        <a href="{{ route('admin.objections.index') }}" class="btn btn-outline-secondary">Kembali</a>
                    </div>

                </form>

            </div>
        </div>
    </div>

</div>
@endsection
