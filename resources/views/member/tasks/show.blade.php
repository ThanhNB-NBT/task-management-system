<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Chi tiết Task</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container py-4">

        <a href="{{ route('member.tasks.index') }}" class="btn btn-outline-secondary mb-3">← Quay lại danh sách</a>

        <div class="card mb-4">
            <div class="card-body">
                <p><strong>Tên dự án:</strong> {{ $task->project->name }}</p>
                <p><strong>Tiêu đề:</strong> {{ $task->title }}</p>
                <p><strong>Mô tả:</strong> {!! nl2br(e($task->description)) !!}</p>
                <p><strong>Trạng thái:</strong> {{ ucfirst($task->status) }}</p>
                <p><strong>Độ ưu tiên:</strong>
                    <span
                        class="badge bg-{{ $task->priority === 'high' ? 'danger' : ($task->priority === 'medium' ? 'warning' : 'secondary') }}">
                        {{ ucfirst($task->priority) }}
                    </span>
                </p>
                <p><strong>Ngày hết hạn:</strong> {{ $task->due_date ?? '—' }}</p>
            </div>
        </div>

        <!-- Form cập nhật trạng thái -->
        <div class="card mb-4">
            <div class="card-header">Cập nhật trạng thái</div>
            <div class="card-body">
                <form method="POST" action="{{ route('member.tasks.updateStatus', $task->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="row align-items-center">
                        <div class="col-md-4">
                            <select name="status" class="form-select">
                                <option value="pending" {{ $task->status == 'pending' ? 'selected' : '' }}>Pending
                                </option>
                                <option value="in_progress" {{ $task->status == 'in_progress' ? 'selected' : '' }}>In
                                    Progress</option>
                                <option value="done" {{ $task->status == 'done' ? 'selected' : '' }}>Done</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-success">Cập nhật</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Bình luận -->
        {{-- <div class="card mb-4">
            <div class="card-header">Bình luận</div>
            <div class="card-body">
                @forelse($task->comments as $comment)
                    <div class="mb-3 border-bottom pb-2">
                        <strong>{{ $comment->user->name }}</strong>
                        <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                        <p>{{ $comment->content }}</p>
                    </div>
                @empty
                    <p>Chưa có bình luận nào.</p>
                @endforelse

                <form method="POST" action="{{ route('member.tasks.comment', $task->id) }}">
                    @csrf
                    <div class="mb-3">
                        <textarea name="content" class="form-control" rows="2" placeholder="Thêm bình luận..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Gửi</button>
                </form>
            </div>
        </div> --}}

        <!-- Lịch sử -->
        <div class="card">
            <div class="card-header">Lịch sử thay đổi</div>
            <div class="card-body">
                @forelse($task->histories as $history)
                    @php
                        $old = is_string($history->old_value)
                            ? json_decode($history->old_value, true)
                            : $history->old_value;
                        $new = is_string($history->new_value)
                            ? json_decode($history->new_value, true)
                            : $history->new_value;
                    @endphp

                    <p class="mb-0">
                        <strong>{{ $history->user->name }}</strong>
                        đã cập nhật trạng thái task
                        từ
                        <span class="badge bg-warning text-dark">{{ $old['status'] ?? '—' }}</span>
                        sang
                        <span class="badge bg-success">{{ $new['status'] ?? '—' }}</span>.
                        <small class="text-muted">({{ $history->created_at->format('d/m/Y H:i') }})</small>
                    </p>

                @empty
                    <p>Chưa có lịch sử nào.</p>
                @endforelse
            </div>
        </div>

    </div>
</body>

</html>
