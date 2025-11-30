<section class="relative py-16 md:py-24 bg-white">
    
    <!-- Background Image -->
    <img src="{{ asset('images/bg-hero.jpg') }}" alt="Event Experience" class="absolute inset-0 w-full h-full object-cover z-0">
    
    <!-- Overlay transparan -->
    <div class="absolute inset-0 bg-white/30 z-1"></div>
    
    <!-- Content -->
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            
            <!-- Heading -->
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6 leading-tight text-white">
                Temukan
                <span class="block text-white">Acara Terbaik</span>
            </h1>
            
            <!-- Description -->
            <p class="text-lg md:text-xl mb-8 text-white max-w-3xl mx-auto leading-relaxed">
                Jelajahi berbagai acara seru di sekitar Anda. Dari konser musik, workshop inspiratif, 
                hingga event olahraga yang tak terlupakan.
            </p>

            <!-- Search Bar -->
            <div class="max-w-2xl mx-auto mb-8">
                <form action="{{ route('events.index') }}" method="GET" class="flex gap-2">
                    <input type="text" 
                           name="search"
                           placeholder="Cari acara, kategori, atau lokasi..."
                           class="flex-1 px-6 py-4 rounded-xl border border-gray-300 text-gray-900 focus:ring-2 focus:ring-[#e692b7] focus:border-[#e692b7] text-lg">
                    <button type="submit" 
                            class="bg-[#262363] text-white px-8 py-4 rounded-xl font-bold hover:bg-[#00183c] transition-colors text-lg">
                        Cari
                    </button>
                </form>
            </div>

            <!-- CTA Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('events.index') }}" 
                   class="bg-[#262363] text-white px-8 py-4 rounded-xl hover:bg-[#00183c] font-bold text-lg transition-all duration-300 shadow-sm text-center">
                    <i class="fas fa-calendar-alt mr-2"></i> Jelajahi Semua Acara
                </a>
                
                @guest
                <a href="{{ route('register') }}" 
                   class="border-2 border-[#e692b7] text-white px-8 py-4 rounded-xl hover:bg-[#b3366c] hover:text-[#fcfcfc] font-bold text-lg transition-all duration-300 text-center">
                    <i class="fas fa-user-plus mr-2"></i> Daftar Sekarang
                </a>
                @endguest
            </div>

        </div>
    </div>
</section>