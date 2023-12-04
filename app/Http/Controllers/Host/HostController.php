<?php

namespace App\Http\Controllers\Host;

use auth;
use App\Models\Admin\Tag;
use App\Models\Host\Host;
use App\Models\SiteDefault;
use Illuminate\Http\Request;
use App\Models\Host\Invitation;
use App\Models\Host\MemberTask;
use App\Models\Admin\Testimonial;
use App\Http\Controllers\Controller;

class HostController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //dd(auth()->guard('host')->user());
        //dd('ss');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
       // dd('reached hostcontroller');
        $lastShortCode = '';
        $generatedShortCodes = []; 
        // for ($i = 0; $i < 500000; $i++) {
        //     $shortCode = $this->generateUniqueShortCode($lastShortCode);
        //     if (in_array($shortCode, $generatedShortCodes)) {
        //         echo "Duplicate found: $shortCode\n";
        //         break; // Exit the loop if a duplicate is found
        //     }
        //     array_push($generatedShortCodes, $shortCode);
        //     echo $shortCode . "\n";
        //     $lastShortCode = $shortCode;
        // }
        
        //dd(count($generatedShortCodes));
        
         if (auth()->guard('host')->check()) {
            
            $host = auth()->guard('host')->user();
            $host = Host::where('id', $host->id)->with('profile')->first();
                $invitation = $host->invitations->first();

                $guests = optional($invitation)->guests;
                $guestCount = 0;
                if($guests != null){
                    foreach($guests as $guest){
                        if($guest->pivot->invite == 3){
                            $guestCount += $guest->family->count();
                        }
                        if($guest->pivot->invite == 2){
                            $guestCount += 1;
                        }
                    }
                }
                $invitationCount = optional($invitation)->guests()?->where('invite', '>', 0)->count();
                $members = Host::where('parent_id', auth()->guard('host')->user()->id)->count();
                $guestCount = $guestCount + $invitationCount;
                $invitationsaccepted = optional($invitation)->guestlist()?->where('inviteStatus', 6)->count();
                $invitationsdeclined = optional($invitation)->guestlist()?->where('inviteStatus', 5)->count();
                $invitationspending = optional($invitation)->guestlist()?->where('inviteStatus', 4)->count();
                $notifications = $host->notifications;

                //
                $sentAccomodation = optional($invitation)->guestlist()?->where('accommodation', 1)->count();
                $sentLogistics = optional($invitation)->guestlist()?->where('logistics', 1)->count();

                $accAccomodation = optional($invitation)->guestlist()?->whereIn('accommodationStatus', [2,4])->count();
                $accLogisitcs = optional($invitation)->guestlist()?->where(function ($query){
                    $query->where('logisticsArrivalStatus', 2)?->orWhere('logisticsDepartureStatus', 2)->orWhere('logisticsDepartureStatus', 4)->orWhere('logisticsArrivalStatus', 4);
                })->count();
                /////
                $decAccomodation = optional($invitation)->guestlist()?->where('accommodationStatus', 3)->count();
                $decLogisitcs = optional($invitation)->guestlist()?->where(
                    function ($query) {
                        $query->where('logisticsArrivalStatus', 3)?->orWhere('logisticsDepartureStatus', 3);
                    }
                )->count();

                $allAccomodation = optional($invitation)->guestlist()?->where('hostAccommodationStatus', 1)->count();
                $allLogisitcs = optional($invitation)->guestlist()?->where(
                    function ($query) {
                        $query->where('hostLogisticsArrivalStatus', 1)?->orWhere('hostLogisticsDepartureStatus', 1);
                    }
                )->count();



                $tasks = MemberTask::where('invitation_id', optional($invitation)->id)->with('assignable', 'category')->oldest('startDate')->get();
                $active = 'home';
                //dd($tasks);
                //$notifications = ['ddfdsf','fdfdsfdsfds'];
                return view('host.welcome', compact('host', 'guests', 'invitationCount','guestCount','invitation', 'invitationsaccepted', 'invitationsdeclined', 'invitationspending', 'notifications', 'sentAccomodation', 'accAccomodation', 'allAccomodation', 'sentLogistics', 'accLogisitcs', 'allLogisitcs', 'decAccomodation', 'decLogisitcs','members', 'tasks', 'active'));
            

        }
        else {
            //dd('ss');
            return redirect()->route('welcome');
        }
    }

    public function getinvi()
    {
        $loggedIn =  auth()->guard('host')->user();
        $invitation = null;
        if($loggedIn){
            $invitation = $loggedIn->invitations->first();
        }
        return [
            'user' => $loggedIn,
            'invi' => $invitation
        ];
    }


    public function testify()
    {
        $loggedIn =  auth()->guard('host')->user();
        $host = Host::where('id', $loggedIn->id)->with('profile')->first();
        $testimonial = new Testimonial();
        $tags = array_filter(Tag::pluck('name', 'id')->toArray());
        return view('host.testimonials.create', compact('loggedIn', 'testimonial', 'tags', 'host'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function mobilenumber(Request $request, Host $host)    {
        $validated = $request->validate([
            'mobile' => 'required|digits:10',
        ]);
        $host->mobile=$request->mobile;
        $host->save();
        return redirect()->back();

    }


    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\host\host  $host
     * @return \Illuminate\Http\Response
     */
    public function show(host $host)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\host\host  $host
     * @return \Illuminate\Http\Response
     */
    public function edit(host $host)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\host\host  $host
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, host $host)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\host\host  $host
     * @return \Illuminate\Http\Response
     */
    public function destroy(host $host)
    {
        //
    }
}
