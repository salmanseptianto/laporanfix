        @extends('mm.templates.index')

        @section('page-dashboard')
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">


                <div class="container">
                    <h1>Mingguan Data Area Savill</h1>

                    <!-- Check if there's data to display -->
                    @if ($mingguanData->isEmpty())
                        <p>No data available.</p>
                    @else
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nomor</th>
                                    <th class="py-2 px-4 text-left">Nama Marketing</th>
                                    <th>Project Area</th>
                                    <th>Periode</th>
                                    <th>Total Jumlah Kanva</th>
                                    <th>Jumlah Kanvas Tim Seminggu</th>
                                    <th>Iklan Online</th>
                                    <th>Posting Sosmed</th>
                                    <th>Janji Temu dan Kunjungan</th>
                                    <th>Calon Kons. Cek Lokasi</th>
                                    <th>Total Data Leads</th>
                                    <th>Data Prospek</th>
                                    <th>Hot Prospek</th>
                                    <th>Booking</th>
                                    <th>Pemberkasan</th>
                                    <th>Closing Akad/Cash</th>
                                    <th>Rencana Target Closing Dalam 1 Bulan</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($mingguanData as $index => $data)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $data->marketing->name }}</td>
                                        <td>{{ $data->projectArea }}</td>
                                        <td>{{ $data->periode }}</td>
                                        <td>{{ $data->totalJumlahKanva }}</td>
                                        <td>{{ $data->jumlahKanvasTimSeminggu }}</td>
                                        <td>{{ $data->iklanOnline }}</td>
                                        <td>{{ $data->postingSosmed }}</td>
                                        <td>{{ $data->janjiTemuDanKunjungan }}</td>
                                        <td>{{ $data->calonKonsCekLokasi }}</td>
                                        <td>{{ $data->totalDataLeads }}</td>
                                        <td>{{ $data->dataProspek }}</td>
                                        <td>{{ $data->hotProspek }}</td>
                                        <td>{{ $data->booking }}</td>
                                        <td>{{ $data->pemberkasan }}</td>
                                        <td>{{ number_format($data->closingAkadCash, 2, ',', '.') }}</td>
                                        <td>{{ $data->rencanaTargetClosingDalam1Bulan }}</td>
                                        <td>
                                            <form action="{{ route('mingguan.approve',  ['id' => Crypt::encrypt($data->id)]) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                @method('POST')
                                                <button type="submit" class="btn btn-success">Setuju</button>
                                            </form>
                                            <form action="{{ route('mingguan.reject', ['id' => Crypt::encrypt($data->id)]) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                @method('POST')
                                                <button type="submit" class="btn btn-success">Tolak</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>



            </div>
            <script>
                // JavaScript to handle notification visibility
                document.addEventListener('DOMContentLoaded', function() {
                    var notification = document.getElementById('notification');
                    if (notification) {
                        // Hide the notification after 20 seconds
                        setTimeout(function() {
                            notification.style.display = 'none';
                        }, 15100); // 20000 milliseconds = 20 seconds
                    }
                });
            </script>
            </section>
        @endsection
