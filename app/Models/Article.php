<?php

namespace App\Models;

use App\Http\Traits\FullTextSearch;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Article extends LocalizedModel
{
    use FullTextSearch;

    protected $fillable = [
        'article_category_id','title', 'description', 'main_image', 'alias' , 'status','view','rating','user_id'
    ];

    protected $searchable = [
        'title',
        'description'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(ArticleCategory::class,'article_category_id','id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function images()
    {
        return $this->hasMany(ArticleImage::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function scopeFilter($query, $filters)
    {
        if ($month = $filters['month']) {
            $query->whereMonth('created_at', \Carbon\Carbon::parse(5 . $filters['month'])->month);
        }
        if ($year = $filters['year']) {
            $query->whereYear('created_at', $year);
        }
    }

    public static function archives()
    {
        $archives = static::selectRaw('year(created_at) year, monthname(created_at) month,
            monthname(created_at) monthHY, count(*) number')
            ->groupBy('year', 'month', 'monthHY')
            ->orderByRaw('min(created_at)')
            ->get();

        return $archives;
    }

    public function getMonthHYAttribute($month)
    {
        switch ($month) {
            case "January":
                return "Հունվար";
            case "February":
                return "Փետրվար";
            case "March":
                return "Մարտ";
            case "April":
                return "Ապրիլ";
            case "May":
                return "Մայիս";
            case "June":
                return "Հունիս";
            case "July":
                return "Հուլիս";
            case "August":
                return "Օգոստոս";
            case "September":
                return "Սեպտեմբեր";
            case "October":
                return "Հոկտեմբեր";
            case "November":
                return "Նոեմբեր";
            case "December":
                return "Դեկտեմբեր";
        }
    }
}
