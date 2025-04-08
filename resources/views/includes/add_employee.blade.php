<!-- Add Employee Modal -->
<div class="modal fade" id="addnew">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><b>Add New Employee</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="card-body text-left">
                    <form method="POST" action="{{ route('employees.store') }}">
                        @csrf

                        <!-- Name -->
                        <div class="form-group">
                            <label for="name">Employee Name</label>
                            <input type="text" class="form-control" placeholder="Enter employee name" id="name" name="name" required />
                        </div>

                        <!-- Email -->
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" class="form-control" placeholder="Enter email" id="email" name="email" required />
                        </div>

                        <!-- Password -->
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" placeholder="Enter password" id="password" name="password" required />
                        </div>

                        <!-- Confirm Password -->
                        <div class="form-group">
                            <label for="password_confirmation">Confirm Password</label>
                            <input type="password" class="form-control" placeholder="Confirm password" id="password_confirmation" name="password_confirmation" required />
                        </div>

                        <!-- Position -->
                        <div class="form-group">
                            <label for="position_id">Position</label>
                            <select class="form-control" id="position_id" name="position_id" required>
                                <option value="" selected disabled>- Select Position -</option>
                                @foreach($positions as $position)
                                    <option value="{{ $position->id }}">{{ $position->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Schedule -->
                        <div class="form-group">
                            <label for="schedule_id">Schedule</label>
                            <select class="form-control" id="schedule_id" name="schedule_id" required>
                                <option value="" selected disabled>- Select Schedule -</option>
                                @foreach($schedules as $schedule)
                                    <option value="{{ $schedule->id }}">
                                        {{ $schedule->slug }} ({{ $schedule->time_in }} - {{ $schedule->time_out }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Join Date -->
                        <div class="form-group">
                            <label for="join_date">Join Date</label>
                            <input type="date" class="form-control" id="join_date" name="join_date" required />
                        </div>

                        <!-- Status -->
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" name="status">
                                <option value="Active" selected>Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </div>

                        <!-- Buttons -->
                        <div class="form-group text-right">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                <i class="fa fa-times"></i> Cancel
                            </button>
                            <button type="submit" class="btn btn-success">
                                <i class="fa fa-check"></i> Submit
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
