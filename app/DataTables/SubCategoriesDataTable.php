<?php

namespace App\DataTables;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Modules\SubCategory\app\Models\SubCategory;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class SubCategoriesDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', 'subcategories.action')
            ->setRowId('id')
            ->rawColumns(['category_id', 'status', 'action'])
            ->editColumn('category_id', function($row) {
                return '<span class="account_role" data-currency_symbol="true">'.$row->category->name.'</span>';
            })
            ->editColumn('status', function ($sub_category) {
                if($sub_category->status == 1)
                    return '<label class="badge badge-success bg-clb">Hoạt động</label>';
                else
                    return '<label class="badge badge-danger bg-cld">Không hoạt động</label>';
            })
            ->addColumn('action', function($sub_category){
                $btn ="";
                    $btn = '<a href="/sub-category/'.$sub_category->id.'/edit" class="status-tb-btn bg-clc btn-custom"><span class="material-icons-sharp">edit</span></a>';
                    $urlDestroy = Route('subCategory.destroy', [$sub_category->id]);
                    $btn .= '<a data-url="'. $urlDestroy. '" id="'.$sub_category->id.'" class="status-tb-btn bg-cld btn-custom action-delete"><span class="material-icons-sharp">delete</span></a>';
                return $btn;
            });
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(SubCategory $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('subcategories-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
                    ->orderBy(0, 'desc')
                    ->selectStyleSingle()
                    ->buttons([
                        Button::make('excel'),
                        Button::make('csv'),
                        Button::make('pdf'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload')
                    ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [

            Column::make('id'),
            Column::make('name')->title('Tên danh mục phụ'),
            Column::make('category_id')->title('Danh mục chính'),
            Column::computed('status')->title('Trạng thái'),
            Column::computed('action')
            ->title('Thao tác')
            ->exportable(false)
            ->printable(false)
            ->width(60)
            ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'SubCategories_' . date('YmdHis');
    }
}
