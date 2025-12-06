{{-- resources/views/components/layout/footer.blade.php --}}
<footer class="bg-[#262363] text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- Brand Column -->
            <div class="col-span-1 md:col-span-2">
                <div class="flex items-center mb-4">
                    <img src="{{ asset('images/logo.jpg') }}" 
                         alt="Eventify Logo" 
                         class="h-10 w-15 mr-3">
                </div>
                <p class="text-gray-300 mb-6 max-w-md">
                    Platform terpercaya untuk menemukan dan memesan acara terbaik. Dari konser hingga konferensi, kami menghadirkan pengalaman terbaik untuk Anda.
                </p>
                
                <!-- Contact Information -->
                <div class="space-y-3 mb-6">
                    <div class="flex items-center text-gray-300">
                        <div class="w-8 h-8 bg-green-500 rounded-lg flex items-center justify-center mr-3">
                            <i class="fab fa-whatsapp text-white text-sm"></i>
                        </div>
                        <div>
                            <div class="text-sm font-medium text-white">WhatsApp</div>
                            <div class="text-gray-300 text-sm">+62 858 1150 0889</div>
                        </div>
                    </div>
                    
                    <div class="flex items-center text-gray-300">
                        <div class="w-8 h-8 bg-[#e6527b] rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-envelope text-white text-sm"></i>
                        </div>
                        <div>
                            <div class="text-sm font-medium text-white">Email</div>
                            <div class="text-gray-300 text-sm">cs@eventify@gmail.com</div>
                        </div>
                    </div>
                    
                    <div class="flex items-center text-gray-300">
                        <div class="w-8 h-8 bg-pink-500 rounded-lg flex items-center justify-center mr-3">
                            <i class="fab fa-instagram text-white text-sm"></i>
                        </div>
                        <div>
                            <div class="text-sm font-medium text-white">Instagram</div>
                            <div class="text-gray-300 text-sm">@eventify_</div>
                        </div>
                    </div>
                </div>

                <!-- Social Media -->
                <div class="flex space-x-4">
                    <a href="#" class="w-10 h-10 bg-[#00183c] rounded-lg flex items-center justify-center hover:bg-[#e6527b] text-white transition-colors">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="w-10 h-10 bg-[#00183c] rounded-lg flex items-center justify-center hover:bg-[#e6527b] text-white transition-colors">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="https://instagram.com/eventify_" class="w-10 h-10 bg-[#00183c] rounded-lg flex items-center justify-center hover:bg-[#e6527b] text-white transition-colors">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="w-10 h-10 bg-[#00183c] rounded-lg flex items-center justify-center hover:bg-[#e6527b] text-white transition-colors">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                </div>
            </div>

            <!-- Quick Links -->
            <div>
                <h3 class="font-semibold text-lg mb-4 text-white">Tautan Cepat</h3>
                <ul class="space-y-2">
                    <li><a href="{{ route('home') }}" class="text-gray-300 hover:text-[#e692b7] transition-colors">Beranda</a></li>
                    <li><a href="{{ route('events.index') }}" class="text-gray-300 hover:text-[#e692b7] transition-colors">Acara</a></li>
                    <li><a href="#" class="text-gray-300 hover:text-[#e692b7] transition-colors">Tentang Kami</a></li>
                    <li><a href="#" class="text-gray-300 hover:text-[#e692b7] transition-colors">Kontak</a></li>
                    <li><a href="#" class="text-gray-300 hover:text-[#e692b7] transition-colors">FAQ</a></li>
                </ul>
            </div>

            <!-- Support -->
            <div>
                <h3 class="font-semibold text-lg mb-4 text-white">Dukungan</h3>
                <ul class="space-y-2">
                    <li><a href="#" class="text-gray-300 hover:text-[#e692b7] transition-colors">Pusat Bantuan</a></li>
                    <li><a href="#" class="text-gray-300 hover:text-[#e692b7] transition-colors">Kebijakan Privasi</a></li>
                    <li><a href="#" class="text-gray-300 hover:text-[#e692b7] transition-colors">Syarat & Ketentuan</a></li>
                    <li><a href="#" class="text-gray-300 hover:text-[#e692b7] transition-colors">Kebijakan Pengembalian</a></li>
                    <li><a href="#" class="text-gray-300 hover:text-[#e692b7] transition-colors">Sumber Daya Organizer</a></li>
                </ul>
            </div>
        </div>

        <!-- Bottom Bar -->
        <div class="border-t border-gray-600 mt-8 pt-8 flex flex-col md:flex-row justify-between items-center">
            <p class="text-gray-300 text-sm">
                &copy; {{ date('Y') }} Eventify. Semua hak dilindungi.
            </p>
            <div class="flex space-x-6 mt-4 md:mt-0">
                <a href="#" class="text-gray-300 hover:text-[#e692b7] text-sm transition-colors">Privasi</a>
                <a href="#" class="text-gray-300 hover:text-[#e692b7] text-sm transition-colors">Syarat</a>
                <a href="#" class="text-gray-300 hover:text-[#e692b7] text-sm transition-colors">Peta Situs</a>
            </div>
        </div>
    </div>
</footer>