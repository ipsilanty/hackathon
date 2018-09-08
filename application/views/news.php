<section class="content-item">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 text-left breadcrumb-c white">
                <a href="home">Home</a> > <span>News</span>
            </div>
        </div>
        <div class="row">
            <div class="col-12 text-center">
                <h1 class="page-title">
                    News
                </h1>
                <div class="col-lg-5 mx-auto">
                    <img src="<?php echo $news["image"]; ?>" class="img-fluid" alt="<?php echo $news["title"]; ?>">
                </div>
            </div>
            <div class="col-12 text-center">
                <a href="<?php echo $news["link"]; ?>" target="_blank" class="news-title"><?php echo $news["title"]; ?></a>
            </div>
            <div class="col-12 text-center white news-body">
                <p><?php echo $news["description"]; ?></p>
            </div>
        </div>
    </div>
</section>