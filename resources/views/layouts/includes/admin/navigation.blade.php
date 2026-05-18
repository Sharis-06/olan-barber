<nav class="fixed top-0 z-50 w-full bg-[#121215]/95 backdrop-blur-md border-b border-[#222227] px-4 py-3 shadow-md shadow-black/10">
  <div class="px-3 lg:px-5 lg:pl-3">
    <div class="flex items-center justify-between">
      <div class="flex items-center justify-start rtl:justify-end">
            <button data-drawer-target="top-bar-sidebar" data-drawer-toggle="top-bar-sidebar" aria-controls="top-bar-sidebar" type="button" class="sm:hidden text-gray-400 bg-transparent border-none hover:text-white focus:outline-none cursor-pointer">
                <span class="sr-only">Open sidebar</span>
                <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M5 7h14M5 12h14M5 17h10"/>
                </svg>
            </button>
            
            <!-- Hidden on desktop/tablets to avoid redundancy with the sidebar, visible on mobile -->
            <a href="/" class="sm:hidden flex ms-2 md:me-24 items-center gap-2">
                <div class="w-8 h-8 rounded-lg overflow-hidden border border-[#c5a880]/30 shadow-sm flex items-center justify-center bg-black">
                    <img src="{{asset('images/logo.jpeg')}}" class="h-full object-cover" alt="Olan Barber" />
                </div>
                <span class="self-center text-lg font-black tracking-widest text-[#f4f4f6] uppercase">OLAN <span class="text-[#c5a880]">BARBER</span></span>
            </a>
        </div>
            
            <!-- User Settings -->
            <div class="flex items-center gap-6">
                <span class="text-sm font-bold text-[#c5a880] flex items-center gap-2 bg-[#1c1c21] border border-[#2e2e36] px-3 py-1.5 rounded-full shadow-sm">
                    <i class="fa-solid fa-circle-user text-base"></i>
                    {{ Auth::user()->name }}
                </span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="text-sm font-bold text-red-400 hover:text-red-300 transition-colors border-none bg-transparent cursor-pointer flex items-center gap-1.5">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                        Cerrar sesión
                    </button>
                </form>
            </div>
    </div>
  </div>
</nav>