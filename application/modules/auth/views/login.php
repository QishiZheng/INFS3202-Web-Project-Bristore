<div class="container col-6 text-center">
    <h1><?php echo lang('login_heading');?></h1>
    <p><?php echo lang('login_subheading');?></p>

    <div class="text-danger" id="infoMessage"><?php echo $message;?></div>

    <?php echo form_open("auth/login");?>

    <p class="text-secondary">
        <?php echo lang('login_identity_label', 'identity');?>
        <?php echo form_input($identity);?>
    </p>

    <p class="text-secondary">
        <?php echo lang('login_password_label', 'password');?>
        <?php echo form_input($password);?>
    </p>

    <p>
        <?php echo lang('login_remember_label', 'remember');?>
        <?php echo form_checkbox('remember', '1', FALSE, 'id="remember"');?>
    </p>

    <a class="btn btn-primary btn-md">
        <?php echo form_submit('submit', lang('login_submit_btn'));?>
    </a>
    <?php echo form_close();?>
    <a class='btn btn-info btn-lg' href='<?= base_url()."auth/register" ?>'>
        Register
    </a>

    <p><a href="forgot_password" class="text-info"><?php echo lang('login_forgot_password');?></a></p>
</div>
