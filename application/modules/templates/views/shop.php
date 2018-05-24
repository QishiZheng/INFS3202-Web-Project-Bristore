<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="<?php echo base_url(); ?>favicon.ico">

    <title>Bristore</title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url();?>assets/css/bootstrap.css" rel="stylesheet">

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <script src="<?php echo base_url()."assets/js/jquery-3.3.1.js"; ?>" ></script>
    <script src="<?php echo base_url(); ?>assets/js/vendor/popper.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/bootstrap.js"></script>
</head>

<body>

<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
    <a class="navbar-brand" href="<?= base_url()."store_items/index"?>">Bristore</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="<?= base_url()."store_items/index"?>">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url()."store_items/all_items"?>">All Items</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="http://example.com" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Categories</a>

                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item" href="<?= base_url().'store_items/category/1'?>">Home & Garden</a>
                    <a class="dropdown-item" href="<?= base_url().'store_items/category/2'?>">Appliances</a>
                    <a class="dropdown-item" href="<?= base_url().'store_items/category/3'?>">Books & Magazines</a>
                    <a class="dropdown-item" href="<?= base_url().'store_items/category/4'?>">Clothing</a>
                    <a class="dropdown-item" href="<?= base_url().'store_items/category/5'?>">Bags & Luggage</a>
                    <a class="dropdown-item" href="<?= base_url().'store_items/category/6'?>">Vehicles</a>
                    <a class="dropdown-item" href="<?= base_url().'store_items/category/8'?>">Electronics</a>
                    <a class="dropdown-item" href="<?= base_url().'store_items/category/7'?>">Accessories</a>
                    <a class="dropdown-item" href="<?= base_url().'store_items/category/9'?>">Others</a>
                </div>
            </li>
        </ul>
        <ul class="nav pull-right">
            <a data-toggle="modal" href="#modalCart" id="cart" class="btn btn-info btn-md">
                CART
            </a>
            <!-- start: User Dropdown -->

            <?php
            $userdata = $this->session->userdata();
            if(isset($userdata['first_name'])) {
            ?>
            <li class="dropdown">
                <button class="dropdown-toggle btn btn-primary" data-toggle="dropdown">
                    <i class="halflings-icon white user">
                    <?php
                    echo $userdata['first_name']."</i>";
                    } else {
                        echo "<a href='".base_url()."auth/login' class='btn btn-primary'>Login</a>";
                    }
                    ?>
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                    <?php
                    //set the first dropdown item to "Dashbaord" if the user is admin, otherwise profile
                        if($userdata['first_name'] == "Admin" | $userdata['first_name'] == "admin"){
                            echo "<li><a class='dropdown-item' href='".base_url()."auth/manage'><i class='halflings-icon user'></i>Dashboard</a></li>";
                            } else {
                            echo "<li><a class='dropdown-item' href='".base_url()."user'><i class='halflings-icon user'></i> Profile</a></li>";
                        }
                    ?>

                    <li><a class="dropdown-item" href="<?php echo base_url()."auth/logout";?>"><i class="halflings-icon off"></i> Logout</a></li>
                </ul>
            </li>
            <!-- end: User Dropdown -->
        </ul>
    </div>
</nav>

<main role="main" class="mt-5 pt-4">

    <div class="container" style="min-height: 640px;">
        <?php
        $this->load->library('session');
        if($this->session->flashdata('item') != "") {
            echo $this->session->flashdata('item');
        }
        ?>

        <?php
        //load the view file if it is set
        if(isset($view_file)) {
            $this->load->view($view_module.'/'.$view_file);
        }
        ?>
    </div>

</main>

<footer class="footer-copyright text-center" >
    <p>&copy; Bristore 2018</p>
    <p>Email: vincezheng4265@gmail.com</p>
</footer>


<!-- Modal for shopping cart-->
<div class="modal fade" id="cart_modal" >
    <div class="modal-dialog modal-lg" >
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Shopping Cart</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <table class="table table-active" id="modal_cart_table">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Item</th>
                        <th>Price</th>
                        <th>Qty</th>
                        <th>Subtotal</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody id="cart_content">

                    </tbody>

                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <a class="btn btn-primary" href="<?= base_url().'cart/check_out' ?>" >Checkout</a>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

</body>

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
                var total = data.total;
                var subtotal = data.subtotal;
                var item_subtotal_id = item_id + "_subtotal";
                $('#total_amount').text("$ " + total);
                $('#'+item_subtotal_id).text("$"+subtotal);

            },
            error: function(error){
                console.log(error);
            }
        });

    }

    $(document).ready(function() {
        //get teh cart data from server and display it with modal when cart is clicked
        $("#cart").click(function() {
            // e.preventDefault();
            $.ajax({
                type: "POST",
                url: <?= json_encode(base_url().'cart/show_cart')?>,
                dataType: "JSON",

                success: function(data) {
                    $('#cart_content').html(data);
                    $('#cart_modal').modal('show');
                    //console.log(data);
                },
                error: function(error) {
                    alert(error);
                }
            });
        });

        //send the item_id to server and delete this item in cart
        $("#modal_cart_table").delegate("button", "click", function() {
            if (confirm("Are you sure you want to delete this item?")) {
                var el = this;
                var id = $(this).attr('id');
                $.ajax({
                    url: <?= json_encode(base_url().'cart/delete_cart_item')?>,
                    type: 'POST',
                    data: { item_id: id },
                    dataType: 'JSON',
                    success: function(data){
                        var total = data;
                        //console.log(data);
                        // Removing row from HTML Table
                        $(el).closest('tr').css('background','tomato');
                        $(el).closest('tr').fadeOut(800, function(){
                            $(this).remove();
                        });

                        $('#total_amount').text("$ " + total);
                    },
                    error: function(error){
                        console.log(error);
                    }
                });
            }
        });



    });
</script>
</html>

