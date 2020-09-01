<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Language
 *
 * @package App\Models
 */
class Language extends Model
{
    /**
     * @var string
     */
    protected $table = 'languages';

    /**
     * @var array
     */
    protected $fillable = ['locale', 'short_name', 'name', 'default'];

    /**
     * List of available languages in short name format.
     * @return array
     */
    public static function shortLanguageList(): array
    {
        return static::pluck('short_name')->toArray();
    }

    /**
     * List of available languages.
     * @return mixed
     */
    public static function languageList()
    {
        return static::get();
    }

    /**
     * @return Language|null
     */
    public static function defaultLanguage()
    {
        return static::firstWhere('default', 1);
    }
}
