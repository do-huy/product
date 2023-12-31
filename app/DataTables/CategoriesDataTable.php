<?php

namespace App\DataTables;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Modules\Category\app\Models\Category;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class CategoriesDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', 'categories.action')
            ->setRowId('id')
            ->rawColumns(['image','status', 'action'])
            ->addColumn('image', function ($row) {
                $image = $row->getFirstMediaUrl('category', 'thumb') ?: asset('admin/images/no-image.png');
                return '<img  src="' . $image . '" >';
            })
            ->editColumn('status', function ($category) {
                if($category->status == 1)
                    return '<label class="badge badge-success bg-clb">Hoạt động</label>';
                else
                    return '<label class="badge badge-danger bg-cld">Không hoạt động</label>';
            })
            ->addColumn('action', function($category){
                $btn ="";
                    $btn = '<a href="/category/'.$category->id.'/edit" class="status-tb-btn bg-clc btn-custom"><span class="material-icons-sharp">edit</span></a>';
                    $urlDestroy = Route('category.destroy', [$category->id]);
                    $btn .= '<a data-url="'. $urlDestroy. '" id="'.$category->id.'" class="status-tb-btn bg-cld btn-custom action-delete"><span class="material-icons-sharp">delete</span></a>';
                return $btn;
            });
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Category $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('categories-table')
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
            Column::make('name')->title('Tên danh mục'),
            Column::make('image')->title('Hình ảnh'),
            Column::computed('status')->title('Trạng thái'),
            Column::computed('action')
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
        return 'Categories_' . date('YmdHis');
    }
}
