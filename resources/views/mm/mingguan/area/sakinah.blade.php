        @extends('mm.templates.index')

        @section('page-dashboard')
            <div class="grid grid-cols-1 gap-8">
                <div class="container mx-auto mt-4 px-4">
                    <h1 class="text-2xl font-semibold mb-4">Mingguan Data Area Sakinah</h1>

                    <!-- Check if there's data to display -->
                    @if ($mingguanData->isEmpty())
                        <p class="text-gray-600">No data available.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white border border-gray-200 divide-y divide-gray-300">
                                <thead class="bg-gray-100 text-gray-600">
                                    <tr>
                                        <th class="py-2 px-4 text-left">Nomor</th>
                                        <th class="py-2 px-4 text-left">Nama Marketing</th>
                                        <th class="py-2 px-4 text-left">Project Area</th>
                                        <th class="py-2 px-4 text-left">Periode</th>
                                        <th class="py-2 px-4 text-left">Total Jumlah Kanva</th>
                                        <th class="py-2 px-4 text-left">Jumlah Kanvas Tim Seminggu</th>
                                        <th class="py-2 px-4 text-left">Iklan Online</th>
                                        <th class="py-2 px-4 text-left">Posting Sosmed</th>
                                        <th class="py-2 px-4 text-left">Janji Temu dan Kunjungan</th>
                                        <th class="py-2 px-4 text-left">Calon Kons. Cek Lokasi</th>
                                        <th class="py-2 px-4 text-left">Total Data Leads</th>
                                        <th class="py-2 px-4 text-left">Data Prospek</th>
                                        <th class="py-2 px-4 text-left">Hot Prospek</th>
                                        <th class="py-2 px-4 text-left">Booking</th>
                                        <th class="py-2 px-4 text-left">Pemberkasan</th>
                                        <th class="py-2 px-4 text-left">Closing Akad/Cash</th>
                                        <th class="py-2 px-4 text-left">Rencana Target Closing Dalam 1 Bulan</th>
                                        <th class="py-2 px-4 text-left">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white">
                                    @foreach ($mingguanData as $index => $data)
                                        <tr>
                                            <td class="py-2 px-4 border-b">{{ $index + 1 }}</td>
                                            <td class="py-2 px-4 border-b">{{ $data->marketing->name }}</td>
                                            <td class="py-2 px-4 border-b">{{ $data->projectArea }}</td>
                                            <td class="py-2 px-4 border-b">{{ $data->periode }}</td>
                                            <td class="py-2 px-4 border-b">{{ $data->totalJumlahKanva }}</td>
                                            <td class="py-2 px-4 border-b">{{ $data->jumlahKanvasTimSeminggu }}</td>
                                            <td class="py-2 px-4 border-b">{{ $data->iklanOnline }}</td>
                                            <td class="py-2 px-4 border-b">{{ $data->postingSosmed }}</td>
                                            <td class="py-2 px-4 border-b">{{ $data->janjiTemuDanKunjungan }}</td>
                                            <td class="py-2 px-4 border-b">{{ $data->calonKonsCekLokasi }}</td>
                                            <td class="py-2 px-4 border-b">{{ $data->totalDataLeads }}</td>
                                            <td class="py-2 px-4 border-b">{{ $data->dataProspek }}</td>
                                            <td class="py-2 px-4 border-b">{{ $data->hotProspek }}</td>
                                            <td class="py-2 px-4 border-b">{{ $data->booking }}</td>
                                            <td class="py-2 px-4 border-b">{{ $data->pemberkasan }}</td>
                                            <td class="py-2 px-4 border-b">
                                                {{ number_format($data->closingAkadCash, 2, ',', '.') }}</td>
                                            <td class="py-2 px-4 border-b">{{ $data->rencanaTargetClosingDalam1Bulan }}
                                            </td>
                                            <td class="py-2 px-4 border-b flex space-x-2">
                                                <form action="{{ route('mingguan.approve',  ['id' => Crypt::encrypt($data->id)]) }}" method="POST"
                                                    class="inline">
                                                    @csrf
                                                    @method('POST')
                                                    <button type="submit"
                                                        class="bg-green-500 text-white py-1 px-3 rounded hover:bg-green-600">Setuju</button>
                                                </form>
                                                <form action="{{ route('mingguan.reject',  ['id' => Crypt::encrypt($data->id)]) }}" method="POST"
                                                    class="inline">
                                                    @csrf
                                                    @method('POST')
                                                    <button type="submit"
                                                        class="bg-red-500 text-white py-1 px-3 rounded hover:bg-red-600">Tolak</button>
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
