@extends('superadmin.index')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="main-panel">
        <div class="content-wrapper">
                        <div class="row flex-grow">
                          <div class="col-12 grid-margin stretch-card">
                            <div class="card card-rounded">
                              <div class="card-body">
                                <div class="d-sm-flex justify-content-between align-items-start">
                                  <div>
                                    <h4 class="card-title card-title-dash">Data List Document</h4>
                                  </div>
                                
                                </div>

                                <br>

                                <a class="btn btn-success btn-sm" href="javascript:void(0)" id="createDocument"> Create Document</a> <a class="btn btn-warning btn-sm float-end" href="{{ route('dokumen.export') }}">Export Document</a>

                                <br>
                                <br>
                                <div class="table-responsive  mt-1">
                                  <table class="table table-striped table-bordered data-document">
                                    <thead>
                                      <tr>
                                        <th>No</th>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Action</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                  </table>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="ajaxModel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modelHeading"></h4>
                    </div>
                    <div class="modal-body">
                        <form id="documentForm" name="documentForm" class="form-horizontal">
                          <input type="hidden" name="doc_id" id="doc_id">
                            <div class="form-group">
                                <label for="title" class="col-sm-2 control-label">Title</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="title" name="title" placeholder="Enter Title" value="" maxlength="50" required="" autocomplete="off">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="description" class="col-sm-2 control-label">Description</label>
                                <div class="col-sm-12">
                                    <textarea class="form-control" id="description" name="description" placeholder="Enter Description" value="" required=""></textarea>
                                </div>
                            </div>

                
                            <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary btn-sm" id="saveBtn" value="create">Save
                            </button> <button type="reset" class="btn btn-danger btn-sm" value="reset">Cancel
                            </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
        <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js" defer></script>
        <script type="text/javascript">
        $(function () {
          
        $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
        });
          
        var table = $('.data-document').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('dokumen-ajax-crud.index') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'title', name: 'title'},
                {data: 'description', name: 'description'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });

        $('#createDocument').click(function () {
        $('#saveBtn').val("create-document");
        $('#doc_id').val('');
        $('#documentForm').trigger("reset");
        $('#modelHeading').html("Create Document");
        $('#ajaxModel').modal('show');
        
        });


        $('body').on('click', '.editDocument', function () {
        var doc_id = $(this).data('id');
        $.get("{{ route('dokumen-ajax-crud.index') }}" +'/' + doc_id +'/edit', function (data) {
            $('#modelHeading').html("Edit Document");
            $('#saveBtn').val("edit-document");
            $('#ajaxModel').modal('show');
            $('#doc_id').val(data.id);
            $('#title').val(data.title);
            $('#description').val(data.description);
        })
      });

            $('#saveBtn').click(function (e) {
              e.preventDefault();
              $(this).html('Sending..');
            
              $.ajax({
                data: $('#documentForm').serialize(),
                url: "{{ route('dokumen-ajax-crud.store') }}",
                type: "POST",
                dataType: 'json',
                success: function (data) {
            
                    $('#documentForm').trigger("reset");
                    $('#ajaxModel').modal('hide');
                    table.draw();
                
                },
                error: function (data) {
                    console.log('Error:', data);
                    $('#saveBtn').html('Save Document');
                }
            });
          });

            $('body').on('click', '.deleteDocument', function () {
            
            var doc_id = $(this).data("id");
            confirm("Are You sure want to delete !");
     
            $.ajax({
                type: "DELETE",
                url: "{{ route('dokumen-ajax-crud.store') }}"+'/'+doc_id,
                success: function (data) {
                    table.draw();
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
        });

          
        });
      </script>
        @endsection