@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}?v=3">
@endpush

@section('title', 'Dashboard - Logbook Studio')
@section('page-title', 'Dashboard')

@section('content')

<div class="studio-dashboard">

    <div class="studio-dashboard-heading">
        <h1>Dashboard</h1>
        <p>
            Pilih studio untuk melihat inventaris dan mengelola
            pemeliharaan barang.
        </p>
    </div>

    <div class="studio-selection">

        {{-- KARTU MASTER CONTROL ROOM --}}
        <a href="{{ route('items.index', ['studio' => 'Master Control Room']) }}"
           class="studio-card">

            <div class="studio-card-image">
                <div class="studio-image-placeholder">
                    <svg viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="1.5">
                        <rect x="3" y="4" width="18" height="13" rx="2"/>
                        <path d="M8 21h8M12 17v4M7 8h4M7 12h10"/>
                    </svg>
                    <span>Foto Master Control Room</span>
                </div>

                <img
                    src="{{ asset('images/studios/mcr.jpeg') }}"
                    alt="Foto Master Control Room"
                    onerror="this.style.display='none'"
                >
            </div>

            <div class="studio-card-content">
                <span class="studio-card-number">STUDIO 01</span>
                <h2>Master Control Room</h2>
                <p>
                    Inventaris dan pemeliharaan barang
                    Master Control Room.
                </p>
            </div>

            <div class="studio-card-footer">
                <span>Buka Studio</span>
                <span class="studio-card-arrow">→</span>
            </div>
        </a>

        {{-- KARTU STUDIO BERITA --}}
        <a href="{{ route('items.index', ['studio' => 'Studio Berita']) }}"
           class="studio-card">

            <div class="studio-card-image">
                <div class="studio-image-placeholder">
                    <svg viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="1.5">
                        <rect x="3" y="4" width="18" height="16" rx="2"/>
                        <path d="M7 8h10M7 12h10M7 16h6"/>
                    </svg>
                    <span>Foto Studio Berita</span>
                </div>

                <img
                    src="{{ asset('images/studios/berita.jpeg') }}"
                    alt="Foto Studio Berita"
                    onerror="this.style.display='none'"
                >
            </div>

            <div class="studio-card-content">
                <span class="studio-card-number">STUDIO 02</span>
                <h2>Studio Berita</h2>
                <p>
                    Inventaris dan pemeliharaan barang
                    Studio Berita.
                </p>
            </div>

            <div class="studio-card-footer">
                <span>Buka Studio</span>
                <span class="studio-card-arrow">→</span>
            </div>
        </a>

        {{-- KARTU STUDIO PENYIARAN --}}
        <a href="{{ route('items.index', ['studio' => 'Studio Penyiaran']) }}"
           class="studio-card">

            <div class="studio-card-image">
                <div class="studio-image-placeholder">
                    <svg viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="1.5">
                        <path d="M5 9a10 10 0 0 1 14 0"/>
                        <path d="M8 12a6 6 0 0 1 8 0"/>
                        <path d="M10.5 15a2.5 2.5 0 0 1 3 0"/>
                        <circle cx="12" cy="18" r="1"/>
                    </svg>
                    <span>Foto Studio Penyiaran</span>
                </div>

                <img
                    src="{{ asset('images/studios/penyiaran.jpeg') }}"
                    alt="Foto Studio Penyiaran"
                    onerror="this.style.display='none'"
                >
            </div>

            <div class="studio-card-content">
                <span class="studio-card-number">STUDIO 03</span>
                <h2>Studio Penyiaran</h2>
                <p>
                    Inventaris dan pemeliharaan barang
                    Studio Penyiaran.
                </p>
            </div>

            <div class="studio-card-footer">
                <span>Buka Studio</span>
                <span class="studio-card-arrow">→</span>
            </div>
        </a>

    </div>
</div>

@endsection