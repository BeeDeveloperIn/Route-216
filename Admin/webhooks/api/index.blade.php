@extends($themeLayoutPath)
@section('menu_title')
    API
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-custom gutter-b">
                    <div class="card-header">
                        <div class="card-title">
                            <h3 class="card-label">Add API key</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label>Description</label>
                                    <input type="text" class="form-control" placeholder="Enter the description" name="desc">
                                </div>

                                <div class="col-md-6 form-group">
                                    <label>Users</label>
                                    <select class="form-control" name="user_id">
                                        <option value="">-- Select --</option>
                                    </select>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label>Permission</label>
                                    <select class="form-control" name="permissions">
                                        <option value="">-- Select --</option>
                                        <option value="1">Read</option>
                                        <option value="2">Write</option>
                                        <option value="3">Read/Write</option>
                                    </select>
                                </div>

                                <div class="col-md-12">
                                    <button class="btn btn-success" type="submit">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection