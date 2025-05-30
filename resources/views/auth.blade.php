<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
    <!-- <link rel="stylesheet" href="./assets/css/sign.css" /> -->
    <title>Đăng ký và đăng nhập</title>
    <!-- <link rel="icon" href="/assets/img/favicon.png" /> -->

</head>

<body>
    <div class="container">
        <div class="forms-container">
            <div class="signin-signup">
                <form action="{{ route('auth.login') }}" method="POST" class="sign-in-form">
                    @csrf
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="input-field">
                        <i class="fas fa-user"></i>
                        <input type="text" name="email_or_phone" placeholder="Email hoặc số điện thoại" required />
                    </div>
                    <div class="input-field password-field">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password" placeholder="Mật khẩu" required />
                        <i class="fas fa-eye password-toggle" style="margin-right: 15px;"></i>
                    </div>
                    <button type="submit" class="btn btn-primary">Đăng nhập</button>
                    <div class="mt-3 text-center">
                        <small class="text-muted">Bạn là nhân viên? </small>
                        <a href="{{ route('admin.loginForm') }}" class="text-primary">
                            Đăng nhập tại đây
                        </a>
                    </div>
                </form>
                <form action="{{ route('auth.register') }}" method="POST" class="sign-up-form">
                    @csrf
                    @if ($errors->any())
                        <div style="color: red;">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session('success'))
                        <p style="color: green;">{{ session('success') }}</p>
                    @endif

                    <h2 class="title">Đăng ký tài khoản khách hàng</h2>
                    <div class="input-field">
                        <i class="fas fa-envelope"></i>
                        <input name="email" type="email" placeholder="Email" required />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-phone"></i>
                        <input name="phone" type="text" placeholder="Số điện thoại" maxlength="10" required />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-add"></i>
                        <input name="add" type="text" placeholder="Địa chỉ" maxlength="200" required />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-name"></i>
                        <input type="text" name="full_name" placeholder="Họ và tên" required>
                    </div>
                    <div class="input-field password-field">
                        <i class="fas fa-lock"></i>
                        <input name="password1" type="password" placeholder="Mật khẩu" required />
                        <i class="fas fa-eye password-toggle"></i>
                    </div>
                    <div class="password-requirements" style="display: none;">
                        <small class="text-muted">
                            Mật khẩu phải có:
                            <ul>
                                <li>8-16 ký tự</li>
                                <li>Ít nhất 1 chữ thường (a-z)</li>
                                <li>Ít nhất 1 chữ hoa (A-Z)</li>
                                <li>Ít nhất 1 số (0-9)</li>
                                <li>Ít nhất 1 ký tự đặc biệt (@$!%*?&)</li>
                            </ul>
                        </small>
                    </div>

                    <div class="input-field password-field">
                        <i class="fas fa-lock"></i>
                        <input name="password2" type="password" placeholder="Nhập lại mật khẩu" required />
                        <i class="fas fa-eye password-toggle"></i>
                    </div>
                    <?=isset($message) ? $message : ''?>
                    <input name="SignUp" type="submit" class="btn" value="Đăng ký" />
                </form>
            </div>
        </div>
        <div class="panels-container">
            <div class="panel left-panel">
                <div class="content">
                    <h3>Thành viên mới?</h3>
                    <p>Nếu bạn chưa có tài khoản. Hãy tạo ngay một tài khoản và tham gia cùng chúng tôi nào!</p>
                    <button class="btn transparent" id="sign-up-btn">Đăng ký</button>
                </div>
            </div>
            <div class="panel right-panel">
                <div class="content">
                    <h3>Xin chào!</h3>
                    <p>Nếu bạn đã có tài khoản. Hãy đăng nhập vào để bắt đầu mua hàng!</p>
                    <button class="btn transparent" id="sign-in-btn">Đăng nhập</button>
                </div>
            </div>
        </div>
    </div>
    <!-- <script src="./assets/js/sign.js"></script> -->

</body>
<style>
    @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700;800&display=swap");
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body,
input {
    font-family: "Poppins", sans-serif;
}

.container {
    position: relative;
    width: 100%;
    background-color: #fff;
    min-height: 100vh;
    overflow: hidden;
}

.forms-container {
    position: absolute;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
}

.signin-signup {
    position: absolute;
    top: 50%;
    transform: translate(-50%, -50%);
    left: 75%;
    width: 50%;
    transition: 1s 0.7s ease-in-out;
    display: grid;
    grid-template-columns: 1fr;
    z-index: 5;
}

form {
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    padding: 0rem 5rem;
    transition: all 0.2s 0.7s;
    overflow: hidden;
    grid-column: 1 / 2;
    grid-row: 1 / 2;
}

form.sign-up-form {
    opacity: 0;
    z-index: 1;
}

form.sign-in-form {
    z-index: 2;
}

.title {
    font-size: 2.2rem;
    color: #1e293b;
    margin-bottom: 10px;
}

.input-field {
    max-width: 380px;
    width: 100%;
    background-color: #f8fafc;
    border: 1px solid #e2e8f0;
    margin: 10px 0;
    height: 55px;
    border-radius: 55px;
    display: grid;
    grid-template-columns: 15% 85%;
    padding: 0 0.4rem;
    position: relative;
}

.input-field i {
    text-align: center;
    line-height: 55px;
    color: #64748b;
    transition: 0.5s;
    font-size: 1.1rem;
}

.input-field input {
    background: none;
    outline: none;
    border: none;
    line-height: 1;
    font-weight: 600;
    font-size: 1.1rem;
    color: #1e293b;
}

.input-field input::placeholder {
    color: #94a3b8;
    font-weight: 500;
}

.social-text {
    padding: 0.7rem 0;
    font-size: 1rem;
}

.social-media {
    display: flex;
    justify-content: center;
}

.social-icon {
    height: 46px;
    width: 46px;
    display: flex;
    justify-content: center;
    align-items: center;
    margin: 0 0.45rem;
    color: #475569;
    border-radius: 50%;
    border: 1px solid #475569;
    text-decoration: none;
    font-size: 1.1rem;
    transition: 0.3s;
}

.social-icon:hover {
    color: #334155;
    border-color: #334155;
    transform: translateY(-2px);
}

.btn {
    width: 150px;
    background-color: #475569;
    border: none;
    outline: none;
    height: 49px;
    border-radius: 49px;
    color: #fff;
    text-transform: uppercase;
    font-weight: 600;
    margin: 10px 0;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn:hover {
    background-color: #334155;
    transform: translateY(-2px);
}

.panels-container {
    position: absolute;
    height: 100%;
    width: 100%;
    top: 0;
    left: 0;
    display: grid;
    grid-template-columns: repeat(2, 1fr);
}

.container:before {
    content: "";
    position: absolute;
    height: 2000px;
    width: 2000px;
    top: -10%;
    right: 48%;
    transform: translateY(-50%);
    background-image: linear-gradient(135deg, #94a3b8, #475569);
    transition: 1.8s ease-in-out;
    border-radius: 50%;
    z-index: 6;
}

.image {
    width: 100%;
    transition: transform 1.1s ease-in-out;
    transition-delay: 0.4s;
}

.panel {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    justify-content: space-around;
    text-align: center;
    z-index: 6;
}

.left-panel {
    pointer-events: all;
    padding: 3rem 17% 2rem 12%;
}

.right-panel {
    pointer-events: none;
    padding: 3rem 12% 2rem 17%;
}

.panel .content {
    color: #fff;
    transition: transform 0.9s ease-in-out;
    transition-delay: 0.6s;
}

.panel h3 {
    font-weight: 600;
    line-height: 1;
    font-size: 1.5rem;
    color: #fff;
}

.panel p {
    font-size: 0.95rem;
    padding: 0.7rem 0;
    color: rgba(255, 255, 255, 0.9);
}

.btn.transparent {
    margin: 0;
    background: none;
    border: 2px solid #fff;
    width: 130px;
    height: 41px;
    font-weight: 600;
    font-size: 0.8rem;
    color: #fff;
}

.btn.transparent:hover {
    background: rgba(255, 255, 255, 0.1);
}

.right-panel .image,
.right-panel .content {
    transform: translateX(800px);
}


/* ANIMATION */

.container.sign-up-mode:before {
    transform: translate(100%, -50%);
    right: 52%;
    transition: transform 1.5s ease-in-out;
}

.container.sign-up-mode .left-panel .image,
.container.sign-up-mode .left-panel .content {
    transform: translateX(-800px);
}

.container.sign-up-mode .signin-signup {
    left: 25%;
    transition: transform 0.7s ease-in-out;
}

.container.sign-up-mode form.sign-up-form {
    opacity: 1;
    z-index: 2;
}

.container.sign-up-mode form.sign-in-form {
    opacity: 0;
    z-index: 1;
}

.container.sign-up-mode .right-panel .image,
.container.sign-up-mode .right-panel .content {
    transform: translateX(0%);
}

.container.sign-up-mode .left-panel {
    pointer-events: none;
}

.container.sign-up-mode .right-panel {
    pointer-events: all;
}

@media (max-width: 870px) {
    .container {
        min-height: 800px;
        height: 100vh;
    }
    .signin-signup {
        width: 100%;
        top: 95%;
        transform: translate(-50%, -100%);
        transition: 1s 0.8s ease-in-out;
    }
    .signin-signup,
    .container.sign-up-mode .signin-signup {
        left: 50%;
    }
    .panels-container {
        grid-template-columns: 1fr;
        grid-template-rows: 1fr 2fr 1fr;
    }
    .panel {
        flex-direction: row;
        justify-content: space-around;
        align-items: center;
        padding: 2.5rem 8%;
        grid-column: 1 / 2;
    }
    .right-panel {
        grid-row: 3 / 4;
    }
    .left-panel {
        grid-row: 1 / 2;
    }
    .image {
        width: 200px;
        transition: transform 0.9s ease-in-out;
        transition-delay: 0.6s;
    }
    .panel .content {
        padding-right: 15%;
        transition: transform 0.9s ease-in-out;
        transition-delay: 0.8s;
    }
    .panel h3 {
        font-size: 1.2rem;
    }
    .panel p {
        font-size: 0.7rem;
        padding: 0.5rem 0;
    }
    .btn.transparent {
        width: 110px;
        height: 35px;
        font-size: 0.7rem;
    }
    .container:before {
        width: 1500px;
        height: 1500px;
        transform: translateX(-50%);
        left: 30%;
        bottom: 68%;
        right: initial;
        top: initial;
        transition: 2s ease-in-out;
        background-image: linear-gradient(135deg, #94a3b8, #475569);
    }
    .container.sign-up-mode:before {
        transform: translate(-50%, 100%);
        bottom: 32%;
        right: initial;
    }
    .container.sign-up-mode .left-panel .image,
    .container.sign-up-mode .left-panel .content {
        transform: translateY(-300px);
    }
    .container.sign-up-mode .right-panel .image,
    .container.sign-up-mode .right-panel .content {
        transform: translateY(0px);
    }
    .right-panel .image,
    .right-panel .content {
        transform: translateY(300px);
    }
    .container.sign-up-mode .signin-signup {
        top: 5%;
        transform: translate(-50%, 0);
    }
}

@media (max-width: 570px) {
    form {
        padding: 0 1.5rem;
    }
    .image {
        display: none;
    }
    .panel .content {
        padding: 0.5rem 1rem;
    }
    .container {
        padding: 1.5rem;
    }
    .container:before {
        bottom: 72%;
        left: 50%;
    }
    .container.sign-up-mode:before {
        bottom: 28%;
        left: 50%;
    }
    form {
        background: white;
        margin: 1rem;
    }
}
    /* Thêm các rules mới này */
.container.sign-up-mode .panels-container {
    display: none;
}

.container.sign-up-mode:before {
    display: none;
}

.container.sign-up-mode .signin-signup {
    left: 50%;
    transform: translate(-50%, -50%);
}

form.sign-up-form {
    opacity: 0;
    z-index: 1;
    display: none;
}

.container.sign-up-mode form.sign-up-form {
    opacity: 1;
    z-index: 2;
    display: flex;
}

.container.sign-up-mode form.sign-in-form {
    display: none;
}

/* Thêm hiệu ứng hover cho input field */
.input-field:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
}

/* Style cho icon hiện/ẩn mật khẩu */
.password-field {
    position: relative;
}

.password-toggle {
    position: absolute;
    right: 15px;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
    color: #64748b;
    z-index: 10;
    transition: all 0.3s ease;
}

.password-toggle:hover {
    color: #475569;
}

/* Thêm hiệu ứng ripple cho buttons */
.btn {
    position: relative;
    overflow: hidden;
}

.btn:after {
    content: '';
    position: absolute;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    pointer-events: none;
    background-image: radial-gradient(circle, #fff 10%, transparent 10.01%);
    background-repeat: no-repeat;
    background-position: 50%;
    transform: scale(10, 10);
    opacity: 0;
    transition: transform .5s, opacity 1s;
}

.btn:active:after {
    transform: scale(0, 0);
    opacity: .3;
    transition: 0s;
}

/* Thêm animation cho form errors và success messages */
.alert {
    animation: slideDown 0.4s ease-out;
    padding: 10px 15px;
    border-radius: 8px;
    margin-bottom: 15px;
    width: 100%;
}

.alert-danger {
    background-color: #fee2e2;
    border: 1px solid #fecaca;
    color: #dc2626;
}

.alert-success {
    background-color: #dcfce7;
    border: 1px solid #bbf7d0;
    color: #16a34a;
}

@keyframes slideDown {
    from {
        transform: translateY(-20px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

.password-requirements {
    width: 100%;
    max-width: 380px;
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 10px;
    margin-top: -5px;
    margin-bottom: 10px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    position: relative;
    opacity: 0;
    visibility: hidden;
    transform: translateY(-10px);
    transition: opacity 0.3s ease, transform 0.3s ease, visibility 0.3s ease;
}

.password-requirements.show {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}

.password-requirements ul {
    padding-left: 20px;
    margin: 5px 0;
    list-style-type: none;
}

.password-requirements li {
    margin: 4px 0;
    font-size: 0.75rem;
    color: #64748b;
    position: relative;
    padding-left: 20px;
}

.password-requirements li:before {
    content: "•";
    position: absolute;
    left: 0;
    color: #94a3b8;
}
</style>

<script>
const sign_in_btn = document.querySelector("#sign-in-btn");
const sign_up_btn = document.querySelector("#sign-up-btn");
const container = document.querySelector(".container");

sign_up_btn.addEventListener("click", () => {
    container.classList.add("sign-up-mode");
});

sign_in_btn.addEventListener("click", () => {
    container.classList.remove("sign-up-mode");
});

// Xử lý hiện/ẩn mật khẩu
document.querySelectorAll('.password-toggle').forEach(toggle => {
    toggle.addEventListener('click', function() {
        const passwordField = this.closest('.password-field');
        const input = passwordField.querySelector('input[type="password"], input[type="text"]');

        if (input.type === 'password') {
            input.type = 'text';
            this.classList.remove('fa-eye');
            this.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            this.classList.remove('fa-eye-slash');
            this.classList.add('fa-eye');
        }
    });
});

// Thêm hiệu ứng ripple cho buttons
document.querySelectorAll('.btn').forEach(button => {
    button.addEventListener('click', function(e) {
        const rect = button.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;

        button.style.setProperty('--ripple-x', x + 'px');
        button.style.setProperty('--ripple-y', y + 'px');
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const password1Input = document.querySelector('input[name="password1"]');
    const password2Input = document.querySelector('input[name="password2"]');
    const requirements = document.querySelector('.password-requirements');
    let isPasswordFieldFocused = false;

    function showRequirements() {
        requirements.style.display = 'block';
        // Đợi một chút để CSS transition hoạt động
        requestAnimationFrame(() => {
            requirements.classList.add('show');
        });
        isPasswordFieldFocused = true;
    }

    function hideRequirements() {
        if (!isPasswordFieldFocused) {
            requirements.classList.remove('show');
            // Đợi animation kết thúc mới ẩn element
            setTimeout(() => {
                if (!isPasswordFieldFocused) {
                    requirements.style.display = 'none';
                }
            }, 300);
        }
    }

    password1Input.addEventListener('focus', showRequirements);
    password2Input.addEventListener('focus', showRequirements);

    password1Input.addEventListener('blur', () => {
        if (!document.activeElement.isSameNode(password2Input)) {
            isPasswordFieldFocused = false;
            hideRequirements();
        }
    });

    password2Input.addEventListener('blur', () => {
        if (!document.activeElement.isSameNode(password1Input)) {
            isPasswordFieldFocused = false;
            hideRequirements();
        }
    });

    // Ngăn chặn việc ẩn requirements khi click vào chính nó
    requirements.addEventListener('mousedown', (e) => {
        e.preventDefault();
    });
});
</script>

</html>
