<?php

namespace App\Models;

use App\Models\Traits\Searchable;
use App\Presenters\Presentable;
use Auth;
use DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Gate;
use Watson\Validating\ValidatingTrait;

/**
 * Model for tag.
 *
 * @version    v1.8
 */
final class Tag extends SnipeModel
{
    use HasFactory;

    protected $table = 'tag';
}