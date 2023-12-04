<?php

namespace App\Http\Controllers\Host;

use Exception;
use Carbon\Carbon;
use App\Models\Host\Host;
use App\Models\SiteDefault;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Host\Savedate;
use App\Models\Host\Invitation;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use App\Traits\ImageUpload;

class SavedateController extends Controller {

    use ImageUpload;

    public $counter;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($invi = null) {
        // dd('sss');
        if (auth()->guard('host')->check()) {
            if($invi == null){
                return redirect(route('hostinvitations.index'));
            }
            $host = auth()->guard('host')->user();
            $host = Host::where('id', $host->id)->with('profile')->first();
            $invitation = Invitation::where('slug', $invi)->with('venues')->first();
            $savedate = $invitation->savedate;
            $active = 'savedate';
            return view('host.invitation.savedate.index', compact('host', 'invitation', 'savedate', 'active'));

            // if($invitation->savedate()->count() != 0) {
            //     $now = Carbon::now();
            //     $marriagedate= $invitation->savedate->startDate;
            //     $counter = $now->diffInSeconds($marriagedate);
            //     $data = $invitation->savedate()->get()->toJson();
            //     $savedate = $invitation->savedate;

            //         if($savedate->imageOne != null ){
            //         $pic = asset('storage'.'/'.$savedate->imageOne);
            //         }
            //         return view('host.invitation.savedate.index', compact('host', 'invitation','savedate','pic','counter'));
            // }else {
            //         //return redirect()->route('hostsavedate.create',[$host, $invitation]);
            //         $savedate = new Savedate();
            //         $pic = SiteDefault::where('name', 'savedate')->inRandomOrder()->first()->img;
            //         return view('host.invitation.savedate.create', compact('host', 'invitation', 'savedate', 'pic'));
            // }
        }



    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Invitation $invitation) {
        $savedate = new Savedate();
        $host = auth()->guard('host')->user();
        $pic = SiteDefault::where('name', 'savedate')->inRandomOrder()->first()->img;
        return view('host.invitation.savedate.create', compact('host', 'invitation','savedate','pic'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Invitation $invitation, Request $request, Savedate $currentSaveDate )  {
        $data =$this->requestValidate($request);
        $host = auth()->guard('host')->user();
        $destImgPath = '\Uploads\\'.$invitation->host->slug.'\\'.$invitation->slug ;
        // if($request->file('imageOne') == null){
        //     $data['imageOne'] = SiteDefault::where('name','savedate')->inRandomOrder()->first()->img;;
        // }
        if (auth()->guard('host')->check()) {
            try {
                $savedate = Savedate::create($data + ['invitation_id' => $invitation->id, 'startDate' => $invitation->startDate ,'slug' => Str::slug($invitation->startDate .'-'. $invitation->slug)]);

                if ($savedate) {
                    if ($request->file('imageOne') != null) {
                        $this->storeImage($savedate, $destImgPath, 'imageOne', $currentSaveDate);
                    }
                }

                return response([
                        'message' => $host->name . ' Savedate created successfully, Add our story for wedding' ,
                        'data' => $savedate
                ]);
                // return redirect()->route('hoststory.create', [$invitation])
                //     ->with([
                //         'status' => 'success',
                //         'message' => $host->name . ' Savedate created successfully, Add OurStory'
                //     ]);
            } catch (Exception $e) {
                return response([
                        'message' => $e->getMessage() ,
                ], 422);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Invitation $invitation, Savedate $savedate)   {
        $pic = '';
        $host = auth()->guard('host')->user();
      return view('host.invitation.savedate.show',compact('host','invitation','savedate','pic'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Invitation $invitation, Savedate $savedate)  {
        $pic = '';
        $host = auth()->guard('host')->user();
        return view('host.invitation.savedate.edit', compact('host', 'invitation', 'savedate','pic'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Invitation $invitation,Savedate $savedate, Request $request)  {

        $data =  $this->requestValidate($request);
        //$data = $request->all();
        $host = auth()->guard('host')->user();
        $destImgPath = '\Uploads\\'.$invitation->host->slug.'\\'.$invitation->slug;
        $currentImg = $savedate->imageOne;

        if (auth()->guard('host')->check()) {
            try {
                $newsavedate = $savedate->update($data + ['invitation_id' => $invitation->id, 'startDate' => $invitation->startDate ,'slug' => Str::slug($invitation->startDate .'-'. $invitation->slug)]);
                if ($newsavedate) {
                    if ($request->file('imageOne') != null) {
                        $this->storeImage($savedate, $destImgPath, 'imageOne', $currentImg);
                    }
                }
                $save = Savedate::where('id', $savedate->id)->first();
                return response([
                        'message' => $host->name . ' Savedate updated successfully' ,
                        'data' => $save
                ]);
                // return redirect()->route('hostsavedate.index', [$invitation])
                //     ->with([
                //         'status' => 'success',
                //         'message' => $host->name . ' Savedate updated successfully'
                //     ]);
            } catch (Exception $e) {
                return response([
                        'message' => $e->getMessage() ,
                ], 422);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Storing and updating the guest_image
     *
     * @param  App\Models\Host\Invitation
     * @return \Illuminate\Http\Response
     */

    private function requestValidate($request)   {

        return $request->validate([
            //'startDate'         => ['required', 'date'],
            'imageOne'          => 'exclude_if:type,update|required|image|mimes:jpeg,png,jpg,gif,svg|max:20248',
            'counter'            => ['sometimes']
        ],
        [
               // 'startDate.required'        => ['invitation date and time required', 'date'],
                'imageOne'                  => 'image files size should less than 2MB',
                'counter'                   => ['sometimes']
        ]

        );
    }
}
