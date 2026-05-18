{{-- Verificar si hay un elemento en el arreglo breadcrumbs --}}
@if(isset($breadcrumbs) && count($breadcrumbs))
    <nav class="mb-4 block font-sans">
        <ol class="flex flex-wrap text-gray-400 text-xs font-semibold uppercase tracking-wider mb-2">
            @foreach ($breadcrumbs as $item)
                <li class="flex items-center">
                    @unless ($loop->first)
                        <span class="px-2 text-gray-600">/</span>
                    @endunless
                    
                    @isset($item['href'])
                        <a href="{{$item['href']}}" class="text-gray-400 hover:text-[#c5a880] transition-colors">
                            {{ $item['name'] }}
                        </a> 
                    @else
                        <span class="text-[#c5a880]/90">{{$item['name']}}</span>
                    @endisset
                </li>
            @endforeach
        </ol>
        
        @if (count($breadcrumbs) > 0)
            <h1 class="text-3xl font-black text-[#f4f4f6] tracking-tight">
                {{ end($breadcrumbs)['name'] }}
            </h1>
        @endif
    </nav>
@endif