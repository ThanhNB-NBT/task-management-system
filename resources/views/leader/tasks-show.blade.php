@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="mb-3">
            <a href="{{ route('leader.tasks.index') }}" class="btn btn-light btn-sm shadow-sm text-secondary">
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
                    Thuộc dự án:
                    <a href="{{ route('leader.projects.show', $task->project_id) }}" class="fw-bold text-decoration-none">
                        <i class="fas fa-folder-open me-1"></i> {{ $task->project->name }}
                    </a>
                </p>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                <div class="btn-group shadow-sm">

                    @if ($task->status === 'done')
                        <form action="{{ route('leader.tasks.reopen', $task->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-warning text-dark fw-bold"
                                onclick="return confirm('Bạn muốn mở lại task này để tiếp tục xử lý?');">
                                <i class="fas fa-unlock-alt me-1"></i> {{ __('Mở Lại Task') }}
                            </button>
                        </form>

                        <button type="button" class="btn btn-outline-danger"
                            onclick="if(confirm('Bạn có chắc muốn xóa task này không?')) document.getElementById('delete-task-form').submit();">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    @else
                        <a href="{{ route('leader.tasks.edit', $task->id) }}" class="btn btn-outline-primary">
                            <i class="fas fa-edit me-1"></i> {{ __('Sửa Task') }}
                        </a>
                        <button type="button" class="btn btn-outline-danger"
                            onclick="if(confirm('Bạn có chắc muốn xóa task này không?')) document.getElementById('delete-task-form').submit();">
                            <i class="fas fa-trash-alt me-1"></i> {{ __('Xóa') }}
                        </button>
                    @endif

                </div>
                <form id="delete-task-form" action="{{ route('leader.tasks.destroy', $task->id) }}" method="POST"
                    class="d-none">
                    @csrf @method('DELETE')
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">

                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white py-3">
                        <h6 class="mb-0 fw-bold text-dark"><i
                                class="fas fa-align-left me-2 text-primary"></i>{{ __('Mô Tả Chi Tiết') }}</h6>
                    </div>
                    <div class="card-body">
                        @if ($task->description)
                            <div class="text-secondary" style="white-space: pre-line;">
                                {{ $task->description }}
                            </div>
                        @else
                            <p class="text-muted fst-italic mb-0">Chưa có mô tả cho công việc này.</p>
                        @endif
                    </div>
                </div>

                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 fw-bold text-dark"><i
                                class="fas fa-paperclip me-2 text-warning"></i>{{ __('Tài Liệu Đính Kèm') }}</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('leader.tasks.attachments.store', $task->id) }}" method="POST"
                            enctype="multipart/form-data" class="mb-4">
                            @csrf
                            <div class="input-group">
                                <input type="file" name="attachment" class="form-control" required>
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-upload me-1"></i> Tải lên
                                </button>
                            </div>
                            <div class="form-text small">Hỗ trợ: jpg, png, pdf, doc, docx, xls, zip... (Max: 10MB)</div>
                        </form>

                        @if ($task->attachments && $task->attachments->count() > 0)
                            <ul class="list-group list-group-flush">
                                @foreach ($task->attachments as $file)
                                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                        <div class="d-flex align-items-center overflow-hidden">
                                            <div class="me-3 text-secondary">
                                                @if (in_array($file->file_type, ['jpg', 'jpeg', 'png', 'gif']))
                                                    <i class="fas fa-file-image fa-lg"></i>
                                                @elseif(in_array($file->file_type, ['pdf']))
                                                    <i class="fas fa-file-pdf fa-lg text-danger"></i>
                                                @elseif(in_array($file->file_type, ['doc', 'docx']))
                                                    <i class="fas fa-file-word fa-lg text-primary"></i>
                                                @elseif(in_array($file->file_type, ['xls', 'xlsx']))
                                                    <i class="fas fa-file-excel fa-lg text-success"></i>
                                                @else
                                                    <i class="fas fa-file fa-lg"></i>
                                                @endif
                                            </div>
                                            <div class="text-truncate">
                                                <a href="{{ route('leader.tasks.attachments.download', $file->id) }}"
                                                    class="text-decoration-none fw-bold text-dark">
                                                    {{ $file->file_name }}
                                                </a>
                                                <div class="small text-muted">
                                                    {{ number_format($file->file_size / 1024, 2) }} KB •
                                                    {{ $file->created_at->format('d/m/Y H:i') }}</div>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <a href="{{ route('leader.tasks.attachments.download', $file->id) }}"
                                                class="btn btn-sm btn-light text-primary me-1" title="Tải xuống"><i
                                                    class="fas fa-download"></i></a>
                                            <form action="{{ route('leader.tasks.attachments.destroy', $file->id) }}"
                                                method="POST" onsubmit="return confirm('Xóa file này?');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-light text-danger"
                                                    title="Xóa file"><i class="fas fa-trash"></i></button>
                                            </form>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-muted small mb-0">Chưa có tài liệu nào.</p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white py-3">
                        <h6 class="mb-0 fw-bold text-dark">{{ __('Thông Tin Chung') }}</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="small text-muted fw-bold text-uppercase">Trạng thái</label>
                            <div class="mt-1">
                                @if ($task->status == 'done')
                                    <span class="badge bg-success w-100 py-2"><i class="fas fa-check-circle me-1"></i> HOÀN
                                        THÀNH</span>
                                @elseif($task->status == 'in_progress')
                                    <span class="badge bg-info text-dark w-100 py-2"><i
                                            class="fas fa-spinner fa-spin me-1"></i> ĐANG THỰC HIỆN</span>
                                @else
                                    <span class="badge bg-warning text-dark w-100 py-2"><i class="fas fa-clock me-1"></i>
                                        CHỜ XỬ LÝ</span>
                                @endif
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="small text-muted fw-bold text-uppercase">Độ Ưu Tiên</label>
                            <div class="mt-1">
                                @if ($task->priority == 'high')
                                    <span
                                        class="badge bg-danger bg-opacity-10 text-danger border border-danger w-100 py-2">CAO</span>
                                @elseif($task->priority == 'medium')
                                    <span
                                        class="badge bg-warning bg-opacity-10 text-dark border border-warning w-100 py-2">TRUNG
                                        BÌNH</span>
                                @else
                                    <span class="badge bg-secondary bg-opacity-10 text-dark border w-100 py-2">THẤP</span>
                                @endif
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="small text-muted fw-bold text-uppercase">Hạn Chót (Due Date)</label>
                            <div class="mt-1 fw-bold text-dark">
                                @if ($task->due_date)
                                    <i class="far fa-calendar-alt me-1"></i>
                                    {{ \Carbon\Carbon::parse($task->due_date)->format('d/m/Y') }}
                                    @if ($task->due_date < now() && $task->status != 'done')
                                        <span class="text-danger small ms-1">(Quá hạn)</span>
                                    @endif
                                @else
                                    <span class="text-muted">-- Chưa thiết lập --</span>
                                @endif
                            </div>
                        </div>

                        <hr class="my-3">

                        <div class="mb-3">
                            <label class="small text-muted fw-bold text-uppercase">Người Thực Hiện</label>
                            <div class="d-flex align-items-center mt-2">
                                @if ($task->assignee)
                                    <div class="avatar-circle bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2"
                                        style="width: 40px; height: 40px; font-weight: bold;">
                                        {{ substr($task->assignee->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark">{{ $task->assignee->name }}</div>
                                        <div class="small text-muted">{{ $task->assignee->email }}</div>
                                    </div>
                                @else
                                    <span class="text-muted fst-italic">-- Chưa giao --</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white py-3">
                        <h6 class="mb-0 fw-bold text-dark">
                            <i class="fas fa-comments me-2 text-info"></i>{{ __('Trao Đổi / Bình Luận') }}
                            <span class="badge bg-light text-dark border ms-1">{{ $task->comments->count() }}</span>
                        </h6>
                    </div>
                    <div class="card-body bg-light">
                        <div class="mb-4" style="max-height: 400px; overflow-y: auto;">
                            @forelse($task->comments as $comment)
                                <div class="d-flex mb-3 {{ $comment->user_id == Auth::id() ? 'flex-row-reverse' : '' }}">
                                    <div class="flex-shrink-0">
                                        <div class="avatar-circle-sm {{ $comment->user->role == 'leader' ? 'bg-danger' : 'bg-primary' }} text-white rounded-circle d-flex align-items-center justify-content-center"
                                            style="width: 32px; height: 32px; font-weight: bold;">
                                            {{ substr($comment->user->name, 0, 1) }}
                                        </div>
                                    </div>
                                    <div class="{{ $comment->user_id == Auth::id() ? 'me-3 text-end' : 'ms-3' }}"
                                        style="max-width: 80%;">
                                        <div class="card border-0 shadow-sm">
                                            <div class="card-body p-2 px-3">
                                                <div class="d-flex justify-content-between align-items-center mb-1 gap-3">
                                                    <strong
                                                        class="small {{ $comment->user->role == 'leader' ? 'text-danger' : 'text-primary' }}">
                                                        {{ $comment->user->name }}
                                                        @if ($comment->user->role == 'leader')
                                                            (Leader)
                                                        @endif
                                                    </strong>
                                                    <small class="text-muted"
                                                        style="font-size: 0.75rem;">{{ $comment->created_at->diffForHumans() }}</small>
                                                </div>
                                                <p class="mb-0 small text-secondary text-start">{{ $comment->content }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center text-muted py-3">
                                    <small>Chưa có bình luận nào. Hãy trao đổi về công việc này.</small>
                                </div>
                            @endforelse
                        </div>

                        <div class="border-top pt-3">
                            <form action="{{ route('leader.tasks.comments.store', $task->id) }}" method="POST">
                                @csrf
                                <div class="d-flex gap-2">
                                    <div class="avatar-circle-sm bg-danger text-white rounded-circle d-flex align-items-center justify-content-center"
                                        style="width: 32px; height: 32px; font-weight: bold;">
                                        {{ substr(Auth::user()->name, 0, 1) }}
                                    </div>
                                    <div class="flex-grow-1">
                                        <textarea name="content" class="form-control" rows="2" placeholder="Nhập chỉ đạo hoặc phản hồi của bạn..."
                                            required></textarea>
                                        <div class="d-flex justify-content-end mt-2">
                                            <button type="submit" class="btn btn-primary btn-sm px-4">
                                                <i class="fas fa-paper-plane me-1"></i> Gửi bình luận
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
