<h1><?= $headline ?></h1>
<hr />
<div class="row-fluid sortable">
    <div class="box span12">
        <div class="box-header" data-original-title>
            <h2>Upload Images of Item <?= $update_id ?></h2>
        </div>


<!--        //form for uploading file-->
        <div class="box-content">
            <?php
                if(isset($error)) {
                    foreach($error as $key=> $value) {
                        echo "<h2 style='color: red;'>".$value."</h2>";
                    }
                } ?>

            <?php echo form_open_multipart('store_items/do_upload/'.$update_id);?>
            <input type="file" name="userfile" size="20" />
            <br /><br />
            <div class="form-actions">
                <button type="submit" class="btn btn-primary" name="submit" value="Submit">Upload</button>
                <button type="submit" class="btn" name="submit" value="Cancel">Cancel</button>
            </div>
<!--            <input type="submit" class="btn btn-primary" value="upload" />-->

            </form>
        </div>
    </div><!--/span-->

</div>