@extends('layouts.admin')

@section('page-title', 'Daftar Permohonan Informasi')

@section('content')

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Data Masuk</h5>

        <a href="{{ route('admin.requests.print') }}" class="btn btn-danger btn-sm" target="_blank">
            <i class="bi bi-file-pdf-fill"></i> Cetak Laporan
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover" id="table1">
                <thead>
                    <tr>
                        <th>Tiket</th>
                        <th>Tgl Masuk</th>
                        <th>Nama Pemohon</th>
                        <th>Kebutuhan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($requests as $req)
                    <tr>
                        <td>
                            <span class="fw-bold text-primary">{{ $req->ticket_number }}</span>
                        </td>
                        <td>{{ $req->created_at->format('d M Y') }}</td>
                        <td>
                            {{ $req->name }}
                            <br>
                            <small class="text-muted">{{ $req->phone }}</small>
                        </td>
                        <td>
                            {{ Str::limit($req->details, 40) }}
                        </td>
                        <td>
                            @if($req->status == 'pending')
                                <span class="badge bg-warning text-dark">Menunggu</span>
                            @elseif($req->status == 'processed')
                                <span class="badge bg-info text-dark">Diproses</span>
                            @elseif($req->status == 'finished')
                                <span class="badge bg-success">Selesai</span>
                            @elseif($req->status == 'rejected')
                                <span class="badge bg-danger">Ditolak</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.requests.show', $req->id) }}" class="btn btn-primary btn-sm">
                                <i class="bi bi-eye"></i> Proses
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <img src="https://cdni.iconscout.com/illustration/premium/thumb/empty-box-4085812-3385481.png" style="width: 100px; opacity: 0.5;">
                            <p class="mt-2">Belum ada permohonan informasi baru.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
