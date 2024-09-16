@extends('marketing.templates.index')

@section('page-dashboard')
    <div class="container mx-auto px-4 py-6">
        <!-- Edit Data Form -->
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-2xl font-semibold mb-4">Edit Data Harian</h2>

            <form action="{{ route('harian.update', ['id' => Crypt::encrypt($harian->id)]) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div class="flex flex-col">
                    <label for="project" class="text-lg font-medium mb-1">Project</label>
                    <select id="project" name="project" class="form-select border border-gray-300 rounded-lg p-2" required>
                        <option value="" disabled>PILIH LOKASI PROJECT</option>
                        <option value="sakinah" {{ $harian->project == 'sakinah' ? 'selected' : '' }}>Sakinah 2</option>
                        <option value="savill" {{ $harian->project == 'savill' ? 'selected' : '' }}>Savill</option>
                        <option value="triehans" {{ $harian->project == 'triehans' ? 'selected' : '' }}>Triehans</option>
                    </select>
                </div>

                <div class="flex flex-col">
                    <label for="leads" class="text-lg font-medium mb-1">Leads</label>
                    <input type="text" id="leads" name="leads" value="{{ $harian->leads }}"
                        class="form-input border border-gray-300 rounded-lg p-2">
                </div>

                <div class="flex flex-col">
                    <label for="aktivitas" class="text-lg font-medium mb-1">Aktivitas</label>
                    <input type="text" id="aktivitas" name="aktivitas" value="{{ $harian->aktivitas }}"
                        class="form-input border border-gray-300 rounded-lg p-2">
                </div>

                <div class="flex space-x-4">
                    <button type="submit"
                        class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 transition duration-300">
                        Update
                    </button>
                    <a href="{{ route('harian') }}"
                        class="px-6 py-3 bg-gray-600 text-white font-semibold rounded-lg shadow-md hover:bg-gray-700 transition duration-300">
                        Back
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
