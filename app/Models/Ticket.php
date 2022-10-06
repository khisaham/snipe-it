<?php

namespace App\Models;

use App\Events\AssetCheckedOut;
use App\Events\CheckoutableCheckedOut;
use App\Exceptions\CheckoutNotAllowed;
use App\Http\Traits\UniqueSerialTrait;
use App\Http\Traits\UniqueUndeletedTrait;
use App\Models\Traits\Acceptable;
use App\Models\Traits\Searchable;
use App\Presenters\Presentable;
use AssetPresenter;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Watson\Validating\ValidatingTrait;

/**
 * Model for Assets.
 *
 * @version    v1.0
 */
class Ticket extends Depreciable
{
    protected $table = 'ticket';

    public function getAsset()
    {
        return $this->belongsTo(\App\Models\Asset::class, 'asset', 'id');
    }

    public function getCreatedBy(){
        return $this->belongsTo(\App\Models\User::class, 'created_by', 'id');
    }
   public function getAssignedTo(){
        return $this->belongsTo(\App\Models\User::class, 'assigned_to', 'id');
    }

    public function getStatusBadgeAttribute()
    {
        $class = 'badge badge--';

        if($this->status == 0){
            $class .= 'warning';
            $text =  're-opened';
        }elseif ($this->status == 1){
            $class .= 'success';
            $text =  'Pending';
        }elseif ($this->status == 2){
            $class .= 'info';
            $text =  're-assigned';
        }elseif ($this->status == 3){
            $class .= 'info';
            $text =  'Solved and Closed';
        }
        else{
            $class .= 'dark';
            $text =  'Closed with no solution';
        }
        return "<span class=\"$class\">".trans($text)."</span>";
    }
}