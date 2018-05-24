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
            <h2>My Orders</h2><br />
            <table class="table">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">Order#</th>
                    <th scope="col">No. of Items</th>
                    <th scope="col">Total Amount</th>
                    <th scope="col">Action</th>
                </tr>
                </thead>
                <tbody id="order_table">

                </tbody>
            </table>
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
    //populate order history table
    $(document).ready(function() {
        $.ajax({
            type: "POST",
            url: <?= json_encode(base_url().'user/get_my_orders/')?>,
            dataType: "JSON",

            success: function(data) {
                //populate the order table with the json array from server
                var trHTML = '';
                $.each(data, function (i, order) {
                    trHTML +='<tr><th scope="row">'+order.order_id+
                                '</th><td>'+order.num_of_items+
                                '</td><td>$ '+order.total+
                                '</td><td><a class="btn btn-info" href="<?=base_url()."user/user_order/"?>'+order.order_id+'">View</a></td></tr>';
                });
                $('#order_table').append(trHTML);
            },
            error: function(error) {
                console.log(error);
            }
        });
    });
</script>
