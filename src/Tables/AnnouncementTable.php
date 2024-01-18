<?php

namespace Skillcraft\Announcement\Tables;

use Botble\Table\Columns\Column;
use Botble\Table\Columns\IdColumn;
use Botble\Table\Actions\EditAction;
use Botble\Table\Columns\DateColumn;
use Botble\Base\Enums\BaseStatusEnum;
use Botble\Table\Actions\DeleteAction;
use Botble\Table\Columns\StatusColumn;
use Botble\Table\Abstracts\TableAbstract;
use Botble\Table\Columns\CreatedAtColumn;
use Illuminate\Database\Eloquent\Builder;
use Botble\Table\BulkActions\DeleteBulkAction;
use Botble\Table\BulkChanges\StatusBulkChange;
use Skillcraft\Announcement\Models\Announcement;
use Botble\Table\HeaderActions\CreateHeaderAction;

class AnnouncementTable extends TableAbstract
{

    public function setup(): void
    {
        $this
            ->model(Announcement::class)
            ->addHeaderAction(CreateHeaderAction::make()->route('announcement.create'))
            ->addActions([
                EditAction::make()->route('announcement.edit'),
                DeleteAction::make()->route('announcement.destroy'),
            ])
            ->addColumns([
                IdColumn::make(),
                Column::make('title')->route('announcement.edit'),
                DateColumn::make('starts_at'),
                DateColumn::make('ends_at'),
                CreatedAtColumn::make(),
                StatusColumn::make(),
            ])
            ->addBulkActions([
                DeleteBulkAction::make()->permission('announcement.destroy'),
            ])
            ->addBulkChanges([
                StatusBulkChange::make(),
            ])
            ->queryUsing(function (Builder $query) {
                return $query
                    ->select([
                        'id',
                        'title',
                        'starts_at',
                        'ends_at',
                        'created_at',
                        'status',
                    ]);
            })
            ->onAjax(function (AnnouncementTable $table) {
                return $table->toJson(
                    $table
                        ->table
                        ->eloquent($table->query())
                        ->filter(function ($query) {
                            if ($keyword = $this->request->input('search.value')) {
                                $keyword = '%' . $keyword . '%';
                                return $query
                                    ->where('title', 'LIKE', $keyword);
                            }

                            return $query;
                        })
                );
            });
    }
}
