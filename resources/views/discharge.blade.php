@extends ('layout')
@section('title','Patient Discharge - HBATS')
@section ('body_class','discharge-page')
@section('content')
 <body class="discharge-page">
<header class="toolbar">
            <div>
                <h2>Patient Discharge Form</h2>
                <p class="subtitle">Discharge patient and update bed avialability</p>
            </div>
            <div class="action-buttons">
                <a href="{{route('dashboard')}}" class="button secondary small">Dashboard</a>
                <a href="{{route('admission.form')}}" class="button secondary small">Admit</a>
                <a href="{{route('passcode.index')}}" class="button secondary small">Passcode</a>
                <a href="{{route('admin.wards')}}" class="button secondary small">Admin</a>
                <form method="POST" action="{{route('logout')}}" style="display: inline;">
                    @csrf
                    <button type="submit" class="button secondary small">Logout</button>
                </form>
            </div>
        </header>
<!--Main-->
<main class="container">
    <!--Step Indicator-->
    <div class="step-indicator connected">
        <div class="step active">
            <div class="circle">1</div>
            Find patient
        </div>
        <div class="step">
            <div class="circle">2</div>
            Confirm discharge
        </div>
        <div class="step">
            <div class="circle">3</div>
            Update system
        </div>
    </div>
    <!--Search -->
    <section class="card">
        <h3>Step 1: Find patient to Discharge</h3>
        
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
        @endif

        @if(isset($error))
            <div class="alert alert-error">
                {{ $error }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-error">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="GET" action="{{route('discharge.search')}}" id="searchForm">
            <div class="form-grid">
                <input type="text" name="q" value="{{ old('q', request('q')) }}" placeholder="Search by patient name or bed number" required>
                <button type="submit" class="btn">Search</button>
            </div>
        </form>
    </section>
    <!--Patient Details-->
    @if(isset($patient) && $patient)
    <section class="card" id="dischargeDetails">
        <h3>Step 2: Confirm Discharge</h3>
        <div class="info-box">
            <h4>Patient Information</h4>
            <p><strong>Name:</strong> {{ $patient->name }}</p>
            <p><strong>Patient ID:</strong> {{ $patient->patient_identifier }}</p>
            @if($patient->bed)
                <p><strong>Ward:</strong> {{ $patient->bed->ward->name }}</p>
                <p><strong>Bed Number:</strong> {{ $patient->bed->bed_number }}</p>
            @endif
            <p><strong>Admitted On:</strong> {{ $patient->admitted_at ? $patient->admitted_at->format('M d, Y H:i') : 'Not specified' }}</p>
        </div>
        <h4>Discharge Information</h4>
        <form method="POST" action="{{route('discharge.complete', $patient)}}">
            @csrf
            <div class="form-group">
                <label>Discharge Date & Time</label>
                <input type="datetime-local" name="discharge_time" value="{{ now()->format('Y-m-d\TH:i') }}" required>
            </div>
            <div class="form-group">
                <label>Discharge Type</label>
                <select name="discharge_type" required>
                    <option value="home">Home</option>
                    <option value="transfer">Transfer</option>
                    <option value="ama">AMA</option>
                    <option value="deceased">Deceased</option>
                </select>
            </div>
            <div class="form-group">
                <label>Discharge Notes</label>
                <textarea name="notes" placeholder="Additional notes or instructions"></textarea>
            </div>
            <div class="warning-box">
                <p>Confirm the patient is ready for discharge. This action cannot be undone.</p>
                <label><input type="checkbox" id="confirmDischarge">I confirm the patient is ready for discharge.</label>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn danger" id="completeBtn" disabled>Complete Discharge</button>
                <a href="{{route('dashboard')}}" class="btn">Cancel</a>
            </div>
        </form>
    </section>
    @endif
</main>
@vite(['resources/js/discharge.js'])
   @endsection