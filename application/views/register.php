<section class="content-item">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 text-center white">
                <h1>Hackathon</h1>
            </div>
            <div class="col-md-8 mx-auto">
                <div class="form-wrapper">
                    <?php if($this->session->flashdata('error')) { ?>
                        <div class="alert alert-danger" role="alert">
                            <strong><i class="fas fa-exclamation-circle" aria-hidden="true"></i> Error:</strong> <?php echo $this->session->flashdata('error'); ?>
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        </div>
                    <?php } ?>
                    <?php echo form_open('register/add_user','id="register_form" class="js-parsley" data-parsley-submit="register_submit" enctype="multipart/form-data"'); ?>
                    <div class="form-group row">
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="username" name="username" data-parsley-trigger="change keyup" data-parsley-minlength="3" data-parsley-remote data-parsley-remote-validator="parsley_is_db_cell_available" data-parsley-remote-message="That username is taken." required placeholder="Username">
                        </div>
                        <div class="col-sm-6">
                            <input type="email" class="form-control" id="email" name="email" data-parsley-type="email" data-parsley-trigger="change keyup" data-parsley-remote data-parsley-remote-validator="parsley_is_db_cell_available" data-parsley-remote-message="That email is taken." required placeholder="Email">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6">
                            <input type="password" class="form-control" id="password" name="password" data-parsley-pattern="^(?=.{9,})(?=.*[a-z])(?=.*[A-Z])(?=.*[\.\@\#\$\%\^\|\?\*\!\:\-\;\&\+\=\{\}\[\]]).*$" data-parsley-trigger="change keyup" data-parsley-pattern-message="Your password must contain at least (1) lowercase, (1) uppercase, (1) number and (1) special character." required placeholder="Password">
                        </div>
                        <div class="col-sm-6">
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm password" data-parsley-equalto="#password" required >
                        </div>
                    </div>
                    <div class="file">
                        <div class="drop col-sm-6 col-xl-3 mx-auto">
                            <div class="previews"></div>
                            <span>
                                <label>Add picture</label>
                                <input type="file" name="photo" id="photo" accept="image/gif,image/jpeg,image/png">
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-12 text-center btn-container">
                        <button type="submit" class="btn btn-yellow px-4" name="register_submit" id="register_submit">Register</button>
                    </div>
                    <?php form_close(); ?>
                </div>
            </div>
        </div>
        <div class="sign-up-row">
           <a href="login">Sign in</a> to your account
        </div>
    </div>
</section>