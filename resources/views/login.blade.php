@extends ('layout')
@section('title','Staff Login - HBATS')
@section ('body_class','centered-page')
@section('content')
<body class="centered-page">
    <div class="login-container">
        <div class="login-card">
            <h1>Staff Login</h1>
            <p class="subtitle">Hospoital Bed Availability & Tracking System</p>
            <form method="post" action="{{route('login.submit')}}" class="login-form">
                @csrf
                <label for="username"> Username</label>
                <input type="text" id="username" name="username" required>  
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            <div class="form-options">
                <label>
                    <input type="checkbox" name="remember"> Remember me
                </label>
                <a href="#">Forgot password?</a>
            </div>
            <button type="submit" class="btn">Login</button>
            </form>
<p class="footer-link">
    <a href="{{route('visitor')}}">Visitor? Find a patient -></a>
</p>
        </div>
    </div>
</body>
@endsection