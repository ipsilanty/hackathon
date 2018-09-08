<section class="content-item">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 text-left breadcrumb-c white">
                <a href="home">Home</a> > <span>Tasks</span>
            </div>
        </div>
        <div class="row">
            <div class="col-12 text-left">
                <h1 class="page-title" style="position: relative;">
                    Tasks
                </h1>
            </div>
            <div class="col-sm-12 col-md-10 mx-auto text-center home-cards">
                <?php if($this->session->flashdata('error')) { ?>
                    <div class="alert alert-danger text-left" role="alert">
                        <strong><i class="fas fa-exclamation-circle" aria-hidden="true"></i> Error:</strong> <?php echo $this->session->flashdata('error'); ?>
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    </div>
                <?php } ?>
                <?php if($this->session->flashdata('success')) { ?>
                    <div class="alert alert-success text-left" role="alert">
                        <strong><i class="fas fa-check-circle"></i> Success:</strong> <?php echo $this->session->flashdata('success'); ?>
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    </div>
                <?php } ?>
                <?php if($tasks) { $taskNo = count($tasks); ?>
                    <form>
                    <?php foreach($tasks as $row) { ?>
                        <div class="form-group row" style="margin-bottom: 0;">
                            <div class="col-10">
                                <input type="text" data-task="<?php echo $row->id; ?>" class="form-control task-line" data-parsley-trigger="change keyup" required placeholder="Task Name/Description" value="<?php echo $row->task; ?>">
                            </div>
                            <div class="col-2 text-left">
                                <?php $button = ($row->checked == 0) ? "btn_u" : "btn_c";  ?>
                                <img src="assets/images/<?php echo $button; ?>.png" alt="Button" data-task="<?php echo $row->id; ?>" class="<?php echo $button; ?>" />
                            </div>
                        </div>
                    <?php } ?>
                    </form>
                <?php } else { $taskNo = 0; ?>
                    <h3 class="white">No tasks assigned yet! Click the button bellow to add new task.</h3>
                <?php } ?>
                <div class="col-12 add-task text-left">
                    <img src="assets/images/Plus_button.png" alt="Add task" height="40" data-toggle="modal" data-target="#addTask"/>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- The Modal -->
<div class="modal" id="addTask">
    <div class="modal-dialog">
        <div class="modal-content">
            <?php echo form_open('Tasks/add_task','id="add-task" class="js-parsley" data-parsley-submit="task-submit"'); ?>
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Add new task</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div class="form-group">
                    <div class="col-12">
                        <input type="text" class="form-control" id="task" name="task" data-parsley-trigger="change keyup" required placeholder="Task Name/Description">
                    </div>
                </div>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer text-center">
                <button type="submit" class="btn btn-yellow">Add Task</button>
            </div>
            <?php form_close(); ?>
        </div>
    </div>
</div>
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
</script>