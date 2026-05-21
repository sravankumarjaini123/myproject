@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card">
            <div class="card-header">
                Register
            </div>

            <div class="card-body">
                <form id="registerForm">
                    <input type="text" id="name" class="form-control mb-2" placeholder="Name">
    <input type="email" id="email" class="form-control mb-2" placeholder="Email">
    <input type="password" id="password" class="form-control mb-2" placeholder="Password">
    <input type="password" id="password_confirmation" class="form-control mb-2" placeholder="Confirm Password">

                    <button type="submit" class="btn btn-success w-100">
                        Register
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
$('#registerForm').submit(function(e){
    e.preventDefault();

    $.ajax({
        url: API_BASE + '/register',
        type: 'POST',
        data: {
            name: $('#name').val(),
            email: $('#email').val(),
            password: $('#password').val(),
            password_confirmation: $('#password_confirmation').val()
        },
        success: function(res){
            showAlert('Registered successfully');
            setTimeout(() => {
                window.location.href = '/login';
            }, 1000);
        },
        error: function(){
            showAlert('Registration failed', 'danger');
        }
    });
});
</script>
@endsection