<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Planner Users</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
                <div class="row">
                    <div class="col-sm-12">
                        <div id="registerUserButton" class="btn btn-success btn-icon-split float-right" style="margin-bottom:10px; cursor:pointer;">
                    <span class="icon text-white-50" style="display: flex;align-items: center;justify-content: center;">
                      <i class="far fa-plus-square"></i>
                    </span>
                            <span class="text">Add User</span>
                        </div>
                        
                        <table class="table table-bordered dataTable" id="dataTable" width="100%" cellspacing="0"
                               role="grid" aria-describedby="dataTable_info" style="width: 100%; margin-top: 10px">
                            <thead>
                            <tr role="row">
                                <th class="sorting_asc" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1"
                                    aria-sort="ascending" aria-label="Name: activate to sort column descending"
                                    style="width: 57px;">Name
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1"
                                    aria-label="Position: activate to sort column ascending" style="width: 62px;">
                                    Email
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1"
                                    aria-label="Office: activate to sort column ascending" style="width: 50px;">Role
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1"
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                                foreach ($conn->query("select name, email, role_name from users INNER JOIN user_roles where users.role=user_roles.role_id") as $row){
                            ?>
                            <tr role="row" class="odd">
                                <td class="sorting_1"><?php echo $row['name']; ?></td>
                                <td><?php echo $row['email']; ?></td>
                                <td><?php echo $row['role_name']; ?></td>
                                <td align="center">
                                    <div href="#" class="btn btn-danger btn-circle btn-sm deleteUserButton" onclick="deleteUserFunction('<?php echo $row['email'];?>');" style="cursor:pointer;">
                                        <i class="fas fa-trash"></i>
                                    </div>
                                </td>
                            </tr>
                            <?php
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="registerUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Register User</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body" style="display: flex; justify-content: center;">
                <form class="user" id="registerUserForm" action="?" method="post" style="width: 60%;margin-bottom:0px">
                    <div class="form-group">
                        <input type="text" name="name" class="form-control form-control-user <?php if(isset($wrongCredentials)){echo 'is-invalid';}?>" id="exampleInputEmail" aria-describedby="emailHelp" value="<?php if(isset($email)){echo $email;}?>" placeholder="Name">
                    </div>
                    <div class="form-group">
                        <input type="email" name="email" class="form-control form-control-user <?php if(isset($wrongCredentials)){echo 'is-invalid';}?>" id="exampleInputEmail" aria-describedby="emailHelp" value="<?php if(isset($email)){echo $email;}?>" placeholder="Email">
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" class="form-control form-control-user <?php if(isset($wrongCredentials)){echo 'is-invalid';}?>" id="exampleInputPassword" placeholder="Password" value="<?php if(isset($password)){echo $password;}?>" placeholder="password">
                    </div>
                    <input type="hidden" name="register_user">
                    <div class="form-group" style="display: flex; justify-content: center">
                       <select class="form-control form-control-user" name="role" style="width:30%">
                           <option value="1">Admin</option>
                       </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" id="registerUserSubmitButton">Register</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete User</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body" style="display: flex; justify-content: center;">
                You are deleting a user! Are you sure? 
            </div>
            <div class="modal-footer">
                <form id="deleteUserForm" action="?" method="post">
                <button type="submit" class="btn btn-danger">Delete</button>
                    <input type="hidden" id="mailToDelete" value="" name="delete_user">
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $("#registerUserButton").on('click',function(){
        $('#registerUserForm').trigger("reset");
        $("#registerUserModal").modal('show');
    });
    
    
    function deleteUserFunction(mail){
        $('#deleteUserForm').trigger("reset");
        $('#mailToDelete').val(mail);
        $("#deleteUserModal").modal('show');
        
    }
   
    
    $("#registerUserSubmitButton").on('click',function(){
        $("#registerUserForm").submit();
    });
    
</script>