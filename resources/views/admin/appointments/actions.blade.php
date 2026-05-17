<div class="flex items-center gap-2">

    {{-- EDIT BUTTON --}}
    <x-wire-button
        href="{{ route('admin.appointments.edit', $appointment) }}"
        class="!bg-blue-500 !hover:bg-blue-600 !text-white p-2 rounded-md transition-colors border-none"
        xs
    >
        <i class="fa-solid fa-pen-to-square text-sm"></i>
    </x-wire-button>

    {{-- DELETE BUTTON --}}
    <form
        action="{{ route('admin.appointments.destroy', $appointment) }}"
        method="POST"
        class="delete-form inline"
    >
        @csrf
        @method('DELETE')

        <x-wire-button
            type="submit"
            class="!bg-red-500 !hover:bg-red-600 !text-white p-2 rounded-md transition-colors border-none"
            xs
        >
            <i class="fa-solid fa-trash text-sm"></i>
        </x-wire-button>

    </form>

</div>