<section class="content-item">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 text-right">
                <a href="logout" class="sign-out"><i class="fas fa-sign-out-alt"></i> Sign out</a>
            </div>
            <div class="col-12 text-center white">
                <?php $profile = (empty($this->session->userdata['photo'])) ? "assets/images/profile_pic.png" : "assets/uploads/thumbs/thumb_".$this->session->userdata['photo']; ?>
                <img src="<?php echo $profile; ?>" class="profile_photo" width="100" alt="Profile picture"/>
                <h1>Good day <?php echo (isset($this->session->userdata['username'])) ? $this->session->userdata['username'] : "" ?></h1>
            </div>
            <div class="col-sm-12 col-xl-10 mx-auto home-cards">
                <div class="row">
                    <div class="col-sm-4 text-center">
                        <div class="widget-box">
                            <div class="card custom-card">
                                <div class="card-header">
                                    Weather
                                </div>
                                <div class="card-body">
                                    <div class="mini-box text-left">
                                        <img src="assets/images/<?php echo $weather->weather[0]->main; ?>.png" id="weather_icon" height="80"/>
                                        <span class="temp"><span id="temp"><?php echo round($weather->main->temp); ?>&#8451; degrees</span></span>
                                    </div>
                                    <div class="main-city">
                                        <?php echo $weather->name; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 text-center">
                        <div class="widget-box">
                            <div class="card custom-card">
                                <div class="card-header">
                                    <a href="news">News</a>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $news["title"]; ?></h5>
                                    <p class="card-text"><?php echo $news["description"]; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 text-center">
                        <div class="widget-box">
                            <div class="card custom-card">
                                <div class="card-header">
                                    <a href="sports">Sports</a>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $team->team; ?></h5>
                                    <p class="card-text">The team with the most home wins. They have <?php echo $team->cnt; ?> wins</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row second-row">
                    <div class="col-sm-4 text-center">
                        <div class="widget-box">
                            <div class="card custom-card">
                                <div class="card-header">
                                    <a href="photos">Photos</a>
                                </div>
                                <div class="card-body">
                                    <div class="row photos-c">
                                        <?php if($photos) { ?>
                                            <?php foreach($photos as $row) { ?>
                                                <div class="col-6">
                                                    <img src="assets/uploads/thumbs/thumb_<?php echo $row->photo; ?>" class="img-fluid th" alt="Photo"/>
                                                </div>
                                            <?php } ?>
                                        <?php } else { ?>
                                            <div class="col-12">No photos uploaded!</div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 text-center">
                        <div class="widget-box">
                            <div class="card custom-card">
                                <div class="card-header">
                                    <a href="tasks">Tasks</a>
                                </div>
                                <div class="card-body">
                                    <?php if($tasks) { ?>
                                        <form>
                                            <?php foreach($tasks as $row) { ?>
                                                <div class="form-group row" style="margin-bottom: 0;">
                                                    <div class="col-lg-10 col-md-9 col-10">
                                                        <input type="text" data-task="<?php echo $row->id; ?>" class="form-control task-line" data-parsley-trigger="change keyup" required placeholder="Task Name/Description" value="<?php echo $row->task; ?>">
                                                    </div>
                                                    <div class="col-lg-2 col-md-3 col-2 text-left">
                                                        <?php $button = ($row->checked == 0) ? "btn_u" : "btn_c";  ?>
                                                        <img src="assets/images/<?php echo $button; ?>.png" alt="Button" data-task="<?php echo $row->id; ?>" class="<?php echo $button; ?>" />
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </form>
                                    <?php } else { ?>
                                        <div class="col-12">No tasks assigned!</div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 text-center">
                        <div class="widget-box">
                            <div class="card custom-card">
                                <div class="card-header">
                                    Clothes
                                </div>
                                <div class="card-body">
                                    <div class="col-12">
                                        <span class="pie-colours-1" style="display: none;"><?php echo $values["jumper"]; ?>,<?php echo $values["hoodie"]; ?>,<?php echo $values["jacket"]; ?>,<?php echo $values["sweater"]; ?>,<?php echo $values["blazer"]; ?>,<?php echo $values["raincoat"]; ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                $( document ).ready(function() {
                    $(".pie-colours-1").peity("pie", {
                        fill: ["cyan", "magenta", "yellow", "black", "OrangeRed ", "LimeGreen "]
                    });

                    getLocation();
                });

                function getLocation() {
                    if (navigator.geolocation) {
                        navigator.geolocation.getCurrentPosition(showPosition);
                    } else {
                        alert("Geolocation is not supported by this browser.");
                    }
                }

                function showPosition(position) {
                    var lat = position.coords.latitude;
                    var long = position.coords.longitude;

                    var data = [];
                    data.push({name: 'lat', value: lat});
                    data.push({name: 'long', value: long});

                    $.ajax({
                        type: "POST",
                        url: "Home/get_location",
                        dataType: 'json',
                        data: data,
                        success: function(result) {
                            if(result) {
                                $("#weather_icon").attr("src", "assets/images/"+result.weather[0].main+".png");
                                $("#temp").html(Math.round(result.main.temp) + "&#8451; degrees");
                                $(".main-city").html(result.name);
                            }

                        }
                    });
                }
            </script>
        </div>
    </div>
</section>
<script type="text/javascript">
    /* Switch task status */
    $(document).on('click',".btn_u", function() {
        var task = $(this).attr("data-task");

        var data = [];
        data.push({name: 'taskId', value: task});
        data.push({name: 'status', value: 1});

        $(this).attr("src", "assets/images/btn_c.png");
        $(this).removeClass("btn_u").addClass("btn_c");
        $.ajax({
            type: "POST",
            url: "Tasks/update_task_status",
            dataType: 'json',
            data: data,
            success: function(result) {
                if (result) {
                    //do something
                }
            }
        });
    });

    $(document).on('click',".btn_c", function() {
        var task = $(this).attr("data-task");

        var data = [];
        data.push({name: 'taskId', value: task});
        data.push({name: 'status', value: 0});

        $(this).attr("src", "assets/images/btn_u.png");
        $(this).removeClass("btn_c").addClass("btn_u");
        $.ajax({
            type: "POST",
            url: "Tasks/update_task_status",
            dataType: 'json',
            data: data,
            success: function(result) {
                if (result) {
                    //do something
                }
            }
        });
    });


    /* Update task description */
    $(".task-line").on('keyup', function(e) {
        var task = $(this).attr("data-task");
        var text = $(this).val();

        var data = [];
        data.push({name: 'taskId', value: task});
        data.push({name: 'task', value: text});

        $.ajax({
            type: "POST",
            url: "Tasks/update_task",
            dataType: 'json',
            data: data,
            success: function(result) {
                if (result) {
                    //do something
                }
            }
        });
    });

    $.getJSON( "assets/js/package.json", function( data ) {

        var items = [];
        var jumper;
        $.each( data.payload, function( key, val ) {

           if(val.clothe == "jumper") {
                jumper = val.clothe.length;
               console.log(jumper);
           }


        });
    });
</script>