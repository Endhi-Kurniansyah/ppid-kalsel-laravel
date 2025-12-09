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
                    {!! $page->content !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
