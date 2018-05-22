<div class="container"><br/>
        <div class="col-md-8 container-fluid">
            <div>
                <h2>Confirm Your Shopping Cart Items</h2>
                <table class="table table-active">
                    <thead>
                    <tr>
                        <th>Item ID</th>
                        <th>Items</th>
                        <th>Price</th>
                        <th>Qty</th>
                        <th>Subtotal</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody id="cart_details">

                    </tbody>
                </table>
            </div>

            <div class="container" >
                <form action="/action_page.php">

                    <div class="row">
                        <div class="col-50">
                            <h3>Billing Address</h3>
                            <label for="fullName"><i class="fa fa-user"></i> Full Name: </label>
                            <input type="text" id="fullName" name="fullName" size="40" value="<?php echo $user->first_name.' '.$user->last_name; ?>"><br/>
                            <label for="email"><i class="fa fa-envelope"></i> Email: </label>
                            <input type="text" id="email" name="email" size="40" placeholder="john@example.com" value="<?php echo $user->email; ?>"><br/>
                            <label for="phone"><i class="fa fa-envelope"></i> Phone Number: </label>
                            <input type="text" id="phone" name="phone" size="40" placeholder="0123456789" value="<?php echo $user->phone; ?>"><br/>
                            <label for="adr"><i class="fa fa-address-card-o"></i> Address: </label>
                            <input type="text" id="adr" name="address" size="50" placeholder="1 Queen Street, " value="<?php echo $user->address; ?>">
                        </div>
                </form>
            </div>

            <a class="btn btn-primary pull-right" href="<?= base_url().'order/place_order' ?>" >Checkout</a>

<!--           PayPal checkout button-->
            <div id="paypal-button-container"></div>
        </div>

</div>


<script src="https://www.paypalobjects.com/api/checkout.js"></script>
<script>
    paypal.Button.render({

        env: 'sandbox', // sandbox | production

        // PayPal Client IDs - replace with your own
        // Create a PayPal app: https://developer.paypal.com/developer/applications/create
        client: {
            sandbox:    'AZDxjDScFpQtjWTOUtWKbyN_bDt4OgqaF4eYXlewfBP4-8aqX3PiV8e1GWU6liB2CUXlkA59kJXE7M6R',
            production: '<insert production client id>'
        },

        // Show the buyer a 'Pay Now' button in the checkout flow
        commit: true,

        // payment() is called when the button is clicked
        payment: function(data, actions) {

            // Make a call to the REST api to create the payment
            return actions.payment.create({
                payment: {
                    transactions: [
                        {
                            amount: { total: '0.01', currency: 'AUD' }
                        }
                    ]
                }
            });
        },

        // onAuthorize() is called when the buyer approves the payment
        onAuthorize: function(data, actions) {

            // Make a call to the REST api to execute the payment
            return actions.payment.execute().then(function() {
                window.alert('Payment Complete!');
            });
        }

    }, '#paypal-button-container');

</script>
</div>




<script>

    //update quantity of item in cart with ajax
    function update_qty(item_id){
        var item_id = item_id;
        var item_qty_id = item_id + "_qty";
        var item_qty = document.getElementById(item_qty_id).value;
        $.ajax({
            url: <?= json_encode(base_url().'cart/update_cart_item_qty')?>,
            type: 'POST',
            data: { item_id: item_id,
                qty: item_qty,
            },
            dataType: 'JSON',
            success: function(data){
                console.log(data);
                //Removing row from HTML Table
                //$('#cart_modal').modal('show');
            },
            error: function(error){
                console.log(error);
            }
        });

    }

    //show shopping cart
    $(document).ready(function() {
        $.ajax({
            type: "POST",
            url: <?= json_encode(base_url().'cart/show_cart')?>,
            dataType: "JSON",

            success: function(data) {
                $('#cart_details').html(data);
                //console.log(data);
            },
            error: function(error) {
                console.log(error);
            }
        });

    });


    //send the item_id to server and delete this item in cart
    $("table").delegate("button", "click", function() {
        if (confirm("Are you sure you want to delete this item?")) {
            var el = this;
            var id = $(this).attr('id');
            $.ajax({
                url: <?= json_encode(base_url().'cart/delete_cart_item')?>,
                type: 'POST',
                data: { item_id: id },
                dataType: 'JSON',
                success: function(data){
                    //console.log(data);
                    // Removing row from HTML Table
                    $(el).closest('tr').css('background','tomato');
                    $(el).closest('tr').fadeOut(800, function(){
                        $(this).remove();
                    });
                },
                error: function(error){
                    console.log(error);
                }
            });
        }
    });


</script>