@extends('layouts.app')

@section('content')
<div class="container animate-fade-in">
    <div class="dashboard-header">
        <h1 class="dashboard-title">Dashboard Sertifikasi</h1>
        <p class="dashboard-subtitle">Pilih bidang sertifikasi untuk mengelola dan mencetak sertifikat peserta.</p>
    </div>

    @if(session('success'))
        <div class="toast toast-success">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-3" style="margin-bottom: 3rem;">
        @foreach($categories as $category)
            <a href="{{ route('dashboard.category', $category) }}" class="category-card">
                <div class="category-icon">
                    @if($category->code == 'KPM')
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                    @elseif($category->code == 'KOM')
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
                    @else
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                    @endif
                </div>
                <h2 class="category-title">{{ $category->name }}</h2>
                <p class="category-desc">{{ $category->description ?? 'Kelola sertifikat untuk bidang ' . $category->name }}</p>
                
                <div class="category-footer">
                    <span style="font-size: 0.75rem; color: var(--text-muted); font-weight: 500; font-family: monospace; letter-spacing: 0.03em;">{{ $category->code }}</span>
                    <span class="badge badge-success">{{ $category->certificates_count }} Sertifikat</span>
                </div>
            </a>
        @endforeach
    </div>
</div>
@endsection
