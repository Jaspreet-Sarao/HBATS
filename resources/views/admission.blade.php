@extends ('layout')
@section('title','Patient Admission - HBATS')
@section ('body_class','admission-page')
@section('content')
<body class="admission-page">
        <!--Header-->
        <header class="toolbar">
            <div>
                <h2>Patient Admission Form</h2>
                <p class="subtitle">Complete patient admission and bed assign process</p>
            </div>
            <div class="action-buttons">
                <a href="{{route('dashboard')}}" class="button secondary small">Dashboard</a>
                <a href="{{route('discharge.form')}}" class="button secondary small">Discharge</a>
                <a href="{{route('passcode.index')}}" class="button secondary small">Passcode</a>
                <a href="{{route('admin.wards')}}" class="button secondary small">Admin</a>
                <form method="POST" action="{{route('logout')}}" style="display: inline;">
                    @csrf
                    <button type="submit" class="button secondary small">Logout</button>
                </form>
            </div>
        </header>
<!--Main-->
<main class="container admission-page">
    <!--Step Indicator-->
    <div class="step-indicator connected">
        <div class="step active">
            <div class="circle">1</div>
            Patient Information
        </div>
        <div class="step">
            <div class="circle">2</div>
            Bed Assignment
        </div>
        <div class="step">
            <div class="circle">3</div>
            Passcode & Confirmation
        </div>
    </div>
<!--Step 1. Bed Seletion-->
<section class="card">
    <h3>Step 1: Select Available Bed</h3>
    <form method="POST" action="{{route('admission.store')}}" id="admissionForm">
        @csrf
        <label for="ward">Filter by Ward:</label>
        <select id="ward" name="ward_id">
            <option value="">All Wards</option>
            @foreach($wards as $ward)
            <option value="{{$ward->id}}">{{$ward->name}}</option>
            @endforeach
        </select>
        <div class="bed-grid">
            @foreach($wards as $ward)
                @foreach($ward->availableBeds as $bed)
                <label class="bed available" data-ward-id="{{$ward->id}}">
                    <input type="radio" name="bed_id" value="{{$bed->id}}">
                    {{$bed->bed_number}} ({{$ward->name}})
                </label>
                @endforeach
            @endforeach
        </div>
    <div class="selected-bed">
        <p><strong>Selected Bed:</strong><span id="selectedBed">None</span></p>
    </div>
    

        <!--Step 2: Patient Info-->
        <h3>Step 2: Patient Information</h3>
        <div class="form-grid">
            <div>
                <label>Patient Name *</label>
                <input type="text" name="name" placeholder="Enter full name" required>
            </div>
            <div>
                <label>Contact Number</label>
                <input type="tel" name="contact" placeholder="Enter your phone number">
            </div>
            <div>
                <label>Emergency Contact</label>
                <input type="text" name="emergency_contact" placeholder="Emergency Contact number">
            </div>
        </div>
        <div>
            <label>Admission Notes</label>
            <textarea name="admission_notes" placeholder="optional"></textarea>
        </div>
</section>
        <!--Step 3: Passcode-->
        <h3>Step 3: Generate visitor Passcode</h3>
        <div class="form-grid">
            <div>
                <label>Passcode Expiry</label>
                <select name="passcode_duration">
                    <option value="24">24 Hours</option>
                    <option value="48">48 Hours</option>
                    <option value="72">72 Hours</option>
                    <option value="168">168 Hours</option>
                </select>
            </div>
            <div class="checkbox">
                <label><input type="checkbox" name="auto_generate" checked>Auto-generate passcode</label>
            </div>
        </div>
</section>
        <!--Buttons-->
        <div class="actions">
            <button type="submit" class="btn success">Complete Admission</button>
            <button type="reset" class="btn secondary">Reset Form</button>
            <a href="{{route('dashboard')}}" class="btn">Cancel</a>
        </div>
    </form>
</section>
</main>
@vite(['resources/js/admission.js'])
@endsection