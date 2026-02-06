<nav x-data="{ open: false }" class="bg-gray-900 border-b border-gray-700 shadow-lg">
    <div class="flex justify-between items-center h-16 px-6">
        <!-- Logo -->
        <div class="flex items-center">
            <h1 style="color: gold; font-size: 1.5rem;">ZARMEX</h1>
        </div>
        <!-- Mensaje de bienvenida -->
        <div class="flex items-center space-x-2">
            @auth ('employee')
                <span class="text-gray-300 text-lg">Bienvenido,</span>
                <span class="text-white text-lg font-semibold">{{ Auth::guard('employee')->user()->name }}</span>
                <span class="text-gray-400 text-md">({{ Auth::guard('employee')->user()->rol }})</span>
            @endauth
        </div>

        <!-- Botón de cierre de sesión -->
        <form method="POST" action="{{ route('employee.logout') }}">
            @csrf
            <button type="submit" class="text-white bg-red-600 px-4 py-2 rounded-lg text-lg hover:bg-red-700 transition">
                Cerrar sesión
            </button>
        </form>
    </div>
</nav>