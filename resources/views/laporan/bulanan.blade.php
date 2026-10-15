@extends('layouts.app')

@section('content')

<style>
    .nav-tabs .nav-link {
        color: #0d6efd;
        font-weight: 600;
        border: 1px solid transparent;
    }
    .nav-tabs .nav-link:hover {
        color: #0a58ca;
    }
    .nav-tabs .nav-link.active {
        color: white !important;
        background-color: #0d6efd !important;
        border-color: #0d6efd #0d6efd #fff;
    }
</style>

<div class="container">
    <h1 class="mb-4">Laporan Bulanan</h1>

    {{-- Nav tabs --}}
    <ul class="nav nav-tabs mb-3" id="laporanTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="pengadaan-tab" data-bs-toggle="tab" data-bs-target="#pengadaan" type="button" role="tab" aria-controls="pengadaan" aria-selected="true">Laporan Bulanan Pengadaan</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="user-tab" data-bs-toggle="tab" data-bs-target="#user" type="button" role="tab" aria-controls="user" aria-selected="false">Daftar User</button>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="monitoring-gr-tab" data-toggle="tab" href="#monitoring-gr" role="tab" aria-controls="monitoring-gr" aria-selected="false">Monitoring GR</a>
        </li>
    </ul>

    {{-- Tab panes --}}
    <div class="tab-content" id="laporanTabContent">
        <div class="tab-pane fade show active" id="pengadaan" role="tabpanel" aria-labelledby="pengadaan-tab">
            @include('laporan.partials.pengadaan')
        </div>

        <div class="tab-pane fade" id="user" role="tabpanel" aria-labelledby="user-tab">
            @include('laporan.partials.user')
        </div>

        <div class="tab-pane fade" id="monitoring-gr" role="tabpanel" aria-labelledby="monitoring-gr-tab">
            @include('laporan.partials.monitoring_gr')
        </div>
    </div>
</div>

@endsection
