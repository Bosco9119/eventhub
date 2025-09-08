@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Navigation Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('events.index') }}">Events</a></li>
            <li class="breadcrumb-item"><a href="{{ route('events.show', $event->id) }}">{{ $event->name }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Event</li>
        </ol>
    </nav>

    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0 text-warning">
                        <i class="fas fa-edit me-2"></i>Edit Event
                    </h1>
                    <p class="text-muted">Update the details for "{{ $event->name }}"</p>
                </div>
                <div>
                    <a href="{{ route('events.show', $event->id) }}" class="btn btn-outline-info me-2">
                        <i class="fas fa-eye me-1"></i>View Event
                    </a>
                    <a href="{{ route('events.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i>Back to Events
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Section -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-dark">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-edit me-2"></i>Event Information
                    </h5>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <h6>Please correct the following errors:</h6>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('events.update', $event->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="name" class="form-label">
                                    <i class="fas fa-tag me-1"></i>Event Name <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       name="name" 
                                       id="name"
                                       class="form-control @error('name') is-invalid @enderror" 
                                       value="{{ old('name', $event->name) }}"
                                       placeholder="Enter event name"
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="venue_id" class="form-label">
                                    <i class="fas fa-map-marker-alt me-1"></i>Venue <span class="text-danger">*</span>
                                </label>
                                <select name="venue_id" 
                                        id="venue_id"
                                        class="form-select @error('venue_id') is-invalid @enderror" 
                                        required>
                                    <option value="">Select a venue</option>
                                    @foreach($venues as $venue)
                                        <option value="{{ $venue->id }}" 
                                                {{ old('venue_id', $event->venue_id) == $venue->id ? 'selected' : '' }}>
                                            {{ $venue->name }} (Capacity: {{ $venue->capacity }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('venue_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="organizer" class="form-label">
                                    <i class="fas fa-user-tie me-1"></i>Organizer <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       name="organizer" 
                                       id="organizer"
                                       class="form-control @error('organizer') is-invalid @enderror" 
                                       value="{{ old('organizer', $event->organizer) }}"
                                       placeholder="Enter organizer name"
                                       required>
                                @error('organizer')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="start_time" class="form-label">
                                    <i class="fas fa-clock me-1"></i>Start Time <span class="text-danger">*</span>
                                </label>
                                <input type="datetime-local" 
                                       name="start_time" 
                                       id="start_time"
                                       class="form-control @error('start_time') is-invalid @enderror" 
                                       value="{{ old('start_time', \Carbon\Carbon::parse($event->start_time)->format('Y-m-d\TH:i')) }}"
                                       required>
                                @error('start_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="end_time" class="form-label">
                                    <i class="fas fa-clock me-1"></i>End Time <span class="text-danger">*</span>
                                </label>
                                <input type="datetime-local" 
                                       name="end_time" 
                                       id="end_time"
                                       class="form-control @error('end_time') is-invalid @enderror" 
                                       value="{{ old('end_time', \Carbon\Carbon::parse($event->end_time)->format('Y-m-d\TH:i')) }}"
                                       required>
                                @error('end_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Activities Editor -->
                        <hr class="my-4">
                        <h5 class="mb-3">
                            <i class="fas fa-tasks me-2"></i>Activities
                            <span class="badge bg-primary ms-2">{{ $event->activities->count() }}</span>
                        </h5>

                        <div id="activities-wrapper">
                            @php $idx = 0; @endphp
                            @foreach($event->activities as $activity)
                                <div class="card mb-4 activity-item border border-primary rounded-3 shadow-sm" style="border-width: 10px;" data-index="{{ $idx }}">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h6 class="mb-0 text-primary">
                                                <i class="fas fa-stream me-2"></i>Activity #{{ $idx + 1 }}
                                            </h6>
                                            <button type="button" class="btn btn-outline-danger btn-sm remove-activity">
                                                <i class="fas fa-trash me-1"></i>Remove
                                            </button>
                                        </div>

                                        <input type="hidden" name="activities[{{ $idx }}][id]" value="{{ $activity->id }}">

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Name <span class="text-danger">*</span></label>
                                                <input type="text" name="activities[{{ $idx }}][name]" class="form-control" value="{{ $activity->name }}" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Venue <span class="text-danger">*</span></label>
                                                <select name="activities[{{ $idx }}][venue_id]" class="form-select" required>
                                                    @foreach($venues as $venue)
                                                        <option value="{{ $venue->id }}" {{ $activity->venue_id == $venue->id ? 'selected' : '' }}>
                                                            {{ $venue->name }} (Cap: {{ $venue->capacity }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Start Time <span class="text-danger">*</span></label>
                                                <input type="datetime-local" name="activities[{{ $idx }}][start_time]" class="form-control" value="{{ \Carbon\Carbon::parse($activity->start_time)->format('Y-m-d\TH:i') }}" required>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">Duration (min) <span class="text-danger">*</span></label>
                                                <input type="number" name="activities[{{ $idx }}][duration]" class="form-control" min="1" value="{{ $activity->duration }}" required>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">Status</label>
                                                <select name="activities[{{ $idx }}][status]" class="form-select">
                                                    <option value="pending" {{ $activity->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                                    <option value="in_progress" {{ $activity->status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                                    <option value="completed" {{ $activity->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="mb-0">
                                            <label class="form-label">Description</label>
                                            <textarea name="activities[{{ $idx }}][description]" class="form-control" rows="2">{{ $activity->description }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                @php $idx++; @endphp
                            @endforeach
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <button type="button" class="btn btn-outline-success" id="add-activity">
                                <i class="fas fa-plus me-1"></i>Add Activity
                            </button>
                            <div>
                                <a href="{{ route('events.show', $event->id) }}" class="btn btn-outline-info me-2">
                                    <i class="fas fa-eye me-1"></i>View Event
                                </a>
                                <a href="{{ route('events.index') }}" class="btn btn-outline-secondary me-2">
                                    <i class="fas fa-times me-1"></i>Cancel
                                </a>
                                <button type="submit" class="btn btn-warning">
                                    <i class="fas fa-save me-1"></i>Update Event
                                </button>
                            </div>
                        </div>

                        <!-- Template for new activity -->
                        <template id="activity-template">
                            <div class="card mb-4 activity-item border border-primary rounded-3 shadow-sm" style="border-width: 10px;" data-index="__INDEX__">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h6 class="mb-0 text-primary">
                                            <i class="fas fa-stream me-2"></i>Activity #__HUMAN_INDEX__
                                        </h6>
                                        <button type="button" class="btn btn-outline-danger btn-sm remove-activity">
                                            <i class="fas fa-trash me-1"></i>Remove
                                        </button>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Name <span class="text-danger">*</span></label>
                                            <input type="text" name="activities[__INDEX__][name]" class="form-control" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Venue <span class="text-danger">*</span></label>
                                            <select name="activities[__INDEX__][venue_id]" class="form-select" required>
                                                @foreach($venues as $venue)
                                                    <option value="{{ $venue->id }}">{{ $venue->name }} (Cap: {{ $venue->capacity }})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Start Time <span class="text-danger">*</span></label>
                                            <input type="datetime-local" name="activities[__INDEX__][start_time]" class="form-control" required>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label class="form-label">Duration (min) <span class="text-danger">*</span></label>
                                            <input type="number" name="activities[__INDEX__][duration]" class="form-control" min="1" required>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label class="form-label">Status</label>
                                            <select name="activities[__INDEX__][status]" class="form-select">
                                                <option value="pending" selected>Pending</option>
                                                <option value="in_progress">In Progress</option>
                                                <option value="completed">Completed</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="mb-0">
                                        <label class="form-label">Description</label>
                                        <textarea name="activities[__INDEX__][description]" class="form-control" rows="2"></textarea>
                                    </div>
                                </div>
                            </div>
                        </template>

                        @push('scripts')
                        <script>
                        (function() {
                            const wrapper = document.getElementById('activities-wrapper');
                            const addBtn = document.getElementById('add-activity');
                            const template = document.getElementById('activity-template').innerHTML;

                            function reindex() {
                                const items = wrapper.querySelectorAll('.activity-item');
                                items.forEach((item, idx) => {
                                    item.setAttribute('data-index', idx);
                                    item.querySelector('h6').innerHTML = `<i class="fas fa-stream me-2"></i>Activity #${idx + 1}`;
                                    // rename inputs
                                    item.querySelectorAll('input[name], select[name], textarea[name]').forEach(el => {
                                        el.name = el.name.replace(/activities\[\d+\]/, `activities[${idx}]`);
                                    });
                                });
                            }

                            function bindRemove(btn) {
                                btn.addEventListener('click', function() {
                                    const item = this.closest('.activity-item');
                                    item.remove();
                                    reindex();
                                });
                            }

                            wrapper.querySelectorAll('.remove-activity').forEach(bindRemove);

                            addBtn.addEventListener('click', function() {
                                const index = wrapper.querySelectorAll('.activity-item').length;
                                const html = template
                                    .replaceAll('__INDEX__', index)
                                    .replaceAll('__HUMAN_INDEX__', index + 1);
                                const div = document.createElement('div');
                                div.innerHTML = html.trim();
                                const node = div.firstChild;
                                wrapper.appendChild(node);
                                bindRemove(node.querySelector('.remove-activity'));
                            });
                        })();
                        </script>
                        @endpush

                        <div class="d-flex justify-content-between mt-4">
                            <div></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-header bg-info text-white">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-info-circle me-2"></i>Event Details
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>Created:</strong><br>
                        <small class="text-muted">{{ $event->created_at->format('M d, Y \a\t g:i A') }}</small>
                    </div>
                    <div class="mb-3">
                        <strong>Last Updated:</strong><br>
                        <small class="text-muted">{{ $event->updated_at->format('M d, Y \a\t g:i A') }}</small>
                    </div>
                    <div class="mb-3">
                        <strong>Current Venue:</strong><br>
                        <small class="text-muted">{{ $event->venue->name }}</small>
                    </div>
                    <div class="mb-0">
                        <strong>Activities:</strong><br>
                        <span class="badge bg-primary">{{ $event->activities->count() }} activities</span>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm mt-3">
                <div class="card-header bg-success text-white">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-lightbulb me-2"></i>Quick Actions
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('events.show', $event->id) }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-eye me-1"></i>View Event
                        </a>
                        <a href="{{ route('activities.create', ['event_id' => $event->id]) }}" class="btn btn-outline-success btn-sm">
                            <i class="fas fa-plus me-1"></i>Add Activity
                        </a>
                        <a href="{{ route('events.index') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-list me-1"></i>All Events
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
