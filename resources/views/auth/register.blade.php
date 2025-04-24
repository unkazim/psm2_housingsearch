@extends('ui.layout')

@section('title', 'Register')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Register</h4>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control @error('username') is-invalid @enderror" 
                               id="username" name="username" value="{{ old('username') }}" required>
                        <div class="form-text">This will be used for login.</div>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                               id="email" name="email" value="{{ old('email') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone Number</label>
                        <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                               id="phone" name="phone" value="{{ old('phone') }}" 
                               placeholder="e.g., 012-3456789" required>
                    </div>

                    <div class="mb-3">
                        <label for="user_type" class="form-label">User Type</label>
                        <select class="form-select @error('user_type') is-invalid @enderror" 
                                id="user_type" name="user_type" required>
                            <option value="">Select User Type</option>
                            <option value="student" {{ old('user_type') == 'student' ? 'selected' : '' }}>Student</option>
                            <option value="landlord" {{ old('user_type') == 'landlord' ? 'selected' : '' }}>Landlord</option>
                        </select>
                    </div>

                    <!-- Student-specific fields -->
                    <div id="studentFields" class="d-none">
                        <div class="mb-3">
                            <label for="matric_number" class="form-label">Matric Number</label>
                            <input type="text" class="form-control @error('matric_number') is-invalid @enderror" 
                                   id="matric_number" name="matric_number" value="{{ old('matric_number') }}">
                        </div>

                        <div class="mb-3">
                            <label for="faculty" class="form-label">Faculty</label>
                            <select class="form-select @error('faculty') is-invalid @enderror" 
                                    id="faculty" name="faculty">
                                <option value="">Select Faculty</option>
                                <option value="FSKTM">Faculty of Computing</option>
                                <option value="FKAAB">Faculty of Civil Engineering and Built Environment</option>
                                <option value="FKEE">Faculty of Electrical and Electronic Engineering</option>
                                <option value="FKMP">Faculty of Mechanical and Manufacturing Engineering</option>
                                <option value="FPTP">Faculty of Technology Management and Business</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="course" class="form-label">Course</label>
                            <input type="text" class="form-control @error('course') is-invalid @enderror" 
                                   id="course" name="course" value="{{ old('course') }}">
                        </div>

                        <div class="mb-3">
                            <label for="semester" class="form-label">Current Semester</label>
                            <input type="number" class="form-control @error('semester') is-invalid @enderror" 
                                   id="semester" name="semester" value="{{ old('semester') }}" min="1" max="8">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                               id="password" name="password" required>
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" 
                               id="password_confirmation" name="password_confirmation" required>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">Register</button>
                    </div>

                    <div class="mt-3 text-center">
                        <span class="text-muted">Already have an account?</span>
                        <a href="{{ route('login') }}" class="text-decoration-none">Login here</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('user_type').addEventListener('change', function() {
    const studentFields = document.getElementById('studentFields');
    const studentInputs = studentFields.querySelectorAll('input, select');
    
    if (this.value === 'student') {
        studentFields.classList.remove('d-none');
        studentInputs.forEach(input => input.required = true);
    } else {
        studentFields.classList.add('d-none');
        studentInputs.forEach(input => input.required = false);
    }

    const helpText = document.getElementById('roleHelp');
    if (this.value === 'landlord') {
        helpText.classList.remove('d-none');
    } else {
        helpText.classList.add('d-none');
    }
});

// Initialize the form based on the selected user type
window.addEventListener('load', function() {
    const userType = document.getElementById('user_type');
    if (userType.value) {
        userType.dispatchEvent(new Event('change'));
    }
});
</script>
@endsection