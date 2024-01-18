<?php

namespace Skillcraft\Announcement\Forms;

use Botble\Base\Forms\FormAbstract;
use Botble\Base\Forms\Fields\TextField;
use Botble\Base\Forms\Fields\EditorField;
use Botble\Base\Forms\Fields\SelectField;
use Botble\Base\Forms\FieldOptions\TextFieldOption;
use Botble\Base\Forms\FieldOptions\StatusFieldOption;
use Botble\Base\Forms\FieldOptions\ContentFieldOption;
use Skillcraft\Announcement\Models\Announcement;
use Skillcraft\Announcement\Http\Requests\AnnouncementRequest;
use Botble\Base\Forms\FieldOptions\DatePickerFieldOption;
use Botble\Base\Forms\Fields\DatePickerField;

class AnnouncementForm extends FormAbstract
{
    public function setup(): void
    {
        $this
            ->model(Announcement::class)
            ->setValidatorClass(AnnouncementRequest::class)
            ->hasTabs()
            ->add('title', TextField::class, TextFieldOption::make()->label('Title')->required()->toArray())
            ->add('content', EditorField::class, ContentFieldOption::make()->allowedShortcodes()->toArray())
            ->add('starts_at', DatePickerField::class, DatePickerFieldOption::make()->label('Starts at')->required()->toArray())
            ->add('ends_at', DatePickerField::class, DatePickerFieldOption::make()->label('Ends at')->toArray())
            ->add('status', SelectField::class, StatusFieldOption::make()->toArray())
            ->setBreakFieldPoint('status');
    }
}
