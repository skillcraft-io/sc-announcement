<?php

namespace Skillcraft\Announcement\Providers;

use Botble\Base\Supports\ServiceProvider;
use Botble\Base\Facades\PanelSectionManager;
use Botble\Base\PanelSections\PanelSectionItem;
use Botble\Base\Traits\LoadAndPublishDataTrait;
use Skillcraft\Core\PanelSections\CorePanelSection;

class AnnouncementServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function boot(): void
    {
        $this
            ->setNamespace('plugins/announcement')
            ->loadHelpers()
            ->loadAndPublishConfigurations(['permissions'])
            ->loadMigrations()
            ->loadAndPublishTranslations()
            ->loadAndPublishViews()
            ->loadRoutes();

            PanelSectionManager::default()->beforeRendering(function () {
                PanelSectionManager::registerItem(
                    CorePanelSection::class,
                    fn () => [
                        PanelSectionItem::make('announcements')
                            ->setTitle(trans('plugins/announcement::announcement.name'))
                            ->withIcon('ti ti-speakerphone')
                            ->withDescription(trans('plugins/announcement::announcement.description'))
                            ->withPriority(-9980)
                            ->withRoute('announcement.index'),
                    ]
                );
            });

            $this->app->booted(function () {
                $this->app->register(HookServiceProvider::class);
            });
    }
}
