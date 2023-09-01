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
                                    <h4 class="card-title card-title-dash">Data List Account</h4>
                                  </div>
                                
                                </div>

                                <br>

                                <a class="btn btn-success btn-sm" href="javascript:void(0)" id="createUser"> Create User</a>

                                <br>
                                <br>

                                <div class="table-responsive  mt-1">
                                  <table class="table table-striped table-bordered data-user">
                                    <thead>
                                      <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Password</th>
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
                        <form id="userForm" name="userForm" class="form-horizontal">
                          <input type="hidden" name="user_id" id="user_id">
                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">Name</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value="" maxlength="50" required="" autocomplete="off">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="email" class="col-sm-2 control-label">Email</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="email" name="email" placeholder="Enter Email" value="" maxlength="30" required="" autocomplete="off">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="password" class="col-sm-2 control-label">Password</label>
                                <div class="col-sm-12">
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password" value="" maxlength="30" required="" autocomplete="off">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="role_id" class="col-sm-2 control-label">Role</label>
                                <div class="col-sm-12">
                                    <select class="form-control" id="role_id" name="role_id" value="">
                                      <option value="">Pilih Role</option>
                                      <option value="1">Administrtor</option>
                                      <option value="2">Pegawai</option>
                                    </select>
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
          
        var table = $('.data-user').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('account-ajax-crud.index') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'password', name: 'password'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });

        $('#createUser').click(function () {
        $('#saveBtn').val("create-user");
        $('#user_id').val('');
        $('#userForm').trigger("reset");
        $('#modelHeading').html("Create User");
        $('#ajaxModel').modal('show');
        
        });


        $('body').on('click', '.editUser', function () {
        var user_id = $(this).data('id');
        $.get("{{ route('account-ajax-crud.index') }}" +'/' + user_id +'/edit', function (data) {
            $('#modelHeading').html("Edit User");
            $('#saveBtn').val("edit-user");
            $('#ajaxModel').modal('show');
            $('#user_id').val(data.id);
            $('#name').val(data.name);
            $('#email').val(data.email);
            $('#password').val(data.password);
            $('#role_id').val(data.role_id);
        })
      });

            $('#saveBtn').click(function (e) {
              e.preventDefault();
              $(this).html('Sending..');
            
              $.ajax({
                data: $('#userForm').serialize(),
                url: "{{ route('account-ajax-crud.store') }}",
                type: "POST",
                dataType: 'json',
                success: function (data) {
            
                    $('#userForm').trigger("reset");
                    $('#ajaxModel').modal('hide');
                    table.draw();
                
                },
                error: function (data) {
                    console.log('Error:', data);
                    $('#saveBtn').html('Save User');
                }
            });
          });

            $('body').on('click', '.deleteUser', function () {
            
            var user_id = $(this).data("id");
            confirm("Are You sure want to delete !");
     
            $.ajax({
                type: "DELETE",
                url: "{{ route('account-ajax-crud.store') }}"+'/'+user_id,
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