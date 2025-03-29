<?php

namespace App\Http\Controllers\Host;

use App\Models\Host\Host;
use App\Models\Gallery;
use App\Models\Album;
use App\Models\Video;
use Illuminate\Http\Request;
use App\Models\Host\Invitation;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use App\Models\Memory;
use App\Models\AlbumImage;

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

    public function videoStore(Request $request, Host $host)
    {
        $invitations = Invitation::where('host_id', $host->id)->first();
        if($request->hasFile('galleryVideo'))
        {
            foreach ($request->file('galleryVideo') as $video) {
                $exten = $video->getClientOriginalExtension();
                $name = time() . '_' . rand(1,100) . '.' . $exten;
                $video->move(public_path('videos/'.$invitations->id), $name);
                $videoModel = new Video();
                $videoModel->name = $name;
                $videoModel->invitation_id = $invitations->id;
                $videoModel->save();
            }
        }
        $albums = Album::where('invitation_id', $invitations->id)->get();
        $galleries = Gallery::where('invitation_id', $invitations->id)->get();
        $videos = Video::where('invitation_id', $invitations->id)->get();
        return response()->json([$albums, $galleries, $videos]);
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

    public function videoDestroy(Host $host, $videoId)
    {
        Log::info('Video deletion attempt', [
            'host_id' => $host->id,
            'video_id' => $videoId
        ]);
        
        $video = Video::find($videoId);
        if($video) {
            $videoPath = public_path("videos/{$video->invitation_id}/{$video->name}");
            Log::info('Video found', [
                'video_path' => $videoPath,
                'exists' => file_exists($videoPath)
            ]);
    
            try {
                if(file_exists($videoPath)) {
                    unlink($videoPath);
                    Log::info('Video file deleted');
                } else {
                    Log::warning("Video file does not exist: $videoPath");
                }
    
                $video->delete();
                Log::info('Video record deleted');
                return response()->json(['success' => true]);
            } catch (\Exception $e) {
                Log::error('Error deleting video', [
                    'error' => $e->getMessage(),
                    'video_path' => $videoPath
                ]);
                return response()->json(['success' => false, 'message' => 'Error deleting video file'], 500);
            }
        }
    
        Log::warning('Video not found', ['video_id' => $videoId]);
        return response()->json(['success' => false, 'message' => 'Video not found'], 404);
    }

    public function pictureStore(Request $request, Host $host)
    {
        $invitations = Invitation::where('host_id', $host->id)->first();
        
        $this->validate($request, [
            'galleryPicture' => 'required',
            'galleryPicture.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:5120',
        ]);

        if($request->hasFile('galleryPicture')) {
            foreach ($request->file('galleryPicture') as $image) {
                $name = time().rand(1,100).'.'.$image->extension();
                $image->move(public_path('files/'.$invitations->id), $name);
                
                $gallery = new Gallery();
                $gallery->imageName = $name;
                $gallery->invitation_id = $invitations->id;
                $gallery->save();
            }
        }

        $albums = Album::where('invitation_id', $invitations->id)->get();
        $galleries = Gallery::where('invitation_id', $invitations->id)->get();
        $videos = Video::where('invitation_id', $invitations->id)->get();
        
        return response()->json([$albums, $galleries, $videos]);
    }

    public function pictureDestroy(Host $host, $pictureId)
    {
        $picture = Gallery::find($pictureId);
        
        if($picture) {
            $picturePath = public_path("files/{$picture->invitation_id}/{$picture->imageName}");
            
            try {
                if(file_exists($picturePath)) {
                    unlink($picturePath);
                }
                
                $picture->delete();
                return response()->json(['success' => true]);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error deleting picture: ' . $e->getMessage()
                ], 500);
            }
        }
        
        return response()->json([
            'success' => false,
            'message' => 'Picture not found'
        ], 404);
    }
    

    public function deleteAlbum(Host $host, $album){
        $album = Album::find($album);
        if(isset($album)){
            // Delete all images in the album
            foreach($album->images as $image){
                if(file_exists(public_path("files/$host->id/$image->imageName"))) {
                    unlink(public_path("files/$host->id/$image->imageName"));
                }
                $image->delete();
            }
            // Delete the album itself
            $album->delete();
        }
        return response()->json(['success' => true]);
    }

    public function memoryUpload(Request $request, Host $host)
    {
        try {
            $request->validate([
                'galleryMemory.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            $invitation = Invitation::where('host_id', $host->id)->firstOrFail();
            $memories = [];

            if ($request->hasFile('galleryMemory')) {
                foreach ($request->file('galleryMemory') as $image) {
                    try {
                        $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                        
                        // Create directory if it doesn't exist
                        $uploadPath = public_path('uploads/memories');
                        if (!file_exists($uploadPath)) {
                            mkdir($uploadPath, 0777, true);
                        }
                        
                        $image->move($uploadPath, $imageName);

                        $memory = Memory::create([
                            'imageName' => $imageName,
                            'invitation_id' => $invitation->id
                        ]);

                        $memories[] = $memory;
                    } catch (\Exception $e) {
                        Log::error('Error processing memory upload: ' . $e->getMessage());
                        throw $e;
                    }
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Memories uploaded successfully',
                'memories' => $memories
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation error in memory upload: ' . json_encode($e->errors()));
            return response()->json([
                'success' => false,
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error in memory upload: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while uploading memories: ' . $e->getMessage()
            ], 500);
        }
    }

    public function deleteMemory($id, $memoryId)
    {
        try {
            $memory = Memory::where('invitation_id', $id)
                ->where('id', $memoryId)
                ->firstOrFail();

            // Delete the image file
            if (file_exists(public_path('uploads/memories/' . $memory->imageName))) {
                unlink(public_path('uploads/memories/' . $memory->imageName));
            }

            // Delete the memory record
            $memory->delete();

            return response()->json([
                'success' => true,
                'message' => 'Memory deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting memory: ' . $e->getMessage()
            ], 500);
        }
    }

    public function addAlbum(Request $request, Host $host)
    {
        $request->validate([
            'album' => 'required|string|max:255',
            'galleryImage.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'galleryVideo.*' => 'nullable|mimes:mp4,mov,ogg,qt|max:20480'
        ]);

        $invitation = Invitation::where('host_id', $host->id)->first();
        
        $album = new Album();
        $album->name = $request->album;
        $album->invitation_id = $invitation->id;
        $album->save();

        // Handle images
        if ($request->hasFile('galleryImage')) {
            foreach ($request->file('galleryImage') as $image) {
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('files/' . $invitation->id), $imageName);

                $albumImage = new AlbumImage();
                $albumImage->imageName = $imageName;
                $albumImage->album_id = $album->id;
                $albumImage->type = 'image';
                $albumImage->save();
            }
        }

        // Handle videos
        if ($request->hasFile('galleryVideo')) {
            foreach ($request->file('galleryVideo') as $video) {
                $videoName = time() . '_' . uniqid() . '.' . $video->getClientOriginalExtension();
                $video->move(public_path('videos/' . $invitation->id), $videoName);

                $albumImage = new AlbumImage();
                $albumImage->imageName = $videoName;
                $albumImage->album_id = $album->id;
                $albumImage->type = 'video';
                $albumImage->save();
            }
        }

        $albums = Album::where('invitation_id', $invitation->id)->get();
        $galleries = Gallery::where('invitation_id', $invitation->id)->get();
        $videos = Video::where('invitation_id', $invitation->id)->get();
        
        return response()->json([$albums, $galleries, $videos]);
    }

    public function deleteAlbumItem($hostId, $itemId)
    {
        try {
            $item = AlbumImage::findOrFail($itemId);
            $invitation = Invitation::where('host_id', $hostId)->firstOrFail();

            // Delete the file
            $filePath = $item->type === 'image' 
                ? public_path('files/' . $invitation->id . '/' . $item->imageName)
                : public_path('videos/' . $invitation->id . '/' . $item->imageName);

            if (file_exists($filePath)) {
                unlink($filePath);
            }

            // Delete the database record
            $item->delete();

            return response()->json([
                'success' => true,
                'message' => 'Item deleted successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Error deleting album item: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error deleting item: ' . $e->getMessage()
            ], 500);
        }
    }
}
