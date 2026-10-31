
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Data Anggota
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 rounded bg-green-100 p-4 text-green-800">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 p-4 bg-red-100 text-red-800 rounded">{{ session('error') }}</div>
            @endif

            @if ($errors->any())
                <div class="mb-4 rounded bg-red-100 p-4 text-red-700">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="mb-4 flex flex-wrap items-center justify-between gap-3">
                <form action="{{ route('members.index') }}"
                      method="GET"
                      class="flex gap-2">
                    <input
                        type="text"
                        name="search"
                        value="{{ $search }}"
                        placeholder="Cari nama anggota..."
                        class="rounded-md border-gray-300 shadow-sm"
                    >

                    <button type="submit"
                            class="rounded-md bg-gray-700 px-4 py-2 text-white">
                        Cari
                    </button>

                    @if ($search)
                        <a href="{{ route('members.index') }}"
                           class="rounded-md border px-4 py-2">
                            Reset
                        </a>
                    @endif
                </form>

                <a href="{{ route('members.create') }}"
                   class="rounded-md bg-blue-600 px-4 py-2 text-white">
                    + Tambah Anggota
                </a>
            </div>

            <div class="overflow-x-auto rounded-lg bg-white shadow">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-3 text-left">No.</th>
                            <th class="px-4 py-3 text-left">Nama</th>
                            <th class="px-4 py-3 text-left">Email</th>
                            <th class="px-4 py-3 text-left">Telepon</th>
                            <th class="px-4 py-3 text-left">Alamat</th>
                            <th class="px-4 py-3 text-left">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200">
                        @forelse ($members as $member)
                            <tr>
                                <td class="px-4 py-3">
                                    {{ $members->firstItem() + $loop->index }}
                                </td>
                                <td class="px-4 py-3">
                                    {{ $member->name }}
                                </td>
                                <td class="px-4 py-3">
                                    {{ $member->email }}
                                </td>
                                <td class="px-4 py-3">
                                    {{ $member->phone ?: '-' }}
                                </td>
                                <td class="px-4 py-3">
                                    {{ $member->address ?: '-' }}
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex gap-2">

                                        <a href="{{ route('members.show', $member->id) }}"
                                            class="text-gray-600 hover:underline">
                                            Detail
                                        </a>

                                        <a href="{{ route('members.edit', $member->id) }}"
                                            class="text-blue-600 hover:underline">
                                            Edit
                                        </a>

                                        <form action="{{ route('members.destroy', $member->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('Yakin ingin menghapus anggota ini?')">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="text-red-600 hover:underline">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6"
                                    class="px-4 py-6 text-center text-gray-500">
                                    @if ($search)
                                        Anggota dengan nama "{{ $search }}" tidak ditemukan.
                                    @else
                                        Belum ada data anggota.
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $members->links() }}
            </div>

        </div>
    </div>
</x-app-layout>
