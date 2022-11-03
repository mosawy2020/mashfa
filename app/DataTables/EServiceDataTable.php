<?php
/*
 * File name: EServiceDataTable.php
 * Last modified: 2021.11.24 at 19:18:10
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2022
 */

namespace App\DataTables;

use App\Models\CustomField;
use App\Models\EService;
use App\Models\Post;
use Barryvdh\DomPDF\Facade as PDF;
use Yajra\DataTables\DataTableAbstract;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Services\DataTable;

class EServiceDataTable extends DataTable
{
    /**
     * custom fields columns
     * @var array
     */
    public static $customFields = [];

    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return DataTableAbstract
     */
    public function dataTable($query)
    {
        $query=$query->with("EServiceType");
         $dataTable = new EloquentDataTable($query);
        $columns = array_column($this->getColumns(), 'data');
          $dataTable = $dataTable
            ->editColumn('image', function ($eService) {
                return getMediaColumn($eService, 'image');
            })
//            ->editColumn('name', function ($eService) {
//                if ($eService['featured']) {
//                    return $eService['name'] . "<span class='badge bg-" . setting('theme_color') . " p-1 m-2'>" . trans('lang.e_service_featured') . "</span>";
//                }
//                return $eService['name'];
//            })
          ->editColumn('service_type', function ($eService) {
              //dd($eService->EServiceType);
                return $eService->EServiceType->name;
            })
             ->editColumn('price', function ($eService) {
                 if ($eService['price_unit'] == 'fixed' && !empty($eService['quantity_unit'])) {
                     return getPriceColumn($eService) . " - " . $eService['quantity_unit'];
                 } else {
                     return getPriceColumn($eService) . " - " . __('lang.e_service_price_unit_' . $eService['price_unit']);
                 }
             })
             ->editColumn('discount_price', function ($eService) {
                 if (empty($eService['discount_price'])) {
                     return '-';
                 } else {
                     if ($eService['price_unit'] == 'fixed' && !empty($eService['quantity_unit'])) {
                         return getPriceColumn($eService, 'discount_price') . " - " . $eService['quantity_unit'];
                     } else {
                         return getPriceColumn($eService, 'discount_price') . " - " . __('lang.e_service_price_unit_' . $eService['price_unit']);
                     }
                 }
             })
            ->editColumn('updated_at', function ($eService) {
                return getDateColumn($eService, 'updated_at');
            })
            ->editColumn('categories', function ($eService) {
                if ($eService->EServiceType->categories->first())
                    return getLinksColumnByRouteName($eService->EServiceType->categories, 'categories.edit', 'id', 'name');
                return null ;
            })
             ->editColumn('e_provider.name', function ($eService) {
                 return getLinksColumnByRouteName([$eService->eProvider], 'eProviders.edit', 'id', 'name');
             })
            ->editColumn('available', function ($eService) {
                return getBooleanColumn($eService, 'available');
            })
            ->addColumn('action', 'e_services.datatables_actions')
            ->rawColumns(array_merge($columns, ['action']));

        return $dataTable;
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        $columns = [
            [
                'data' => 'image',
                'title' => trans('lang.e_service_image'),
                'searchable' => false, 'orderable' => false, 'exportable' => false, 'printable' => false,
            ],
//            [
//                'data' => 'name',
//                'title' => trans('lang.e_service_name'),
//
//            ],
            [
                'data' => 'service_type',
                'title' => trans('lang.e_service_type'),

            ],
             [
                 'data' => 'e_provider.name',
                 'name' => 'eProvider.name',
                 'title' => trans('lang.e_service_e_provider_id'),

             ],
             [
                 'data' => 'price',
                 'title' => trans('lang.e_service_price'),

             ],
             [
                 'data' => 'discount_price',
                 'title' => trans('lang.e_service_discount_price'),

             ],
            [
                'data' => 'categories',
                'title' => trans('lang.e_service_categories'),
                'searchable' => false,
                'orderable' => false
            ],
            [
                'data' => 'available',
                'title' => trans('lang.e_service_available'),

            ],
            [
                'data' => 'updated_at',
                'title' => trans('lang.e_service_updated_at'),
                'searchable' => false,
            ]
        ];

        $hasCustomField = in_array(EService::class, setting('custom_field_models', []));
        if ($hasCustomField) {
            $customFieldsCollection = CustomField::where('custom_field_model', EService::class)->where('in_table', '=', true)->get();
            foreach ($customFieldsCollection as $key => $field) {
                 array_splice($columns, $field->order - 1, 0, [[
                    'data' => 'custom_fields.' . $field->name . '.view',
                    'title' => trans('lang.e_service_' . $field->name),
                    'orderable' => false,
                    'searchable' => false,
                ]]);
            }
        }
        return $columns;
    }

    /**
     * Get query source of dataTable.
     *
     * @param EService $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(EService $model)
    {

        if (auth()->user()->hasRole('provider')) {
            $q =  $model->newQuery()->with("eProvider")->join('e_provider_users', 'e_provider_users.e_provider_id', '=', 'e_services.e_provider_id')
                ->groupBy('e_services.id')
                ->where('e_provider_users.user_id', auth()->id())
                ->select('e_services.*');
        }
        else $q =
         $model->newQuery()->with("eProvider")->select("$model->table.*");
        if (request("e_provider_id")!==null)
            $q= $q->where("e_provider_id",request("e_provider_id")) ;
        return $q ;
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return Builder
     */
    public function html()
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->addAction(['width' => '80px', 'printable' => false, 'responsivePriority' => '100'])
            ->parameters(array_merge(
                config('datatables-buttons.parameters'), [
                    'language' => json_decode(
                        file_get_contents(base_path('resources/lang/' . app()->getLocale() . '/datatable.json')
                        ), true)
                ]
            ));
    }

    /**
     * Export PDF using DOMPDF
     * @return mixed
     */
    public function pdf()
    {
        $data = $this->getDataForPrint();
        $pdf = PDF::loadView($this->printPreview, compact('data'));
        return $pdf->download($this->filename() . '.pdf');
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'e_servicesdatatable_' . time();
    }
}
