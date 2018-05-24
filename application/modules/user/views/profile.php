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
            <h2>My Profile</h2>
            <table class="table ">
                <tbody>
                <tr>
                    <td>Name: </td>
                    <td id="name"></td>
                </tr>
                <tr>
                    <td>Email: </td>
                    <td id="email"></td>
                </tr>
                <tr>
                    <td>Phone Number</td>
                    <td id="phone"></td>
                </tr>
                <tr>
                    <td>Address: </td>
                    <td id="address"></td>
                </tr>
                </tbody>
            </table>

            <!-- Button trigger modal -->
            <a class="btn btn-info" href="<?= base_url()?>user/update_address">Update Address</a>

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
    //get user details from server
    $(document).ready(function() {
        $.ajax({
            type: "POST",
            url: <?= json_encode(base_url().'user/profile/')?>,
            dataType: "JSON",

            success: function(data) {
               $('#name').text(data.first_name + " " +data.last_name);
               $('#email').text(data.email);
               $('#phone').text(data.phone);
               $('#address').text(data.address);
                //console.log(data);
            },
            error: function(error) {
                console.log(error);
            }
        });

    });

</script>
