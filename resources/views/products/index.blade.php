@extends('layouts.app')

@section('content')

<h2 class="mb-4">Products</h2>

<div class="row" id="product-list">
    <div class="text-center">
        <h4>Loading products...</h4>
    </div>
</div>

<script>
$(document).ready(function() {
    loadProducts();
});

function loadProducts() {
    $.ajax({
        url: API_BASE + '/products',
        type: 'GET',
        success: function(products) {
            let html = '';

            if (products.length === 0) {
                html = '<div class="alert alert-warning">No products found</div>';
            }

            products.forEach(function(product) {
                html += `
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-sm">
                            <img src="https://via.placeholder.com/300x200"
                                 class="card-img-top"
                                 alt="product">

                            <div class="card-body">
                                <h5>${product.name}</h5>
                                <p>${product.description ?? ''}</p>
                                <p><strong>₹ ${product.price}</strong></p>
                                <p>Stock: ${product.stock}</p>

                                <button class="btn btn-primary add-cart"
                                        data-id="${product.id}">
                                    Add to Cart
                                </button>

                                <a href="/products/${product.id}"
                                   class="btn btn-secondary">
                                   View
                                </a>
                            </div>
                        </div>
                    </div>
                `;
            });

            $('#product-list').html(html);
        },
        error: function() {
            showAlert('Failed to load products', 'danger');
        }
    });
}

$(document).on('click', '.add-cart', function() {
    let productId = $(this).data('id');

    if (!getToken()) {
        window.location.href = '/login';
        return;
    }

    $.ajax({
        url: API_BASE + '/cart/add',
        type: 'POST',
        data: {
            product_id: productId,
            quantity: 1
        },
        success: function(res) {
            showAlert(res.message);
        },
        error: function(xhr) {
            showAlert('Failed to add cart', 'danger');
        }
    });
});
</script>

@endsection