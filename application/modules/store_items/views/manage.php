<h1>Manage Items</h1>
<?php
$this->load->library('session');
if($this->session->flashdata('item') != "") {
    echo $this->session->flashdata('item');
}

$create_item_url = base_url()."store_items/create";
?>
<br />
<a href="<?php echo $create_item_url;?>"><button type="button" class="btn btn-primary">Add New Item</button></a>
<hr />

<div class="row-fluid sortable">
    <div class="box span12">
        <div class="box-header" data-original-title>
            <h2>Item Inventory</h2>
<!--            <div class="box-icon">-->
<!--                <a href="#" class="btn-setting"><i class="halflings-icon white wrench"></i></a>-->
<!--                <a href="#" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>-->
<!--                <a href="#" class="btn-close"><i class="halflings-icon white remove"></i></a>-->
<!--            </div>-->
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
                <tbody>
                <?php
                    foreach ($query->result() as $row) {
                        $edit_item_url = base_url()."store_items/create/".$row->id;
                        $id = $row->id;
                        $item_title = $row->item_title;
                        $item_price = $row->item_price;
                        $item_stock = $row->item_stock;
                        $item_category = $row->item_category;
                        $item_description = $row->item_description;
                        ?>

                <tr>
                    <td ><?= $id ?></td>
                    <td class="center"><?= $item_title ?></td>
                    <td class="center"><?= $item_price ?></td>
                    <td class="center"><?= $item_stock ?></td>
                    <td class="center"><?= $item_category ?></td>
                    <td class="center"><?= $item_description ?></td>
                    <td class="center">
                        <?php
                        //display different color labels depending on the stock of the item
                        if($row->item_stock <= 0 ) {
                            echo '<span class="label label-important">Out of Stock!</span>';
                        } elseif($row->item_stock > 0 && $row->item_stock <= 10 ) {
                            echo '<span class="label label-warning">Low Stock!</span>';
                        } else {
                            echo '<span class="label label-success">In Stock</span>';
                        } ?>

                    </td>
                    <td class="center">
                        <!--button for viewing this item on product page-->
                        <a class="btn btn-success" href="<?= base_url() ?>store_items/view_item/<?= $row->id?>">
                            <i class="halflings-icon white zoom-in"></i>
                        </a>
                        <!--button for editing this item-->
                        <a class="btn btn-info" href="<?= $edit_item_url ?>">
                            <i class="halflings-icon white edit"></i>
                        </a>
                        <!--button for deleting this item-->
                        <btn class="btn btn-danger btnDelete" id="del_<?php echo $id; ?>">
                            <i class="halflings-icon white trash"></i>
                        </btn>
                    </td>
                </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div><!--/span-->

</div><!--/row-->

<script>
    //$.support.cors = true;
    // Delete
    $('.btnDelete').click(function(){

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