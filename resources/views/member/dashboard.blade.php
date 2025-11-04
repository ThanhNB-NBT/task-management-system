<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Member Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Thống kê tổng quan -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-gray-500 text-sm font-medium">Tổng số task</h3>
                    <p class="text-3xl font-bold text-gray-900">{{ $stats['total_tasks'] }}</p>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-gray-500 text-sm font-medium">Task đang làm</h3>
                    <p class="text-3xl font-bold text-blue-600">{{ $stats['in_progress_tasks'] }}</p>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-gray-500 text-sm font-medium">Task hoàn thành</h3>
                    <p class="text-3xl font-bold text-green-600">{{ $stats['done_tasks'] }}</p>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-gray-500 text-sm font-medium">Task chờ xử lý</h3>
                    <p class="text-3xl font-bold text-yellow-600">{{ $stats['pending_tasks'] }}</p>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-gray-500 text-sm font-medium">Dự án tham gia</h3>
                    <p class="text-3xl font-bold text-purple-600">{{ $stats['total_projects'] }}</p>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-gray-500 text-sm font-medium">Thông báo chưa đọc</h3>
                    <p class="text-3xl font-bold text-red-600">{{ $stats['unread_notifications'] }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Task sắp hết hạn -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">Task sắp hết hạn (3 ngày tới)</h3>
                        @if($upcomingTasks->count() > 0)
                            <div class="space-y-3">
                                @foreach($upcomingTasks as $task)
                                    <div class="border-l-4 border-red-500 pl-4 py-2">
                                        <a href="{{ route('member.tasks.show', $task->id) }}" class="text-blue-600 hover:underline font-medium">
                                            {{ $task->title }}
                                        </a>
                                        <p class="text-sm text-gray-500">
                                            Hạn: {{ $task->due_date->format('d/m/Y') }}
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500">Không có task sắp hết hạn</p>
                        @endif
                    </div>
                </div>

                <!-- Task mới nhất -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">Task mới nhất</h3>
                        @if($recentTasks->count() > 0)
                            <div class="space-y-3">
                                @foreach($recentTasks as $task)
                                    <div class="border-l-4 border-blue-500 pl-4 py-2">
                                        <a href="{{ route('member.tasks.show', $task->id) }}" class="text-blue-600 hover:underline font-medium">
                                            {{ $task->title }}
                                        </a>
                                        <p class="text-sm text-gray-500">
                                            Dự án: {{ $task->project->name ?? 'N/A' }}
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500">Chưa có task nào</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
