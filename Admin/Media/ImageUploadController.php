<?php

namespace App\Http\Controllers\Admin\Media;

use App\Http\Controllers\Admin\MyAdminController;
use App\Http\Controllers\Bz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ImageUploadController extends MyAdminController
{

    //displayMediaUploader
    public function displayMediaUploader()
    {
        return $this->renderAdminView('global/display-media-uploader');
    }

    /**
     * Display a listing of the resource.
     *

     */
    public function imageUpload(Request $request)
    {
        #check access
        if (!$this->has_operation_access("edit_media")) {
            return $this->show_invalid_access();
        }

        mk_load_functions(['option']);
        $formData = $request->all();
        # set default
        $this->data['s'] = "";
        #start query
        $media = DB::table('media')
            ->orderBy('id', 'Desc');
        if (isset($formData['s']) && $formData['s'] != "") {
            $this->data['s'] = $formData['s'];
            $media = $media->where('filename', 'like', "%{$formData['s']}%");
        }
        $media = $media->paginate(20)->appends(request()->input());

        $this->data['media'] = $media;
        // set event and inputs
        if (isset($formData['is_multiple']) && $formData['is_multiple']) {
            $this->data['is_multiple'] = true;
        } else {
            $this->data['is_multiple'] = false;
        }
        //element
        if (isset($formData['element']) && $formData['element'] != "") {
            $this->data['element'] = $formData['element'];
        } else {
            $this->data['element'] = '';
        }

        // callback
        if (isset($formData['callback']) && $formData['callback'] != "") {
            $this->data['callback'] = $formData['callback'];
        } else {
            $this->data['callback'] = '';
        }

        //get_admin_theme_assets
        $this->get_admin_theme_assets();
        return view('admin.global.media-upload', $this->data);
    }

    public function deleteMediaImage(Request $request, $id)
    {
        #check access
        if (!$this->has_operation_access("delete_media")) {
            return $this->show_invalid_access();
        }

        $mediaModel = mkGetModelInstance('MediaModel', 'Media');
        $delRes = $mediaModel->delete_media($id);
        if ($delRes) {
            return redirect()->back()->with('success_message', __('common.item_deleted'));
        } else {
            return redirect()->back()->with('error_message', __('common.error_while_deleting'));
        }
    }

    /**
     * @return mixed
     * get_upload_dir
     * Return upload media dir folder name
     */
    public function get_upload_dir()
    {
        $upload_dir = apply_filters('upload_dir', 'images');
        // set month tree
        $upload_dir = $upload_dir . '/' . strtolower(date('Y'));
        $upload_dir = $upload_dir . '/' . strtolower(date('M'));
        return $upload_dir;
    }

    public function imageUploadPost(Request $request)
    {
        #check access
        if (!$this->has_operation_access("edit_media")) {
            return $this->show_invalid_access();
        }
        // load dependency function
        mk_load_functions(['user']);
        $folder = $this->get_upload_dir();
        // validate files
        if (empty($_FILES) || (!isset($_FILES['image']))) {
            return back()->with('error_message', __("common.formdata_empty"));
        } else {
            $allowTypes = array('jpg', 'png', 'jpeg', 'gif', 'webp', 'svg');
            $fileNames = array_filter($_FILES['image']['name']);
            $errorUploadType = array();
            if (!empty($fileNames)) {
                foreach ($_FILES['image']['name'] as $key => $val) {
                    // File upload path
                    $fileName = basename($_FILES['image']['name'][$key]);
                    // Check whether file type is valid
                    $fileType = pathinfo($fileName, PATHINFO_EXTENSION);
                    if (!in_array($fileType, $allowTypes)) {
                        $errorUploadType[] = $_FILES['image']['name'][$key];
                    }
                }
                if (!empty($errorUploadType)) {
                    return back()->with('error_message', 'Invalid files ' . implode(' | ', $errorUploadType));
                }
            }
        }

        //process
        $media_ids = [];
        if ($request->hasfile('image')) {
            foreach ($request->image as $image) {
                $imageName = $image->getClientOriginalName();
                // here check and get unique file name
                $imageName = $this->getUniqueImageName($image, $imageName, $folder, 1);
                // Do upload file on public disk
                $image->move(public_path($folder), $imageName);
                // Manage db process
                $data_insert = array();
                $data_insert['user_id'] = get_current_user_id();
                $data_insert['filename'] = $imageName;
                $data_insert['path'] = $folder . '/' . $imageName;
                $data_insert['disk'] = 'local';
                $data_insert['created_at'] = \App\Http\Controllers\Bz::getTimeStamp();
                $mediaModel = mkGetModelInstance('MediaModel', 'Media');
                $media_ids[] = $mediaModel->insert_media($data_insert);
                //END DB process
            }
        }

        return back()->with('success_message', count($media_ids) . ' file uploaded');
    }

    public function getUniqueImageName($imageInstance, $imageName, $folder, $increasedBy = 1)
    {
        if (!file_exists(public_path($folder . '/' . $imageName))) {
            return $imageName;
        } else {
            $imageName = $increasedBy . "_" . $imageName;
            $increasedBy++;
            return $this->getUniqueImageName($imageInstance, $imageName, $folder, $increasedBy);
        }
    }
}
