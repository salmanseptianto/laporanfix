<?php

namespace App\Exports;

use App\Models\Harian;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class HarianExport implements FromArray, WithHeadings
{
    protected $project;
    protected $status;

    public function __construct($project = null, $status = null)
    {
        $this->project = $project;
        $this->status = $status;
    }
    
    public function array(): array
    {
        // dd($this->status);
        $query = Harian::with('marketing')
            ->where('status', $this->status);

        if ($this->project && $this->project !== 'all') {
            $query->where('project', $this->project);
        }

        $harianData = $query->get();

        $exportData = [];
        foreach ($harianData as $index => $data) {
            $exportData[] = [
                $index + 1,
                $data->marketing->name ?? 'Manager Marketing',
                $data->date,
                $data->project,
                $data->leads,
                $data->aktivitas
            ];
        }

        return $exportData;
    }

    public function headings(): array
    {
        return [
            'Nomor',
            'Nama Marketing',
            'Tanggal',
            'Project',
            'Leads',
            'Aktivitas'
        ];
    }
}
