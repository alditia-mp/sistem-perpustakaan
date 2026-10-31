<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Detail Anggota</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <dl class="space-y-2">
                    <div><dt class="font-semibold">Nama</dt><dd>{{ $member->name }}</dd></div>
                    <div><dt class="font-semibold">Email</dt><dd>{{ $member->email }}</dd></div>
                    <div><dt class="font-semibold">Telepon</dt><dd>{{ $member->phone ?: '-' }}</dd></div>
                    <div><dt class="font-semibold">Alamat</dt><dd>{{ $member->address ?: '-' }}</dd></div>
                </dl>
                <div class="mt-6 flex gap-3">
                    <a href="{{ route('members.index') }}" class="text-gray-600">Kembali</a>
                    <a href="{{ route('members.edit', $member->id) }}" class="text-yellow-600">Edit</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>