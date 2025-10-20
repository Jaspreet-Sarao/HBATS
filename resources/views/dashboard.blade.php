@extends ('layout')
@section('title','DashBoard - HBATS')
@section ('body_class','dashboard-page')
@section('content')
<body class="dashboard-page">
        
        <!--Navigation-->
      <header class="toolbar">
        <div>
            <h2>HBATS - Staff Dashboard</h2>
            <p class="subtitle">Real-time hospital bed availability & Status</p>
        </div>
        <div class="action-buttons">
            <a href="{{route('admission.form')}}" class="button primary small">Admit Patient</a>
            <a href="{{route('discharge.form')}}" class="button primary small">Discharge Patient</a>
            <a href="{{route('passcode.index')}}" class="button secondary small">Generate Passcode</a>
            <a href="{{route('admin.wards')}}" class="button secondary small">Admin Panel</a>
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
                <h3>{{$totalBeds ?? 48}}</h3>
                <p>Total Beds</p>
            </div>
            <div class="stat-box available">
                <h3>{{$available ?? 18}}</h3>
                <p>Avialable</p>
            </div>
            <div class="stat-box occupied">
                <h3>{{$occupied ?? 30}}</h3>
                <p>Occupied</p>
            </div>
            <div class="stat-box rate">
                <h3>{{$rate ?? 62.5}}%</h3>
                <p>Occupancy Rate</p>
            </div>
        </div>
        <!--Filters-->
        <div class="filter-panel">
           <div>
            <label>Filter by Ward</label>
                    <select id="wardFilter">
                        <option value="all">All Wards</option>
                        <option value="ICU">ICU</option>
                        <option value="General">General</option>
                        <option value="Pediatric">Pediatric</option>
                        <option value="Emergency">Emergency</option>
                    </select>
           </div>
                    <div>
                        <label>Filter by status</label>
                    <select id="statusFilter">
                        <option value="all">All Statuses</option>
                        <option value="available">Available</option>
                        <option value="occupied">Occupied</option>
                    </select>
                </div>
                    <div>
                        <label>Search</label>
                    <input type="text" id="searchbox" placeholder="Search by bed or patient">
                    </div>
        </div>
        <!--Ward Display-->
        @foreach($wards ?? [] as $ward)
        <section class="ward-section">
            <h3>{{$ward->name}} ({{ $ward->total_beds}} beds)</h3>
            <div class="bed-grid">
                @foreach($ward->beds as $bed)
                <div class="bed {{ $bed->patient_id ? 'occupied' : 'available' }}">
                    <p class="bed-id">{{$bed->bed_number}}</p>
                    <p class="bed-data">{{$bed->patient->name ?? '-'}}</p>
                    <p class="status-{{$bed->patient_id ? 'red' : 'green'}}">{{$bed->patient_id ? 'Occupied':'Available'}}</p>
                </div>
                @endforeach
            </div>
        <div class="show-link"><a href="#">show all {{$ward->total_beds}} beds -></a></div>
        </section>
        @endforeach
      </main>
@vite(['resources/js/dashboard.js'])
@endsection