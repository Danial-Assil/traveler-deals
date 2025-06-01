<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\JoinClause;

class AppModel extends Model
{
    use HasFactory;

    protected $appends = ['image_path', 'status_txt'];
    public function getImagePathAttribute()
    {
        return $this->image ? asset('uploads/' . $this->table . '/' . $this->image) : asset('assets/dash/img/no-img.jpg');
    }
    public function getImagePathThumbAttribute()
    {
        return $this->image ? asset('uploads/' . $this->table . '/thumbs/' . $this->image) : asset('assets/dash/img/no-img.jpg');
    }

    public function getStatusTxtAttribute()
    {
        return $this->status ?  trans('dash.active') :   trans('dash.unactive');
    }
    private function getTranslationsTable(): string
    {
        return app()->make($this->getTranslationModelName())->getTable();
    }

    public function getLocaleKey(): string
    {
        return $this->localeKey ?: config('translatable.locale_key', 'locale');
    }

    public function scopeTranslation(Builder $query)
    {
        $translationTable = $this->getTranslationsTable();
        $localeKey = $this->getLocaleKey();
        $table = $this->getTable();
        $keyName = $this->getKeyName();

        return $query->join($translationTable, function (JoinClause $join) use ($translationTable, $localeKey, $table, $keyName) {
            $join->on($translationTable . '.' . $this->getRelationKey(), '=', $table . '.' . $keyName)
                ->where($translationTable . '.' . $localeKey, $this->locale());
        });
    }
}
