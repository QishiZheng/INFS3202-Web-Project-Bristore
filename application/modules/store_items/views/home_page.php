
<?php

$this->load->library('session');
if($this->session->flashdata('item') != "") {
    echo $this->session->flashdata('item');
}

echo "<h1>This is home page</h1>";
