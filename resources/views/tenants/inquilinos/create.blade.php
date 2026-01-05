<x-app-layout>
    <div class="container">
        <h1>Create Tenant</h1>

        <form action="{{ route('tenants.store') }}" method="post">
            @csrf
            <div class="form-group">
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')"
                    required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>


            <div class="flex items-center gap-4">
                <a href="{{ route('tenants.index') }}"
                    class="text-black bg-gray-200 box-border border border-transparent hover:bg-gray-300 focus:ring-4 focus:ring-gray-medium shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none">Cancel</a>
                <button type="submit"
                    class="text-black bg-brand box-border border border-transparent hover:bg-brand-strong focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none">Create
                    Tenant</button>
            </div>
        </form>
    </div>
</x-app-layout>
