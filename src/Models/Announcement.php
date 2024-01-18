<?php

namespace Skillcraft\Announcement\Models;

use Botble\Base\Casts\SafeContent;
use Botble\Base\Enums\BaseStatusEnum;
use Skillcraft\Core\Models\CoreModel;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static \Botble\Base\Models\BaseQueryBuilder<static> query()
 */
class Announcement extends CoreModel
{
    use SoftDeletes;

    protected $table = 'sc_announcements';

    protected $fillable = [
        'title',
        'content',
        'starts_at',
        'ends_at',
        'status',
    ];
    
    protected $casts = [
        'status' => BaseStatusEnum::class,
        'title' => SafeContent::class,
        'content' => SafeContent::class,
    ];

    protected $dates = ['starts_at', 'ends_at'];
}
