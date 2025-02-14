@extends($themeLayoutPath)
@section('menu_title')
    Role & Permissions
@endsection
@section('content')
    <div class="container">
        <div class="card card-custom gutter-b">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">All {{ \Illuminate\Support\Str::plural('permission') }}</h3>
                    <div class="card-toolbar text-right">
                        <div class="example-tools justify-content-center">
                            <a href="<?php echo route('admin.addRoleCaps'); ?>" class="btn btn-secondary">Add permission</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body pb-0">
                <div class="row">
                    <div class="col-md-12 form-group">
                        <form method="POST" action="<?php echo route('admin.roleCaps') ?>">
                            <?php echo csrf_field(); ?>
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="">Search by keyword</label>
                                    <input value="<?php echo \Illuminate\Support\Facades\Request::get('s') ?>"
                                           type="search" class="form-control"
                                           name="s" placeholder="Search by keyword...">
                                </div>
                                <div class="col-md-2">
                                    <label>Show entries</label>
                                    <select name="limit" class=" form-control">
                                        <?php
                                        $selectedValue = \Illuminate\Support\Facades\Request::get('limit');
                                        if ($selectedValue == "") {
                                            $selectedValue = 10;
                                        }

                                        foreach (get_limit_values() as $limitData) {
                                            $selected = "";
                                            if ($selectedValue == $limitData['value'] && $selectedValue != "") {
                                                $selected = 'selected';
                                            }
                                            echo "<option {$selected} value='{$limitData['value']}'>{$limitData['value']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label>Status</label>
                                    <select name="status" class=" form-control">
                                        <?php
                                        $selectedValue = \Illuminate\Support\Facades\Request::get('status');
                                        if ($selectedValue == "") {
                                        }
                                        foreach ([['title' => '-- Select --', 'value' => ''], ['title' => 'Enable', 'value' => 1], ['title' => 'Disable', 'value' => 0]] as $limitData) {
                                            $selected = "";
                                            if ($selectedValue == $limitData['value'] && $selectedValue != "") {
                                                $selected = 'selected';
                                            }
                                            echo "<option {$selected} value='{$limitData['value']}'>{$limitData['title']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <div style="visibility: hidden;"><label for="">submit</label></div>
                                    <button class="btn btn-primary" type="submit">Search</button>
                                    <a href="<?php echo route('admin.roleCaps'); ?>" class="btn btn-secondary"
                                       type="submit">Reset</a>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 form-group">
                        <?php if ($caps->num_rows()) { ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <caption style="caption-side:top;">
                                    <?php
                                    echo "<p>Showing {$current_page} to " . ($current_page + $caps->num_rows() - 1) . " of {$caps->total_rows}</p>";
                                    ?>
                                </caption>
                                <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Slug</th>
                                    <th>Status</th>
                                    <th>Roles</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($caps->result() as $index => $cap) { ?>
                                <tr>

                                    <th>
                                        <span class="font-weight-bold text-muted">
                                            <?php echo $current_page++; ?>.
                                        </span>
                                    </th>
                                    <td>
                                        <?php echo $cap->cap_name;?>
                                    </td>

                                    <td>
                                        <?php echo $cap->cap_slug; ?>
                                    </td>

                                    <td>

                                        <?php if($cap->status == 1){?>
                                        <span class="badge badge-success">Enable</span>
                                        <?php }else{?>
                                        <span class="badge badge-danger">Disable</span>
                                        <?php }?>

                                    </td>

                                    <td>
                                        <?php echo $cap->roles; ?>
                                    </td>

                                    <td>
                                        <div class="dropdown dropdown-inline">
                                            <a href="<?php echo route('admin.editRoleCaps', ['cap_id' => $cap->cap_id]); ?>"
                                               class="btn btn-sm btn-clean btn-icon mr-2">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <a onclick="deleteCaps(this)" href="javascript:void(0)"
                                               data-href="<?php echo route('admin.deleteRoleCaps', ['cap_id' => $cap->cap_id]); ?>"
                                               class="btn btn-sm btn-clean btn-icon mr-2">
                                                <i class="fa fa-trash"></i>
                                            </a>

                                        </div>
                                    </td>
                                </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-12 mk-custom-pagination">
                        <?php echo $pagination_links; ?>
                    </div>
                    <?php } else { ?>
                    <h4><?php echo __('common.data_list_empty'); ?></h4>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            // deleteCaps
            function deleteCaps(that) {
                event.preventDefault();
                let confirmDel = confirm("{{__('common.sure_want_to_delete')}}");
                if (confirmDel) {
                    window.location.href = $(that).attr('data-href');
                } else {
                    return false;
                }
            }
        </script>
    @endpush
@endsection