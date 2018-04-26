<h1><?= $headline ?></h1>
<hr />

<?= validation_errors("<h2 style='color: red;'>", "</h2>")?>

<?php if(isset($flash)) {
    echo $flash;
} ?>

<div class="row-fluid sortable">
    <div class="box span12">
        <div class="box-header" data-original-title>
            <h2>Upload Success</h2>
        </div>
        <div class="box-content">
            <div class="alert alert-success">Your file was successfully uploaded!</div>

            <ul>
                <?php foreach ($upload_data as $item => $value):?>
                    <li><?php echo $item;?>: <?php echo $value;?></li>
                <?php endforeach; ?>
            </ul>

            <a href="<?php echo base_url().'store_items/create/'.$update_id; ?>">
                <button type="button" class="btn btn-primary">Return to Update page</button>
            </a>
        </div>
    </div>
</div>
