<section class="content-item">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 text-left breadcrumb-c white">
                <a href="home">Home</a> > <span>Sports</span>
            </div>
        </div>
        <div class="row">
            <div class="col-12 text-left">
                <h1 class="page-title" style="position: relative;">
                    Sports
                </h1>
            </div>
            <div class="col-sm-12 col-md-10 mx-auto text-center home-cards">
                <form>
                    <div class="form-group row">
                        <div class="col-md-4 mx-auto">
                            <input type="text" class="form-control" id="team-name" placeholder="Input team name" style="font-size: 1.5rem;">
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-sm-12 col-md-10 mx-auto white" id="beaten-list">

            </div>
        </div>
    </div>
</section>
<script type="text/javascript">
    $("#team-name").on('keyup', function(event) {
        if ((event.keyCode >= 48 && event.keyCode <= 57) || (event.keyCode >= 65 && event.keyCode <= 90) || event.keyCode == 8) {
            var team = $(this).val();
            var data = [];
            data.push({name: 'team', value: team});

            $.ajax({
                type: "POST",
                url: "Sports/get_teams",
                dataType: 'json',
                data: data,
                success: function(result) {
                    if (result) {
                        if(result.length > 0) {
                            var items = [];
                            $.each( result, function( key, val ) {
                                items.push( "<li>" + val.Team + "</li>" );
                            });

                            $( "<ol/>", {
                                "class": "my-new-list",
                                html: items.join( "" )
                            }).appendTo( "#beaten-list" );
                        } else {
                            $( "#beaten-list").html("");
                        }
                    }
                }
            });
        }
    });
</script>