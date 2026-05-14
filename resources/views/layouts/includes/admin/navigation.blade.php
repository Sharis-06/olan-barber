<nav class="fixed top-0 z-50 w-full bg-white border-b border-gray-200">
  <div class="px-3 py-3 lg:px-5 lg:pl-3">
    <div class="flex items-center justify-between">
      <div class="flex items-center justify-start rtl:justify-end">
            <button data-drawer-target="top-bar-sidebar" data-drawer-toggle="top-bar-sidebar" aria-controls="top-bar-sidebar" type="button" class="sm:hidden text-heading bg-transparent box-border border border-transparent hover:bg-neutral-secondary-medium focus:ring-4 focus:ring-neutral-tertiary font-medium leading-5 rounded-base text-sm p-2 focus:outline-none">
                <span class="sr-only">Open sidebar</span>
                <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M5 7h14M5 12h14M5 17h10"/>
                </svg>
            </button>
            <a href="/" class="flex ms-2 md:me-24">
            {{-- <img src="{{asset('images/logo.jpeg')}}" class="h-6 me-3" alt="Olan Barber" /> --}}
            <span class="self-center text-lg font-semibold whitespace-nowrap dark:text-white"></span>
            </a>
        </div>
            <!-- Settings Dropdown -->
            <div class="flex items-center gap-4">
                    <span class="text-sm font-semibold text-gray-700">
                        {{ Auth::user()->name }}
                    </span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="text-sm text-red-500 hover:text-red-700">
                        Cerrar sesión
                    </button>
                </form>
            </div>
    </div>
</nav>