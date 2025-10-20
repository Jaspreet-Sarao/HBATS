@extends ('layout')
@section('title','Admin Ward Management')
@section ('body_class','admin-page')
@section('content')
<body class="admin-page">
        <header class="toolbar">
            <div>
                <h2>Admin Ward Management</h2>
                <p class="subtitle">Create and manage wards and bed configurations</p>
            </div>
            <div class="action-buttons">
                <a href="{{route('dashboard')}}" class="button secondary small">Dashboard</a>
                <a href="{{route('admission.form')}}" class="button secondary small">Admit</a>
                <a href="{{route('discharge.form')}}" class="button secondary small">Discharge</a>
                <a href="{{route('passcode.index')}}" class="button secondary small">Passcode</a>
                <form method="POST" action="{{route('logout')}}" style="display: inline;">
                    @csrf
                    <button type="submit" class="button secondary small">Logout</button>
                </form>
            </div>
        </header>
        <!--Content-->
      <main class="container">
        <div class="stats-wrapper">
            <div class="stat-box">
                <h3>{{ $wards->sum('total_beds') }}</h3>
                <p>Total Beds</p>
            </div>
            <div class="stat-box available">
                <h3>{{ $wards->sum(function($ward) { return $ward->availableBeds->count(); }) }}</h3>
                <p>Available</p>
            </div>
            <div class="stat-box occupied">
                <h3>{{ $wards->sum(function($ward) { return $ward->occupiedBeds->count(); }) }}</h3>
                <p>Occupied</p>
            </div>
            <div class="stat-box rate">
                <h3>{{ $wards->sum('total_beds') > 0 ? round(($wards->sum(function($ward) { return $ward->occupiedBeds->count(); }) / $wards->sum('total_beds')) * 100, 1) : 0 }}%</h3>
                <p>Occupancy Rate</p>
            </div>
        </div>
        <!--Add Ward-->
        <section class="card">
            <h3>Add New Ward</h3>
            <form method="POST" action="{{route('admin.wards.store')}}" id="addWardForm">
                @csrf

            <div class="form-grid">
            <div>
                <label>Ward Name</label>
                <input type="text" name="name" placeholder="e.g.,ICU" required>
            </div>
            <div>
                <label>Ward Code</label>
                <input type="text" name="code" placeholder="e.g.,ICU-001" required>
            </div>
            <div>
                <label>Number of Beds</label>
                <input type="number" name="total_beds" min="1" placeholder="10" required>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn success">Create Ward</button>
            </div>
        </div>
        </form>
        </section>
        <section class="card">
            <h3>Existing Wards</h3>
            @foreach($wards as $ward)
            <div class="ward-item">
                <h4>{{ $ward->name }}</h4>
                <p>Total Beds: {{ $ward->total_beds }} | Available: {{ $ward->availableBeds->count() }} | Occupied: {{ $ward->occupiedBeds->count() }}</p>
                <div class="action-buttons">
                    <button class="button info toggle-view" data-target="view{{ $ward->id }}">View</button>
                    <button class="button edit toggle-edit" data-target="edit{{ $ward->id }}">Edit</button>
                    <button class="button danger toggle-delete" data-target="delete{{ $ward->id }}">Delete</button>
                </div>
                
                <!--Hidden View Section-->
                <div id="view{{ $ward->id }}" class="hidden ward-section">
                    <div class="info-box">
                        <h4>Ward Details</h4>
                        <p><strong>Name:</strong> {{ $ward->name }}</p>
                        <p><strong>Code:</strong> {{ $ward->code }}</p>
                        <p><strong>Total Beds:</strong> {{ $ward->total_beds }}</p>
                        <p><strong>Available:</strong> {{ $ward->availableBeds->count() }}</p>
                        <p><strong>Occupied:</strong> {{ $ward->occupiedBeds->count() }}</p>
                    </div>
                </div>
                
                <!--Hidden Edit-->
                <div id="edit{{ $ward->id }}" class="hidden ward-section">
                    <div class="card">
                        <form method="POST" action="{{ route('admin.wards.update', $ward) }}">
                            @csrf
                            @method('PUT')
                            <div class="form-grid">
                                <div><label>Ward Name</label><input type="text" name="name" value="{{ $ward->name }}" required></div>
                                <div><label>Ward Code</label><input type="text" name="code" value="{{ $ward->code }}" required></div>
                                <div><label>Number of Beds</label><input type="number" name="total_beds" value="{{ $ward->total_beds }}" required></div>
                                <div class="form-actions">
                                    <button type="submit" class="btn success">Save Changes</button>
                                    <button type="button" class="btn cancel cancel-edit">Cancel</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                
                <!--Hidden Delete-->
                <div id="delete{{ $ward->id }}" class="hidden ward-section">
                    <div class="warning-box">
                        <p>Are you sure you want to delete <strong>{{ $ward->name }}</strong>? This action cannot be undone.</p>
                        <form method="POST" action="{{ route('admin.wards.destroy', $ward) }}" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <div class="form-actions">
                                <button type="submit" class="btn danger">Yes, Delete</button>
                                <button type="button" class="btn cancel cancel-delete">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </section>
        <!--System Settings-->
        <section class="card">
            <h3>System Settings</h3>
            <div class="settings-list">
                <label><input type="checkbox" checked>Auto-generated bed number</label>
                <label><input type="checkbox" checked>Enable visitor passcode system</label>
                <label><input type="checkbox" checked>Require admin approval for new wards</label>
                <label><input type="checkbox" checked>Send notifications for capacity alerts</label>
            </div>
        </section>
      </main>
@vite(['resources/js/admin.js'])
    </body>
@endsection