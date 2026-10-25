
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tambah Anggota
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="rounded-lg bg-white p-6 shadow">

                @if ($errors->any())
                    <div class="mb-4 rounded bg-red-100 p-4 text-red-700">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('members.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label for="name" class="mb-1 block font-medium">
                            Nama Anggota <span class="text-red-600">*</span>
                        </label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name') }}"
                            required
                            class="w-full rounded-md border-gray-300 shadow-sm"
                        >
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="email" class="mb-1 block font-medium">
                            Email <span class="text-red-600">*</span>
                        </label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            class="w-full rounded-md border-gray-300 shadow-sm"
                        >
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="phone" class="mb-1 block font-medium">
                            Nomor Telepon
                        </label>
                        <input
                            type="text"
                            id="phone"
                            name="phone"
                            value="{{ old('phone') }}"
                            maxlength="20"
                            class="w-full rounded-md border-gray-300 shadow-sm"
                        >
                        @error('phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="address" class="mb-1 block font-medium">
                            Alamat
                        </label>
                        <textarea
                            id="address"
                            name="address"
                            rows="3"
                            class="w-full rounded-md border-gray-300 shadow-sm"
                        >{{ old('address') }}</textarea>
                        @error('address')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex gap-3">
                        <button
                            type="submit"
                            class="rounded-md bg-blue-600 px-4 py-2 text-white hover:bg-blue-700"
                        >
                            Simpan
                        </button>

                        <a
                            href="{{ route('members.index') }}"
                            class="rounded-md border border-gray-300 px-4 py-2 text-gray-700 hover:bg-gray-100"
                        >
                            Kembali
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
