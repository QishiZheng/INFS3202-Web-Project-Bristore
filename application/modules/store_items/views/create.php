<h1><?= $headline ?></h1>
<hr />

<?= validation_errors("<h2 style='color: red;'>", "</h2>")?>

<?php if(isset($flash)) {
    echo $flash;
} ?>

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
                            <input type="text" class="span6" name="item_price" value="<?= $item_price?>">
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="typeahead">Item Stock</label>
                        <div class="controls">
                            <input type="text" class="span6" name="item_stock" value="<?= $item_stock?>">
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