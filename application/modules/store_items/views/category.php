<h2><?= $category_name ?></h2>
<div class="album py-5 bg-light">
    <div class="container">
        <div class="row" id="item_card">

        </div>
    </div>
</div>

<script>
    //populate the page with item card data from server
    $(document).ready(function() {
        $.ajax({
            type: "POST",
            url: <?= json_encode(base_url().'store_items/category_items/'.$category_id)?>,
            dataType: "JSON",

            success: function(data) {
                $('#item_card').html(data);
                //console.log(data);
            },
            error: function(error) {
                console.log(error);
            }
        });

    });

</script>