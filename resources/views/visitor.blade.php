@extends('layout')
@section('title', 'Visitor Portal - HBATS')
@section('body_class', 'centered-page')
@section('content')

<body class="centered-page">
    <div class="login-container">
        <div class="login-card">
            <h1>Visitor Portal</h1>
            <p class="subtitle">Find a Patient - Hospital Bed Availability & Tracking System</p>
            
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
            
            <form method="get" action="{{route('visitor.search')}}" class="login-form">
                <label for="patient_name">Patient Name</label>
                <input type="text" id="patient_name" name="patient_name" 
                       value="{{ old('patient_name', $patientName ?? '') }}" 
                       placeholder="Enter patient name" required>
                
                <label for="passcode">Visit Passcode</label>
                <input type="text" id="passcode" name="passcode" 
                       value="{{ old('passcode', $passcode ?? '') }}" 
                       placeholder="Enter visit passcode" required>
                
                <button type="submit" class="btn">Find Patient</button>
            </form>
            
            @if(isset($patient) && $patient)
                <div class="patient-info" style="margin-top: 20px; padding: 15px; background: #f8f9fa; border-radius: 5px;">
                    <h3>Patient Information</h3>
                    <p><strong>Name:</strong> {{ $patient->name }}</p>
                    <p><strong>Patient ID:</strong> {{ $patient->patient_identifier }}</p>
                    @if($patient->bed)
                        <p><strong>Ward:</strong> {{ $patient->bed->ward->name }}</p>
                        <p><strong>Bed Number:</strong> {{ $patient->bed->bed_number }}</p>
                    @endif
                    @if($patient->passcodes->isNotEmpty())
                        <p><strong>Passcode Expires:</strong> {{ $patient->passcodes->first()->expires_at->format('M d, Y H:i') }}</p>
                    @endif
                </div>
            @endif
            
            <p class="footer-link">
                <a href="{{route('login')}}">Staff Login -></a>
            </p>
        </div>
    </div>
</body>

@endsection
