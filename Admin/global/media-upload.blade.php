<!DOCTYPE html>
<html lang="en">
<head>
    <title>Media uploader</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{ $adminAssets }}css/plugins.bundle.css" rel="stylesheet" type="text/css"/>
    <link href="{{ $adminAssets }}css/style.bundle.css" rel="stylesheet" type="text/css"/>
    {{--    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">--}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap" rel="stylesheet">
</head>
<body>
<style>
    .media-thumbnail-preview {
        display: flex;
    }

    .media-thumbnail {
        height: 100px;
        width: 100px;
        display: block;
        object-fit: contain;
    }
</style>
<div class="container-fluid p-0">
    <div class="card border-0">
        <div class="card-body">
            @if (Session::has('success_message'))
                <div onclick="$(this).hide()">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-success mb-2 " role="alert">
                                <h4 class="alert-heading">Success!</h4>
                                <p>{{ Session::get('success_message') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @if (Session::has('error_message'))
                <div onclick="$(this).hide()">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-danger mb-2 " role="alert">
                                <h4 class="alert-heading">Error!</h4>
                                <p>{{ Session::get('error_message') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if (count($errors) > 0)
                <div class="container" onclick="$(this).hide()">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-danger mb-2 " role="alert">
                                <h4 class="alert-heading">Error!</h4>
                                @foreach ($errors->all() as $error)
                                    <p>{{ $error }}</p>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <div class="row">
                <div class="col-md-12 form-group">
                    <form action="{{ route('image.upload.post') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <div class="dropzone dropzone-default dz-clickable text-left">
                                    <input type="file" required class="form-control form-group" name="image[]"
                                           multiple="multiple"/>
                                    <button type="submit" class="btn btn-primary">Start upload</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="col-md-12 form-group">
                    <form method="get" action="<?php echo route('admin.image.upload');?>">
                        @csrf
                        <input type="hidden" name="is_multiple" value="<?php echo @$is_multiple?>">
                        <input type="hidden" name="element" value="<?php echo @$element?>">
                        <input type="hidden" name="callback" value="<?php echo @$callback?>">
                        <label>Search image</label>
                        <div class="input-group">
                            <input value="<?php echo $s;?>" type="text" name="s" class="form-control"
                                   placeholder="Search image via filename...">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">Search</button>
                            </div>
                        </div>
                    </form>
                </div>

                @if($media->count() > 0)
                    <div class="col-md-12 form-group">
                        <table class="table table-bordered form-group">
                            <thead>
                            <th>#</th>
                            <th>img</th>
                            <th>Filename</th>
                            <th>Uploaded on</th>
                            <th>Action</th>
                            </thead>
                            <tbody>
                            @foreach ($media as $index=>$file)
                                <tr>
                                    <th>
                                        {{$index + $media->firstItem()}}
                                    </th>
                                    <td>
                                        <img class="media-thumbnail img-fluid img-thumbnail"
                                             src="{{ asset($file->path) }}"
                                             alt="">
                                    </td>
                                    <td><a target="_blank" href="{{ asset($file->path) }}">{{ $file->filename }}</a>
                                    </td>
                                    <td>{{ $file->created_at }}</td>
                                    <td>
                                        <?php
                                        if(isset($callback) && $callback){
                                        ?>

                                        <?php
                                        if($is_multiple){
                                        ?>
                                        <a onclick="addItem({{ json_encode($file) }}, false,this)"
                                           href="javascript:void(0)"
                                           class="btn btn-primary">Select</a>
                                        <?php
                                        }
                                        ?>
                                        <a onclick="addItem({{ json_encode($file) }},true,this)"
                                           href="javascript:void(0)"
                                           class="btn btn-primary">Select & close</a>
                                        <?php
                                        }
                                        ?>
                                        <a onclick="deleteItem(this)"
                                           href="{{ route('image.deleteMedia',['id'=>$file->id]) }}"
                                           class="btn btn-danger">Delete</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="pagination">
                            {{ $media->links() }}
                        </div>
                    </div>
                @else
                    <div class="col-md-12 form-group">
                        <h3><?php echo __("common.data_list_empty");?></h3>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
<script>
    var element = '<?php echo $element?>';
    var callback = '<?php echo $callback?>';
    var is_multiple = '<?php echo $is_multiple?>';
    var media_data;
    var media_image_selected_class = 'media-selected';

    // on close
    function addItem(data, addAndClose, that) {
        $(that).hide();
        $('+ a.btn', that).hide();
        $(that).parents('tr').css('background','#f5f5f5');
        // if multiple
        if (parseInt(is_multiple)) {
            if (typeof media_data == "undefined" || media_data == null || media_data == "" || media_data.length == 0) {
                media_data = [];
            }
            media_data.push(data);
            // alert('Item added');
        } else {
            media_data = {};
            media_data = data;
        }
        // hide modal
        if (!parseInt(is_multiple)) {
            if (typeof callback != "undefined") {
                var fn = parent[callback];
                if (typeof fn === 'function') {
                    fn({
                        media_data: media_data,
                        element: element
                    });
                }
            } else {
                alert("callback is required");
            }
            $(window.parent.document).find('#mediaModal .close-media-modal').trigger('click');
            return true;
        } else if (addAndClose && parseInt(is_multiple)) {
            if (typeof callback != "undefined") {
                var fn = parent[callback];
                if (typeof fn === 'function') {
                    fn({
                        media_data: media_data,
                        element: element
                    });
                }
            } else {
                alert("callback is required");
            }
            $(window.parent.document).find('#mediaModal .close-media-modal').trigger('click');
            return true;
        }
    }


    // deleteItem
    function deleteItem(that) {
        event.preventDefault();
        let confirmDel = confirm('<?php echo __('common.sure_want_to_delete') ?>');
        if (confirmDel) {
            window.location.href = that.getAttribute('href');
        } else {
            return false;
        }
    }
</script>
</body>
</html>
