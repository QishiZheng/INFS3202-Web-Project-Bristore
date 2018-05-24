<div class="container-fluid-full">
    <div class="row-fluid">
        <!-- start: left sidebar menu -->
        <div class="sidenav">
            <a href="<?php echo base_url().'user';?>">Profile</a>
            <a href="<?php echo base_url().'user/my_orders';?>">Orders</a>
        </div>


        <!-- end: Main Menu -->

        <!-- start: Content -->
        <div id="content" class="span10" style="margin-left: 200px;">
            <h2>Order# <?= $order_id?></h2><br />
            <div class="row">
                <div class="col">
                    <h2>Bristore</h2>
                </div>
                <div class="col">
                    <h5>Order#: <?= $order_details->id?></h5>
                    <h5>Created At:</h5>
                    <p><?= $order_details->time?></p>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <h5>Name: <?php echo $user_details->first_name.' '.$user_details->last_name; ?></h5>
                    <h5>Shipping Address:</h5>
                    <p><?= $order_details->shipping_address?></p>
                </div>
                <div class="col">
                    <h5>Phone:</h5>
                    <p><?= $user_details->phone?></p>
                    <h5>Email:</h5>
                    <p><?= $user_details->email?></p>
                </div>
            </div>
            <table class="table">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">Item#</th>
                    <th scope="col">Item Title</th>
                    <th scope="col">Qty</th>
                    <th scope="col">Price</th>
                    <th scope="col">Subtotal</th>

                </tr>
                </thead>
                <tbody id="order_item_table">

                </tbody>
            </table>
            <hr />
            <h3 id="total">Total: $ </h3>
            <!-- end: Content -->
        </div><!--/#content.span10-->
    </div><!--/fluid-row-->
</div>

<!--//additional styling for side nav-->
<style>
    body {
        font-family: "Lato", sans-serif;
    }
    .sidenav {
        height: 100%;
        width: 200px;
        position: fixed;
        z-index: 1;
        top: 0;
        left: 0;
        background-color: #111;
        overflow-x: hidden;
        padding-top: 20px;
        margin-top: 50px;
    }

    .sidenav a {
        padding: 6px 6px 6px 32px;
        text-decoration: none;
        font-size: 25px;
        color: #818181;
        display: block;
    }

    .sidenav a:hover {
        color: #f1f1f1;
    }

    @media screen and (max-height: 450px) {
        .sidenav {padding-top: 15px;}
        .sidenav a {font-size: 18px;}
    }
</style>

<script>
    //populate item history table
    $(document).ready(function() {
        $.ajax({
            type: "POST",
            url: <?= json_encode(base_url().'order/get_order_items_json/'.$order_id)?>,
            dataType: "JSON",

            success: function(data) {
                //populate the item table with the json array from server
                var trHTML = '';
                var total = 0;
                $.each(data, function (i, item) {
                    trHTML +='<tr><th scope="row">'+item.item_id+
                        '</th><td><a href="<?=base_url()."store_items/view_item/"?>'+item.item_id+'">'+item.item_title+
                        '</a></td><td>'+item.qty+
                        '</td><td>'+item.price+
                        '</td><td>'+item.subtotal;
                        var subtotal = item.subtotal.replace(",", "");
                        total += parseFloat(subtotal);
                });
                $('#order_item_table').append(trHTML);
                $('#total').append(total);
            },
            error: function(error) {
                console.log(error);
            }
        });
    });
</script>
