@if($applications->isEmpty())
    <div class="alert alert-info">
        No applications found in this category.
    </div>
@else
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th>Property</th>
                    <th>Student</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($applications as $application)
                <tr id="application-{{ $application->application_id }}">
                    <td>
                        <div class="d-flex align-items-center">
                            @if($application->property->images->isNotEmpty())
                                <img src="{{ asset($application->property->images->first()->image_url) }}" 
                                     alt="{{ $application->property->title }}" 
                                     class="me-2" 
                                     style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                            @else
                                <div class="bg-light text-center me-2" style="width: 50px; height: 50px; border-radius: 4px;">
                                    <i class="fas fa-home text-muted" style="line-height: 50px;"></i>
                                </div>
                            @endif
                            <div>
                                <strong>{{ $application->property->title }}</strong>
                                <div class="small text-muted">{{ $application->property->address }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <strong>{{ $application->student->user->name }}</strong>
                        <div class="small text-muted">{{ $application->student->user->email }}</div>
                        <div class="small text-muted">{{ $application->student->user->phone }}</div>
                    </td>
                    <td>{{ $application->application_date->format('d M Y') }}</td>
                    <td>
                        @if($application->status == 'pending')
                            <span class="badge bg-warning">Pending</span>
                        @elseif($application->status == 'approved')
                            <span class="badge bg-success">Approved</span>
                        @else
                            <span class="badge bg-danger">Rejected</span>
                        @endif
                    </td>
                    <td>
                        <button type="button" class="btn btn-sm btn-info mb-1" data-bs-toggle="collapse" data-bs-target="#details-{{ $application->application_id }}">
                            <i class="fas fa-eye"></i> Details
                        </button>
                        
                        @if($application->status == 'pending')
                            <div class="btn-group mb-1">
                                <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#approveModal-{{ $application->application_id }}">
                                    <i class="fas fa-check"></i> Approve
                                </button>
                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal-{{ $application->application_id }}">
                                    <i class="fas fa-times"></i> Reject
                                </button>
                            </div>
                        @endif
                    </td>
                </tr>
                <tr class="collapse" id="details-{{ $application->application_id }}">
                    <td colspan="5" class="bg-light">
                        <div class="p-3">
                            <h6>Student Message:</h6>
                            <p>{{ $application->message ?: 'No message provided.' }}</p>
                            
                            @if($application->status != 'pending' && $application->landlord_message)
                                <h6>Your Response:</h6>
                                <p>{{ $application->landlord_message }}</p>
                            @endif
                            
                            <div class="d-flex justify-content-end">
                                <a href="{{ url('/') }}" class="btn btn-sm btn-outline-primary me-2">
                                    <i class="fas fa-home"></i> Home
                                </a>
                                <div class="d-flex justify-content-end">
                                    <a href="mailto:{{ $application->student->user->email }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-envelope"></i> Email Student
                                    </a>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                
                <!-- Approve Modal -->
                <div class="modal fade" id="approveModal-{{ $application->application_id }}" tabindex="-1" aria-labelledby="approveModalLabel-{{ $application->application_id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <!-- Approve Modal form action -->
                            <form action="{{ route('landlord.applications.updateStatus', $application->application_id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="approved">
                                
                                <div class="modal-header">
                                    <h5 class="modal-title" id="approveModalLabel-{{ $application->application_id }}">Approve Application</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p>Are you sure you want to approve this application from <strong>{{ $application->student->user->name }}</strong> for <strong>{{ $application->property->title }}</strong>?</p>
                                    <p class="text-warning"><strong>Note:</strong> Approving this application will mark the property as rented and reject all other pending applications for this property.</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-success">Approve Application</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
                <!-- Reject Modal -->
                <div class="modal fade" id="rejectModal-{{ $application->application_id }}" tabindex="-1" aria-labelledby="rejectModalLabel-{{ $application->application_id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <!-- Reject Modal form action -->
                            <form action="{{ route('landlord.applications.updateStatus', $application->application_id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="rejected">
                                
                                <div class="modal-header">
                                    <h5 class="modal-title" id="rejectModalLabel-{{ $application->application_id }}">Reject Application</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p>Are you sure you want to reject this application from <strong>{{ $application->student->user->name }}</strong> for <strong>{{ $application->property->title }}</strong>?</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-danger">Reject Application</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </tbody>
        </table>
    </div>
@endif