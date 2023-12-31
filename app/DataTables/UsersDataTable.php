<?php

namespace App\DataTables;

use Modules\User\app\Models\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Carbon\Carbon;

class UsersDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', 'users.action')
            ->setRowId('id')
            ->rawColumns(['status', 'action'])
            ->editColumn('status', function ($user) {
                if($user->status == 1)
                    return '<label class="badge badge-success bg-clb">Hoạt động</label>';
                else
                    return '<label class="badge badge-danger bg-cld">Không hoạt động</label>';
            })
            ->editColumn('created_at', function($user){
                $formatedDate = Carbon::createFromFormat('Y-m-d H:i:s', $user->created_at)->format('d-m-Y');
                return $formatedDate;
            })
            ->addColumn('action', function($user){
                $btn ="";
                    // if(auth()->user()->can('role-edit')) {
                        $btn = '<a href="/user/'.$user->id.'/edit-password" class="status-tb-btn bg-clb btn-custom"><span class="material-icons-sharp">password</span></a>';
                        $btn .= '<a href="/user/'.$user->id.'/edit" class="status-tb-btn bg-clc btn-custom"><span class="material-icons-sharp">edit</span></a>';
                    // }
                    // if(auth()->user()->can('role-delete')) {
                        $urlDestroy = Route('user.destroy', [$user->id]);
                        $btn .= '<a data-url="'. $urlDestroy. '" id="'.$user->id.'" class="status-tb-btn bg-cld btn-custom action-delete"><span class="material-icons-sharp">delete</span></a>';
                    // }
                return $btn;
            });
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(User $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('users-table')
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
            Column::make('name')->title('Tên tài khoản'),
            Column::make('email')->title('Email'),
            Column::computed('status')->title('Trạng thái'),
            Column::computed('created_at')->title('Ngày đăng ký'),
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
        return 'Users_' . date('YmdHis');
    }
}
