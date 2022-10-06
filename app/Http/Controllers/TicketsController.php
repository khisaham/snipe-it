<?php

namespace App\Http\Controllers;

use App\Http\Transformers\UsersTransformer;
use App\Models\Actionlog;
use App\Models\Asset;
use App\Models\Ticket;
use App\Models\Company;
use App\Models\Setting;
use App\Models\TicketActivities;
use App\Models\User;
use App\Notifications\RequestAssetCancelation;
use App\Notifications\RequestAssetNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * This controller handles all actions related to the ability for users
 * to view their own assets in the Snipe-IT Asset Management application.
 *
 * @version    v1.0
 */
class TicketsController extends Controller
{
    /**
     * Redirect to the profile page.
     *
     * @return Redirect
     */
    public function getIndex()
    {
        $myticket = Ticket::with('getAsset')->whereNotNull('created_by')
        ->where('created_by', '=', Auth::user()->id)
        ->orderBy('id', 'ASC')->get();
        $assigned = Ticket::whereNotNull('assigned_to')
        ->where('assigned_to', '=', Auth::user()->id)
        ->orderBy('id', 'ASC')->get();

            return view('tickets/view-ticket', compact('myticket', 'assigned'))
                ->with('settings', Setting::getSettings());
    }

    /**
     * Returns view of requestable items for a user.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getCreateTicket()
    {
        return view('tickets/create-ticket');
    }

    public function postSaveTicket(Request $request){
       $userid = Auth::user()->id;
       $ticketNo = 'TK'.random_int(100000, 999999);
       $ticket = new Ticket();
       $ticket->type = 'new type';
       $ticket->asset = $request->asset;
       $ticket->priority = $request->priority;
       $ticket->assigned_to = $request->user;
       $ticket->status = 1;
       $ticket->created_by = $userid;
       $ticket->description = $request->description;
       $ticket->subject = $request->subject;
       $ticket->ticket_no = $ticketNo;
        if ($ticket->save()) {
            $ticketActivity = new TicketActivities();
            $ticketActivity->user = $userid;
            $ticketActivity->subject = 'new ticket: ';
            $ticketActivity->ticket = $ticket->id;
            $ticketActivity->activity = 'Created new ticket '.$ticketNo.' ';
            $ticketActivity->status = 1;
            $ticketActivity->save();
            return redirect()->route('view-tickets')->with('success', trans('general.ticket-created-success'));
        }

        return redirect()->back()->withInput()->withErrors($ticket->getErrors());
    }

    public function postUpdateTicket(Request $request){
//        route('tickets.show', $ticket->id)
        $userid = Auth::user()->id;
        $ticket = Ticket::find($request->ticket_id);
        $ticket->status = $request->status;
        $ticket->save();
        $subject = 'closed no solution';
        if($request->status == 0){
            $subject = 're-opened';
        }
        else if($request->status == 1){
            $subject = 'Pending';
        } else if($request->status == 2){
            $subject = 're-assigned';
        } else if($request->status == 3){
            $subject = 'Solved and Closed';
        }
        $ticketActivity = new TicketActivities();
        $ticketActivity->user = $userid;
        $ticketActivity->subject = $subject;
        $ticketActivity->ticket = $request->ticket_id;
        $ticketActivity->activity = $subject.' '.$request->solution;
        $ticketActivity->status = 1;
        if($ticketActivity->save()){
            return redirect()->route('tickets.show', $request->ticket_id)->with('success', trans('general.ticket-created-success'));
        }
        return redirect()->back()->withInput()->withErrors($ticket->getErrors());
    }

    /**
     * Process a specific requested asset
     * @param null $assetId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getRequestAsset($assetId = null)
    {
        $user = Auth::user();

        // Check if the asset exists and is requestable
        if (is_null($asset = Asset::RequestableAssets()->find($assetId))) {
            return redirect()->route('requestable-assets')
                ->with('error', trans('admin/hardware/message.does_not_exist_or_not_requestable'));
        }
        if (! Company::isCurrentUserHasAccess($asset)) {
            return redirect()->route('requestable-assets')
                ->with('error', trans('general.insufficient_permissions'));
        }

        $data['item'] = $asset;
        $data['target'] = Auth::user();
        $data['item_quantity'] = 1;
        $settings = Setting::getSettings();

        $logaction = new Actionlog();
        $logaction->item_id = $data['asset_id'] = $asset->id;
        $logaction->item_type = $data['item_type'] = Asset::class;
        $logaction->created_at = $data['requested_date'] = date('Y-m-d H:i:s');

        if ($user->location_id) {
            $logaction->location_id = $user->location_id;
        }
        $logaction->target_id = $data['user_id'] = Auth::user()->id;
        $logaction->target_type = User::class;

        // If it's already requested, cancel the request.
        if ($asset->isRequestedBy(Auth::user())) {
            $asset->cancelRequest();
            $asset->decrement('requests_counter', 1);

            $logaction->logaction('request canceled');
            $settings->notify(new RequestAssetCancelation($data));

            return redirect()->route('requestable-assets')
                ->with('success')->with('success', trans('admin/hardware/message.requests.cancel'));
        }

        $logaction->logaction('requested');
        $asset->request();
        $asset->increment('requests_counter', 1);
        $settings->notify(new RequestAssetNotification($data));

        return redirect()->route('requestable-assets')->with('success')->with('success', trans('admin/hardware/message.requests.success'));
    }

    public function getRequestedAssets()
    {
        return view('account/requested');
    }


    public function show($id)
    {
        $this->authorize('view', Ticket::class);

        if (is_null($ticket = Ticket::find($id))) {
            return redirect()->route('view-tickets')
                ->with('error', trans('admin/companies/message.not_found'));
        }
        $ticketActivties = TicketActivities::where('ticket', $id)->get();

        return view('tickets/view')->with('ticket', $ticket)->with('ticket_activities', $ticketActivties);
    }

}