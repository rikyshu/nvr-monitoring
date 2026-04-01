<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            Ubah Data Pengguna NVR
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('cms.users.update', $user->id) }}">
                        @csrf
                        @method('PUT')
                        
                        <!-- Name -->
                        <div class="mb-4">
                            <label for="name" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Nama</label>
                            <input id="name" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" type="text" name="name" value="{{ old('name', $user->name) }}" required autofocus />
                            @error('name') <span class="text-sm text-red-600 mt-2">{{ $message }}</span> @enderror
                        </div>

                        <!-- Email Address -->
                        <div class="mb-4">
                            <label for="email" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Email</label>
                            <input id="email" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" type="email" name="email" value="{{ old('email', $user->email) }}" required />
                            @error('email') <span class="text-sm text-red-600 mt-2">{{ $message }}</span> @enderror
                        </div>
                        
                        <!-- Role -->
                        <div class="mb-4">
                            <label for="role" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Hak Akses (Role)</label>
                            <select id="role" name="role" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="viewer" {{ old('role', $user->role) === 'viewer' ? 'selected' : '' }}>Viewer (Hanya Melihat)</option>
                                <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin (Akses Penuh)</option>
                            </select>
                            @error('role') <span class="text-sm text-red-600 mt-2">{{ $message }}</span> @enderror
                        </div>

                        <!-- Password -->
                        <div class="mb-4 p-4 border border-gray-200 bg-gray-50 rounded-md">
                            <p class="text-sm text-gray-500 mb-4 font-bold">Biarkan kosong jika tidak ingin mengubah sandi.</p>
                            
                            <label for="password" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Password Baru</label>
                            <input id="password" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mb-3" type="password" name="password" />
                            @error('password') <span class="text-sm text-red-600 mt-2">{{ $message }}</span> @enderror

                            <label for="password_confirmation" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Konfirmasi Password Baru</label>
                            <input id="password_confirmation" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" type="password" name="password_confirmation" />
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a class="underline text-sm text-gray-600 hover:text-gray-900 leading-5" href="{{ route('cms.users.index') }}">
                                Batal
                            </a>
                            <button type="submit" class="ml-4 inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
