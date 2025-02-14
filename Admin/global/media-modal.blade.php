<!-- Modal-->
<div class="modal fade" id="mediaModal" data-backdrop="static" tabindex="-1" role="dialog"
     aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Media uploader</h5>
                <button onclick="onMediaClose();" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="fa fa-close close-media-modal"></i>
                </button>
            </div>
            <div class="modal-body">
                <iframe id="media-modal-iframe" class="w-100 border-0" style="min-height: 70vh;"
                        src="{{ route('admin.image.upload',['element'=>1,'callback'=>'set_featured_image']) }}"></iframe>
            </div>
            {{--            <div class="modal-footer-bk">--}}
            {{--                <button type="button" class="btn btn-light-primary font-weight-bold close-media-modal"--}}
            {{--                        data-dismiss="modal">--}}
            {{--                    Close--}}
            {{--                </button>--}}
            {{--            </div>--}}
        </div>
    </div>
</div>
@push('scripts')
    <script>
        var media_modal_iframe = $("#media-modal-iframe");
        var media_uploader_url = '<?php echo route('admin.image.upload')?>';
        var preserve_uploader_url = '<?php echo route('admin.image.upload')?>';
        console.log("First:media_uploader_url", media_uploader_url);
        var mediaModal = $('#mediaModal');

        function onMediaClose() {
            media_modal_iframe.attr('src', "");
            media_uploader_url = preserve_uploader_url;
        }

        function init_media_modal(media_params) {
            media_modal_iframe.attr('src', "");

            let element;
            let callback;
            let is_multiple = 0;
            // set callback
            if (typeof media_params.callback != "undefined" && media_params.callback != "" && media_params.callback != null) {
                callback = media_params.callback;
            } else {
                alert("Callback function is required to get data from media uploader ");
                return false;
            }
            // set element
            if (typeof media_params.element != "undefined" && media_params.element != "" && media_params.element != null) {
                element = media_params.element;
            }
            //is_multiple
            if (typeof media_params.is_multiple != "undefined" && media_params.is_multiple != "" && media_params.is_multiple != null) {
                is_multiple = media_params.is_multiple;
            }

            // set url

            media_uploader_url = media_uploader_url + '?media=1';
            media_uploader_url = media_uploader_url + '&callback=' + callback;
            if (element) {
                media_uploader_url = media_uploader_url + '&element=' + element;
            }
            if (is_multiple) {
                media_uploader_url = media_uploader_url + '&is_multiple=1';
            } else {
                media_uploader_url = media_uploader_url + '&is_multiple=0';
            }
            //end set url

            media_modal_iframe.attr('src', media_uploader_url);
            setTimeout(function () {
                mediaModal.modal('show');
            }, 500);
        }
    </script>
@endpush

