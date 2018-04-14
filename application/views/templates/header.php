<html>
    <head>
        <title>Bristore</title>
<!--        bootstrap navigation bar template from bootswatch-->
        <link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.min.css">
    </head>

    <body>

        <!-- This is the code for global nav bar from bootswatch template -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <a class="navbar-brand" href="<?php echo base_url(); ?>">Bristore</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarColor01">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a href="<?php echo base_url(); ?>" class="nav-link <?php if($this->uri->segment(1)== ""){echo 'active';}?>" >Home</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Category</a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo base_url(); ?>items" class="nav-link <?php if($this->uri->segment(1)== "items"){echo 'active';}?>" >All Items</a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo base_url(); ?>about" class="nav-link <?php if($this->uri->segment(1)== "about"){echo 'active';}?>"  >About</a>
                    </li>
                </ul>
                <form class="form-inline my-2 my-lg-0">
                    <input class="form-control mr-sm-2" type="text" placeholder="Search">
                    <button class="btn btn-secondary my-2 my-sm-0" type="submit">Search</button>
                </form>

                <!--                    <ul class="nav navbar-nav navbar-right">-->
                <!--                        <li><a href= "/" ><span class="glyphicon glyphicon-login"></span>Login</a></li>-->
                <!--                        <li><a href= "/" ><span class="glyphicon glyphicon-user"></span>Sign Up</a></li>-->
                <!--                        -->
                <!--                    </ul>-->

            </div>
        </nav>

    <div class="container">

