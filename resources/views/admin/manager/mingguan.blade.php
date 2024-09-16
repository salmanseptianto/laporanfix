        @extends('admin.templates.index')

        @section('page-dashboard')
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                Mingguan
                <a href="{{ route('laporanMingguan', ['type' => 'approve']) }}">Diterima</a>
                <a href="{{ route('laporanMingguan', ['type' => 'reject']) }}">Ditolak</a>


            </div>

            </section>
        @endsection
