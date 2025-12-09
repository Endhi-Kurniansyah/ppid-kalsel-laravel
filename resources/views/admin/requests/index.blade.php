@extends('layouts.admin')

@section('page-title', 'Data Permohonan Informasi')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>Data Masuk</span>
        <a href="{{ route('requests.print') }}" class="btn btn-danger" target="_blank">
            <i class="bi bi-file-pdf"></i> Cetak Laporan PDF
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped" id="table1">
                <thead>
                    <tr>
                        <th>No Tiket</th>
                        <th>Nama Pemohon</th>
                        <th>Kategori</th>
                        <th>Informasi Diminta</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($requests as $req)
                    <tr>
                        <td>{{ $req->ticket_number }}</td>
                        <td>
                            {{ $req->applicant->name }} <br>
                            <small class="text-muted">{{ $req->applicant->type }}</small>
                        </td>
                        <td>{{ $req->applicant->job ?? '-' }}</td>
                        <td>{{ Str::limit($req->details, 50) }}</td>
                        <td>
                            @if($req->status == 'pending')
                                <span class="badge bg-warning">Menunggu</span>
                            @elseif($req->status == 'accepted')
                                <span class="badge bg-success">Diterima</span>
                            @else
                                <span class="badge bg-danger">Ditolak</span>
                            @endif
                        </td>
                        <td>
                            <a href="#" class="btn btn-sm btn-info">Detail</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Belum ada data permohonan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
