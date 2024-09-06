<x-layout>

    <!-- declaration for the $heading variable we used in our layout.blade file -->
    <x-slot:heading>
        Register
    </x-slot:heading>

    <form method="POST" action="/register">
        @csrf
        <div class="space-y-12">
            <div class="border-b border-gray-900/10 pb-12">
                {{-- <h2 class="text-base font-semibold leading-7 text-gray-900">Profile</h2>
        <p class="mt-1 text-sm leading-6 text-gray-600">This information will be displayed publicly so be careful what you share.</p> --}}

                <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                    <div class="sm:col-span-4">
                        <x-form-label for="first_name">First Name</x-form-label>
                        <div class="mt-2">
                            <x-form-input name='first_name' id='first_name' placeholder="Jon" :value="old('first_name')" required></x-form-input>
                            <x-form-error name="first_name" />
                        </div>
                    </div>
                    <div class="sm:col-span-4">
                        <x-form-label for="last_name">Last Name</x-form-label>
                        <div class="mt-2">
                            <x-form-input name='last_name' id='last_name' placeholder="Doe" :value="old('last_name')" required></x-form-input>
                            <x-form-error name="last_name" />
                        </div>
                    </div>
                    <div class="sm:col-span-4">
                        <x-form-label for="email">Email</x-form-label>
                        <div class="mt-2">
                            <x-form-input name='email' id='email' type="email" placeholder="jondoe@example.com" :value="old('email')" required></x-form-input>
                            <x-form-error name="email" />
                        </div>
                    </div>
                    <div class="sm:col-span-4">
                        <x-form-label for="password">Password</x-form-label>
                        <div class="mt-2">
                            <x-form-input name="password" id="password" type="password" required></x-form-input>
                            <x-form-error name="password" />
                        </div>
                    </div>
                    <div class="sm:col-span-4">
                        <x-form-label for="password">Confirm Password</x-form-label>
                        <div class="mt-2">
                            <x-form-input name="password_confirmation" id="password_confirmation" type="password" required></x-form-input>
                            <x-form-error name="password_confirmation" />
                        </div>
                    </div>

                </div>

                <div class="mt-10">
                    One way to show errors all collectively....?
                    @if ($errors->any())
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li class="text-red-500 italic">{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>

            </div>
        </div>

        <div class="mt-6 flex items-center justify-end gap-x-6">
            <a href="/" class="text-sm font-semibold leading-6 text-gray-900">Cancel</a>
            <x-form-button>Save</x-form-button>
        </div>

    </form>

</x-layout>
