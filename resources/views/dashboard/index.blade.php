@extends('layouts.app')

@section('content')
<div class="container animate-fade-in">
    <div class="dashboard-header" style="margin-bottom: 2rem;">
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
                @if($category->code == 'KPM')
                    <div class="category-icon" style="background: rgba(59, 130, 246, 0.12); color: #3B82F6;">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                    </div>
                @elseif($category->code == 'KOM')
                    <div class="category-icon" style="background: rgba(16, 185, 129, 0.12); color: #10B981;">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path><path d="M13 8H7"/><path d="M17 12H7"/></svg>
                    </div>
                @else
                    <div class="category-icon" style="background: rgba(245, 158, 11, 0.12); color: #F59E0B;">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 14c.2-1 .7-1.7 1.5-2.5 1-.9 1.5-2.2 1.5-3.5A6 6 0 0 0 6 8c0 1 .2 2.2 1.5 3.5.7.9 1.2 1.5 1.5 2.5"/><path d="M9 18h6"/><path d="M10 22h4"/></svg>
                    </div>
                @endif
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
