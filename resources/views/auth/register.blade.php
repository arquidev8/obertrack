<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Tipo de Usuario -->
        <div class="mt-4">
            <x-input-label for="tipo_usuario" :value="__('Tipo de Usuario')" />
            <select id="tipo_usuario" class="block mt-1 w-full" name="tipo_usuario" required>
                <option value="">Seleccione...</option>
                <option value="empleador">Empresa</option>
                <option value="empleado">Profesional</option>
            </select>
            <x-input-error :messages="$errors->get('tipo_usuario')" class="mt-2" />
        </div>

       
        <div class="form-group">
    <label for="empleado_por_id" id="empleado_por_id_label">Seleccionar Empresa</label>

    <select name="empleado_por_id" id="empleado_por_id" class="form-control mt-1 w-full">
        <option value="">Seleccione una Empresa</option>
        @foreach ($empleadores as $empleadorId => $nombreEmpleador)
            <option value="{{ $empleadorId }}">{{ $nombreEmpleador }}</option>
        @endforeach
    </select>
</div>



        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>


    </form>

    <script>
$(document).ready(function() {
    // Escucha el evento change en el selector tipo_usuario
    $('#tipo_usuario').change(function() {
        var selectedValue = $(this).val();
        var labelSelector = '#empleado_por_id_label'; // ID del label para referenciarlo

        if (selectedValue === 'empleado' || selectedValue === '') { // Si se selecciona Empleador o está vacío
            $(labelSelector).show(); // Muestra el label
            $('#empleado_por_id').show(); // Muestra el selector de Empleador
        } else { // Para cualquier otro valor, como Empleado
            $(labelSelector).hide(); // Oculta el label
            $('#empleado_por_id').hide(); // Oculta el selector de Empleador
        }
    });

    // Inicialmente oculta el selector de Empleador y su label si el valor inicial no es Empleador
    $('#tipo_usuario').trigger('change');
});
</script>


    {{-- <script>
$(document).ready(function() {
    // Escucha el evento change en el selector tipo_usuario
    $('#tipo_usuario').change(function() {
        var selectedValue = $(this).val();

        if (selectedValue === 'empleado' || selectedValue === '') { // Si se selecciona Empleador o está vacío
            $('#empleado_por_id').show(); // Muestra el selector de Empleador
        } else { // Para cualquier otro valor, como Empleado
            $('#empleado_por_id').hide(); // Oculta el selector de Empleador
        }
    });

    // Inicialmente oculta el selector de Empleador si el valor inicial no es Empleador
    $('#tipo_usuario').trigger('change');
});
</script> --}}

</x-guest-layout>
