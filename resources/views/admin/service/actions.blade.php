<div class="flex items-center gap-2">

    {{-- BOTÓN EDITAR --}}
    <x-wire-button
        href="{{ route('admin.service.edit', $service) }}"
        class="!bg-blue-500 hover:!bg-blue-600 !text-white p-2 rounded-md transition-colors border-none"
        xs
    >
        <i class="fa-solid fa-pen-to-square text-sm"></i>
    </x-wire-button>

    {{-- BOTÓN ELIMINAR --}}
    <form action="{{ route('admin.service.destroy', $service) }}"
          method="POST"
          class="delete-form inline">

        @csrf
        @method('DELETE')

        <x-wire-button
            type="submit"
            class="!bg-red-500 hover:!bg-red-600 !text-white p-2 rounded-md transition-colors border-none"
            xs
        >
            <i class="fa-solid fa-trash text-sm"></i>
        </x-wire-button>

    </form>

</div>