<?php

namespace App\Exports;

use App\Models\Project;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProjectsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Project::with('leader')
            ->orderBy('id')
            ->get()
            ->map(function ($p) {
                return [
                    'id' => $p->id,
                    'name' => $p->name,
                    'leader' => $p->leader?->name,
                    'start_date' => $p->start_date,
                    'end_date' => $p->end_date,
                    'created_at' => $p->created_at,
                ];
            });
    }

    public function headings(): array
    {
        return ['ID', 'Name', 'Leader', 'Start Date', 'End Date', 'Created At'];
    }
}
