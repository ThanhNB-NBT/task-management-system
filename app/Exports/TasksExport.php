<?php

namespace App\Exports;

use App\Models\Task;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TasksExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Task::with(['project', 'assignee'])
            ->orderBy('id')
            ->get()
            ->map(function ($t) {
                return [
                    'id' => $t->id,
                    'title' => $t->title,
                    'project' => $t->project?->name,
                    'assignee' => $t->assignee?->name,
                    'status' => $t->status,
                    'priority' => $t->priority,
                    'due_date' => $t->due_date,
                    'created_at' => $t->created_at,
                ];
            });
    }

    public function headings(): array
    {
        return ['ID', 'Title', 'Project', 'Assignee', 'Status', 'Priority', 'Due Date', 'Created At'];
    }
}
