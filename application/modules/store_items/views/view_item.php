<!--template from https://mdbootstrap.com/freebies/ecommerce-template/-->

<div class="container dark-grey-text mt-5">

    <!--Grid row-->
    <div class="row wow fadeIn">

        <!--Grid column-->
        <div class="col-md-6 mb-4">
            <!-- show the pic of this item, show "NoImageFound" if this item has no pics-->
            <img src="<?= base_url()?>item_pics/<?php
            if($item_pic != "") { echo $item_pic;}
            else{echo "noImageFound.png";} ;?>" class="img-fluid" alt="<?= $item_title?>">
        </div>
        <!--Grid column-->

        <!--Grid column-->
        <div class="col-md-6 mb-4">

            <!--Content-->
            <div class="p-4">

                <div class="mb-3">
                    <h1><?= $item_title ?></h1>
                </div>
                <hr/>
              <span class="mr-1">
                  <p class="text-secondary">Price: <h3>$<?= $item_price ?></h3></p>
              </span>
                <form class="d-flex justify-content-left">
                    <!-- Default input -->
                    <input type="number" value="1" aria-label="Search" class="form-control" style="width: 100px">
                    <button class="btn btn-primary btn-md my-0 p" type="submit">Add to cart
                        <i class="fa fa-shopping-cart ml-1"></i>
                    </button>

                </form>

            </div>
            <!--Content-->

        </div>
        <!--Grid column-->

    </div>
    <!--Grid row-->

    <hr>

    <!--Grid row-->
    <div class="row d-flex justify-content-center wow fadeIn">

        <!--Grid column-->
        <div class="col-md-6 text-center">

            <h4 class="my-4 h4">Description</h4>


            <p><?= $item_description ?></p>

        </div>
        <!--Grid column-->

    </div>
    <!--Grid row-->

    <!--Grid row-->
    <div class="row wow fadeIn">

        <!--Grid column-->
        <div class="col-lg-4 col-md-12 mb-4">

            <img src="#" class="img-fluid" alt="">

        </div>
        <!--Grid column-->

        <!--Grid column-->
        <div class="col-lg-4 col-md-6 mb-4">

            <img src="#" class="img-fluid" alt="">

        </div>
        <!--Grid column-->

        <!--Grid column-->
        <div class="col-lg-4 col-md-6 mb-4">

            <img src="#" class="img-fluid" alt="">

        </div>
        <!--Grid column-->

    </div>
    <!--Grid row-->

</div>
