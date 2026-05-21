<!DOCTYPE html>
<html>
<head>
    <title>Ecommerce</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="/products">Ecommerce</a>

        <div>
            <a href="/products" class="btn btn-light btn-sm">Products</a>
            <a href="/cart" class="btn btn-warning btn-sm">Cart</a>
            <a href="/login" class="btn btn-info btn-sm" id="loginBtn">Login</a>
            <a href="/register" class="btn btn-success btn-sm" id="registerBtn">Register</a>
            <button class="btn btn-danger btn-sm" id="logoutBtn">Logout</button>
        </div>
    </div>
</nav>

<div class="container mt-4">
    <div id="alert-box"></div>

    @yield('content')
</div>

<script>
const API_BASE = "http://127.0.0.1:8000/api";

function getToken() {
    return localStorage.getItem('token');
}

$.ajaxSetup({
    beforeSend: function(xhr) {
        let token = getToken();

        if (token) {
            xhr.setRequestHeader('Authorization', 'Bearer ' + token);
        }
    }
});

function showAlert(message, type='success') {
    $('#alert-box').html(`
        <div class="alert alert-${type}">
            ${message}
        </div>
    `);
}

$('#logoutBtn').click(function() {
    $.post(API_BASE + '/logout', function() {
        localStorage.removeItem('token');
        window.location.href = '/login';
    });
});
</script>

</body>
</html>