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
            <h2>This is My Orders page</h2><br />
            <table class="table">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">Order#</th>
                    <th scope="col">No. of Item</th>
                    <th scope="col">Total Amount</th>
                    <th scope="col">Action</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <th scope="row">1</th>
                    <td>5</td>
                    <td>$100</td>
                    <td>View</td>
                </tr>
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
            url: <?= json_encode(base_url().'')?>,
            dataType: "JSON",

            success: function(data) {
                // $('#item_table').html(data);

            },
            error: function(error) {
                console.log(error);
            }
        });

    });
</script>
