<?php

namespace App\Models;

use App\Events\AssetCheckedOut;
use AssetPresenter;
use Auth;
use Carbon\Carbon;
use DB;

/**
 * Model for Assets.
 *
 * @version    v1.0
 */
class TicketActivities extends Depreciable
{
    protected $table = 'ticket_activities';

    public function getTicket()
    {
        return $this->belongsTo(\App\Models\Ticket::class, 'ticket', 'id');
    }

    public function getAddedBy(){
        return $this->belongsTo(\App\Models\User::class, 'user', 'id');
    }
    public function getFormattedDateAttribute(){
        return \Carbon\Carbon::parse($this->created_at)->format('d F Y');
    }

}