<div class="album py-5 bg-light">
    <div class="container">
        <div class="row" id="item_card">


            <div class="col-md-4">
                <div class="card mb-4 box-shadow">
                    <img class="card-img-top" data-src="holder.js/100px225?theme=thumb&bg=55595c&fg=eceeef&text=Thumbnail" alt="Card image cap">
                    <div class="card-body">
                        <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-outline-secondary">View</button>
                                <button type="button" class="btn btn-sm btn-outline-secondary">Edit</button>
                            </div>
                            <small class="text-muted">9 mins</small>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>

<script>
    //populate the page with item card data from server
    $(document).ready(function() {
        $.ajax({
            type: "POST",
            url: <?= json_encode(base_url().'store_items/show_all_items')?>,
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
