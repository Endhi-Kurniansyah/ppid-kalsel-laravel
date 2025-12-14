@extends('layouts.admin')

@section('page-title', 'Dashboard Overview')

@section('content')
<div class="row">

    <div class="col-6 col-lg-3 col-md-6">
        <div class="card bg-warning text-dark shadow-sm">
            <div class="card-body px-3 py-4-5">
                <div class="row">
                    <div class="col-md-4">
                        <div class="stats-icon white text-warning">
                            <i class="bi bi-exclamation-circle-fill"></i>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <h6 class="text-dark font-semibold">Menunggu Proses</h6>
                        <h3 class="font-extrabold mb-0">{{ $pendingRequests }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-6 col-lg-3 col-md-6">
        <div class="card bg-primary text-white shadow-sm">
            <div class="card-body px-3 py-4-5">
                <div class="row">
                    <div class="col-md-4">
                        <div class="stats-icon white text-primary">
                            <i class="bi bi-inbox-fill"></i>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <h6 class="text-white font-semibold">Total Permohonan</h6>
                        <h3 class="font-extrabold mb-0">{{ $totalRequests }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-6 col-lg-3 col-md-6">
        <div class="card bg-success text-white shadow-sm">
            <div class="card-body px-3 py-4-5">
                <div class="row">
                    <div class="col-md-4">
                        <div class="stats-icon white text-success">
                            <i class="bi bi-newspaper"></i>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <h6 class="text-white font-semibold">Berita Terbit</h6>
                        <h3 class="font-extrabold mb-0">{{ $totalPosts }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-6 col-lg-3 col-md-6">
        <div class="card bg-danger text-white shadow-sm">
            <div class="card-body px-3 py-4-5">
                <div class="row">
                    <div class="col-md-4">
                        <div class="stats-icon white text-danger">
                            <i class="bi bi-file-earmark-pdf-fill"></i>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <h6 class="text-white font-semibold">Dokumen Publik</h6>
                        <h3 class="font-extrabold mb-0">{{ $totalDocs }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header">
                <h5 class="mb-0">Permohonan Informasi Terbaru</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-lg">
                        <thead>
                            <tr>
                                <th>Tiket</th>
                                <th>Nama Pemohon</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($latestRequests as $req)
                            <tr>
                                <td class="fw-bold">{{ $req->ticket_number }}</td>
                                <td>{{ $req->name }}</td>
                                <td>{{ $req->created_at->format('d M Y') }}</td>
                                <td>
                                    @if($req->status == 'pending')
                                        <span class="badge bg-warning text-dark">Menunggu</span>
                                    @elseif($req->status == 'processed')
                                        <span class="badge bg-info">Diproses</span>
                                    @elseif($req->status == 'finished')
                                        <span class="badge bg-success">Selesai</span>
                                    @else
                                        <span class="badge bg-danger">Ditolak</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.requests.show', $req->id) }}" class="btn btn-sm btn-primary">Proses</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">Belum ada data masuk.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="text-end mt-3">
                    <a href="{{ route('admin.requests.index') }}" class="btn btn-outline-primary btn-sm">Lihat Semua Permohonan <i class="bi bi-arrow-right"></i></a>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
