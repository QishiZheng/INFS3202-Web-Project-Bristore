<div class="container"><br/>
        <div class="col-md-8 container-fluid">
            <h2>Confrim Your Shopping Cart Items</h2>
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
            <a class="btn btn-primary pull-right" href="#" >Checkout</a>
        </div>
    </div>
</div>

<script>
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