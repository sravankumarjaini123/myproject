@extends('layouts.app')

@section('content')

<div class="row" id="product-detail">
    <div class="text-center">
        <h4>Loading product...</h4>
    </div>
</div>

<script>
$(document).ready(function() {
    loadProduct();
});

function loadProduct() {
    $.ajax({
        url: API_BASE + '/products/{{ $id }}',
        type: 'GET',
        success: function(product) {
            let html = `
                <div class="col-md-6">
                    <img src="https://via.placeholder.com/500x350"
                         class="img-fluid rounded shadow">
                </div>

                <div class="col-md-6">
                    <h2>${product.name}</h2>

                    <p class="mt-3">
                        ${product.description ?? ''}
                    </p>

                    <h4 class="text-success">
                        ₹ ${product.price}
                    </h4>

                    <p>
                        Stock: ${product.stock}
                    </p>

                    <div class="mb-3">
                        <label>Quantity</label>
                        <input type="number"
                               id="quantity"
                               class="form-control"
                               value="1"
                               min="1">
                    </div>

                    <button class="btn btn-primary"
                            id="addCartBtn"
                            data-id="${product.id}">
                        Add to Cart
                    </button>

                    <a href="/products" class="btn btn-secondary">
                        Back
                    </a>
                </div>
            `;

            $('#product-detail').html(html);
        },
        error: function() {
            showAlert('Product not found', 'danger');
        }
    });
}

$(document).on('click', '#addCartBtn', function() {
    if (!getToken()) {
        window.location.href = '/login';
        return;
    }

    let productId = $(this).data('id');
    let quantity = $('#quantity').val();

    $.ajax({
        url: API_BASE + '/cart/add',
        type: 'POST',
        data: {
            product_id: productId,
            quantity: quantity
        },
        success: function(res) {
            showAlert(res.message);
        },
        error: function() {
            showAlert('Failed to add to cart', 'danger');
        }
    });
});
</script>

@endsection