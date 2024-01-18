<?php

namespace Skillcraft\Announcement\Providers;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Supports\ServiceProvider;
use Skillcraft\Announcement\Models\Announcement;

class HookServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if (defined('DASHBOARD_FILTER_ADMIN_NOTIFICATIONS')) {
            add_filter(DASHBOARD_FILTER_ADMIN_NOTIFICATIONS, [$this, 'addAccouncement'], 10, 1);
        }

        if (defined('SKILLCRAFT_ACCOUNT_WIDGET_FILTER_ADMIN_NOTIFICATIONS')) {
            add_filter(SKILLCRAFT_ACCOUNT_WIDGET_FILTER_ADMIN_NOTIFICATIONS, [$this, 'addAccouncement'], 10, 1);
        }
    }

    public function addAccouncement(mixed $data)
    {
         $announcement = (new Announcement())
                    ->query()
                    ->whereDate('starts_at', '<=', now()->toDateString())
                    ->whereDate('ends_at', '>=', now()->toDateString())
                    ->where('status', BaseStatusEnum::PUBLISHED)
                    ->inRandomOrder()
                    ->first();
        
        if ($announcement) {
            $data = $data.view('plugins/announcement::announcement', compact('announcement'))->render();
        }
        
        return $data;
    }
}
