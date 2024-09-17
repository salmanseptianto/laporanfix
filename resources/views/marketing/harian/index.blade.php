@extends('marketing.templates.index')

@section('page-dashboard')
    <div class="container mx-auto px-4 py-6">
        <!-- Form Section -->
        <div class="bg-white shadow-md rounded-lg p-6 mb-6">
            <h2 class="text-2xl font-semibold mb-4">Tambah Data Harian</h2>

            <form method="POST" action="{{ route('addharian') }}" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div class="flex flex-col">
                    <label for="nama" class="text-lg font-medium mb-1">Nama Lengkap</label>
                    <input type="text" id="nama" name="nama" required class="form-input">
                </div>
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
                    <label for="pekerjaan" class="text-lg font-medium mb-1">Pekerjaan</label>
                    <input type="text" id="pekerjaan" name="pekerjaan" required class="form-input">
                </div>

                <div class="flex flex-col">
                    <label for="alamat" class="text-lg font-medium mb-1">Alamat</label>
                    <input type="text" id="alamat" name="alamat" required class="form-input">
                </div>
                <div class="flex flex-col">
                    <label for="prospek" class="text-lg font-medium mb-1">Status</label>
                    <select id="prospek" name="prospek" required class="form-select">
                        <option value="" disabled selected> --- PILIH STATUS ----</option>
                        <option value="prosepek">Prospek</option>
                        <option value="nonprospek">Non-Prospek</option>
                    </select>
                </div>
                {{-- <div class="flex flex-col">
                    <label for="foto" class="text-lg font-medium mb-1">Bukti Foto</label>
                    <input type="file" id="foto" name="foto">
                </div> --}}
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
                                <th class="py-3 px-4 text-left border-b">Nama Lengkap</th>
                                <th class="py-3 px-4 text-left border-b">Projek Lokasi</th>
                                <th class="py-3 px-4 text-left border-b">Pekerjaan</th>
                                <th class="py-3 px-4 text-left border-b">alamat</th>
                                <th class="py-3 px-4 text-left border-b">Prospek</th>
                                <th class="py-3 px-4 text-left border-b">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700 text-sm">
                            @foreach ($harianData as $index => $data)
                                <tr class="border-b hover:bg-gray-50 transition duration-150 ease-in-out">
                                    <td class="py-3 px-4">{{ $index + 1 }}</td>
                                    <td class="py-3 px-4">{{ $data->date }}</td>
                                    <td class="py-3 px-4">{{ $data->nama }}</td>
                                    <td class="py-3 px-4">{{ $data->project }}</td>
                                    <td class="py-3 px-4">{{ $data->pekerjaan }}</td>
                                    <td class="py-3 px-4">{{ $data->alamat }}</td>
                                    <td class="py-3 px-4">{{ $data->prospek }}</td>
                                    {{-- <td class="py-3 px-4">
                                        @if ($data->foto)
                                           <img src="{{ asset('storage/' . $data->foto) }}" alt="Foto" class="w-16 h-16 object-cover">

                                        @else
                                            No Image
                                        @endif
                                    </td> --}}
                                    <td class="py-3 px-4 flex space-x-2">
                                        <a href="{{ route('harian.edit', ['id' => Crypt::encrypt($data->id)]) }}"
                                            class="px-3 py-1 bg-yellow-500 text-white font-semibold rounded-lg hover:bg-yellow-600 transition duration-300">Edit</a>
                                        <form action="{{ route('harian.destroy', ['id' => Crypt::encrypt($data->id)]) }}"
                                            method="POST" class="inline">
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
