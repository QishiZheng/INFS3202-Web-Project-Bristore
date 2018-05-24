<!-- Simple line Icon -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/simple-line-icons.css">
<!-- Themify Icon -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/themify-icons.css">
<!-- Hover Effects -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/set1.css">
<!-- Main CSS -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.css">

<div class="slider d-flex align-items-center">
<!--     <img src="images/Slider.jpeg" class="img-fluid" alt="background.jpg"> -->
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-md-12">
                <div class="slider-title_box">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="slider-content_wrap">
                                <h1>BRISTORE</h1>
                                <h5 style="color:white;">Buy new and second-hand items near you!</h5>
                            </div>
                        </div>
                    </div>
                    <div class="row d-flex justify-content-center">
                        <div class="col-md-10">
                            <?php echo validation_errors(); ?>

                            <?php echo form_open(base_url().'store_items/search'); ?>
<!--                            <form class="form-wrap mt-4" method="GET" action="--><?//=base_url().'store_items/search' ?><!--">-->
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <input type="text" name="search_term" id="search_term" placeholder="What are your looking for?" class="btn-group">
<!--                                    <input type="text" placeholder="Auchenflower" class="btn-group2">-->
                                    <button type="submit" value="Search" class="btn-form">SEARCH</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--// SLIDER -->
<!--//END HEADER -->
<!--============================= FIND PLACES =============================-->
<div class="main-block">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="styled-heading" style="margin-top: 10px;">
                    <h3>Popular Categories</h3>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="find-place-img_wrap">
                    <div class="grid">
                        <figure class="effect-ruby">
                            <a href="<?= base_url().'store_items/category/1'?>">
                            <img src="<?php echo base_url(); ?>assets/img/homepage_images/home-garden.jpg" class="img-fluid" alt="home-and-garden" />
                            </a>
                            <figcaption>
                                <h5>Home & Garden</h5>
                            </figcaption>
                        </figure>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="row find-img-align">
                    <div class="col-md-12">
                        <div class="find-place-img_wrap">
                            <div class="grid">
                                <figure class="effect-ruby">
                                    <a href="<?= base_url().'store_items/category/8'?>">
                                    <img src="<?php echo base_url(); ?>assets/img/homepage_images/headphone.jpg" class="img-fluid" alt="elecs" />
                                    </a>
                                    <figcaption>
                                        <h5>Electronics</h5>
                                    </figcaption>
                                </figure>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="find-place-img_wrap">
                            <div class="grid">
                                <figure class="effect-ruby">
                                    <a href="<?= base_url().'store_items/category/4'?>">
                                    <img src="<?php echo base_url(); ?>assets/img/homepage_images/clothes.jpg" class="img-fluid" alt="clothes" />
                                    </a>
                                    <figcaption>
                                        <h5>Clothing</h5>
                                    </figcaption>
                                </figure>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="row find-img-align">
                    <div class="col-md-12">
                        <div class="find-place-img_wrap">
                            <div class="grid">
                                <figure class="effect-ruby">
                                    <a href="<?= base_url().'store_items/category/3'?>">
                                    <img src="<?php echo base_url(); ?>assets/img/homepage_images/books.jpg" class="img-fluid" alt="books-magazines" />
                                    </a>
                                    <figcaption>
                                        <h5>Books & Magazines</h5>
                                    </figcaption>
                                </figure>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="find-place-img_wrap">
                            <div class="grid">
                                <figure class="effect-ruby">
                                    <a href="<?= base_url().'store_items/category/7'?>">
                                    <img src="<?php echo base_url(); ?>assets/img/homepage_images/accessories.jpg" class="img-fluid" alt="accessories" />
                                    </a>
                                    <figcaption>
                                        <h5>Accessories</h5>
                                    </figcaption>
                                </figure>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--//END FIND PLACES -->