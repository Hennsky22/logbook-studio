
@extends('layouts.app')

@section('title', 'Foto Barang')
@section('page-title', 'Foto Barang')

@section('content')
<div class="page-heading">
    <div>
        <h1>Foto Barang</h1>
        <p>Foto inventaris barang studio.</p>
    </div>
</div>

<div class="card" style="padding:24px;">
    <h2>{{ $item->nama_barang }}</h2>

    @if ($item->foto && \Illuminate\Support\Facades\Storage::disk('public')->exists($item->foto))
        <img
            src="{{ asset('storage/' . $item->foto) }}"
            alt="Foto {{ $item->nama_barang }}"
            style="display:block;max-width:100%;max-height:500px;object-fit:contain;margin:20px auto;border-radius:10px;"
        >
    @else
        <p>Foto barang belum tersedia.</p>
    @endif

    <p><strong>Serial Number:</strong> {{ $item->serial_number ?: '-' }}</p>
    <p><strong>Merk:</strong> {{ $item->merk ?: '-' }}</p>
    <p><strong>Kategori:</strong> {{ $item->kategori }}</p>
    <p><strong>Kondisi:</strong> {{ $item->kondisi_barang }}</p>

    <a href="{{ route('items.index') }}" class="btn btn-outline">
        Kembali ke Inventaris
    </a>
</div>
@endsection
