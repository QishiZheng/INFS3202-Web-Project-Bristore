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
    <link href="<?php echo base_url(); ?>assets/css/bootstrap.css" rel="stylesheet">
<!--    <link href="--><?php //echo base_url(); ?><!--assets/adminfiles/css/bootstrap.min.css" rel="stylesheet">-->

<!--    <!-- Custom styles for this template -->-->
<!--    <link href="--><?php //echo base_url(); ?><!--dist/css/jumbotron.css" rel="stylesheet">-->

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <script src="<?php echo base_url()."assets/js/jquery-3.3.1.js"; ?>" ></script>
    <script src="<?php echo base_url(); ?>assets/js/vendor/popper.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
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
                <a class="nav-link" href="#">Link</a>
            </li>
            <li class="nav-item">
                <a class="nav-link disabled" href="#">Disabled</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="http://example.com" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown</a>
                <div class="dropdown-menu" aria-labelledby="dropdown01">
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <a class="dropdown-item" href="#">Something else here</a>
                </div>
            </li>
        </ul>
        <ul class="nav pull-right">
            <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
            <a data-toggle="modal" href="#modalCart" id="cart" class="btn btn-info btn-md">
                <i class="icon-shopping-cart"></i>CART
            </a>
            <!-- start: User Dropdown -->
            <?php
            //show the user dropdown if the user is logged in
            $userdata = $this->session->userdata();
            if(isset($userdata['first_name'])) {
            ?>
            <li class="dropdown">
                <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="halflings-icon white user"></i>
                    <?php
                    echo $userdata['first_name'];
                    } else {
                        echo "<a href='".base_url()."auth/login' class='btn btn-primary'>Login</a>";
                    }
                    ?>
                    <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <li class="dropdown-menu-title">
                        <span>Account Settings</span>
                    </li>
                    <li><a href="#"><i class="halflings-icon user"></i> Profile</a></li>
                    <li><a href="<?php echo base_url()."auth/logout";?>"><i class="halflings-icon off"></i> Logout</a></li>
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

<footer class="container">
    <p>&copy; Company 2018</p>
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
                <table class="table table-active">
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
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

</body>

<script>
    // show the cart modal when cart button is clicked
    $(document).ready(function() {
        $("#cart").click(function(e) {
            e.preventDefault();
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
                    console.log(error);
                }
            });
        });
    });


</script>
</html>

