<h2><?= $title ?></h2>

<main role="main">
    <link href="assets/css/itemsIndex.css" rel="stylesheet">

    <div class="album py-5 bg-light">
        <div class="container">

            <div class="row">
                <?php foreach($items as $item) : ?>
                <div class="col-md-4">
                    <div class="card mb-4 box-shadow">
                        <img class="card-img-top" data-src="holder.js/100px225?theme=thumb&bg=55595c&fg=eceeef&text=Thumbnail" alt="Card image cap">
                        <div class="card-body">
                            <h3><?php echo $item['title']; ?></h3>
                            <p class="card-text"><?php echo $item['description']; ?></p>
                            <h4 class="text-primary">Price: $<?php echo $item['price']; ?></h4>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-outline-secondary">
                                        <a href="<?php echo site_url('/items/'.$item['id']);?>">View</a>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-secondary">Edit</button>
                                </div>
                                <small class="text-muted" id="create-date">Posted on: <?php echo $item['created_at']; ?></small>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

</main>