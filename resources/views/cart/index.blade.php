@extends('layouts.app')

@section('content')

<h2 class="mb-4">My Cart</h2>

<div id="cart-content">
    <h4>Loading cart...</h4>
</div>

<script>
$(document).ready(function() {
    if (!getToken()) {
        window.location.href = '/login';
        return;
    }

    loadCart();
});

function loadCart() {
    $.ajax({
        url: API_BASE + '/cart',
        type: 'GET',
        success: function(cart) {
            let html = '';

            if (!cart || !cart.items || cart.items.length === 0) {
                html = `
                    <div class="alert alert-warning">
                        Cart is empty
                    </div>
                `;
                $('#cart-content').html(html);
                return;
            }

            let total = 0;

            html += `
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th>Subtotal</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
            `;

            cart.items.forEach(function(item) {
                let subtotal = item.product.price * item.quantity;
                total += subtotal;

                html += `
                    <tr>
                        <td>${item.product.name}</td>
                        <td>₹ ${item.product.price}</td>
                        <td>
                            <input type="number"
                                   class="form-control qty-input"
                                   data-id="${item.id}"
                                   value="${item.quantity}"
                                   min="1">
                        </td>
                        <td>₹ ${subtotal}</td>
                        <td>
                            <button class="btn btn-success btn-sm update-cart"
                                    data-id="${item.id}">
                                Update
                            </button>

                            <button class="btn btn-danger btn-sm remove-cart"
                                    data-id="${item.id}">
                                Remove
                            </button>
                        </td>
                    </tr>
                `;
            });

            html += `
                    </tbody>
                </table>

                <h4>Total: ₹ ${total}</h4>

                <button class="btn btn-danger" id="clearCart">
                    Clear Cart
                </button>
            `;

            $('#cart-content').html(html);
        },
        error: function() {
            showAlert('Failed to load cart', 'danger');
        }
    });
}

$(document).on('click', '.update-cart', function() {
    let id = $(this).data('id');
    let qty = $('.qty-input[data-id="' + id + '"]').val();

    $.ajax({
        url: API_BASE + '/cart/' + id,
        type: 'PUT',
        data: {
            quantity: qty
        },
        success: function(res) {
            showAlert(res.message);
            loadCart();
        },
        error: function() {
            showAlert('Update failed', 'danger');
        }
    });
});

$(document).on('click', '.remove-cart', function() {
    let id = $(this).data('id');

    $.ajax({
        url: API_BASE + '/cart/' + id,
        type: 'DELETE',
        success: function(res) {
            showAlert(res.message);
            loadCart();
        },
        error: function() {
            showAlert('Remove failed', 'danger');
        }
    });
});

$(document).on('click', '#clearCart', function() {
    $.ajax({
        url: API_BASE + '/cart',
        type: 'DELETE',
        success: function(res) {
            showAlert(res.message);
            loadCart();
        },
        error: function() {
            showAlert('Clear cart failed', 'danger');
        }
    });
});
</script>

@endsection