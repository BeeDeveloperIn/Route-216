<?php

namespace App\plugins\importer\Controllers;

use App\Http\Controllers\Admin\Auth\Auth;
use App\Http\Controllers\Admin\MyAdminController;
use App\Http\Controllers\Admin\Users\UsersImporter;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Illuminate\Support\Facades\Validator;

use App\plugins\entities\Models\EntitiesModel;
use App\plugins\importer\Models\ImportExport;
use App\plugins\importer\Models\ImportExportRow;

class ImportExportController extends MyAdminController
{

    public function __construct()
    {
        parent::__construct();
    }

    /*
     * index
     * It will help to select
     * {what-he-want}/{what-data}
     * {what-he-want} may be any valid entry in terms model
     * with type = import_export & parent_id = 0
     * {what-data} will be child of selected what-he-want
     */
    /**/

    public function index()
    {
        /* get import and export methods */
        $this->data['terms'] = \App\plugins\entities\Models\EntitiesModel::where(['parent_id' => 0, 'status' => 1, 'type' => 'import_export'])->get();
//        $this->data['import_export'] = ImportExport::get();
        $limit = 10;
        $dataModel = \App\plugins\importer\Models\ImportExport::query()->orderBy('id', 'DESC');
        $this->data['import_export'] = $dataModel->paginate($limit);
        return $this->renderAdminView('ImportExport.index', $this->data);
    }

    /*
     * redirectNextStep
     *  form submit redirection */

    public function redirectNextStep(Request $request)
    {
        $formData = $request->all();
        $_errs = array();
        try {

            // validating the request
            $validator = Validator::make($formData, [
                'type' => 'required|string',
                'category' => 'required|string',
            ]);

            // throughout of the block if getting some error
            if ($validator->fails()) {
                $_errs = $validator->errors();
                throw new Exception(__('importexport::ImportExports.invalid_data'));
            }
            //save step 1
//            $import_export = ImportExport::create(['method' => $request->input('type'), 'category' => $request->input('category')]);
            //redirect url with id
            $redirect_url = route('importexport.main-page', [$request->input('type'), $request->input('category')]);
            //update redirect url
//            $import_export->current_url = $redirect_url;
//            $import_export->update();


            // returning valid response with redirect url if all okay
            return response()->json([
                'succ' => true,
                'public_msg' => __('importexport::ImportExports.redirect_with_thanks'),
                'redirect_url' => $redirect_url
            ]);
        } catch (Exception $ex) {
            return $this->getStandardErrorFormat($ex, $_errs);
        }
    }

    /*
     * getCategory
     * getCategory we are using for ajax on step 1
     * when user select import or export then load the
     * sub category
     * */

    public function getCategory()
    {
        $id = request()->get('id');
        $_errs = [];
        try {

        } catch (Exception $ex) {
            return $this->getStandardErrorFormat($ex, $_errs);
        }
        $id = request()->get('id');
        if (isset($id)) {
            return EntitiesModel::where(['parent_id' => $id, 'status' => 1, 'type' => 'import_export'])->get(['id', 'title', 'slug'])->toJson();
        }
    }

    /*main page for import/export*/
    public function mainPage($method, $category)
    {
        $_errs = [];
        try {
            //check url key
            if ($terms = EntitiesModel::where('slug', $method)->first()) {
                if ($category = EntitiesModel::where(['slug' => $category, 'parent_id' => $terms->id])->first()) {

                    //GET handler
                    if ($handler = $this->get_handler($category->slug)) {
                        //GET import additional form fields


                        $obj_handler = new $handler($category->slug);

                        $additional__form_fields = [];
                        if (method_exists($obj_handler, 'get_import_additional_form_fields')) {
                            $additional__form_fields = $obj_handler->get_import_additional_form_fields();
                        } else {
                            $additional__form_fields = [];
                        }
                        $this->data['additional__form_fields'] = $additional__form_fields;
                        if ($method == 'import') {
                            $this->data['display_information'] = method_exists($obj_handler, 'get_meta_import_information') ? $obj_handler->get_meta_import_information() : '';
                        } else {
                            $this->data['display_information'] = method_exists($obj_handler, 'get_meta_export_information') ? $obj_handler->get_meta_export_information() : '';
                        }

                        $this->data['obj_handler'] = $obj_handler;

                    } else {
                        throw new Exception(__('importexport.handler_not_found'));
                    }

                    $this->data['method'] = $terms->title;
                    $this->data['category'] = $category;
                    $this->data['hidden_fields'] = [
//                        [
//                            'name' => 'method',
//                            'value' => $method
//                        ],
//                        [
//                            'name' => 'category',
//                            'value' => $category->slug
//                        ]
                    ];
                    if ($method == 'import') {
                        return $this->renderAdminView('ImportExport.main-page', $this->data);
                    } else {
                        return $this->renderAdminView('ImportExport.main-page-export', $this->data);
                    }
                }
            }
        } catch (Exception $ex) {
            $this->ajax_errors[] = $ex->getMessage();
            return $this->mk_print_ajax_error_json(false);
        }
        return redirect()->route('importexport.index');
    }

    /*Step 2 upload file*/

    protected function get_handler($slug)
    {
        $handler = false;
        $category = EntitiesModel::where(['slug' => $slug])->first();
        if (!empty($category->meta_data)) {
            //dynamically inject meta_data->hanlder->import_handler()
            $meta_data = $category->meta_data;
            if (isset($meta_data['handler'])) {
                $handler = $meta_data['handler'];;
            }
        }

        // check manual loading
        if ($handler === false) {
            $handler = $this->manualHandlers($slug);
            return $handler;
        }
        return $handler;
    }


    public function stringReplaceOfHandlerName($handlerName)
    {

        $handler = str_replace('/', "'\'", $handlerName);
        $handler = str_replace("'", '', $handler);
        return $handler;
    }

    /**
     * @param $slug
     * @return false|mixed|string|null
     * manualHandlers
     * Manage manual handlers
     */
    public function manualHandlers($slug)
    {
        $handlers = array();

        // set user handler
        $userHandlerName = "App/Http/Controllers/Admin/Users/UsersImporter";
        $handlers['import_users'] = $this->stringReplaceOfHandlerName($userHandlerName);
        $handlers['export_users'] = $this->stringReplaceOfHandlerName($userHandlerName);
        /**
         * Filter for import and export manual handler
         * Plugin can inject into this
         * import_export_manual_handlers
         */
        $handlers = apply_filters('import_export_manual_handlers', $handlers);
        if (isset($handlers[$slug])) {
            return $handlers[$slug];
        }
        return null;
    }

    /**
     * @param $method
     * @param $category
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * moveFileData
     * Move file data
     */
    public function moveFileData($method, $category)
    {
        $file = request()->file('file');
        $_errs = [];
        try {
            //check url key
//            $this->key_exists($encrypt_id);
            //validation rule
            $validator = Validator::make(request()->all(), [
                'file' => ['required', function ($attribute, $value, $fail) {
                    if (!in_array($value->getClientOriginalExtension(), ['csv', 'xls', 'xlsx'])) {
                        $fail('Incorrect :attribute type choose.');
                    }
                }],
                'delimiter' => ['required']
            ]);

            // throughout of the block if getting some error
            if ($validator->fails()) {
                $_errs = $validator->errors();
                throw new Exception(__('importexport.invalid_file_type'));
            }

            //file move to server
            $file_name = time() . '.' . $file->getClientOriginalExtension();
            $path = storage_path() . '/upload-data';
            if (!is_writable($path)) {
                $_errs = "$path is not writable";
                throw new Exception("$path is not writable");
            }

            $file->move($path, $file_name);
            $file_path = $path . '/' . $file_name;

            // decrypt id
            //data save in database
            $import_row_obj = $this->genAndGetImportModel($method, $category);
            $import_row_obj->delimiter = \request()->input('delimiter');
            $import_row_obj->file_url = $file_path;
            $import_row_obj->type = $file->getClientOriginalExtension();
            $import_row_obj->meta_data = (\request()->input('additional_field')) ? (\request()->input('additional_field')) : null;
            //save handler
            $handler = $this->get_handler($category);
            $import_row_obj->handler_meta_data = $handler;


            //next page url
            $encrypt_id = $this->encryptId($import_row_obj->id);
            $redirect_url = route('importexport.map-files', ['method' => $method, 'category' => $category, 'id' => $encrypt_id]);
            //update current url
            $import_row_obj->current_url = $redirect_url;


            //update import export row data
            $import_row_obj->update();

            return redirect($redirect_url);
            // returning valid response with redirect url if all okay
//            return response()->json([
//                'succ' => true,
//                'public_msg' => __('importexport::ImportExports.redirect_with_thanks'),
//                'redirect_url' => $redirect_url
//            ]);

        } catch (Exception $ex) {
            return $this->getStandardErrorFormat($ex, $_errs);
        }
    }

    /*/*Step 3 map data & import*/

    public function genAndGetImportModel($method, $category)
    {
        return ImportExport::create([
            'created_by' => \Illuminate\Support\Facades\Auth::id(),
            'method' => $method, 'category' => $category]);
    }

    /* get file header*/

    protected function encryptId($id)
    {
        return $id;
    }

    /*
     * genAndGetImportModel
     * it generate import or export model based on
     * @param
     * @method = export or import
     * @category = operation
     */

    public function mapFile($method, $category)
    {
        $_errs = [];
        $encrypt_id = request()->input('id');

        try {
            //check url key
            $this->key_exists($encrypt_id);
            //decrypt the id
            $id = $this->dcryptId($encrypt_id);
            //find data
            $import_row_obj = ImportExport::find($id);
            if (!empty($import_row_obj)) {
                //get attached file header
                $this->data['header_data'] = $this->get_file_header($import_row_obj['file_url']);


                //GET handler
                if ($handler = $this->get_handler($import_row_obj['category'])) {
                    //GET import additional form fields
                    $obj_handler = new $handler;
                    $import_column = $obj_handler->get_import_column();

//                    $rejected_columns = $obj_handler->rejectedImportColumns;
                    # remove rejected columns from final data
//                    foreach (@$import_column as $key => $value) {
//                        if (in_array($key, @$rejected_columns)) {
//                            unset($import_column[$key]);
//                        }
//                    }

                    //restrict remove id
                    $this->data['import_column'] = $import_column;
                }
                //set category method
                $this->data['method'] = $import_row_obj['method'];
                $this->data['category'] = EntitiesModel::where(['slug' => $category])->first(['title']);
                return $this->renderAdminView('ImportExport.upload-map-file');
            } else {
                return redirect()->route('importexport.index', [app()->getLocale()]);
            }
        } catch (Exception $ex) {
            return $this->getStandardErrorFormat($ex, $_errs);
        }
    }

    /*csv to array conversion*/

    protected function key_exists($encrypt_id)
    {
        $_errs = [];
        try {
            //check
            if (empty($encrypt_id)) {
                throw new Exception(__('importexport::ImportExports.invalid_url'));
            }
            //check key exist in the db
            if ($id = $this->dcryptId($encrypt_id)) {
                if (empty(ImportExport::find($id))) {
                    throw new Exception(__('importexport::ImportExports.invalid_url'));
                }
            } else {
                throw new Exception(__('importexport::ImportExports.invalid_url'));
            }

        } catch (Exception $ex) {
            return $this->getStandardErrorFormat($ex, $_errs);
        }
    }

    /*get handler*/

    protected function dcryptId($id)
    {
        return $id;
    }

    protected function get_file_header($file_path)
    {
        $csv = array_map("str_getcsv", file($file_path, FILE_SKIP_EMPTY_LINES));
        if (isset($csv[0])) {
            return $csv[0];
        }

//        if (isset($csv[3])) {
//            return $csv[3];
//        }
        return [];
//        $keys = array_shift($csv);
//        return $keys;
    }

    /* encrypt id */

    public function importData()
    {
        $_errs = [];
        $res = $this->getStandardSuccFormat();
        $encrypt_id = request()->input('id');
        try {
            //check url key
            $this->key_exists($encrypt_id);
            $input = request()->all();

            //decrypt the id
            $id = $this->dcryptId($encrypt_id);


            //find data
            $import_row_obj = ImportExport::find($id);
            $handler = $this->get_handler($import_row_obj['category']);
            //GET import additional form fields
            $obj_handler = new $handler;
            $import_column = $obj_handler->get_import_column();

            $temp_arr = [];
            // input fields map data
            $data['map_data'] = $input['map_data'];
            foreach (@$data['map_data'] as $key => $value) {
                if ($value === 'do-not-import') {
                    unset($data['map_data'][$key]);
                } elseif (array_key_exists($value, $import_column) && $import_column[$value]['is_duplicate_allowed'] == true) {
                    $temp_arr[$key] = $value;
                    unset($data['map_data'][$key]);
                }
            }

            //check map data empty
            if (empty(array_merge($data['map_data'], $temp_arr))) {
                throw new Exception(__('importexport::ImportExports.required_field'));
            }

            //validation rule
            $validator = Validator::make($data, [
                "map_data.*" => "distinct",
            ]);

            //through out of the block if getting some error
            if ($validator->fails()) {
                $_errs = $validator->errors();
                throw new Exception(__('importexport::ImportExports.duplicate_field'));
            }

            $data['map_data'] = array_merge($data['map_data'], $temp_arr);
            if (!empty($import_row_obj)) {
                $final_data = [];
                // input fields map data
                $map_data = $data['map_data'];
                //check imported data
                if (@$import_row_obj['type'] == 'csv') {
                    $arrData = $this->csvToArray($import_row_obj['file_url'], $import_row_obj['delimiter']);

                    //remove unmap data from csv data using handler remaining
                    foreach (@$arrData as $key => $value) {
                        foreach ($value as $kei => $val) {
                            if (array_key_exists($kei, $map_data)) {
                                $kv = $map_data[$kei];
                                $final_data[$key][$kv] = $val;
                            }
                        }
                    }

                    //update total record count
                    $import_row_obj->total_rows = count($final_data);
                    $import_row_obj->update();

                    $fdata = [];
                    //create import_export_rows
                    foreach ($final_data as $key => $value) {
                        //$import_export_row = new ImportExportRow();
                        $fdata[$key]['import_export_id'] = $id;
                        $fdata[$key]['meta_data'] = json_encode($value);
                    }

                    //insert in bulk
                    ImportExportRow::insert($fdata);
                    ImportExport::where('id', $id)->update(['status' => 1]);

                    //get handler
//                    $handler = $this->get_handler($import_row_obj['category']);
//                    $obj_handler = new $handler;
//                    $delay_time = $obj_handler->getDelayToNextRecords();
//
//                    if (!$delay_time) {
//                        throw new Exception(__('importexport::ImportExports.delay_time_missing'));
//                    }

//                    $number_of_jobs = $obj_handler->getNumberOfRecorderPerJobs();

//                    if (!$number_of_jobs) {
//                        throw new Exception(__('importexport::ImportExports.number_of_jobs_missing'));
//                    }

//                    $temp_time = 1;
//                    $page = 1;
//                    $limit = $number_of_jobs;
//                    for ($x = 0; $x <= round(count($final_data) / $number_of_jobs); $x++) {
//                        $temp_time = $temp_time + $delay_time;
//                        dispatch(new ImportData($id, $page, $limit))->delay(now()->addMinutes($temp_time));
//                        $page = $page + 1;
//                    }

                    //get imported rows
                    //$import_export_data = ImportExportRow::where('import_export_id', $id)->get()->toArray();
                    // foreach (@$import_export_data as $key => $value) {
                    //     # code...
                    //     if($key==$number_of_jobs){
                    //         $delay_time = $delay_time*2;
                    //     }
                    //     dispatch(new ImportData($id))->delay(now()->addMinutes($delay_time));
                    // }

                }
                $res['public_msg'] = __('importexport::importexport.import_qu_succ');
                $res['redirect_url'] = route('importexport.import-status', ['id' => $id]);

                if (\request()->ajax()) {
                    return response()->json($res);
                } else {
                    return redirect($res['redirect_url']);
                }

            } else {
                return redirect()->route('ImportExport.index', [app()->getLocale()]);
            }
        } catch (Exception $ex) {
            return $this->getStandardErrorFormat($ex, $_errs);
        }
    }

    public function get_link_for_list($type)
    {
        switch ($type) {
            case 'wh-shelf-code':
                // sh shelf code list
                return route('shelf.list');
            case 'import-box':
                // box listing screen
                return route('box.list');
            case 'import-product':
                // product listing screen
                return route('entity.index', ['entityType' => 'product']);
            case 'import-inventory':
                // inventory listing screen
                return route('inv.list');
            case 'order-importer':
                // for order listing screen
                return route('order.list');
        }
    }

    public function viewImportStatus($id)
    {
        $this->data['importExportModel'] = ImportExport::find($id);
        $this->data['list_url'] = $this->get_link_for_list($this->data['importExportModel']->category);
        return $this->renderAdminView('ImportExport.view-import-status');
    }

    /* dcrypt id */

    protected function csvToArray($filename = '', $delimiter = ',')
    {
        if (!file_exists($filename) || !is_readable($filename))
            return false;

        $header = null;
        $data = array();
        if (($handle = fopen($filename, 'r')) !== false) {
            $count = 0;
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {
//                $this->print_r($row);
//                if ($count <= 0) {
//                    $count++;
//                    continue;
//                }
//                if ($count <= 0) {
//                    $count++;
//                    continue;
//                }
                if (!$header && $count == 0) {
                    $header = $row;
                } else {
                    if (count($header) == count($row)) {
                        $data[] = array_combine($header, $row);
                    } else {
                        continue;
                    }
                }
                $count++;
            }
            fclose($handle);
        }

        return $data;
    }

    public function export_handler()
    {
        // dynamically inject meta_data->hanlder->export_handler()
    }

    public function get_import_column()
    {
        // dynamically inject meta_data->hanlder->get_import_column()
    }

    public function get_import_additional_form_fields()
    {
        // dynamically inject meta_data->hanlder->get_import_additional_form_fields()
    }

    public function importRows()
    {
        $id = request()->post('id');
        return $this->manage_import($id);
    }


    /*
     * manage_import
     * it will manage all import
     */

    public function manage_import($import_export_id)
    {
        $import_row_obj = ImportExport::find($import_export_id);
        $hander_obj = new $import_row_obj->handler_meta_data;
        return $hander_obj->manage_import($import_export_id);
    }

    /*
     * manage_export
     */


    public function manage_export($import_export_id)
    {
    }

    // public function manage_import()
    // {
    //     ///Modules/Users/Http/Controller/UsersImportExportController
    //     // Modules/Taxes/Http/Controller/TaxesImportExportController
    //     $reutn = meta->handler->mange_import($data);
    // }
    /***
     * master table
     * TBL import_export
     * id, file_url, import, import_customer, data_time, type, imported_rows, total_rows, meta_keys (form_fields_dyanmic)
     *
     * TBL relation_table
     * import_export_rows
     * it will keep all the rows to keep the success message and error msg against each rows
     * id, import_export_id (primary key of master table)
     * row_dump (json_encoded_values), is_error (0,1), error_msg, succ_msg
     */

    /*
     * eventTermSeederInit
     */
    public function RegImportExportEntities()
    {
        $terms = [['title' => 'import',
            'slug' => 'import',
            'parent_id' => '0',
            'type' => 'import_export',
        ], [
            'title' => 'export',
            'slug' => 'export',
            'parent_id' => '0',
            'type' => 'import_export'
        ]];
        \App\plugins\importer\Models\EntitiesModel::RegBulkEntities($terms);
    }

    public function exportImportSampleFile($slug)
    {
        $label = [];
        $keys = [];
        $sample_data = [];
        $handler = $this->get_handler($slug);
        $obj_handler = new $handler;
        $cols = $obj_handler->get_import_column();
        foreach ($cols as $key => $group) {
            foreach ($group['cols'] as $key => $item) {
                $reqText = isset($item['required']) ? 'Required' : 'Optional';
                $keys[] = $key;
                $label[] = $item['label'] . " {$reqText}";
                $sample_data[] = isset($item['sample']) ? $item['sample'] : '';
            }
        }
        $rows = [
            $keys,
            $sample_data
        ];

        $fileName = $slug . '-sample.csv';
        return self::Export($fileName, $rows);

    }

    public static function Export($fileName, $rows)
    {

        $res_headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );
        $callback = function () use ($rows) {
            $file = fopen('php://output', 'w');
            foreach ($rows as $eachRow) {
                fputcsv($file, $eachRow);
            }
            fclose($file);
        };
        return response()->stream($callback, 200, $res_headers);
    }

    /*
     * @param
     * item_id - integer (valid order_id or item_id)
     * type - order or order_item
     * per_page as limit default 5
     */
    public function getImportRows(Request $request)
    {
        // it will keep all errors
        $_errs = array();
        // default succ response defined in HomeBaseController
        $res = $this->getStandardSuccFormat();

        try {

            $formData = $request->query();

            if (!isset($formData['ie_id'])) {
                throw new Exception('ie_id is missing');
            }

            $limit = !isset($formData['per_page']) ? 20 : $formData['per_page'];

            $dataModel = ImportExportRow::where('import_export_id', $formData['ie_id']);
            $res['data'] = $dataModel->paginate($limit);

            // logics
            return response()->json($res);
        } catch (Exception $ex) {
            return $this->getStandardErrorFormat($ex, $_errs);
        }
    }
}
