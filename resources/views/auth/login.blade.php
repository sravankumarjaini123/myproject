@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card">
            <div class="card-header">
                Login
            </div>

            <div class="card-body">
                <form id="loginForm">
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" id="email" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" id="password" class="form-control">
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        Login
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
$('#loginForm').submit(function(e){
    e.preventDefault();

    $.ajax({
        url: API_BASE + '/login',
        type: 'POST',
        data: {
            email: $('#email').val(),
            password: $('#password').val()
        },
        success: function(res){
            localStorage.setItem('token', res.token);
            window.location.href = '/products';
        },
        error: function(xhr){
            showAlert('Login failed', 'danger');
        }
    });
});
</script>
@endsection