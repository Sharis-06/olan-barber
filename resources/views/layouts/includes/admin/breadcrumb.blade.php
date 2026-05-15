{{-- Verificar si hay un elemento en el arreglo breadcrumbs --}}
@if(isset($breadcrumbs) && count($breadcrumbs))
    <nav class="mb-4 block">
        <ol class="flex flex-wrap text-gray-500 text-sm mb-1">
            @foreach ($breadcrumbs as $item)
                <li class="flex items-center">
                    @unless ($loop->first)
                        <span class="px-2 text-gray-300">/</span>
                    @endunless
                    
                    @isset($item['href'])
                        <a href="{{$item['href']}}" class="hover:text-gray-700 transition-colors">
                            {{ $item['name'] }}
                        </a> 
                    @else
                        <span class="text-gray-400">{{$item['name']}}</span>
                    @endisset
                </li>
            @endforeach
        </ol>
        
        @if (count($breadcrumbs) > 0)
            <h1 class="text-2xl font-bold text-gray-900">
                {{ end($breadcrumbs)['name'] }}
            </h1>
        @endif
    </nav>
@endif