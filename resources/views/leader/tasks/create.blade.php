@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow border-0">
                <div class="card-header bg-primary text-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-plus-circle me-2"></i>{{ __('Tạo Công Việc Mới') }}</h5>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('leader.tasks.store') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="project_id" class="form-label fw-bold">{{ __('Thuộc Dự Án') }} <span class="text-danger">*</span></label>
                            <select id="project_id" name="project_id" class="form-select @error('project_id') is-invalid @enderror" required onchange="updateAssignees()">
                                <option value="">-- Chọn dự án --</option>
                                @foreach($projects as $project)
                                    <option value="{{ $project->id }}"
                                        {{ (old('project_id') == $project->id || (isset($selectedProjectId) && $selectedProjectId == $project->id)) ? 'selected' : '' }}
                                        data-members='@json($project->members)'>
                                        {{ $project->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('project_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="title" class="form-label fw-bold">{{ __('Tên Công Việc') }} <span class="text-danger">*</span></label>
                            <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" required placeholder="Nhập tên công việc..." autofocus>
                            @error('title')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="description" class="form-label fw-bold">{{ __('Mô Tả Chi Tiết') }}</label>
                            <textarea id="description" class="form-control" name="description" rows="4">{{ old('description') }}</textarea>
                        </div>

                        <div class="row g-4 mb-4">
                            <div class="col-md-6">
                                <label for="priority" class="form-label fw-bold">{{ __('Độ Ưu Tiên') }}</label>
                                <select name="priority" id="priority" class="form-select">
                                    <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Thấp</option>
                                    <option value="medium" {{ old('priority', 'medium') == 'medium' ? 'selected' : '' }}>Trung bình</option>
                                    <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>Cao</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="due_date" class="form-label fw-bold">{{ __('Hạn Chót') }}</label>
                                <input id="due_date" type="date" class="form-control @error('due_date') is-invalid @enderror" name="due_date" value="{{ old('due_date') }}">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="assignee_id" class="form-label fw-bold">{{ __('Giao Cho Thành Viên') }}</label>
                            <select id="assignee_id" name="assignee_id" class="form-select bg-light">
                                <option value="">-- Vui lòng chọn dự án trước --</option>
                            </select>
                            <div class="form-text">Danh sách thành viên sẽ thay đổi theo dự án bạn chọn.</div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                            <a href="{{ url()->previous() }}" class="btn btn-light px-4">{{ __('Hủy') }}</a>
                            <button type="submit" class="btn btn-primary px-5 fw-bold">
                                <i class="fas fa-save me-1"></i> {{ __('Lưu Công Việc') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Hàm cập nhật danh sách thành viên khi đổi dự án
    function updateAssignees() {
        const projectSelect = document.getElementById('project_id');
        const assigneeSelect = document.getElementById('assignee_id');
        const selectedOption = projectSelect.options[projectSelect.selectedIndex];

        // Xóa cũ
        assigneeSelect.innerHTML = '<option value="">-- Chọn thành viên --</option>';

        // Lấy data members từ attribute data-members
        const membersData = selectedOption.getAttribute('data-members');

        if (membersData) {
            const members = JSON.parse(membersData);

            if (members.length > 0) {
                assigneeSelect.classList.remove('bg-light');
                assigneeSelect.removeAttribute('disabled');

                members.forEach(member => {
                    const option = document.createElement('option');
                    option.value = member.id;
                    option.textContent = `${member.name} (${member.email})`;
                    assigneeSelect.appendChild(option);
                });
            } else {
                assigneeSelect.innerHTML = '<option value="">Dự án này chưa có thành viên</option>';
                assigneeSelect.classList.add('bg-light');
            }
        } else {
            assigneeSelect.innerHTML = '<option value="">-- Vui lòng chọn dự án trước --</option>';
            assigneeSelect.classList.add('bg-light');
        }
    }

    // Chạy ngay khi load trang (để xử lý trường hợp old input hoặc selectedProjectId)
    document.addEventListener('DOMContentLoaded', function() {
        updateAssignees();

        // Khôi phục giá trị cũ nếu có lỗi validate
        const oldAssignee = "{{ old('assignee_id') }}";
        if(oldAssignee) {
            document.getElementById('assignee_id').value = oldAssignee;
        }
    });
</script>
@endsection
