<h1><?= $headline ?></h1>
<hr />

<?= validation_errors("<h2 style='color: red;'>", "</h2>")?>

<?php
//$this->load->library('session');
//if($this->session->flashdata('item') != "") {
//    echo $this->session->flashdata('item');
//}
//?>



<div class="row-fluid sortable">
    <div class="box span12">
        <div class="box-header" data-original-title>
            <h2>Item Details</h2>
            <div class="box-icon">
<!--                <a href="#" class="btn-setting"><i class="halflings-icon white wrench"></i></a>-->
<!--                <a href="#" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>-->
<!--                <a href="#" class="btn-close"><i class="halflings-icon white remove"></i></a>-->
            </div>
        </div>
        <div class="box-content">
            <?php $form_location = base_url()."store_items/create/".$update_id; ?>
            <form class="form-horizontal" method="post" action="<?= $form_location ?>">
                <fieldset>
                    <div class="control-group">
                        <label class="control-label" for="typeahead">Item Title </label>
                        <div class="controls">
                            <input type="text" class="span6" name="item_title" value="<?= $item_title?>">
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="typeahead">Item Price $</label>
                        <div class="controls">
                            <input type="number" step="0.01" class="span6" name="item_price" value="<?= $item_price?>">
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="typeahead">Item Stock</label>
                        <div class="controls">
                            <input type="number" class="span6" name="item_stock" value="<?= $item_stock?>">
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="typeahead">Item Category </label>
                        <div class="controls">
                            <input type="text" class="span6" name="item_category" value="<?= $item_category?>">
                        </div>
                    </div>


                    <div class="control-group hidden-phone">
                        <label class="control-label" for="textarea2">Item Description</label>
                        <div class="controls">
                            <textarea class="cleditor" id="textarea2" rows="3" name="item_description">
                                <?php echo $item_description;?>
                            </textarea>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary" name="submit" value="Submit">Save changes</button>
                        <button type="submit" class="btn" name="submit" value="Cancel">Cancel</button>
                    </div>
                </fieldset>
            </form>

        </div>
    </div><!--/span-->

</div><!--/row-->


<!--Display the available item operations when in update mode-->
<?php if(is_numeric($update_id)) { ?>
    <div class="row-fluid sortable">
        <div class="box span12">
            <div class="box-header" data-original-title>
                <h2>Item Operations</h2>
            </div>
            <div class="box-content">

<!--                show upload image button if the item does not have images,-->
<!--                otherwise show delete image button.-->
                <?php if($item_pic != "") { ?>
                    <a href="<?= base_url() ?>store_items/delete_img/<?= $update_id ?>">
                        <button type="button" class="btn btn-warning">Delete Image</button>
                    </a>
                <?php } else { ?>
                        <a href="<?= base_url() ?>store_items/upload_img/<?= $update_id ?>">
                            <button type="button" class="btn btn-success">Upload Image</button>
                        </a>
                <?php } ?>
                <a href="<?= base_url() ?>store_items/view_item/<?= $update_id?>"><button type="button" class="btn btn-primary">View Item</button></a>
                <a href="<?= base_url() ?>store_items/conf_del/<?= $update_id?>"><button type="button" class="btn btn-danger">Delete Item</button></a>
            </div>
        </div><!--/span-->

    </div><!--/row-->

<!--    show the thumbnails of item images-->
    <?php if($item_pic != "") { ?>
        <div class="row-fluid sortable">
            <div class="box span12">
                <div class="box-header" data-original-title>
                    <h2>Item Images</h2>
                </div>
                <div class="box-content">
                    <?php
                    list($file_name, $file_extension) = explode(".", $item_pic);
                    $item_thumb_path = $file_name."_thumb.".$file_extension;
                    ?>
                    <img src="<?= base_url()?>item_pics/<?= $item_thumb_path?>" class="img-fluid">;
                </div>
            </div><!--/span-->

        </div><!--/row-->
    <?php } ?>
<?php }?>


