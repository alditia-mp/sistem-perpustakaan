<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <form action="{{ route('users.store') }}" method="POST">
                    @csrf
                    
                    <p>Nama:</p>
                    <input type="text" name="name" value="{{ old('name') }}">
                    @error('name') <span style="color:red">{{ $message }}</span> @enderror
                    <br><br>

                    <p>Email:</p>
                    <input type="email" name="email" value="{{ old('email') }}">
                    @error('email') <span style="color:red">{{ $message }}</span> @enderror
                    <br><br>

                    <p>Password:</p>
                    <input type="password" name="password">
                    @error('password') <span style="color:red">{{ $message }}</span> @enderror
                    <br><br>

                    <p>Role:</p>
                    <select name="role">
                        <option value="">-- Pilih --</option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="petugas" {{ old('role') == 'petugas' ? 'selected' : '' }}>Petugas</option>
                    </select>
                    @error('role') <span style="color:red">{{ $message }}</span> @enderror
                    <br><br>

                    <div class="flex items-center gap-4 mt-4">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Simpan
                        </button>
                        <a href="{{ route('users.index') }}" class="text-gray-600 hover:underline">
                            Batal
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>