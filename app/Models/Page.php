<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\MultilingualTrait;

/**
 * Class Page
 *
 * @package App\Models
 */
class Page extends Model
{
    use MultilingualTrait;

    protected $table = 'pages';

    protected $fillable = ['parent_id', 'active', 'icon'];
}
