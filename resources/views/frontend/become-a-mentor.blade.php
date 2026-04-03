@extends('frontend.layout.layout')
@section('title', 'Become a Mentor | Share Your Knowledge | EFOS Edumarketers Pvt Ltd')
@section('meta_description',
    'Join EFOS as a mentor and help students grow. Share your expertise, conduct online
    sessions and earn by guiding students in career and skills development.')
@section('meta_keywords',
    'become mentor, online mentor registration, teach online, mentor platform, career mentor
    registration, mentor opportunities')
@section('meta_robots', 'index, follow')
@section('canonical', url('become-mentor'))
@push('style')
    <style>
        :root {
            --primary-color: #E72939;
            --dark-color: #181818;
            --gray-light: #f8f9fa;
            --gray-medium: #999;
            --white: #ffffff;
            --border-color: #e0e0e0;
            --success-color: #10b981;
            --error-color: #ef4444;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .mentor-form-section {
            padding: 60px 0;
            background: linear-gradient(135deg, #f9f9f9 0%, #ffffff 100%);
            min-height: 100vh;
        }

        .form-header {
            text-align: center;
            margin-bottom: 50px;
        }

        .form-header h2 {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--dark-color);
            margin-bottom: 12px;
            letter-spacing: -0.5px;
        }

        .form-header p {
            font-size: 1.1rem;
            color: var(--gray-medium);
            font-weight: 400;
        }

        .form-wrapper {
            background: var(--white);
            border-radius: 16px;
            padding: 40px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(0, 0, 0, 0.05);
            max-width: 900px;
            margin: 0 auto;
        }

        .mentor-form {
            display: flex;
            flex-direction: column;
        }

        /* Alert Messages */
        .alert-error,
        .alert-success {
            padding: 16px 20px;
            border-radius: 12px;
            margin-bottom: 25px;
            display: flex;
            align-items: flex-start;
            gap: 12px;
            animation: slideDown 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .alert-error {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #b91c1c;
        }

        .alert-error h4 {
            margin: 0 0 8px 0;
            font-weight: 700;
            font-size: 0.95rem;
        }

        .alert-error ul {
            margin: 0;
            padding-left: 20px;
            font-size: 0.9rem;
            line-height: 1.6;
        }

        .alert-success {
            background: rgba(16, 185, 129, 0.1);
            border: 1px solid rgba(16, 185, 129, 0.3);
            color: #065f46;
        }

        .success-icon {
            font-weight: 700;
            font-size: 1.2rem;
            flex-shrink: 0;
        }

        /* Form Grid */
        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 24px;
            margin-bottom: 30px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        .form-section {
            grid-column: 1 / -1;
        }

        .section-title {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--dark-color);
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .section-title::before {
            content: '';
            display: inline-block;
            width: 4px;
            height: 24px;
            background: var(--primary-color);
            border-radius: 2px;
        }

        /* Profile Photo Upload */
        .photo-upload-wrapper {
            position: relative;
        }

        .photo-preview {
            border: 2px dashed var(--border-color);
            border-radius: 12px;
            padding: 40px;
            text-align: center;
            cursor: pointer;
            transition: var(--transition);
            background: linear-gradient(135deg, rgba(231, 41, 57, 0.05), rgba(24, 24, 24, 0.02));
        }

        .photo-preview:hover {
            border-color: var(--primary-color);
            background: linear-gradient(135deg, rgba(231, 41, 57, 0.08), rgba(24, 24, 24, 0.04));
        }

        .upload-icon {
            width: 48px;
            height: 48px;
            color: var(--primary-color);
            margin: 0 auto 12px;
            stroke-width: 1.5;
        }

        .photo-preview p {
            font-size: 1rem;
            font-weight: 600;
            color: var(--dark-color);
            margin: 0 0 6px 0;
        }

        .photo-preview span {
            font-size: 0.85rem;
            color: var(--gray-medium);
            display: block;
        }

        .photo-input {
            display: none;
        }

        /* Form Label */
        .form-label {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 0.95rem;
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 8px;
            letter-spacing: 0.3px;
        }

        .required {
            color: var(--primary-color);
            font-weight: 800;
            font-size: 1.1rem;
        }

        /* Form Inputs */
        .form-input {
            padding: 12px 16px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 0.95rem;
            font-family: inherit;
            color: var(--dark-color);
            background: var(--white);
            transition: var(--transition);
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(231, 41, 57, 0.1);
        }

        .form-input::placeholder {
            color: var(--gray-medium);
        }

        .form-input.error {
            border-color: #ef4444;

            background: rgba(239, 68, 68, 0.05);
        }

        /* Phone Input */
        .phone-input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
            width: 100%;
        }

        .phone-prefix {
            position: absolute;
            left: 16px;
            color: var(--gray-medium);
            font-weight: 600;
            pointer-events: none;
        }

        .phone-input-wrapper .form-input {
            padding-left: 45px;
            width: 100%;
        }

        /* Error Messages */
        .error-text {
            font-size: 0.8rem;
            color: var(--error-color);
            margin-top: 6px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .error-text::before {
            content: '⚠';
            font-weight: 700;
        }

        /* Form Actions */
        .form-actions {
            display: flex;
            gap: 16px;
            justify-content: center;
            margin-top: 30px;
            padding-top: 30px;
            border-top: 1px solid rgba(0, 0, 0, 0.05);
        }

        .btn-submit,
        .btn-cancel {
            padding: 14px 32px;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            border: none;
        }

        .btn-submit {
            background: linear-gradient(135deg, var(--primary-color), #ff4757);
            color: #ffffff;
            box-shadow: 0 4px 15px rgba(231, 41, 57, 0.3);
            position: relative;
            overflow: hidden;
            min-width: 200px;
            justify-content: center;

        }

        /* force text white */

        .btn-submit .btn-text {
            color: #ffffff;

        }

        .btn-submit .btn-icon {
            color: #ffffff;

        }


        /* keep white on hover */

        .btn-submit:hover {
            color: #ffffff;
            background: #181818;

        }

        .btn-submit::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.25), transparent);
            transition: left 0.6s ease;
        }

        .btn-submit:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(231, 41, 57, 0.4);
        }

        .btn-submit:hover::before {
            left: 100%;
        }

        .btn-cancel {
            background: var(--gray-light);
            color: var(--dark-color);
            border: 1px solid var(--border-color);
        }

        .btn-cancel:hover {
            background: var(--border-color);
            transform: translateY(-2px);
        }

        .btn-icon {
            font-weight: 700;
            transition: transform 0.3s ease;
        }

        .btn-submit:hover .btn-icon {
            transform: translateX(4px);
        }

        /* Animations */
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .form-wrapper {
                padding: 30px 20px;
            }

            .form-header h2 {
                font-size: 2rem;
            }

            .form-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .form-actions {
                flex-direction: column;
            }

            .btn-submit,
            .btn-cancel {
                width: 100%;
                justify-content: center;
            }

            .photo-preview {
                padding: 30px 20px;
            }
        }

        @media (max-width: 480px) {
            .mentor-form-section {
                padding: 40px 0;
            }

            .form-wrapper {
                padding: 24px 16px;
                border-radius: 12px;
            }

            .form-header h2 {
                font-size: 1.6rem;
            }

            .form-header p {
                font-size: 0.95rem;
            }

            .form-label {
                font-size: 0.9rem;
            }

            .form-input {
                font-size: 0.9rem;
                padding: 10px 12px;
            }

            .upload-icon {
                width: 36px;
                height: 36px;
            }

            .form-actions {
                gap: 12px;
            }

            .btn-submit,
            .btn-cancel {
                padding: 12px 24px;
                font-size: 0.9rem;
            }
        }

        .spinner {
            width: 16px;
            height: 16px;
            border: 2px solid #fff;
            border-top: 2px solid transparent;
            border-radius: 50%;
            display: inline-block;
            animation: spin 0.6s linear infinite;
        }

        @keyframes spin {
            100% {
                transform: rotate(360deg)
            }
        }

        .btn-submit:disabled {
            opacity: 0.85;
            cursor: not-allowed;

        }
    </style>
@endpush
@section('content')

    <main>
        <!-- Banner area start here -->
        <section class="banner-inner-area sub-bg bg-image">
            <div class="container">
                <div class="banner-inner__content">
                    <h1>
                        Become a Mentor
                    </h1>
                    <ul>
                        <li><a href="{{ url('/') }}">Home</a></li>
                        <li><i class="fa-regular fa-angle-right"></i></li>
                        <li>Become a Mentor</li>
                    </ul>
                </div>
            </div>
        </section>

        <!-- Mentor Application Form Section -->
        <section class="mentor-form-section">
            <div class="container">
                <div class="form-header">
                    <h2>Join Our Mentor Community</h2>
                    <p>Share your expertise and help students achieve their goals</p>
                </div>

                <div class="form-wrapper">
                    <form action="{{ route('mentor.store') }}" method="POST" enctype="multipart/form-data"
                        class="mentor-form">
                        @csrf
                        <!-- Form Grid -->
                        <div class="form-grid">

                            <!-- Mentor Category -->
                            <div class="form-group">
                                <label for="mentor_category_id" class="form-label">
                                    <span class="label-text">Expertises</span>
                                    <span class="required">*</span>
                                </label>

                                <select name="mentor_category_id" id="mentor_category_id" class="form-input" required>
                                    <option value="">Select a expertise</option>
                                    @foreach ($expertises as $expertise)
                                        <option value="{{ $expertise->id }}"
                                            {{ old('mentor_category_id') == $expertise->id ? 'selected' : '' }}>
                                            {{ $expertise->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('mentor_category_id')
                                    <span class="error-text">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <!-- Name -->
                            <div class="form-group">
                                <label for="name" class="form-label">
                                    <span class="label-text">Full Name</span>
                                    <span class="required">*</span>
                                </label>
                                <input type="text" name="name" id="name" class="form-input"
                                    placeholder="Enter your full name" pattern="[A-Za-z ]+" title="Only letters allowed"
                                    required>
                                @error('name')
                                    <span class="error-text">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="form-group">
                                <label for="email" class="form-label">
                                    <span class="label-text">Email Address</span>
                                    <span class="required">*</span>
                                </label>
                                <input type="email" name="email" id="email" class="form-input"
                                    placeholder="your@email.com" required>
                                @error('email')
                                    <span class="error-text">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Phone -->
                            <div class="form-group">
                                <label for="phone" class="form-label">
                                    <span class="label-text">Phone Number</span>
                                    <span class="required">*</span>
                                </label>
                                <div class="phone-input-wrapper">
                                    <span class="phone-prefix">+91</span>
                                    <input type="tel" name="phone" id="phone" class="form-input"
                                        placeholder="10 digit number" maxlength="10" pattern="[0-9]{10}"
                                        title="Enter 10 digit phone number" required>
                                </div>
                                @error('phone')
                                    <span class="error-text">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Profile Photo Section -->
                            <div class="form-section full-width" style="margin-bottom: 30px;">
                                <h3 class="section-title">Profile Photo</h3>
                                <div class="photo-upload-wrapper">
                                    <div class="photo-preview" id="photoPreview">
                                        <svg class="upload-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                            <polyline points="17 8 12 3 7 8"></polyline>
                                            <line x1="12" y1="3" x2="12" y2="15"></line>
                                        </svg>
                                        <p>Click to upload or drag and drop</p>
                                        <span>PNG, JPG, GIF up to 2MB</span>
                                    </div>
                                    <input type="file" name="profile_photo" id="profilePhoto" class="photo-input"
                                        accept="image/*">
                                </div>
                            </div>

                        </div>

                        <!-- Form Actions -->
                        <div class="form-actions">
                            <button type="submit" class="btn-submit" id="submitBtn">
                                <span class="btn-text">
                                    Submit Application
                                </span>
                                <span class="btn-icon">
                                    →
                                </span>
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </section>

    </main>



    @push('script')
        <script>
            document.querySelector('.mentor-form')

                .addEventListener('submit', function() {

                    let btn = document.getElementById('submitBtn');

                    btn.disabled = true;

                    btn.querySelector('.btn-text').innerHTML =

                        'Your Application is Submitting...';

                    btn.querySelector('.btn-icon').innerHTML =

                        '⏳';

                });
        </script>
        <script>
            // Photo Preview
            document.getElementById('profilePhoto').addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const preview = document.getElementById('photoPreview');
                        preview.innerHTML = `
                        <img src="${e.target.result}" alt="Preview" style="max-width: 100%; max-height: 300px; border-radius: 8px;">
                        <p style="margin-top: 12px; font-size: 0.9rem;">Click to change photo</p>
                    `;
                    };
                    reader.readAsDataURL(file);
                }
            });

            // Photo Upload Click
            document.getElementById('photoPreview').addEventListener('click', function() {
                document.getElementById('profilePhoto').click();
            });

            // Form Validation
            document.querySelector('.mentor-form').addEventListener('submit', function(e) {
                const mentorCategory = document.getElementById('mentor_category_id').value;
                const name = document.getElementById('name').value.trim();
                const email = document.getElementById('email').value.trim();
                const phone = document.getElementById('phone').value.trim();

                if (!mentorCategory || !name || !email || !phone) {
                    e.preventDefault();
                    alert('Please fill in all required fields');
                    return false;
                }

                if (phone.length !== 10) {
                    e.preventDefault();
                    alert('Phone number must be 10 digits');
                    return false;
                }
            });
        </script>



        <script>
            const nameInput = document.getElementById('name');
            const phoneInput = document.getElementById('phone');
            const emailInput = document.getElementById('email');


            /* name validation */
            nameInput.addEventListener('input', function() {
                this.value = this.value.replace(/[^A-Za-z ]/g, '');
                if (this.value.length < 3) {
                    showError(this, 'Enter valid name');
                } else {
                    removeError(this);
                }
            });

            /* phone validation */
            phoneInput.addEventListener('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '');
                if (this.value.length !== 10) {
                    showError(this, 'Phone must be 10 digits');
                } else {
                    removeError(this);
                }
            });


            /* email validation */
            emailInput.addEventListener('input', function() {
                let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailPattern.test(this.value)) {
                    showError(this, 'Enter valid email');
                } else {
                    removeError(this);
                }
            });

            /* error functions */
            function showError(input, message) {
                input.classList.add('error');
                let parent = input.closest('.form-group');
                let error = parent.querySelector('.live-error');
                if (!error) {
                    error = document.createElement('span');
                    error.className = 'error-text live-error';
                    parent.appendChild(error);
                }
                error.textContent = message;
            }

            function removeError(input) {
                input.classList.remove('error');
                let parent = input.closest('.form-group');
                let error = parent.querySelector('.live-error');
                if (error) {
                    error.remove();
                }
            }
        </script>
    @endpush



@endsection
