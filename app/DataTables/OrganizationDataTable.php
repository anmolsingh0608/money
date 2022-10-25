<?php

namespace App\DataTables;

use App\Models\Organization;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class OrganizationDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('users', function(Organization $organization){
                return $organization->users()->count();
            })
            ->addColumn('certified_users', function(Organization $organization){
                return $organization->users()->where('certified' ,'=', 'yes')->count();
            })
            ->addColumn('action', 'admin.organization.action');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Organization $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Organization $model)
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('organization-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(1)
                    ->buttons(
                        Button::make('create'),
                        Button::make('export'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload')
                    );
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('id'),
            Column::make('organization_name')
                  ->exportable(false)
                  ->printable(false)
                  ->addClass('text-center'),
            Column::make('users'),
            Column::make('certified_users'),
            Column::make('action'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Organization_' . date('YmdHis');
    }
}
