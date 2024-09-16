@extends('marketing.templates.index')

@section('page-dashboard')
    <div class="container mx-auto px-4 py-6">
        <!-- Form Section -->
        <div class="bg-white shadow-md rounded-lg p-6 mb-6">
            <h2 class="text-2xl font-semibold mb-4">Tambah Data Harian</h2>

            <form method="POST" action="{{ route('addharian') }}" class="space-y-4">
                @csrf
                <div class="flex flex-col">
                    <label for="project" class="text-lg font-medium mb-1">Project</label>
                    <select id="project" name="project" required class="form-select">
                        <option value="" disabled selected> --- PILIH LOKASI PROJECT ----</option>
                        <option value="sakinah">Sakinah 2</option>
                        <option value="savill">Savill</option>
                        <option value="triehans">Triehans</option>
                    </select>
                </div>

                <div class="flex flex-col">
                    <label for="leads" class="text-lg font-medium mb-1">Data Leads</label>
                    <input type="text" id="leads" name="leads" required class="form-input">
                </div>

                <div class="flex flex-col">
                    <label for="aktivitas" class="text-lg font-medium mb-1">Aktivitas</label>
                    <input type="text" id="aktivitas" name="aktivitas" required class="form-input">
                </div>

                <div>
                    <button type="submit"
                        class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 transition duration-300">
                        Kirim
                    </button>
                </div>
            </form>
        </div>

        <!-- Data Table Section -->
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-2xl font-semibold mb-4">Data Harian</h2>

            @if ($harianData->isEmpty())
                <p class="text-gray-500">Tidak ada data yang tersedia.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-md">
                        <thead class="bg-gray-100 text-gray-800 uppercase text-sm">
                            <tr>
                                <th class="py-3 px-4 text-left border-b">Nomor</th>
                                <th class="py-3 px-4 text-left border-b">Tanggal</th>
                                <th class="py-3 px-4 text-left border-b">Project</th>
                                <th class="py-3 px-4 text-left border-b">Leads</th>
                                <th class="py-3 px-4 text-left border-b">Aktivitas</th>
                                <th class="py-3 px-4 text-left border-b">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700 text-sm">
                            @foreach ($harianData as $index => $data)
                                <tr class="border-b hover:bg-gray-50 transition duration-150 ease-in-out">
                                    <td class="py-3 px-4">{{ $index + 1 }}</td>
                                    <td class="py-3 px-4">{{ $data->date }}</td>
                                    <td class="py-3 px-4">{{ $data->project }}</td>
                                    <td class="py-3 px-4">{{ $data->leads }}</td>
                                    <td class="py-3 px-4">{{ $data->aktivitas }}</td>
                                    <td class="py-3 px-4 flex space-x-2">
                                        <a href="{{ route('harian.edit', ['id' => Crypt::encrypt($data->id)]) }}"
                                            class="px-3 py-1 bg-yellow-500 text-white font-semibold rounded-lg hover:bg-yellow-600 transition duration-300">Edit</a>
                                        <form action="{{ route('harian.destroy',  ['id' => Crypt::encrypt($data->id)]) }}" method="POST"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="px-3 py-1 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition duration-300">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
@endsection
