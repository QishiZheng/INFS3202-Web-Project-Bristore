<h1><?= $headline ?></h1>
<hr />

<?= validation_errors("<h2 style='color: red;'>", "</h2>")?>

<?php if(isset($flash)) {
    echo $flash;
} ?>

<div class="row-fluid sortable">
    <div class="box span12">
        <div class="box-header" data-original-title>
            <h2>Confirm Delete Item<?= $update_id ?></h2>
        </div>
        <div class="box-content">
            <p>Do you really want to delete this item: <strong><?= $item_title; ?></strong>
            </p>

            <?php echo form_open('store_items/delete_item/'.$update_id);?>
            <br /><br />
            <div class="form-actions">
                <button type="submit" class="btn btn-danger" name="submit" value="Yes">Yes, Delete It</button>
                <button type="submit" class="btn btn-secondary" name="submit" value="No">No</button>
            </div>
            </form>
        </div>
    </div>
</div>
