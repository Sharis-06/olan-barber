<div class="flex items-center gap-2">

    {{-- EDIT BUTTON (Barber Pole Blue) --}}
    <a
        href="{{ route('admin.appointments.edit', $appointment) }}"
        class="bg-gradient-to-r from-[#1e40af] to-[#2563eb] hover:from-[#2563eb] hover:to-[#3b82f6] text-white p-2 rounded-xl transition-all duration-300 shadow-md shadow-blue-950/40 border border-blue-500/20 flex items-center justify-center transform hover:scale-110 active:scale-95 cursor-pointer w-8 h-8"
        title="Editar Cita"
    >
        <i class="fa-solid fa-pen-to-square text-sm"></i>
    </a>

    {{-- PDF BUTTON (Barber Pole Gold) --}}
    <a
        href="{{ route('admin.appointments.pdf', $appointment) }}"
        target="_blank"
        class="bg-gradient-to-r from-[#a2835b] to-[#c5a880] hover:from-[#c5a880] hover:to-[#d4b790] text-black font-extrabold p-2 rounded-xl transition-all duration-300 shadow-md shadow-[#c5a880]/20 border border-[#c5a880]/30 flex items-center justify-center transform hover:scale-110 active:scale-95 cursor-pointer w-8 h-8"
        title="Ver Comprobante PDF"
    >
        <i class="fa-solid fa-file-pdf text-sm"></i>
    </a>

    {{-- DELETE BUTTON (Barber Pole Red) --}}
    <form
        action="{{ route('admin.appointments.destroy', $appointment) }}"
        method="POST"
        class="delete-form inline"
    >
        @csrf
        @method('DELETE')

        <button
            type="submit"
            class="bg-gradient-to-r from-[#991b1b] to-[#dc2626] hover:from-[#dc2626] hover:to-[#ef4444] text-white p-2 rounded-xl transition-all duration-300 shadow-md shadow-red-950/40 border border-red-500/20 flex items-center justify-center transform hover:scale-110 active:scale-95 cursor-pointer w-8 h-8"
            title="Eliminar Cita"
        >
            <i class="fa-solid fa-trash text-sm"></i>
        </button>

    </form>

</div>