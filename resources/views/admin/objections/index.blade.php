@extends('layouts.admin')

@section('page-title', 'Daftar Pengajuan Keberatan')

@section('content')

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Data Keberatan Masuk</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover" id="table1">
                <thead>
                    <tr>
                        <th>Kode Reg.</th>
                        <th>Tgl Pengajuan</th>
                        <th>Tiket Asal</th>
                        <th>Alasan Keberatan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($objections as $obj)
                    <tr>
                        <td><span class="fw-bold text-danger">{{ $obj->objection_code }}</span></td>
                        <td>{{ $obj->created_at->format('d M Y') }}</td>
                        <td>
                            <small class="text-muted">{{ $obj->request->ticket_number }}</small><br>
                            {{ $obj->request->name }}
                        </td>
                        <td>{{ Str::limit($obj->reason, 30) }}</td>
                        <td>
                            @if($obj->status == 'pending')
                                <span class="badge bg-warning text-dark">Menunggu</span>
                            @elseif($obj->status == 'processed')
                                <span class="badge bg-info">Diproses</span>
                            @elseif($obj->status == 'finished')
                                <span class="badge bg-success">Selesai</span>
                            @else
                                <span class="badge bg-danger">Ditolak</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.objections.show', $obj->id) }}" class="btn btn-danger btn-sm">
                                <i class="bi bi-pencil-square"></i> Tindak Lanjuti
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">Belum ada pengajuan keberatan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
