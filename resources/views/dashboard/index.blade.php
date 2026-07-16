@extends('layouts.app')

@section('content')
<div class="container animate-fade-in">
    <div class="dashboard-header">
        <h1 class="dashboard-title">Dashboard Sertifikasi</h1>
        <p class="dashboard-subtitle">Pilih bidang sertifikasi untuk mengelola dan mencetak sertifikat.</p>
    </div>

    @if(session('success'))
        <div style="background: #D1FAE5; color: #065F46; padding: 1rem; border-radius: var(--radius-md); margin-bottom: 2rem;">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-3">
        @foreach($categories as $category)
            <a href="{{ route('dashboard.category', $category) }}" class="category-card">
                <div class="category-icon">
                    @if($category->code == 'KPM')
                        <!-- Leadership Icon -->
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                    @elseif($category->code == 'KOM')
                        <!-- Communication Icon -->
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
                    @else
                        <!-- Problem Solving Icon -->
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><path d="M12 16v-4"></path><path d="M12 8h.01"></path></svg>
                    @endif
                </div>
                <h2 class="category-title">{{ $category->name }}</h2>
                <p class="category-desc">{{ $category->description }}</p>
                
                <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid var(--border); padding-top: 1rem;">
                    <span style="font-size: 0.85rem; color: var(--text-muted); font-weight: 500;">Format ID: {{ $category->code }}-...</span>
                    <span class="badge badge-active">{{ $category->certificates_count }} Terbit</span>
                </div>
            </a>
        @endforeach
    </div>
</div>
@endsection
