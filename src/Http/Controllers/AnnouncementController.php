<?php

namespace Skillcraft\Announcement\Http\Controllers;

use Skillcraft\Announcement\Http\Requests\AnnouncementRequest;
use Skillcraft\Announcement\Models\Announcement;
use Botble\Base\Facades\PageTitle;
use Botble\Base\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Exception;
use Skillcraft\Announcement\Tables\AnnouncementTable;
use Botble\Base\Events\CreatedContentEvent;
use Botble\Base\Events\DeletedContentEvent;
use Botble\Base\Events\UpdatedContentEvent;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Skillcraft\Announcement\Forms\AnnouncementForm;
use Botble\Base\Forms\FormBuilder;

class AnnouncementController extends BaseController
{
    public function index(AnnouncementTable $table)
    {
        PageTitle::setTitle(trans('plugins/announcement::announcement.name'));

        return $table->renderTable();
    }

    public function create(FormBuilder $formBuilder)
    {
        PageTitle::setTitle(trans('plugins/announcement::announcement.create'));

        return $formBuilder->create(AnnouncementForm::class)->renderForm();
    }

    public function store(AnnouncementRequest $request, BaseHttpResponse $response)
    {
        $Announcement = Announcement::query()->create($request->input());

        event(new CreatedContentEvent(ACCOUNT_ANNOUNCEMENT_MODULE_SCREEN_NAME, $request, $Announcement));

        return $response
            ->setPreviousUrl(route('announcement.index'))
            ->setNextUrl(route('announcement.edit', $Announcement->getKey()))
            ->setMessage(trans('core/base::notices.create_success_message'));
    }

    public function edit(Announcement $Announcement, FormBuilder $formBuilder)
    {
        PageTitle::setTitle(trans('core/base::forms.edit_item', ['name' => $Announcement->title]));

        return $formBuilder->create(AnnouncementForm::class, ['model' => $Announcement])->renderForm();
    }

    public function update(Announcement $Announcement, AnnouncementRequest $request, BaseHttpResponse $response)
    {
        $Announcement->fill($request->input());

        $Announcement->save();

        event(new UpdatedContentEvent(ACCOUNT_ANNOUNCEMENT_MODULE_SCREEN_NAME, $request, $Announcement));

        return $response
            ->setPreviousUrl(route('announcement.index'))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }

    public function destroy(Announcement $Announcement, Request $request, BaseHttpResponse $response)
    {
        try {
            $Announcement->delete();

            event(new DeletedContentEvent(ACCOUNT_ANNOUNCEMENT_MODULE_SCREEN_NAME, $request, $Announcement));

            return $response->setMessage(trans('core/base::notices.delete_success_message'));
        } catch (Exception $exception) {
            return $response
                ->setError()
                ->setMessage($exception->getMessage());
        }
    }
}
