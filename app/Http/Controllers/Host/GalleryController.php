<?php

namespace App\Http\Controllers\Host;

use App\Models\Host\Host;
use App\Models\Gallery;
use App\Models\Album;
use App\Models\Video;
use Illuminate\Http\Request;
use App\Models\Host\Invitation;
use App\Http\Controllers\Controller;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()  {

        $host = auth()->guard('host')->user();
        $host = Host::where('id', $host->id)->with('profile')->first();
        $invitation=$host->invitations->first();
        $invitations=$host->invitations->first();
        $active = 'gallery';

        if($invitations == null){
                return redirect(route('hostinvitations.index'));
            }

        if(isset($invitations)){
            $albums=Album::with('images')->where('invitation_id',$invitations->id)->get();
            $galleries=Gallery::with(['invitation','album'])->where('invitation_id',$invitations->id)->get();
            $videos=Video::where('invitation_id',$invitations->id)->get();
        }
        else{
            $galleries=[];
            $videos=[];
            return "<h1> Please create invitation</h1>";
        }
        
        return view('host.gallery.index', compact('host','albums','invitations','galleries','videos', 'active', 'invitation'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Invitation $invitation) {
        $host = auth()->guard('host')->user();
        return view('host.gallery.create', compact('host', 'invitation'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $host = auth()->guard('host')->user();
        $invitations=$host->invitations->first();

        $this->validate($request,[
            'galleryImage'=>'required',
            'galleryImage.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:512',
        ]);

        if($request->hasFile('galleryImage'))
        {
            foreach ($request->file('galleryImage') as $image) {
                $name = time().rand(1,100).'.'.$image->extension();
                $image->move(public_path('files/'.$invitations->id), $name);
                $gallery= new Gallery();
                $gallery->imageName = $name;
                $gallery->invitation_id=$invitations->id;
                $gallery->album_id=$request->albumId;
                $gallery->save();

            }
        }



       return back()->with('success', 'Images saved successfully ');
    }

    public function createAlbum(Request $request){
         //dd($request);
        $host = auth()->guard('host')->user();
        $validated = $request->validate([
            'album' => 'required',
            'galleryImage'=>'required',
            'galleryImage.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:10240',
        ], [], [
            'galleryImage.*' => 'Images'
        ]);
        $invitations=$host->invitations->first();
        $albumName=ucfirst(strtolower($request->album));
        $album=Album::where('name',$albumName)->where('invitation_id',$invitations->id)->first();
        if(!isset($album)){
            $album = new Album();
            $album->name=$albumName;
            $album->description="image Collection";
            $album->coverimage="default";
            $album->invitation_id=$invitations->id;
            $album->save();
        }

        if($request->hasFile('galleryImage'))
        {
            foreach ($request->file('galleryImage') as $image) {
                $name = time().rand(1,100).'.'.$image->extension();
                $image->move(public_path('files/'.$invitations->id), $name);
                $gallery= new Gallery();
                $gallery->imageName = $name;
                $gallery->invitation_id=$invitations->id;
                $gallery->album_id=$album->id;
                $gallery->save();

            }
        }

        $albums=Album::with('images')->where('invitation_id',$invitations->id)->get();
        $galleries=Gallery::with(['invitation','album'])->where('invitation_id',$invitations->id)->get();
        $videos=Video::where('invitation_id',$invitations->id)->get();
        
        return[$albums, $galleries, $videos];
        //return back()->with('success','Album created and images added Successfuly');
    }

    public function videoStore(Request $request)
    {
       // dd($request);
       

        $host = auth()->guard('host')->user();
        $request->validate([
            'galleryVideo'=>'required',
            'galleryVideo.*' => 'mimetypes:video/avi,video/mpeg,video/quicktime,video/mp4|max:10240'
        ], [], [
            'galleryVideo.*' => 'Videos'
        ]);
        $invitations=$host->invitations->first();
        $albumName=ucfirst(strtolower($request->album));
        // $album=Album::where('name',$albumName)->first();
        // if(!isset($album)){
        //     $album = new Album();
        //     $album->name=$albumName;
        //     $album->description="image Collection";
        //     $album->coverimage="default";
        //     $album->invitation_id=$invitations->id;
        //     $album->save();
        // }
        if($request->hasFile('galleryVideo'))
        {
            foreach ($request->file('galleryVideo') as $video) {
                $exten = $video->extension();
                $video->move(public_path('videos/'.$invitations->id), $albumName.".".$exten); 
                $video= new Video();
                $video->name = $albumName.".".$exten;
                $video->invitation_id=$invitations->id;
                //$gallery->video=1;
                //$gallery->album_id=$album->id;
                $video->save();
            }
        }

        $albums=Album::with('images')->where('invitation_id',$invitations->id)->get();
        $galleries=Gallery::with(['invitation','album'])->where('invitation_id',$invitations->id)->get();
        $videos=Video::where('invitation_id',$invitations->id)->get();
        
        return[$albums, $galleries, $videos];
       //return back()->with('success', 'Video saved successfully ');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($gallery)
    {
        $host = auth()->guard('host')->user();
        $image=Gallery::find($gallery);
        unlink("files/$host->id/$image->imageName");
        $image->delete();
        return redirect()->route('hostgallery.index',$host)
                        ->with('success','Image deleted successfully');

    }

    public function videoDestroy($gallery)
    {
        $host = auth()->guard('host')->user();
        $image=Video::find($gallery);
        // dd($gallery);
        // dd($image->name);
            unlink("videos/$host->id/$image->name");
        $image->delete();
        return redirect()->route('hostgallery.index',$host)
                        ->with('success','Image deleted successfully');
    }

    // public function deleteAlbum(Host $host,$album){

    //     $album=Album::find($album);
    //     if(isset($album)){
    //         foreach($album->images as $image){
    //             if($image->video==0){
    //                 unlink("files/$host->id/$image->imageName");
    //                 $image->delete();
    //             }
    //             else{
    //                 unlink("videos/$host->id/$image->imageName");
    //                 $image->delete();
    //             }
    //         }
    //     }
    //     $album->delete();
    //     return redirect()->route('hostgallery.index',$host)
    //                     ->with('success','Album deleted successfully');


    // }
}
