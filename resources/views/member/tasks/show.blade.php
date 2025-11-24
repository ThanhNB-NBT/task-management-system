@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="mb-3">
        <a href="{{ route('member.tasks.index') }}" class="btn btn-light btn-sm text-secondary shadow-sm">
            <i class="fas fa-arrow-left me-1"></i> {{ __('Quay lại danh sách') }}
        </a>
    </div>

    <div class="row mb-4 align-items-start">
        <div class="col-md-8">
            <div class="d-flex align-items-center mb-2">
                <span class="badge bg-secondary me-2">#{{ $task->id }}</span>
                <h1 class="h3 mb-0 text-primary fw-bold">{{ $task->title }}</h1>
            </div>
            <p class="text-muted mb-0">
                Dự án: <span class="fw-bold text-dark">{{ $task->project->name }}</span>
                <span class="mx-2">|</span>
                Leader: {{ $task->project->leader->name ?? 'N/A' }}
            </p>
        </div>

        <div class="col-md-4 text-md-end mt-3 mt-md-0">
            <form action="{{ route('member.tasks.updateStatus', $task->id) }}" method="POST" id="statusForm">
                @csrf @method('PUT')

                @if($task->status == 'pending')
                    <button name="status" value="in_progress" class="btn btn-primary w-100">
                        <i class="fas fa-play me-1"></i> {{ __('Bắt Đầu Thực Hiện') }}
                    </button>
                @elseif($task->status == 'in_progress')
                    <div class="btn-group w-100 shadow-sm">
                        <button type="button" class="btn btn-info text-white active" disabled>
                            <i class="fas fa-spinner fa-spin me-1"></i> Đang làm
                        </button>
                        <button name="status" value="done" class="btn btn-success" onclick="return confirm('Xác nhận hoàn thành công việc?');">
                            <i class="fas fa-check me-1"></i> {{ __('Hoàn Thành') }}
                        </button>
                    </div>
                @else
                    <button type="button" class="btn btn-success w-100" disabled>
                        <i class="fas fa-check-circle me-1"></i> {{ __('Đã Hoàn Thành') }}
                    </button>
                @endif
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">

            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0 fw-bold text-dark"><i class="fas fa-align-left me-2 text-primary"></i>{{ __('Mô Tả') }}</h6>
                </div>
                <div class="card-body">
                    <div class="text-secondary" style="white-space: pre-line;">{{ $task->description ?? 'Không có mô tả.' }}</div>
                </div>
            </div>

            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0 fw-bold text-dark"><i class="fas fa-paperclip me-2 text-warning"></i>{{ __('Tài Liệu & Kết Quả') }}</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('member.tasks.attachments.store', $task->id) }}" method="POST" enctype="multipart/form-data" class="mb-4">
                        @csrf
                        <label class="small fw-bold text-muted mb-1">Tải lên tài liệu hoặc kết quả công việc:</label>
                        <div class="input-group">
                            <input type="file" name="attachment" class="form-control" required>
                            <button class="btn btn-outline-primary" type="submit"><i class="fas fa-upload"></i> Upload</button>
                        </div>
                    </form>

                    @if($task->attachments->count() > 0)
                        <ul class="list-group list-group-flush">
                            @foreach($task->attachments as $file)
                                <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <div class="d-flex align-items-center text-truncate">
                                        <div class="me-3 text-muted"><i class="fas fa-file"></i></div>
                                        <div>
                                            <a href="{{ route('member.tasks.attachments.download', $file->id) }}" class="text-dark fw-bold text-decoration-none">{{ $file->file_name }}</a>
                                            <div class="small text-muted">{{ number_format($file->file_size / 1024, 2) }} KB • {{ $file->created_at->format('d/m H:i') }}</div>
                                        </div>
                                    </div>
                                    <div class="d-flex">
                                        <a href="{{ route('member.tasks.attachments.download', $file->id) }}" class="btn btn-sm btn-light text-primary me-1"><i class="fas fa-download"></i></a>
                                        @if($file->user_id == Auth::id())
                                            <form action="{{ route('member.tasks.attachments.destroy', $file->id) }}" method="POST" onsubmit="return confirm('Xóa file này?');">
                                                @csrf @method('DELETE')
                                                <button class="btn btn-sm btn-light text-danger"><i class="fas fa-trash"></i></button>
                                            </form>
                                        @endif
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted small fst-italic text-center">Chưa có file nào được tải lên.</p>
                    @endif
                </div>
            </div>

            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0 fw-bold text-dark"><i class="fas fa-comments me-2 text-info"></i>{{ __('Trao Đổi') }}</h6>
                </div>
                <div class="card-body bg-light">
                    <div class="mb-4" style="max-height: 400px; overflow-y: auto;">
                        @forelse($task->comments as $comment)
                            <div class="d-flex mb-3 {{ $comment->user_id == Auth::id() ? 'flex-row-reverse' : '' }}">
                                <div class="flex-shrink-0">
                                    <div class="avatar-circle-sm {{ $comment->user->role == 'leader' ? 'bg-danger' : 'bg-primary' }} text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; font-weight: bold;">
                                        {{ substr($comment->user->name, 0, 1) }}
                                    </div>
                                </div>
                                <div class="{{ $comment->user_id == Auth::id() ? 'me-3 text-end' : 'ms-3' }}" style="max-width: 80%;">
                                    <div class="card border-0 shadow-sm">
                                        <div class="card-body p-2 px-3">
                                            <div class="d-flex justify-content-between align-items-center mb-1 gap-2">
                                                <strong class="small {{ $comment->user->role == 'leader' ? 'text-danger' : 'text-dark' }}">
                                                    {{ $comment->user->name }}
                                                </strong>
                                                <small class="text-muted" style="font-size: 0.7rem;">{{ $comment->created_at->format('H:i d/m') }}</small>
                                            </div>
                                            <p class="mb-0 small text-secondary text-start">{{ $comment->content }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-center text-muted small">Chưa có bình luận nào.</p>
                        @endforelse
                    </div>

                    <form action="{{ route('member.tasks.comments.store', $task->id) }}" method="POST">
                        @csrf
                        <div class="input-group">
                            <textarea name="content" class="form-control" rows="1" placeholder="Nhập bình luận..." required></textarea>
                            <button class="btn btn-primary"><i class="fas fa-paper-plane"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0 fw-bold text-dark">{{ __('Thông Tin') }}</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="small text-muted fw-bold text-uppercase">Độ Ưu Tiên</label>
                        <div class="mt-1">
                            @if($task->priority == 'high') <span class="badge bg-danger w-100 py-2">CAO</span>
                            @elseif($task->priority == 'medium') <span class="badge bg-warning text-dark w-100 py-2">TRUNG BÌNH</span>
                            @else <span class="badge bg-secondary w-100 py-2">THẤP</span>
                            @endif
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="small text-muted fw-bold text-uppercase">Hạn Chót</label>
                        <div class="mt-1 fw-bold text-dark">
                            @if($task->due_date)
                                {{ \Carbon\Carbon::parse($task->due_date)->format('d/m/Y') }}
                                @if($task->due_date < now() && $task->status != 'done')
                                    <span class="text-danger small ms-1">(Quá hạn)</span>
                                @endif
                            @else -- @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
