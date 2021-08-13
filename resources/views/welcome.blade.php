<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>TTest Laravel-Elasticsearch</title>
        <meta name="csrf-token" content="{{csrf_token()}}"> 

        <link rel="stylesheet" type="text/css" href="{{ asset('bootstrap-5.0.2-dist/css/bootstrap.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('font-awesome.min.css') }}">     
    </head>
    <body  style=" background-color: purple">
        <div class="container-fluid" style="margin-top: 50px;">
            
                
            <div class="row" >
                <div class="col-lg-3" style="background-color: silver; border-radius: 10px; height: 550px; margin: 0px 5px 0px 5px;">
                    <div class="row" style="margin: 10px 5px 30px 5px;">
                        <div class="col-lg-12">
                            <h3 style="text-align: center;  color: purple; font-weight: bold;"> Ajouter un article</h3>
                        </div>
                        <div class="col-lg-12" id="result_add">
                            
                        </div>
                    </div>
                    <hr style="color: purple;">
                    <div class="row" style="text-align: center;">
                        <img src="{{ asset('image/circle_loading.gif') }}" height="150" id="circle_loading" hidden="true"> 
                        <form method="POST" enctype="multipart/form-data" id="form" action="javascript:void(0)" >
                            @csrf
                            <div class="form-group">
                                <div class="row">
                                    <div class="form-group has-success col-md-6" style="margin-bottom: 10px;">
                                        <label class="control-label">Title <span style="color: red;">*</span></label>
                                        <input type="text" name="title" id="title" class="form-control" placeholder="Title" />
                                    </div>    
                                    <div class="form-group has-success col-md-6" style="margin-bottom: 10px;">
                                        <label class="control-label">Montant <span style="color: red;">*</span></label>
                                        <input type="number" name="montant" id="montant" class="form-control" placeholder="3000" />
                                    </div>
                                    <div class="form-group has-success col-md-12" style="margin-bottom: 10px;">
                                        <label class="control-label">Détails <span style="color: red;">*</span></label>
                                        <textarea class="form-control" id="details" name="details" placeholder="Détails">
                                        </textarea>
                                    </div>
                                    <div class="row" >
                                        <div class="form-group has-success col-md-12" style="margin-bottom: 10px; margin-right: 15px; margin-left: 15px; ">
                                            <label class="control-label">Photo <span style="color: red;">*</span></label>
                                            <div class="row" >
                                                <div class="col-md-12" style="height: 100px; background-color: white; border-radius: 5px; margin-bottom: 5px; " >
                                                   <img src="" id="image" width="80" height="100" style="margin-left: 30px;margin-right: 30px;">
                                               </div>
                                               <div class="col-md-12" >
                                                    <input class="form-control form-control-lg" id="formFileLg" type="file" name="photo" accept='image/*' onchange='openFile(event)' />
                                                    
                                               </div> 
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" >
                                        <div class="form-group has-success col-md-12">
                                            <button class="btn btn-success" type="submit" id="add" style="width: 100%; margin-left: 10px;">
                                                <span style="font-size: 1em; font-weight: bold;">Enregistrer</span> 
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>   
                    </div>  
                </div>
                <div class="col-lg-8" style="background-color: silver; border-radius: 10px; height: 550px;">
                    <div class="row" style="margin: 30px 5px 30px 5px;">
                        <div class="col-lg-6">
                            <h3 class="" style="color: purple; font-weight: bold;">Liste des articles publiés (<span id="nombre"> 00</span> )</h3>
                        </div>
                        <div class="col-lg-6">
                            <div class="input-group">
                              <input type="text" class="form-control rounded" placeholder="Prix,nom, date ou détails" aria-label="Rechercher" aria-describedby="search-addon" name="search" id="search"/>
                                <button  class="btn btn-outline-primary">Rechercher</button>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="padding: 10px 10px 10px 10px;overflow: scroll; max-height: 430px;" id="search_list">
                        

                    </div>
                </div>
            </div>    
        </div>

       <script type="text/javascript" src="{{ asset('bootstrap-5.0.2-dist/js/bootstrap.min.js') }}"></script>
       <script type="text/javascript" src="{{ asset('bootstrap/jquery.min.js') }}"></script>
       <script type="text/javascript">
           $(document).ready(function(){
                $('#add').on('click',function(){
                    $("#form").hide();
                    $("#circle_loading").show();
                });
           });
       </script>
       <script type="text/javascript">
           $(document).ready(function(){
                
                $.ajaxSetup({
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $('#form').submit(function(e) {
                    
                    e.preventDefault();
                    var formData = new FormData(this);
                    $.ajax({
                        url:"add",
                        type:"POST",
                        data: formData,
                        cache:false,
                        contentType: false,
                        processData: false,
                        success: (data) => {
                            this.reset();
                            $('#result_add').html(data);
                            $("#circle_loading").hide();
                            $("#form").show();
                            
                        },
                        error: function(data){
                            console.log(data);
                            $("#circle_loading").hide();
                            $("#form").show();
                            
                        }
                    });
                });
           });
       </script>

       <script type="text/javascript">
           
            var openFile = function(event) {
                var input = event.target;

                var reader = new FileReader();
                reader.onload = function(){
                  var dataURL = reader.result;
                  var output = document.getElementById('image');
                  output.src = dataURL;
                };
                reader.readAsDataURL(input.files[0]);
              };
       </script>

       <script type="text/javascript">
           $(document).ready(function(){
                $('#search').on('keyup',function(){
                    var query = $(this).val();
                    $.ajax({
                        url:"search",
                        type:"GET",
                        data:{'search':query},
                        success:function(data){
                            $('#search_list').html(data["output"]);
                            $('#nombre').text(data["number"]);
                        }
                    });
                });
           });
       </script>
    </body>
</html>
