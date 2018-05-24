<h1>Manage Items</h1>
<?php
//$this->load->library('session');
//if($this->session->flashdata('item') != "") {
//    echo $this->session->flashdata('item');
//}

$create_item_url = base_url()."store_items/create";
?>
<br />
<a href="<?php echo $create_item_url;?>"><button type="button" class="btn btn-primary">Add New Item</button></a>
<hr />

<div class="row-fluid sortable">
    <div class="box span12">
        <div class="box-header">
            <h2>Item Inventory</h2>
        </div>
        <div class="box-content">
            <table class="table table-striped table-bordered bootstrap-datatable datatable">
                <thead>
                <tr>
                    <th>Item ID</th>
                    <th>Title</th>
                    <th>Price($)</th>
                    <th>Stock</th>
                    <th>Category</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody id="item_table">

                </tbody>
            </table>
        </div>
    </div><!--/span-->

</div><!--/row-->

<script>
    //show shopping cart
    $(document).ready(function() {
        $.ajax({
            type: "POST",
            url: <?= json_encode(base_url().'store_items/show_items')?>,
            dataType: "JSON",

            success: function(data) {
                $('#item_table').html(data);
                //console.log(data);
            },
            error: function(error) {
                console.log(error);
            }
        });

    });

    // Delete the item in the manage table using AJAX
    $("#item_table").delegate(".btnDelete", "click", function() {
        if (confirm("Are you sure you want to delete this item?")) {
            var el = this;
            var id = this.id;
            //get the id of item that we want to delete
            var deleteid = id.split("_")[1];
                // AJAX Request
                $.ajax({
                    url: <?= json_encode(base_url().'store_items/ajax_do_delete_item')?>,
                    type: 'POST',
                    data: { id:deleteid },
                    dataType: 'JSON',
                    success: function(data){
                        console.log(data);
                        // Removing row from HTML Table
                        $(el).closest('tr').css('background','tomato');
                        $(el).closest('tr').fadeOut(800, function(){
                            $(this).remove();
                        });
                    },
                    error: function(error){
                        console.log(error);
                    }
                });
            }
    });

</script>