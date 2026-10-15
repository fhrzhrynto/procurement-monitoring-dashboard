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
    <h1 class="mb-4">Persiapan Pengadaan</h1>

    {{-- Nav tabs --}}
    <ul class="nav nav-tabs mb-3" id="persiapanTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="tab1-tab" data-bs-toggle="tab" data-bs-target="#tab1" type="button" role="tab" aria-controls="tab1" aria-selected="true">Daftar Proyek</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="tab2-tab" data-bs-toggle="tab" data-bs-target="#tab2" type="button" role="tab" aria-controls="tab2" aria-selected="false">Plan Pengajuan</button>
        </li>
    </ul>

    {{-- Tab panes --}}
    <div class="tab-content" id="persiapanTabContent">
        <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="tab1-tab">
            @include('persiapan_pengadaan.partials.tab1')
        </div>

        <div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="tab2-tab">
            @include('persiapan_pengadaan.partials.tab2')
        </div>
    </div>
</div>

<script>
    function setupTableSearch(inputId, tableId) {
        const input = document.getElementById(inputId);
        const table = document.getElementById(tableId);
        input.addEventListener('keyup', function () {
            const filter = input.value.toLowerCase();
            const rows = table.getElementsByTagName('tr');
            for (let i = 0; i < rows.length; i++) {
                const rowText = rows[i].textContent.toLowerCase();
                rows[i].style.display = rowText.includes(filter) ? '' : 'none';
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        setupTableSearch('searchTab1', 'tab1Table');
        setupTableSearch('searchTab2', 'tab2Table');
    });
</script>

@endsection