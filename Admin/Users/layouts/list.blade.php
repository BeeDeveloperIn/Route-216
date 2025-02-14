@extends($themeLayoutPath)
@section('menu_title')
    Users
@endsection
@section('content')
    <div class="container">
        <div class="card card-custom gutter-b">

              <!--begin:: Card Header -->
              <div class="card-header flex-wrap">
                <div class="card-title">
                    <h3 class="card-label">
                        {{ __('user.title_users_list',['user_type' => $user_type]) }}
                        {{-- <span class="d-block text-muted pt-2 font-size-sm">User management made easy</span> --}}
                    </h3>
                </div>
                <div class="card-toolbar">
                    <a href="{{ route('admin.adduser', ['user_type'=>$user_type]) }}" class="btn btn-primary font-weight-bolder">
                        <i class="fa fa-list"></i> {{ __('user.title_add_user',['user_type' => $user_type]) }}
                    </a>
                </div>
            </div>
            <!--End:: Card Header -->

            <div class="card-body">
                <form action="" method="GET">
                    <div class="row">
                        <div class="col-md-5">
                            <label for="">Search by keywords</label>
                            <input type="text" value="<?php echo @$_GET['search']; ?>" class="form-control"
                                   name="search" placeholder="Search by name | email | mobile"/>
                        </div>
                        <div class="col-md-2">
                            <label for="">Status</label>
                            <select class="form-control" name="status">
                                <option value="">-- Select --</option>
                                <option value="1" <?php echo @$_GET['status'] == '1' ? 'selected' : ''; ?>>Active
                                </option>
                                <option value="0" <?php echo @$_GET['status'] == '0' ? 'selected' : ''; ?>>Inactive
                                </option>
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label for="">Role</label>
                            <select class="form-control" name="role_id">
                                <option value="">-- Select --</option>
                                @foreach ($roles as $role)
                                    <option
                                        value="{{ $role['role_id'] }}" <?php echo @$_GET['role_id'] == $role['role_id'] ? 'selected' : ''; ?>>{{ $role['role'] }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label for="" class="" style="visibility: hidden;">Submit</label>
                            <div>
                                <button type="submit" class="btn btn-primary">Search</button>
                                <button onclick="window.location.href='<?php echo route('admin.users',['user_type'=>'user'])?>';" type="button" class="btn btn-secondary">
                                    Reset filters
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-body">
                <div class="row">
                    <?php
                    if ($users->num_rows()) {
                        ?>
                    <div class="col-md-12 form-group">
                        <div class="table-responsive">
                            <table class="table admin-post-listing-table">
                                <caption style="caption-side:top;">
                                        <?php
                                        echo "<p>Showing {$current_page} to " . ($current_page + $users->num_rows() - 1) . " of {$users->total_rows}</p>";
                                        ?>
                                </caption>
                                <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Role</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Mobile</th>
                                    <th>Username</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <?php
                                foreach ($users->result_array() as $index => $user) {
                                    ?>
                                <tr>
                                    <td>
                                        <span class="font-weight-bold text-muted">
                                       <?php echo $current_page++; ?>.
                                        </span>
                                    </td>
                                    <td><?php echo $user['role']; ?></td>
                                    <td><?php echo $user['first_name'] . ' ' . $user['last_name']; ?></td>
                                    <td><?php echo $user['email']; ?></td>
                                    <td><?php echo $user['mobile1']; ?></td>
                                    <td><?php echo $user['username']; ?></td>
                                    <td>
                                        <span
                                            class="label label-lg font-weight-boldlabel-light-success label-inline"><?php echo mk_display_user_status($user['status']); ?></span>
                                    </td>
                                    <td>
                                        <div class="dropdown dropdown-inline">
                                            <a href="<?php echo route('admin.editUser', ['user_type' => $user_type, 'user_id' => $user['id']]) ?>"
                                               class="btn btn-sm btn-clean btn-icon mr-2">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <a onclick="deleteUser(this)"
                                               href="<?php echo route('admin.deleteUser', ['user_type' => $user_type, 'user_id' => $user['id']]); ?>"
                                               class="btn btn-sm btn-clean btn-icon mr-2">
                                                <i class="fa fa-trash"></i>
                                            </a>

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
                    <div class="col-md-12 mk-custom-pagination">
                            <?php echo $pagination_links; ?>
                    </div>
                        <?php
                    } else {
                        ?>
                    <div class="col-md-12">
                        <h4><?php echo __('common.data_list_empty') ?></h4>
                    </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            /*
            deleteUser
            Delete user
            */
            function deleteUser(that) {
                event.preventDefault();
                let confirmDel = confirm("{{ __('common.sure_want_to_delete') }}");
                if (confirmDel) {
                    window.location.href = $(that).attr('href');
                } else {
                    return false;
                }
            }
        </script>
    @endpush
@endsection
