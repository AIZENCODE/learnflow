<x-app-layout>
    <div class="container">
        <h1>Edit Tenant</h1>

        <form action="{{ route('tenants.update', $tenant->id) }}" method="post">
            @csrf
            @method('PUT')
            <div class="form-group">
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="id" :value="$tenant->name ?? old('name')"
                    required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <button type="submit"
                class="text-black bg-brand box-border border border-transparent hover:bg-brand-strong focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none">Update
                Tenant</button>
        </form>
    </div>
</x-app-layout>
