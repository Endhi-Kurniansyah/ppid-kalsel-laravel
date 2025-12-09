@extends('layouts.admin')

@section('page-title', 'Laporan Survei Kepuasan (IKM)')

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h4>Statistik Penilaian</h4>
                <a href="{{ route('surveys.print') }}" class="btn btn-danger" target="_blank">
                    <i class="bi bi-printer"></i> Cetak Laporan
                </a>
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach($results as $res)
                    <div class="col-md-2 text-center border-end">
                        <h2 class="text-primary">{{ $res->total }}</h2>
                        <p class="text-muted">
                            @if($res->rating == 5) Sangat Puas
                            @elseif($res->rating == 4) Puas
                            @elseif($res->rating == 3) Cukup
                            @else Kurang Puas
                            @endif
                        </p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card">
            <div class="card-header">Detail Masukan Masyarakat</div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Waktu</th>
                            <th>Rating</th>
                            <th>Saran/Masukan</th>
                            <th>IP Address</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($surveys as $s)
                        <tr>
                            <td>{{ $s->created_at->format('d M Y H:i') }}</td>
                            <td>
                                <span class="badge bg-{{ $s->rating >= 4 ? 'success' : ($s->rating == 3 ? 'warning' : 'danger') }}">
                                    {{ $s->rating }} Bintang
                                </span>
                            </td>
                            <td>{{ $s->feedback ?? '-' }}</td>
                            <td>{{ $s->ip_address }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-center">Belum ada data survei.</td></tr>
                        @endforelse
                    </tbody>
                </table>
                {{ $surveys->links() }} </div>
        </div>
    </div>
</div>
@endsection
