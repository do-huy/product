<?php

namespace App\DataTables;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Modules\Product\app\Models\Product;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ProductsDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', 'products.action')
            ->setRowId('id')
            ->rawColumns(['image','action','status'])
            ->addColumn('image', function ($row) {
                $image = $row->getFirstMediaUrl('product', 'thumb') ?: asset('images/no-image.png');
                return '<img style="border-radius: 50px;width:40px" src="' . $image . '" >';
            })
            ->editColumn('category_id', function ($row) {
                return $row->category->name . ($row->sub_category ? " > {$row->sub_category->name}" : '');
            })
            ->editColumn('price', function ($row) {
                return number_format($row->price, 0, '', ',') . ' đ' ;
            })
            ->editColumn('seller_id', function ($row) {
                return $row->seller->name;
            })
            ->editColumn('status', function ($product) {
                if($product->status == 1)
                    return '<label class="badge badge-success bg-clb">Hoạt động</label>';
                else
                    return '<label class="badge badge-danger bg-cld">Không hoạt động</label>';
            })
            ->addColumn('action', function($product){
                $btn ="";
                    $btn = '<a href="/product/'.$product->slug.'/edit" class="status-tb-btn bg-clc btn-custom"><span class="material-icons-sharp">edit</span></a>';
                    $urlDestroy = Route('product.destroy', [$product->id]);
                    $btn .= '<a data-url="'. $urlDestroy. '" id="'.$product->id.'" class="status-tb-btn bg-cld btn-custom action-delete"><span class="material-icons-sharp">delete</span></a>';
                return $btn;
            });
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Product $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('products-table')
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
            Column::computed('image')->title('Hình ảnh'),
            Column::make('name')->title('Tên sản phẩm'),
            Column::computed('category_id')->title('Danh mục'),
            Column::make('price')->title('Giá'),
            Column::computed('seller_id')->title('Cửa hàng'),
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
        return 'Products_' . date('YmdHis');
    }
}
