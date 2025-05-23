<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="bg-white shadow sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    @isset($permission) Éditer la permission @else Créer une nouvelle permission @endisset
                </h3>
            </div>

            <div class="px-4 py-5 sm:p-6">
                <form method="POST" action="@isset($permission) {{ route('diamanka.permissions.update', $permission->id) }} @else {{ route('diamanka.permissions.store') }} @endisset">
                    @csrf
                    @isset($permission) @method('PUT') @endisset

                    <!-- Nom de la permission -->
                    <div class="mb-6">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nom technique</label>
                        <input type="text" id="name" name="name" value="{{ $permission->name ?? old('name') }}" 
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm" 
                            placeholder="ex: users.create" required>
                        <p class="mt-1 text-xs text-gray-500">Format exemple : [models].[action]</p>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Rôles associés (seulement en édition) -->
                    @isset($permission)
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Rôles avec cette permission</label>
                        <div class="space-y-2">
                            @foreach($roles as $role)
                            <div class="flex items-center">
                                <input id="role-{{ $role->id }}" type="checkbox" 
                                    class="focus:ring-emerald-500 h-4 w-4 text-emerald-600 border-gray-300 rounded"
                                    @checked($role->hasPermissionTo($permission)) disabled>
                                <label for="role-{{ $role->id }}" class="ml-3 text-sm text-gray-700">
                                    {{ $role->name }}
                                </label>
                            </div>
                            @endforeach
                        </div>
                        <p class="mt-2 text-xs text-gray-500">
                            Modifiez les permissions depuis la <a href="{{ route('diamanka.roles.index') }}" class="text-emerald-600 hover:underline">gestion des rôles</a>.
                        </p>
                    </div>
                    @endisset

                    <!-- Boutons -->
                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('diamanka.permissions.index') }}" 
                        class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                            Annuler
                        </a>
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                            @isset($permission) Mettre à jour @else Enregistrer @endisset
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
</x-app-layout>
