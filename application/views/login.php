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
                    <?php echo form_open('login/validate','id="login_form" class="js-parsley" data-parsley-submit="login_submit"'); ?>
                    <div class="form-group row">
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="username" name="username" data-parsley-trigger="change keyup" data-parsley-minlength="3" required placeholder="Username">
                        </div>
                        <div class="col-sm-6">
                            <input type="password" class="form-control" id="password" name="password" required placeholder="Password">
                        </div>
                    </div>
                    <div class="col-sm-12 text-center btn-container">
                        <button type="submit" class="btn btn-yellow px-4">Login</button>
                    </div>
                    <?php form_close(); ?>
                </div>
            </div>
        </div>
        <div class="sign-up-row">
            New to the Hackathon? <a href="register">Sign up</a>
        </div>
    </div>
</section>