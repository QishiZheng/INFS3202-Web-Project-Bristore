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
    <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet">

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
            <a href="#" class="btn btn-info btn-md">
                <i class="icon-shopping-cart"></i>CART
            </a>
            <!-- start: User Dropdown -->
            <li class="dropdown">
                <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="halflings-icon white user"></i>
                    <?php
                    $userdata = $this->session->userdata();
                    echo $userdata['first_name'];?>
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


</body>
</html>
