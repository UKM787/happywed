<?php

namespace App\Models\Vendor\Service;

use App\Models\Vendor\Lead;
use App\Models\Vendor\Review;
use App\Models\Admin\VenueMaster;
use App\Models\Admin\VendorMaster;
use App\Models\Admin\LocationMaster;
use App\Models\Admin\ServiceMaster;
use App\Models\Host\Invitation;
use App\Models\Vendor\VendorService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Venue extends Model
{

    use HasFactory;
    protected $table = 'venues';
    protected $guarded = [];
    protected $casts = [
        'venue_facilities' => 'array',
        'party_area' => 'array',
        'venue_policies' => 'array',
        'features' => 'array',
        'images' => 'array',  
        'videos' => 'array', 
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function master(){
        return $this->belongsTo(VenueMaster::class,'venuemaster_id','id');
    }

    public function location()
    {
        return $this->belongsTo(LocationMaster::class, 'location_id', 'id')->with('state');
    }

    public function category()
    {
        return $this->belongsTo(VendorMaster::class, 'category_id', 'id');
    }

    public function venueable()
    {
        return $this->morphTo();
    }

    public function reviews()  {
        return $this->morphMany(Review::class, 'productable');
    }

    public function leads()  {
        return $this->morphMany(Lead::class, 'productable');
    }

    public function services()  {
        return $this->morphToMany(ServiceMaster::class,'productable', 'vendor_service');
    }

    public function ceramonies()
    {
        return $this->belongsToMany(Ceramony::class, 'ceramony_venue', 'venue_id', 'ceramony_id')->withPivot(['venue_id', 'ceramony_id'])->withTimestamps();
    }


    public function invitations()
    {
        return $this->belongsToMany(Venue::class, 'invitation_venue', 'venue_id', 'invitation_id')->withPivot(['venue_id', 'invittation_id'])->withTimestamps();
    }

    public function allInvitations()
    {
        return $this->morphToMany(Invitation::class, 'vendorable');
    }

}
