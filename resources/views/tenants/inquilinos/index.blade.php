<x-app-layout>
    <div class="container">

        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Inquilinos
            </h2>
        </x-slot>
        <div class="mb-4 flex justify-end">
            <a href="{{ route('tenants.create') }}"
                class="text-black bg-brand box-border border border-transparent hover:bg-brand-strong focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none ">Create
                Inquilino</a>
        </div>




        <div class="relative overflow-x-auto bg-neutral-primary-soft shadow-xs rounded-base border border-default">
            <table class="w-full text-sm text-left rtl:text-right text-body">
                <thead class="text-sm text-body bg-neutral-secondary-soft border-b rounded-base border-default">
                    <tr>
                        <th scope="col" class="px-6 py-3 font-medium">
                            ID
                        </th>
                        {{-- <th scope="col" class="px-6 py-3 font-medium">
                            Nombre
                        </th> --}}
                        <th scope="col" class="px-6 py-3 font-medium">
                            Dominio
                        </th>
                        <th scope="col" class="px-6 py-3 font-medium">
                            Acciones
                        </th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($tenants as $tenant)
                        <tr class="bg-neutral-primary border-b border-default">
                            <td class="px-6 py-4">
                                {{ $tenant->id }}
                            </td>
                            {{-- <th scope="row" class="px-6 py-4 font-medium text-heading whitespace-nowrap">
                                {{ $tenant->name }}
                            </th> --}}
                            <td class="px-6 py-4">
                                {{ $tenant->domains->first()->domain }}
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ route('tenants.show', $tenant->id) }}"
                                    class="text-black bg-brand box-border border border-transparent hover:bg-brand-strong focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none">Ver</a>
                                <a href="{{ route('tenants.edit', $tenant->id) }}"
                                    class="text-black bg-brand box-border border border-transparent hover:bg-brand-strong focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none">Editar</a>

                                    <form action="{{ route('tenants.destroy', $tenant->id) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-black bg-brand box-border border border-transparent hover:bg-brand-strong focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none">Eliminar</button>
                                    </form>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</x-app-layout>
