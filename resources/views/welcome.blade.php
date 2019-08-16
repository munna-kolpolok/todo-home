<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">

        <title>To Do List</title>

        <!-- Bootstrap 3.3.4 -->
        <link href="{{ asset('la-assets/css/bootstrap.css') }}" rel="stylesheet" type="text/css" />
        
        <link href="{{ asset('la-assets/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />

        <link href="{{ asset('la-assets/css/AdminLTE.css') }}" rel="stylesheet" type="text/css" />


        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <style>
          #sortable { list-style-type: none; margin: 0; padding: 0; width: 60%; }
          #sortable li { margin: 0 3px 3px 3px; padding: 0.4em; padding-left: 1.5em; font-size: 1.4em;  }

          #sortable-in-work { list-style-type: none; margin: 0; padding: 0; width: 60%; }
          #sortable-in-work li { margin: 0 3px 3px 3px; padding: 0.4em; padding-left: 1.5em; font-size: 1.4em;  }

          #sortable-done { list-style-type: none; margin: 0; padding: 0; width: 60%; }
          #sortable-done li { margin: 0 3px 3px 3px; padding: 0.4em; padding-left: 1.5em; font-size: 1.4em;  }
          </style>
          <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
          <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
          <script>
          $( function() {
            
            $( "#1" ).sortable({
                axis: 'y',
                update: function (event, ui) {
                    var order = [];
                    $('.draggable-item').each(function (index, element) {
                        order.push({
                            id: $(this).attr('data-id'),
                            position: index + 1
                        });
                    });
                    // POST to server using $.post or $.ajax
                    $.ajax({
                        data: {
                            order: order,
                            _token: '{{csrf_token()}}'
                        },
                        type: 'POST',
                        url: 'todo-order'
                    });
                }
            });
            $( "#sortable" ).disableSelection();


            $( "#2" ).sortable({
                axis: 'y',
                update: function (event, ui) {

                    var order = [];
                    $('.draggable-item').each(function (index, element) {
                        order.push({
                            id: $(this).attr('data-id'),
                            position: index + 1
                        });
                    });
                    // POST to server using $.post or $.ajax
                    $.ajax({
                        data: {
                            order: order,
                            _token: '{{csrf_token()}}'
                        },
                        type: 'POST',
                        url: 'todo-order'
                    });
                }
            });

            $( "#3" ).sortable({
                axis: 'y',
                update: function (event, ui) {
                    var order = [];
                    $('.draggable-item').each(function (index, element) {
                        order.push({
                            id: $(this).attr('data-id'),
                            position: index + 1
                        });
                    });
                    // POST to server using $.post or $.ajax
                    $.ajax({
                        data: {
                            order: order,
                            _token: '{{csrf_token()}}'
                        },
                        type: 'POST',
                        url: 'todo-order'
                    });
                }
            });
            

          } );


          </script>
        
    </head>
    <body>
        
        <div id="wrapper" class="clearfix">
            
              <div class="row">
                <div class="col-md-4">
                  <ul class="connected-sortable droppable-area1"  id="1">
                    @foreach($works as $work)
                        @if($work->status==1)
                        <li class="draggable-item"  data-id="{{ $work->id }}">{{ $work->description or null }}</li>
                        @endif
                    @endforeach
                  </ul>
                </div>
                
                <div class="col-md-4">
                  <ul class="connected-sortable droppable-area2" id="2">
                    @foreach($works as $work)
                        @if($work->status==2)
                        <li class="draggable-item"  data-id="{{ $work->id }}">{{ $work->description or null }}</li>
                        @endif
                    @endforeach
                  </ul>
                </div>

                <div class="col-md-4">
                  <ul class="connected-sortable droppable-area3" id="3">
                    @foreach($works as $work)
                        @if($work->status==3)
                        <li class="draggable-item"  data-id="{{ $work->id }}">{{ $work->description or null }}</li>
                        @endif
                    @endforeach
                  </ul>
                </div>

              </div>
        </div>
        
        

        <!-- modal start -->
        <div class="modal fade" id="AddModal" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Add Todo</h4>
                </div>
                <form method="post" action="{{ url('/to-do-store') }}" id="todo-add-form">
                    {{ csrf_field() }}
                <div class="modal-body">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="item_id">Work Description <span class='la-required'>* </span>:</label>
                            <textarea class="form-control" 
                            name="description" required="1" data-placeholder="Enter Description"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success btn-save">Save</button>

                </div>
                </form>
            </div>
        </div>
        <!-- modal end -->
        
    </div>

    </body>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="{{ asset('la-assets/js/bootstrap.min.js') }}" type="text/javascript"></script>

    <script src='https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js'></script>

    <script type="text/javascript">
        $( init );

        function init() {
          $( ".droppable-area1, .droppable-area2,.droppable-area3" ).sortable({
              connectWith: ".connected-sortable",
              //stack: '.connected-sortable ul',
              receive: function(event, ui) {
                var work_id=ui.item.attr('data-id');
                var status=this.id;
                
                var order = [];
                $('.draggable-item').each(function (index, element) {
                    order.push({
                        id: $(this).attr('data-id'),
                        position: index + 1

                    });
                });
                // POST to server using $.post or $.ajax
                $.ajax({
                    data: {
                        order: order,
                        work_id: work_id,
                        status:status,
                        _token: '{{csrf_token()}}'
                    },
                    type: 'POST',
                    url: 'todo-order'
                });

              }
            }).disableSelection();
        }
    </script>

</html>
