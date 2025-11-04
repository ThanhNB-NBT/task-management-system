<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Leader Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Thống kê tổng quan -->
            <div class="grid grid-cols-1 md:grid-cols-5 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-gray-500 text-sm font-medium">Dự án quản lý</h3>
                    <p class="text-3xl font-bold text-gray-900">{{ $stats['total_projects'] }}</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-gray-500 text-sm font-medium">Tổng Members</h3>
                    <p class="text-3xl font-bold text-blue-600">{{ $stats['total_members'] }}</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-gray-500 text-sm font-medium">Tổng Tasks</h3>
                    <p class="text-3xl font-bold text-gray-900">{{ $stats['total_tasks'] }}</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-gray-500 text-sm font-medium">Đang làm</h3>
                    <p class="text-3xl font-bold text-yellow-600">{{ $stats['in_progress'] }}</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-gray-500 text-sm font-medium">Hoàn thành</h3>
                    <p class="text-3xl font-bold text-green-600">{{ $stats['done'] }}</p>
                </div>
            </div>

            <!-- Danh sách dự án -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Dự án đang quản lý</h3>
                    @if($projects->count() > 0)
                        <div class="space-y-4">
                            @foreach($projects as $project)
                                <div class="border rounded-lg p-4">
                                    <h4 class="font-semibold text-lg">{{ $project->name }}</h4>
                                    <p class="text-sm text-gray-600 mt-1">{{ $project->description }}</p>
                                    <div class="mt-2 flex gap-4 text-sm text-gray-500">
                                        <span>📋 {{ $project->tasks_count }} tasks</span>
                                        <span>👥 {{ $project->members_count }} members</span>
                                        <span>📅 {{ $project->created_at->format('d/m/Y') }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500">Chưa quản lý dự án nào</p>
                    @endif
                </div>
            </div>

            <!-- Task cần chú ý -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Task cần chú ý</h3>
                    @if($criticalTasks->count() > 0)
                        <div class="space-y-3">
                            @foreach($criticalTasks as $task)
                                <div class="border-l-4 {{ $task->due_date < now() ? 'border-red-500' : 'border-yellow-500' }} pl-4 py-2">
                                    <p class="font-medium">{{ $task->title }}</p>
                                    <p class="text-sm text-gray-500">
                                        Dự án: {{ $task->project->name }}
                                    </p>
                                    <p class="text-sm text-gray-500">
                                        Assignee: {{ $task->assignee->name ?? 'Chưa giao' }}
                                    </p>
                                    <p class="text-sm {{ $task->due_date < now() ? 'text-red-500' : 'text-yellow-500' }}">
                                        Hạn: {{ $task->due_date->format('d/m/Y') }}
                                        @if($task->due_date < now())
                                            (Quá hạn {{ $task->due_date->diffForHumans() }})
                                        @endif
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500">Không có task cần chú ý</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
