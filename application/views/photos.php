<section class="content-item">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 text-left breadcrumb-c white">
                <a href="home">Home</a> > <span>Photos</span>
            </div>
        </div>
        <div class="row">
            <div class="col-12 text-center">
                <h1 class="page-title" style="position: relative;">
                    Photos
                </h1>
            </div>
            <div class="col-sm-12 col-xl-10 mx-auto home-cards">
                <div class="row">
                    <div class="col-sm-4 text-center">
                        <form action="" id="upload" enctype="multipart/form-data" method="post">
                            <div class="photo-box">
                                <div class="file">
                                    <div class="drop photos">
                                        <span>
                                            <img src="assets/images/Plus_button.png" class="img-fluid" alt="Add new photo" id="plus">
                                            <input type="file" name="photo" id="photo" accept="image/gif,image/jpeg,image/png">
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <?php if($photos) { ?>
                        <?php foreach($photos as $row) { ?>
                        <div class="col-sm-4 text-center">
                            <div class="photo-box">
                                <div class="file">
                                    <div class="drop photos">
                                        <div class="delete-photo">
                                            <i class="fas fa-trash delete_photo" data-photo="<?php echo $row->photo; ?>" data-id="<?php echo $row->id; ?>"></i>
                                        </div>
                                        <span>
                                            <img src="assets/uploads/thumbs/thumb_<?php echo $row->photo; ?>" class="img-fluid" alt="Photo" id="plus">
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript">
    $(document).on('change',"#photo", function() {
        $( "#upload" ).submit();
    });
    //Upload new photo
    $('#upload').submit(function(e){
        e.preventDefault();
        $.ajax({
            url:'Photos/photo_upload',
            type:"post",
            data:new FormData(this),
            processData:false,
            contentType:false,
            dataType: 'json',
            cache:false,
            async:false,
            success: function(data){
                if(data.status == "success") {
                    $(":animated").promise().done(function() {
                        location.href = location.pathname;
                    });
                } else {
                    alert(data.msg);
                }
            }
        });
    });

    /* Delete image */
    $(document).on('click',"i.delete_photo", function() {
        var photoId = $(this).attr("data-id");
        var photo = $(this).attr("data-photo");

        var data = [];
        data.push({name: 'photoId', value: photoId});
        data.push({name: 'photo', value: photo});
        $.ajax({
            type: "POST",
            url: "Photos/delete_photo",
            dataType: 'json',
            data: data,
            success: function(result) {
                if (result) {
                    if(result.status == "success") {
                        $(":animated").promise().done(function() {
                            location.href = location.pathname;
                        });
                    } else {
                        alert("Something went wrong! Please try again");
                    }
                }
            }
        });
        return false; // Will stop the submission of the form
    });
</script>