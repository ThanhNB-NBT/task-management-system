<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Thống kê Users -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-4">Quản lý người dùng</h3>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h4 class="text-gray-500 text-sm font-medium">Tổng Users</h4>
                        <p class="text-3xl font-bold text-gray-900">{{ $stats['total_users'] }}</p>
                    </div>
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h4 class="text-gray-500 text-sm font-medium">Admins</h4>
                        <p class="text-3xl font-bold text-red-600">{{ $stats['total_admins'] }}</p>
                    </div>
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h4 class="text-gray-500 text-sm font-medium">Leaders</h4>
                        <p class="text-3xl font-bold text-purple-600">{{ $stats['total_leaders'] }}</p>
                    </div>
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h4 class="text-gray-500 text-sm font-medium">Members</h4>
                        <p class="text-3xl font-bold text-blue-600">{{ $stats['total_members'] }}</p>
                    </div>
                </div>
            </div>

            <!-- Thống kê Projects & Tasks -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-4">Dự án & Task</h3>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h4 class="text-gray-500 text-sm font-medium">Tổng Dự án</h4>
                        <p class="text-3xl font-bold text-gray-900">{{ $stats['total_projects'] }}</p>
                    </div>
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h4 class="text-gray-500 text-sm font-medium">Tổng Tasks</h4>
                        <p class="text-3xl font-bold text-gray-900">{{ $stats['total_tasks'] }}</p>
                    </div>
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h4 class="text-gray-500 text-sm font-medium">Tasks Done</h4>
                        <p class="text-3xl font-bold text-green-600">{{ $stats['done_tasks'] }}</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Dự án mới nhất -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">Dự án mới nhất</h3>
                        @if($recentProjects->count() > 0)
                            <div class="space-y-3">
                                @foreach($recentProjects as $project)
                                    <div class="border-l-4 border-blue-500 pl-4 py-2">
                                        <p class="font-medium">{{ $project->name }}</p>
                                        <p class="text-sm text-gray-500">
                                            Leader: {{ $project->leader->name ?? 'N/A' }}
                                        </p>
                                        <p class="text-sm text-gray-400">
                                            {{ $project->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500">Chưa có dự án nào</p>
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
                                            Assignee: {{ $task->assignee->name ?? 'Chưa giao' }}
                                        </p>
                                        <p class="text-sm {{ $task->due_date < now() ? 'text-red-500' : 'text-yellow-500' }}">
                                            Hạn: {{ $task->due_date->format('d/m/Y') }}
                                            @if($task->due_date < now())
                                                (Quá hạn)
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
    </div>
</x-app-layout>
