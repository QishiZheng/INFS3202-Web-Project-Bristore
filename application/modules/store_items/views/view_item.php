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
                <!-- Default input -->
                <div>
                    <label for="qty">Qty:</label>
                    <input type="number" name="qty" id="qty" value="1" placeholder="1" class="form-control" style="width: 100px; height:35px;">
                </div>
                <br/>
                <button class="btn btn-info btn-lg" id="addToCart">
                    <span class="glyphicon glyphicon-shopping-cart"></span>Add to Cart
                </button>

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

    <!-- Modal for showing successful adding item to cart-->
    <div class="modal fade" id="modalAddToCard" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Success</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?=$item_title ?> has been successfully added to cart!
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
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


<script>
    // trigger this function when addToCart button is clicked
    $("#addToCart").click(function(e) {
         e.preventDefault();
        console.log();
        $.ajax({
            type: "POST",
            url: <?= json_encode(base_url().'store_items/test')?>,
            data: {
                qty: $("#qty").val(),
                price:<?= json_encode($item_price) ?>
            },

            success: function(result) {

                $('#modalAddToCard').modal('show')
            },
            error: function(result) {
                alert('error');
            }
        });
    });
</script>