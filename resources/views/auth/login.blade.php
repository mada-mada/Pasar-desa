<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Pasar Desa Indramayu</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        gold: {
                            DEFAULT: '#D4AF37',
                            light: '#FDE047',
                            dark: '#b5952f'
                        },
                        blue: {
                            deep: '#1E3A8A',
                            light: '#3B82F6',
                            dark: '#1e40af'
                        }
                    }
                }
            }
        }
    </script>
    
    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/user.css') }}">
    <style>
        .login-bg {
            background-color: #1E3A8A;
            background-image: radial-gradient(circle at top right, rgba(212, 175, 55, 0.15), transparent 40%),
                              radial-gradient(circle at bottom left, rgba(59, 130, 246, 0.2), transparent 40%);
        }
        
        .glass-panel {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }
        
        .input-glass {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
            transition: all 0.3s ease;
        }
        .input-glass:focus {
            background: rgba(255, 255, 255, 0.15);
            border-color: #D4AF37;
            box-shadow: 0 0 0 4px rgba(212, 175, 55, 0.2);
            outline: none;
        }
        .input-glass::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }
    </style>
</head>
<body class="login-bg min-h-screen flex items-center justify-center p-4">

    <!-- Decorative elements -->
    <div class="fixed top-0 left-0 w-full h-full overflow-hidden z-0 pointer-events-none">
        <div class="absolute -top-[20%] -left-[10%] w-[50%] h-[50%] rounded-full bg-blue-500 opacity-20 blur-[100px]"></div>
        <div class="absolute bottom-[10%] right-[5%] w-[30%] h-[40%] rounded-full bg-gold opacity-10 blur-[100px]"></div>
    </div>

    <div class="w-full max-w-5xl z-10 flex flex-col md:flex-row rounded-3xl overflow-hidden shadow-[0_20px_60px_-15px_rgba(0,0,0,0.7)] border border-blue-800/50">
        
        <!-- Left Side: Graphic / Info -->
        <div class="hidden md:flex md:w-1/2 bg-blue-deep/80 backdrop-blur-md p-12 flex-col justify-between relative border-r border-white/10">
            <div class="absolute inset-0 bg-gradient-to-br from-blue-deep to-gray-900 opacity-80 z-0"></div>
            
            <div class="relative z-10 flex items-center gap-3 mb-10">
                <div class="w-10 h-10 rounded-full bg-gold flex items-center justify-center">
                    <i class="fas fa-store text-blue-deep text-xl"></i>
                </div>
                <span class="font-bold text-2xl text-white tracking-wide">Pasar<span class="text-gold">Desa</span></span>
            </div>
            
            <div class="relative z-10">
                <h2 class="text-4xl font-extrabold text-white mb-6 leading-tight">Sistem Informasi <br><span class="text-gold text-transparent bg-clip-text bg-gradient-to-r from-gold to-yellow-200">Manajemen Pasar</span></h2>
                <p class="text-blue-200 text-lg leading-relaxed mb-8">
                    Kelola data pasar, jadwal operasional, fasilitas, dan pantau peta ketersebaran wilayah desa dari satu portal administrator yang terpusat.
                </p>
                
                <div class="flex items-center space-x-4 text-sm text-blue-300">
                    <div class="flex flex-col items-center p-3 rounded-xl bg-white/5 backdrop-blur-sm border border-white/5">
                        <i class="fas fa-shield-alt text-2xl text-gold mb-2"></i>
                        <span>Aman</span>
                    </div>
                    <div class="flex flex-col items-center p-3 rounded-xl bg-white/5 backdrop-blur-sm border border-white/5">
                        <i class="fas fa-tachometer-alt text-2xl text-gold mb-2"></i>
                        <span>Cepat</span>
                    </div>
                    <div class="flex flex-col items-center p-3 rounded-xl bg-white/5 backdrop-blur-sm border border-white/5">
                        <i class="fas fa-map-marked text-2xl text-gold mb-2"></i>
                        <span>Terpusat</span>
                    </div>
                </div>
            </div>
            
            <div class="relative z-10 mt-10">
                <a href="{{ route('pasar.index') }}" class="text-blue-300 hover:text-gold transition-colors text-sm flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali ke Halaman Publik
                </a>
            </div>
        </div>

        <!-- Right Side: Login Form -->
        <div class="w-full md:w-1/2 glass-panel p-8 md:p-12 relative">
            <div class="flex flex-col h-full justify-center">
                <div class="text-center mb-10">
                    <div class="md:hidden flex items-center justify-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-full bg-gold flex items-center justify-center">
                            <i class="fas fa-store text-blue-deep text-xl"></i>
                        </div>
                        <span class="font-bold text-2xl text-white tracking-wide">Pasar<span class="text-gold">Desa</span></span>
                    </div>
                    
                    <h3 class="text-3xl font-bold text-white mb-2">Selamat Datang</h3>
                    <p class="text-blue-200">Silakan masuk ke akun Administrator.</p>
                </div>

                @if(session('error'))
                    <div class="bg-red-500/20 border border-red-500 text-red-200 px-4 py-3 rounded-lg mb-6 flex items-start">
                        <i class="fas fa-exclamation-circle mt-1 mr-3 text-red-400"></i>
                        <span class="text-sm">{{ session('error') }}</span>
                    </div>
                @endif
                
                @if($errors->any())
                    <div class="bg-red-500/20 border border-red-500 text-red-200 px-4 py-3 rounded-lg mb-6 flex items-start">
                        <i class="fas fa-exclamation-circle mt-1 mr-3 text-red-400"></i>
                        <span class="text-sm">{{ $errors->first() }}</span>
                    </div>
                @endif

                <form method="POST" action="{{ url('/login') }}" class="space-y-6">
                    @csrf
                    
                    <div>
                        <label for="email" class="block text-sm font-medium text-blue-200 mb-2">Alamat Email</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-envelope text-blue-300"></i>
                            </div>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                                class="input-glass w-full pl-11 pr-4 py-3 rounded-xl text-base" 
                                placeholder="admin@pasardesa.id">
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <label for="password" class="block text-sm font-medium text-blue-200">Password</label>
                        </div>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-blue-300"></i>
                            </div>
                            <input type="password" name="password" id="password" required 
                                class="input-glass w-full pl-11 pr-4 py-3 rounded-xl text-base" 
                                placeholder="••••••••">
                        </div>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-lg text-lg font-bold text-blue-deep bg-gold hover:bg-yellow-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gold focus:ring-offset-gray-900 transition-all transform hover:-translate-y-1">
                            Masuk ke Dashboard <i class="fas fa-sign-in-alt ml-2 mt-1"></i>
                        </button>
                    </div>
                </form>
                
                <div class="mt-8 text-center md:hidden">
                    <a href="{{ route('pasar.index') }}" class="text-blue-300 hover:text-white transition-colors text-sm">
                        <i class="fas fa-arrow-left mr-1"></i> Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
