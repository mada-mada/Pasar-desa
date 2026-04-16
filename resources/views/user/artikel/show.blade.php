@extends('layouts.user')

@section('title', Str::limit($artikel->judul_artikel, 50) . ' - Pasar Desa Indramayu')

@section('content')
<!-- Detail Article Content -->
<div class="bg-gray-50 pb-16">
    <!-- Image Header -->
    <div class="w-full h-64 md:h-96 relative bg-blue-deep relative overflow-hidden shadow-inner">
        @if($artikel->gambar_sampul)
            <img src="{{ asset('storage/' . $artikel->gambar_sampul) }}" class="w-full h-full object-cover opacity-70" alt="{{ $artikel->judul_artikel }}">
            <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-transparent to-transparent"></div>
        @else
            <div class="absolute -top-24 -right-24 w-96 h-96 rounded-full bg-blue-light opacity-10 blur-3xl"></div>
            <div class="w-full h-full flex flex-col items-center justify-center text-blue-200">
                <i class="fas fa-newspaper text-6xl mb-4 opacity-50"></i>
            </div>
            <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-transparent to-transparent"></div>
        @endif
        
        <div class="absolute bottom-0 left-0 w-full">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 pb-8">
                <nav class="flex text-sm text-gray-300 mb-4" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        <li class="inline-flex items-center">
                            <a href="{{ route('artikel.index') }}" class="hover:text-gold transition-colors block py-2 border-b-2 border-transparent hover:border-gold">Daftar Artikel</a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <i class="fas fa-chevron-right text-xs mx-2 opacity-50"></i>
                                <span class="text-white font-medium truncate max-w-[200px]">{{ $artikel->judul_artikel }}</span>
                            </div>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <!-- Article Body -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 -mt-8 relative z-20">
        <div class="bg-white rounded-2xl shadow-xl p-8 md:p-12 border border-blue-50/50">
            <!-- Article Title -->
            <h1 class="text-3xl md:text-5xl font-extrabold text-gray-900 leading-tight mb-6">
                {{ $artikel->judul_artikel }}
            </h1>
            
            <!-- Metadata -->
            <div class="flex flex-wrap items-center text-sm text-gray-500 mb-10 pb-6 border-b border-gray-100 gap-4">
                <div class="flex items-center mr-6">
                    <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center text-blue-deep mr-3 border border-blue-100 shadow-sm">
                        <i class="fas fa-user-edit"></i>
                    </div>
                    <div>
                        <span class="block text-xs uppercase text-gray-400 font-semibold tracking-wider">Ditulis oleh</span>
                        <span class="font-bold text-gray-800">{{ $artikel->penulis->nama_lengkap ?? 'Administrator' }}</span>
                    </div>
                </div>
                
                <div class="flex items-center mr-6">
                    <div class="w-10 h-10 rounded-full bg-amber-50 flex items-center justify-center text-gold mr-3 border border-amber-100 shadow-sm">
                        <i class="far fa-calendar-alt"></i>
                    </div>
                    <div>
                        <span class="block text-xs uppercase text-gray-400 font-semibold tracking-wider">Tanggal Terbit</span>
                        <span class="font-bold text-gray-800">{{ \Carbon\Carbon::parse($artikel->tanggal_rilis)->translatedFormat('d F Y') }}</span>
                    </div>
                </div>
            </div>
            
            <!-- Article Content -->
            <div class="prose prose-lg prose-blue max-w-none text-gray-700 mb-12">
                {!! nl2br(e($artikel->isi_konten)) !!}
            </div>
            
            <!-- Share Section (Decorative) -->
            <div class="pt-8 border-t border-gray-100 flex items-center justify-between">
                <span class="font-bold text-gray-800">Bagikan Artikel Ini:</span>
                <div class="flex space-x-3">
                    <button class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 hover:bg-blue-600 hover:text-white flex items-center justify-center transition-colors">
                        <i class="fab fa-facebook-f"></i>
                    </button>
                    <button class="w-10 h-10 rounded-full bg-sky-100 text-sky-500 hover:bg-sky-500 hover:text-white flex items-center justify-center transition-colors">
                        <i class="fab fa-twitter"></i>
                    </button>
                    <button class="w-10 h-10 rounded-full bg-green-100 text-green-600 hover:bg-green-600 hover:text-white flex items-center justify-center transition-colors">
                        <i class="fab fa-whatsapp"></i>
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Back Button -->
        <div class="mt-8 text-center">
            <a href="{{ route('artikel.index') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg text-blue-deep bg-blue-100 hover:bg-blue-200 transition-colors">
                <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar Artikel
            </a>
        </div>
    </div>
</div>
@endsection
