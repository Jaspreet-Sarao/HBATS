@extends ('layout')
@section('title','Passcode Management - HBATS')
@section ('body_class','passcode-page')
@section('content')
<body class="passcode-page">
<header class="toolbar">
    <h2>Passcode Management</h2>
    <p class="subtitle">Generate or invalidate visitor passcodes for patients</p>
    <div class="action-buttons">
        <a href="{{route('dashboard')}}" class="button secondary small">Dashboard</a>
        <a href="{{route('admission.form')}}" class="button secondary small">Admit</a>
        <a href="{{route('discharge.form')}}" class="button secondary small">Discharge</a>
        <a href="{{route('admin.wards')}}" class="button secondary small">Admin</a>
        <form method="POST" action="{{route('logout')}}" style="display: inline;">
            @csrf
            <button type="submit" class="button secondary small">Logout</button>
        </form>
    </div>
</header>
<main class="container passcode-page">
    <!--Search Section-->
    <section class="card" id="search-section">
        <h3>Search Patient</h3>
        
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

        <form method="GET" action="{{route('passcode.search')}}" id="searchForm">
            <div class="form-group">
                <label>Search Patient *</label>
                <input type="text" name="q" value="{{ old('q', request('q')) }}" placeholder="Search by patient name, ID, or bed number" required>
                <button type="submit" class="btn">Search</button>
            </div>
        </form>
    </section>
    <!--Patient Details-->
    @if(isset($patient) && $patient)
    <section class="card" id="patient-details" style="display: block;">
        <div class="info-box">
            <h4>Patient Information</h4>
            <p><strong>Name:</strong> {{ $patient->name }}</p>
            <p><strong>Patient ID:</strong> {{ $patient->patient_identifier }}</p>
            @if($patient->bed)
                <p><strong>Bed:</strong> {{ $patient->bed->bed_number }}</p>
                <p><strong>Ward:</strong> {{ $patient->bed->ward->name }}</p>
            @endif
            @if($patient->passcodes->isNotEmpty())
                <p><strong>Current Passcode:</strong> {{ $patient->passcodes->first()->code }}</p>
                <p><strong>Expires:</strong> {{ $patient->passcodes->first()->expires_at->format('M d, Y H:i') }}</p>
            @endif
        </div>
        
        <div class="form-grid">
            <div class="card">
                <h4>Generate new passcode</h4>
                <form method="POST" action="{{route('passcode.generate', $patient)}}">
                    @csrf
                    <label>Expiry duration</label>
                    <select name="expiry">
                        <option value="24">24 Hours</option>
                        <option value="48">48 Hours</option>
                        <option value="72">72 Hours</option>
                        <option value="168">1 Week</option>
                    </select>
                    <button type="submit" class="btn success">Generate New Passcode</button>
                </form>
            </div>
            <div class="card">
                <h4>Invalidate Current passcode</h4>
                <form method="POST" action="{{route('passcode.invalidate', $patient)}}">
                    @csrf
                    <label>Reason</label>
                    <select name="reason">
                        <option value="patient request">Patient Request</option>
                        <option value="security concern">Security Concern</option>
                        <option value="visitor change">Visitor Change</option>
                        <option value="other">Other</option>
                    </select>
                    <button type="submit" class="btn danger">Invalidate Passcode</button>
                </form>
            </div>
        </div>
    </section>
    @endif
    @if(isset($patient) && !$patient)
    <div class="error-box" id="errorBox">
        <p class="error">No patient found. Please try again.</p>
    </div>
    @endif
</main>
@vite(['resources/js/passcode.js'])
    </body>
    @endsection