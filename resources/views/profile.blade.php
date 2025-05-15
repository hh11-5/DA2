@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Thông tin tài khoản</h4>
                </div>
                <div class="card-body">

                    <form action="{{ route('profile.update') }}" method="POST" id="profileForm">
                        @csrf
                        <div class="d-flex justify-content-end mb-3">
                            <button type="button" class="btn btn-primary" id="editButton" onclick="toggleEdit()">
                                <i class="fas fa-edit me-2"></i>Chỉnh sửa
                            </button>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Họ</label>
                                <input type="text" name="hokh" class="form-control @error('hokh') is-invalid @enderror"
                                       value="{{ old('hokh', $customer->hokh) }}" required disabled>
                                @error('hokh')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Tên</label>
                                <input type="text" name="tenkh" class="form-control @error('tenkh') is-invalid @enderror"
                                       value="{{ old('tenkh', $customer->tenkh) }}" required disabled>
                                @error('tenkh')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Địa chỉ</label>
                            <input type="text" name="diachikh"
                                   class="form-control @error('diachikh') is-invalid @enderror"
                                   value="{{ old('diachikh', $customer->diachikh) }}"
                                   required disabled
                                   id="address-input">
                            @error('diachikh')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div id="address-feedback" class="form-text"></div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email', $user->emailtk) }}" required disabled>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Số điện thoại</label>
                            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                                   value="{{ old('phone', $user->sdttk) }}" required disabled>
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="mb-0">Mật khẩu</h5>
                            <button type="button" class="btn btn-outline-primary btn-sm"
                                    onclick="togglePasswordChange()"
                                    id="changePasswordBtn"
                                    disabled>
                                <i class="fas fa-key me-2"></i>Đổi mật khẩu
                            </button>
                        </div>

                        <div id="password-change-section" style="display: none;">
                            <p class="text-muted small">Nhập thông tin để đổi mật khẩu</p>

                            <div class="mb-3">
                                <label class="form-label">Mật khẩu hiện tại</label>
                                <input type="password" name="current_password"
                                       class="form-control @error('current_password') is-invalid @enderror">
                                @error('current_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Mật khẩu mới</label>
                                <input type="password" name="new_password"
                                       class="form-control @error('new_password') is-invalid @enderror">
                                @error('new_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Xác nhận mật khẩu mới</label>
                                <input type="password" name="password_confirmation" class="form-control">
                            </div>
                        </div>

                        <div class="text-end" id="submitButton" style="display: none;">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save me-2"></i>Lưu thay đổi
                            </button>
                            <button type="button" class="btn btn-secondary ms-2" onclick="cancelEdit()">
                                <i class="fas fa-times me-2"></i>Hủy
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    border: none;
    border-radius: 15px;
}

.card-header {
    border-radius: 15px 15px 0 0 !important;
    padding: 1rem 1.5rem;
}

.form-label {
    font-weight: 500;
    color: #333;
}

.btn-primary {
    padding: 0.5rem 1.5rem;
}

.form-control:disabled {
    background-color: #f8f9fa;
    cursor: not-allowed;
}

.btn-success {
    background-color: #198754;
    border-color: #198754;
}

.btn-success:hover {
    background-color: #157347;
    border-color: #146c43;
}
</style>

<script>
function togglePasswordChange() {
    const section = document.getElementById('password-change-section');
    const inputs = section.querySelectorAll('input');

    if (section.style.display === 'none') {
        section.style.display = 'block';
        // Enable các input khi hiện form
        inputs.forEach(input => input.removeAttribute('disabled'));
    } else {
        section.style.display = 'none';
        // Disable và clear các input khi ẩn form
        inputs.forEach(input => {
            input.setAttribute('disabled', 'disabled');
            input.value = '';
        });
    }
}

// Disable tất cả input password khi trang load
document.addEventListener('DOMContentLoaded', function() {
    const section = document.getElementById('password-change-section');
    const inputs = section.querySelectorAll('input');
    inputs.forEach(input => input.setAttribute('disabled', 'disabled'));
});

// Update toggleEdit function
function toggleEdit() {
    const form = document.getElementById('profileForm');
    const inputs = form.querySelectorAll('input:not([name^="password"])');
    const editButton = document.getElementById('editButton');
    const submitButton = document.getElementById('submitButton');
    const changePasswordBtn = document.getElementById('changePasswordBtn');

    inputs.forEach(input => {
        input.disabled = false;
    });

    editButton.style.display = 'none';
    submitButton.style.display = 'block';
    changePasswordBtn.disabled = false; // Enable password change button
}

// Update cancelEdit function
function cancelEdit() {
    const form = document.getElementById('profileForm');
    const inputs = form.querySelectorAll('input:not([name^="password"])');
    const editButton = document.getElementById('editButton');
    const submitButton = document.getElementById('submitButton');
    const changePasswordBtn = document.getElementById('changePasswordBtn');
    const passwordSection = document.getElementById('password-change-section');

    // Reset form to original values
    form.reset();

    // Disable all inputs
    inputs.forEach(input => {
        input.disabled = true;
    });

    // Reset password section
    passwordSection.style.display = 'none';
    const passwordInputs = passwordSection.querySelectorAll('input');
    passwordInputs.forEach(input => {
        input.setAttribute('disabled', 'disabled');
        input.value = '';
    });

    editButton.style.display = 'block';
    submitButton.style.display = 'none';
    changePasswordBtn.disabled = true; // Disable password change button
    document.getElementById('address-feedback').textContent = '';
}

// Update DOMContentLoaded event
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('profileForm');
    const inputs = form.querySelectorAll('input:not([name^="password"])');
    const changePasswordBtn = document.getElementById('changePasswordBtn');
    const passwordSection = document.getElementById('password-change-section');
    const passwordInputs = passwordSection.querySelectorAll('input');

    // Disable all regular inputs
    inputs.forEach(input => {
        input.disabled = true;
    });

    // Disable password change button and inputs
    changePasswordBtn.disabled = true;
    passwordInputs.forEach(input => {
        input.setAttribute('disabled', 'disabled');
    });
});

// Thay thế phần xử lý submit form bằng code sau
document.getElementById('profileForm').addEventListener('submit', async function(e) {
    e.preventDefault();

    const addressInput = document.getElementById('address-input');
    const phoneInput = document.querySelector('input[name="phone"]');
    const feedback = document.getElementById('address-feedback');
    const submitButton = this.querySelector('button[type="submit"]');

    // Validate phone number
    if (!phoneInput.disabled && !validatePhone(phoneInput.value)) {
        phoneInput.classList.add('is-invalid');
        const feedbackDiv = phoneInput.nextElementSibling || document.createElement('div');
        feedbackDiv.className = 'invalid-feedback';
        feedbackDiv.textContent = 'Số điện thoại không đúng định dạng Việt Nam';
        if (!phoneInput.nextElementSibling) {
            phoneInput.parentNode.appendChild(feedbackDiv);
        }
        return;
    }

    // Remove phone error if valid
    phoneInput.classList.remove('is-invalid');

    // Nếu địa chỉ không thay đổi, submit form luôn
    if (addressInput.value === '{{ $customer->diachikh }}') {
        this.submit();
        return;
    }

    // Disable nút submit trong khi kiểm tra
    submitButton.disabled = true;
    submitButton.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Đang kiểm tra địa chỉ...';

    try {
        const response = await fetch(`/verify-address?address=${encodeURIComponent(addressInput.value)}`);

        if (!response.ok) {
            throw new Error('Lỗi kết nối server');
        }

        const data = await response.json();

        if (data.isValid) {
            this.submit();
        } else {
            feedback.innerHTML = `
                <div class="text-danger">
                    <p>❌ ${data.error || 'Địa chỉ không hợp lệ'}</p>
                    <p class="small mt-2">Vui lòng nhập địa chỉ đầy đủ (Số nhà, Đường, Phường/Xã, Quận/Huyện, Tỉnh/Thành phố)</p>
                </div>
            `;
            feedback.className = 'form-text mt-2';
        }
    } catch (error) {
        feedback.innerHTML = `
            <div class="text-danger">
                <p>❌ Lỗi kiểm tra địa chỉ</p>
                <p class="small mt-2">Vui lòng thử lại sau hoặc liên hệ hỗ trợ</p>
            </div>
        `;
        feedback.className = 'form-text mt-2';
    } finally {
        submitButton.disabled = false;
        submitButton.innerHTML = '<i class="fas fa-save me-2"></i>Lưu thay đổi';
    }
});

// Xóa feedback khi người dùng thay đổi địa chỉ
document.getElementById('address-input').addEventListener('input', function() {
    document.getElementById('address-feedback').textContent = '';
});

// Add this function for phone validation
function validatePhone(phone) {
    // Clean the phone number
    let cleanPhone = phone.replace(/[^0-9]/g, '');

    // Convert 84 prefix to 0
    if (cleanPhone.startsWith('84')) {
        cleanPhone = '0' + cleanPhone.substring(2);
    }

    // Check Vietnamese phone pattern
    const pattern = /^0[3|5|7|8|9][0-9]{8}$/;
    return pattern.test(cleanPhone);
}

// Add phone validation on input
document.querySelector('input[name="phone"]').addEventListener('input', function() {
    this.classList.remove('is-invalid');
    const feedback = this.nextElementSibling;
    if (feedback && feedback.classList.contains('invalid-feedback')) {
        feedback.remove();
    }
});
</script>
@endsection
