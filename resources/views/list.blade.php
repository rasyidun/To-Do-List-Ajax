<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title> Ajax To-Do List Project</title>
    <!-- BootstapCDN | CSS | Bootstap-->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
     <!-- BootstapCDN | CSS | Font-Awesome-->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <!-- Jqueryui | CSS |-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" />
</head>
<body>
  {{csrf_field()}}
    <br>
    
    <br>
    <div class="container">

        <div class="row">
          <!-- Search Box -->
    <div class="col-lg-2 col-lg-offset-3 pull-right ">
      <input type="text" class="form-control" name="searchItem" id="searchItem" placeholder="Search">
    </div>
            <div class="col-lg-offset-3 col-lg-6">

                <div class="panel panel-default">

                  <div class="panel-heading">
                    <h3 class="panel-title">Ajax To-Do List<a href="#" class="pull-right" id="addNew" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus" aria-hidden="true"></i></a></h3>
                  </div>
                  <div class="panel-body" id="items">
                    <ul class="list-group">
                      @foreach ($items as $item)
                      <li class="list-group-item ourItem" data-toggle="modal" data-target="#myModal">{{$item->item}}<input type="hidden" id="itemId" value="{{$item->id}}"><br /></li>
                      
                      @endforeach
                    </ul>
                  </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bootsrap | Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="modal-title">Add New Item</h4>
          </div>
          <div class="modal-body">
            <input type="hidden" id="id">
            <p><input class="form-control" type="text" placeholder="Write Item Here" id="addItem"></p>
          </div>
          <div class="modal-footer">

            <button type="button" class="btn btn-warning" id="delete" data-dismiss="modal" style="display: none">Delete</button>
            <button type="button" class="btn btn-primary" id="saveChanges" style="display: none" data-dismiss="modal">Save changes</button>
            <button type="button" class="btn btn-primary" id="AddButton" data-dismiss="modal">Add Item</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    
    <!-- BootstapCDN | JQ-->
    <script
      src="http://code.jquery.com/jquery-3.2.1.min.js"
      integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
      crossorigin="anonymous">
    </script>

    <!-- BootstapCDN | js-->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <!-- Jqueryui | js-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script>
      $(document).ready(function() {
        $(document).on('click', '.ourItem', function(event) {
              var text = $(this).text();
              var id = $(this).find('#itemId').val();
              $('#title').text('Edit Item');
              var text = $.trim(text);
              $('#addItem').val(text);
              $('#delete').show('400');
              $('#saveChanges').show('400');
              $('#AddButton').hide('400');
              $('#id').val(id);
              console.log(text);
          });

          $(document).on('click', '#addNew', function(event) {
              $('#title').text('Add New Item');
              $('#addItem').val("");
              $('#delete').hide('400');
              $('#saveChanges').hide('400');
              $('#AddButton').show('400');
              
          });

          $('#AddButton').click(function(event) {
              var text = $('#addItem').val();
              if (text =="") {
                alert('please type anything for item');
              }else {
                $.post('list', {'text': text,'_token':$('input[name=_token]').val()}, function(data) {
              console.log(data);
                $('#items').load(location.href + ' #items');
                });
              }    
          });

          $('#delete').click(function(event) {
              var id = $("#id").val();
              $.post('delete', {'id': id,'_token':$('input[name=_token]').val()}, function(data) {
              $('#items').load(location.href + ' #items');  
                console.log(data);
              });   
          });

          $('#saveChanges').click(function(event) {
              var id = $("#id").val();
              var value = $("#addItem").val();
              $.post('update', {'id': id,'value':value, '_token':$('input[name=_token]').val()}, function(data) {
                $('#items').load(location.href + ' #items');  
                console.log(data);
              });   
          });

          $( function() {
              var availableTags = [
               
                //"C",
               // "C++",
              //  "Clojure",
               // "COBOL",
               // "ColdFusion",
              //  "Erlang",
               
              ];
              $( "#searchItem" ).autocomplete({
                source: '{{ asset('search') }}'
              });
            } );
      });
    </script>
</body>
</html>