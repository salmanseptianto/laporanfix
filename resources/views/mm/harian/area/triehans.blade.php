@extends('mm.templates.index')

@section('page-dashboard')
    <div class="container mt-4">
        <h2 class="text-2xl font-semibold mb-4">Data Harian Triehans</h2>

        @if ($harianData->isEmpty())
            <p>Tidak ada data yang tersedia.</p>
        @else
            <table class="min-w-full bg-white border border-gray-200">
                <thead class="bg-gray-100 text-gray-600">
                    <tr>
                        <th class="py-2 px-4 border-b">Nomor</th>
                        <th class="py-2 px-4 border-b">Nama Marketing</th>
                        <th class="py-2 px-4 border-b">Tanggal</th>
                        <th class="py-2 px-4 border-b">Project</th>
                        <th class="py-2 px-4 border-b">Leads</th>
                        <th class="py-2 px-4 border-b">Aktivitas</th>
                        <th class="py-2 px-4 border-b">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($harianData as $index => $data)
                        <tr>
                            <td class="py-2 px-4 border-b">{{ $index + 1 }}</td>
                            <td class="py-2 px-4 border-b">{{ $data->marketing->name }}</td>
                            <td class="py-2 px-4 border-b">{{ $data->date }}</td>
                            <td class="py-2 px-4 border-b">{{ $data->project }}</td>
                            <td class="py-2 px-4 border-b">{{ $data->leads }}</td>
                            <td class="py-2 px-4 border-b">{{ $data->aktivitas }}</td>
                            <td class="py-2 px-4 border-b">
                                <form action="{{ route('harian.approve', ['id' => Crypt::encrypt($data->id)]) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('POST')
                                    <button type="submit" class="btn btn-success">Setuju</button>
                                </form>
                                <form action="{{ route('harian.reject', ['id' => Crypt::encrypt($data->id)]) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('POST')
                                    <button type="submit" class="btn btn-danger">Tolak</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
