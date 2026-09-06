let cartItems = {};

    function addToCart(id, name, price) {
        if (cartItems[id]) {
            cartItems[id].quantity++;
        } else {
            cartItems[id] = { id: id, name: name, price: price, quantity: 1 };
        }
        renderCart();
    }

function renderCart() {
    var cart = document.getElementById('cart');
    cart.innerHTML = '';

    var subtotal = 0;

    for (var id in cartItems) {
        var item = cartItems[id];
        subtotal += item.price * item.quantity;

        var itemDiv = document.createElement('div');
        itemDiv.className = 'cart-item d-flex align-items-center mb-2';

        // Left - name (flex:1, align left)
        // Center - price x qty (flex:1, text-center)
        // Right - buttons (flex:1, align right)

        itemDiv.innerHTML =

            '<div style="flex: 1; text-align: left;">' +
                '<strong>' + item.name + '</strong>' +
            '</div>' +
            '<div style="flex: 1; text-align: center;">' +
                '$' + item.price.toFixed(2) + ' x ' + item.quantity +
            '</div>' +
            '<div style="flex: 1; text-align: right;">' +
                '<button onclick="decrementQuantity(' + id + ')" class="btn btn-sm btn-outline-secondary me-1">-</button>' +
                '<button onclick="incrementQuantity(' + id + ')" class="btn btn-sm btn-outline-secondary me-2">+</button>' +
                '<button onclick="removeItem(' + id + ')" class="btn btn-sm btn-danger">&times;</button>' +
            '</div>';

        cart.appendChild(itemDiv);
    }

    updateTotals(subtotal);
    // Scroll to bottom of cart-area
var cartArea = document.getElementById('cart-area');
cartArea.scrollTo({
    top: cartArea.scrollHeight,
    behavior: 'smooth' 
});
}

    function incrementQuantity(id) {
        cartItems[id].quantity++;
        renderCart();
    }

    function decrementQuantity(id) {
        if (cartItems[id].quantity > 1) {
            cartItems[id].quantity--;
        } else {
            delete cartItems[id];
        }
        renderCart();
    }

    function removeItem(id) {
        delete cartItems[id];
        renderCart();
    }

 function updateTotals(subtotal) {
    var taxRate = 0.1;
    var tax = subtotal * taxRate;
    var payout = subtotal + tax;

    document.getElementById('subtotal').textContent = '$' + subtotal.toFixed(2);
    document.getElementById('tax').textContent = '$' + tax.toFixed(2);
    document.getElementById('total').textContent = '$' + payout.toFixed(2);
}
// clear cart
function clearCart() {
    cartItems = {};
    renderCart();
}


// ------------------ Order Cart

document.addEventListener("DOMContentLoaded", function () {
    const orderForm = document.getElementById('orderForm');
    const cartDataInput = document.getElementById('cartData');

    if (orderForm && cartDataInput) {
        orderForm.addEventListener('submit', function(e) {
            const cartArray = Object.values(cartItems).map(item => ({
                product_id: item.id,
                price: item.price,
                quantity: item.quantity,
            }));
            cartDataInput.value = JSON.stringify(cartArray);
        });
    }
});

// ----------------------------- Proceed
$('#proceed').click(function () {
    let customerId = null;
    let tableNumberId = null;
    let orderType = null;

    if ($("#checkDelivery").is(':checked')) {
        customerId = $("#customerSelect").val();
        orderType = 'delivery';
    } else {
        tableNumberId = $("#tableSelect").val();
        orderType = 'dine-in';
    }

    if (!orderType || (orderType === 'delivery' && !customerId) || (orderType === 'dine-in' && !tableNumberId)) {
        alert('Please select a customer or table!');
        return;
    }

    let cartArray = Object.values(cartItems).map(item => ({
        product_id: item.id,
        price: item.price,
        quantity: item.quantity,
    }));

    if (cartArray.length === 0) {
        alert('Your cart is empty!');
        return;
    }

    const data = {
        order_type: orderType,
        cart: JSON.stringify(cartArray),
    };

    if (orderType === 'dine-in') {
        data.table_number_id = tableNumberId;
    } else {
        data.customer_id = customerId;
    }

    $.post('/orders/save', data)
        .done(function (response) {
    alert(response.message || 'Order saved!');
    clearCart();

    if (data.order_type === 'dine-in') {
  
        const currentOption = $(`#tableSelect option[value="${data.table_number_id}"]`);
        currentOption.prop('disabled', true).text(currentOption.text() + ' (In Use)');
        const nextAvailable = $('#tableSelect option:not(:disabled)').first();
        if (nextAvailable.length > 0) {
            $('#tableSelect').val(nextAvailable.val());
        } else {
            $('#tableSelect').val(''); 
        }


        const dineInContainer = document.getElementById('dineInContainer');
        if (dineInContainer) {
            const card = document.createElement('div');
            card.className = "card rounded mx-2 mt-1";
            card.style.width = "13rem";
            card.style.height = "13rem";
            card.setAttribute("data-bs-toggle", "modal");
            card.setAttribute("data-bs-target", `#table${response.order_id}`);

            card.innerHTML = `
                <div class="card-body">
                    <h5 class="card-title">Table Number</h5>
                    <h4 class="card-subtitle mb-2 text-muted">${currentOption.text()}</h4>
                    <p>Click to view</p>
                    <p class="text-danger paid-status" data-order-id="${response.order_id}">unpaid</p>
                </div>
            `;
            dineInContainer.appendChild(card);
        }
    }


    if (data.order_type === 'delivery') {
        $('#customerSelect').val('');
    }
});

});















