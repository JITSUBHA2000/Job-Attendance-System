@foreach($employees as $employee)
<!-- Edit Employee Modal -->
<div class="modal fade" id="editEmployee{{ $employee->id }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><b>Edit Employee</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="card-body text-left">
                    <form method="POST" action="{{ route('employees.update', $employee->id) }}">
                        @csrf
                        @method('PUT')

                        <!-- Name -->
                        <div class="form-group">
                            <label for="name">Employee Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $employee->user->name }}" required />
                        </div>

                        <!-- Email -->
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ $employee->user->email }}" required />
                        </div>

                        <!-- Position -->
                        <div class="form-group">
                            <label for="position_id">Position</label>
                            <select class="form-control" id="position_id" name="position_id" required>
                                @foreach($positions as $position)
                                    <option value="{{ $position->id }}"
                                        {{ $employee->position_id == $position->id ? 'selected' : '' }}>
                                        {{ $position->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Schedule -->
                        <div class="form-group">
                            <label for="schedule_id">Schedule</label>
                            <select class="form-control" id="schedule_id" name="schedule_id" required>
                                @foreach($schedules as $schedule)
                                    <option value="{{ $schedule->id }}"
                                        {{ $employee->schedule_id == $schedule->id ? 'selected' : '' }}>
                                        {{ $schedule->slug }} ({{ $schedule->time_in }} - {{ $schedule->time_out }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Join Date -->
                        <div class="form-group">
                            <label for="join_date">Join Date</label>
                            <input type="date" class="form-control" id="join_date" name="join_date"
                                   value="{{ $employee->join_date }}" required />
                        </div>

                        <!-- Status -->
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" name="status">
                                <option value="Active" {{ $employee->status == 'Active' ? 'selected' : '' }}>Active</option>
                                <option value="Inactive" {{ $employee->status == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>

                        <!-- Buttons -->
                        <div class="form-group text-right">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                <i class="fa fa-times"></i> Cancel
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save"></i> Update
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach
