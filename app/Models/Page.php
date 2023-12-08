<?php

namespace App\Models;

use App\Traits\Attributes\HasTranslatableWithJsonEscape;
use App\Traits\Scopes\HasActiveScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use RalphJSmit\Laravel\SEO\Support\HasSEO;
use RalphJSmit\Laravel\SEO\Support\SEOData;

class Page extends Model
{
    use HasFactory;
    use HasActiveScope;
    use HasTranslatableWithJsonEscape;
    use HasSEO;

    /**
     * Cached Pages Key.
     */
    public static string $forEverCachedKey = 'pages-for-ever-cached-key';

    /**
     * Translation Fields using Spatie\Translatable
     * @var string[]
     */
    public $translatable = [
        'title',
        'description',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'title',
        'description',

        'shows',
        'is_active',
    ];

    protected $casts = [
        'shows' => 'array',
    ];

    /**
     * @return SEOData
     */
    public function getDynamicSEOData(): SEOData
    {
        return new SEOData(
            title: $this->getTranslation('title', app()->getLocale()),
            description: $this->getTranslation('description', app()->getLocale()),
            url: route('pages.show', ['page' => $this, 'title' => str($this->getTranslation('title', app()->getLocale()))->slug()]),
            published_time: $this->created_at,
            modified_time: $this->updated_at,
            section: 'pages',
            site_name: config('app.name'),
            locale: app()->getLocale(),
        );
    }
}
