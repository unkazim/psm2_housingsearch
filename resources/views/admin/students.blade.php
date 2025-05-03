@extends('ui.layout')

@section('title', 'Manage Students')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-primary">Manage Students</h1>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-primary">
            <i class="fas fa-arrow-left"></i> Back to Dashboard
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($students->isEmpty())
        <div class="alert alert-info shadow-sm">
            <p class="mb-0"><i class="fas fa-info-circle me-2"></i>There are no students in the system.</p>
        </div>
    @else
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-user-graduate me-2"></i>All Students ({{ $students->count() }})</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover" id="studentsTable">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Matric Number</th>
                                <th>Faculty</th>
                                <th>Course</th>
                                <th>Semester</th>
                                <th>Registration Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($students as $student)
                                <tr>
                                    <td>{{ $student->user->name }}</td>
                                    <td>{{ $student->user->email }}</td>
                                    <td>{{ $student->user->phone }}</td>
                                    <td>{{ $student->matric_number }}</td>
                                    <td>{{ $student->faculty }}</td>
                                    <td>{{ $student->course }}</td>
                                    <td>{{ $student->semester }}</td>
                                    <td>{{ $student->created_at->format('d M Y') }}</td>
                                    <td>
                                        <form action="{{ route('admin.students.delete', $student->student_id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this student account? This action cannot be undone.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
</div>

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endpush
@endsection