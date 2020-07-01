<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Page
 *
 * @package App\Models
 */
class Page extends Model
{
    protected $table = 'pages';

    protected $fillable = ['parent_id', 'active', 'icon'];
}
