<?php

namespace App\DataTables;

use App\Models\PatientMedicalFile;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;
use App\Models\CustomField;
use Illuminate\Support\Facades\DB;

class PatientMedicalFileDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public static $customFields = [];


    public function dataTable($query)
    {
        $dataTable = new EloquentDataTable($query);
        $columns = array_column($this->getColumns(), 'data');
        $dataTable = $dataTable

        ->editColumn('id', function ($booking) {
            return $booking->id;
        })
            ->editColumn('Email', function ($category) {
                return $category->UserName->email;          
            }) ->editColumn('user_id', function ($category) {
                return $category->UserName->name;
            })

            
            ->editColumn('updated_at', function ($category) {
                return getDateColumn($category, 'updated_at');
            })
            ->addColumn('action', 'patients.datatables_actions')
            ->rawColumns(array_merge($columns, ['action']));

        return $dataTable;
    }

    protected function getColumns()
    {
        $columns = [
            [
                'data' => 'id',
                'title' => trans('lang.booking_id'),
            ],
            [
                'data' => 'Email',
                'name' => 'Email',                
                'title' => trans('Email'),
                'searchable' => false, 'orderable' => false, 'exportable' => false, 'printable' => false,
            ],
          
            [
                'data' => 'user_id',
                 'name' => 'user_id',

                'title' => trans('User Name'),
                'searchable' => false, 'orderable' => false,
            ],
            [
                'data' => 'updated_at',
                'title' => trans('lang.category_updated_at'),
                'searchable' => false,
            ]
        ];

        $hasCustomField = in_array(PatientMedicalFile::class, setting('custom_field_models', []));
        if ($hasCustomField) {
            $customFieldsCollection = CustomField::where('custom_field_model', PatientMedicalFile::class)->where('in_table', '=', true)->get();
            foreach ($customFieldsCollection as $key => $field) {
                array_splice($columns, $field->order - 1, 0, [[
                    'data' => 'custom_fields.' . $field->name . '.view',
                    'title' => trans('lang.category_' . $field->name),
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
     * @param Category $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(PatientMedicalFile $model)
    {

             return $model->newQuery()->whereNotIn('user_id' , [1 , 2])->select();  // Get data Not Admin ...                                                                
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
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
     * Get columns.
     *
     * @return array
     */
    // protected function getColumns()
    // {
    //     return [
    //         Column::computed('action')
    //               ->exportable(false)
    //               ->printable(false)
    //               ->width(60)
    //               ->addClass('text-center'),
    //         Column::make('id'),
    //         Column::make('add your columns'),
    //         Column::make('created_at'),
    //         Column::make('updated_at'),
    //     ];
    // }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'PatientMedicalFile_' . date('YmdHis');
    }
}
