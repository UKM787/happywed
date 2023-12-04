<!-- hostprofile -->
<div class="row">

    <div class="col-md-12">
        <label class="form-label" id="name">{{ __('Venue Name*') }}</label>
        <input name="name" type="text" class="form-control @error('name') is-invalid @enderror" placeholder="enter venue name" value="{{ old('name') ?? $venue->name ?? '' }}" aria-label="name" aria-describedby="name" autocomplete="name">

        @error('name')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>

{{-- <div class="row">
    <div class="col-md-12">
        <label class="form-label" id="description">{{ __('Venue Description*')}}</label>
        <textarea name="description" type="text" class="form-control @error('description') is-invalid @enderror" placeholder="enter detailed venueInformation" aria-label="description" aria-describedby="description" autocomplete="description">{{ old('description') ?? $venue->description ?? ''}}</textarea>
        @error('description')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div> --}}

<div class="row">
    <div class="col-md-12">
        <label class="form-label" id="address">{{ __('Address*')}}</label>
        <textarea name="address" type="text" class="form-control @error('address') is-invalid @enderror" placeholder="enter venueAddress" aria-label="address" aria-describedby="address" autocomplete="address">{{ old('address') ?? $venue->address ?? ''}}</textarea>
        @error('address')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>
<div class="row">
    {{--
    @if($categories->isNotEmpty())
    <div class="col">
        <label for="category_id" class="form-label">{{ __('Category') }}</label>
        <select name="category_id" id="category_id" class="form-control" size="5">
            @foreach ($categories as $key => $val)
            <option value="{{$val}}" @if (isset($venue)) {{$val == $venue->category_id ? 'selected' : '' }} @endif>{{$key}}</option>
            @endforeach
        </select>
        @error('category_id')
        <span class="invalid-feedback" role="alert">
            <strong>{{$message}}
        </span>
        @enderror
    </div>
    @endif --}}
   {{-- <div class="col">
        <label for="location_id" class="form-label">{{ __('Location') }}</label>
        <select name="location_id" id="location_id" class="form-control" size="5">
            @foreach ($locations as $key => $val)
            <option value="{{$val}}" @if (isset($venue)) {{$val == $venue->location_id ? 'selected' : '' }} @endif>{{$key}}</option>
            @endforeach
        </select>
        @error('location_id')
        <span class=" invalid-feedback" role="alert">
            <strong>{{$message}}
        </span>
        @enderror
    </div> --}}
    {{--
    @if(! isset($host))
    @if(! isset($vendor))
    <div class="col">
        <label for="priority" class="form-label">{{ __('Priority') }}</label>
        <select name="priority" id="priority" class="form-control" size="5">
            <option value="0" disabled>Select Priority</option>
            <option value="1">One</option>
            <option value="2">Two</option>
            <option value="3">Three</option>
            <option value="4">Four</option>
            <option value="5">Five</option>
            <option value="6">Six</option>
            <option value="7">Seven</option>
            <option value="8">Eight</option>
            <option value="9">Nine</option>
        </select>
        @error('priority')
        <span class="invalid-feedback" role="alert">
            <strong>{{$message}}
        </span>
        @enderror
    </div>
    @endif
    --}}
</div>
<div class="row mt-2">
    <div class="col">
        <label for="state" class="col-form">{{ __('State') }}</label>
        <select required name="state" id="state" class="form-control @error('state') is-invalid @enderror">
            <option value="" selected>Select your state</option>
        </select>
        @error('state')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
    <div class="col">
        <label for="location_id" class="col-form">{{ __('City') }}</label>
        <select required name="location_id" id="location_id" class="form-control @error('location_id') is-invalid @enderror" data-old="{{old('location_id')}}">
            <option value="" selected>Select your State First</option>
        </select>
        @error('location_id')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>
{{--
<div class="row">

    <div class="col-md-4">
        <label class="form-label" id="longitude">{{ __('Longitude') }}</label>
        <input name="longitude" type="text" class="form-control @error('longitude') is-invalid @enderror" placeholder="enter longtitude" value="{{ old('longitude') ?? $venue->longitude ?? ''}}" aria-label="longitude" aria-describedby="longitude" autocomplete="longitude">
        @error('longitude')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

    <div class="col-md-4">
        <label class="form-label" id="latitude">{{ __('Latitude*')}}</label>
        <input name="latitude" type="text" class="form-control @error('latitude') is-invalid @enderror" placeholder="enter latitude" value="{{ old('latitude') ?? $venue->latitude ?? ''}}" aria-label="latitude" aria-describedby="latitude" autocomplete="latitude">
        @error('latitude')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

    <div class="col-md-4">
        <Label class="form-label" id="map">{{ __('Map')}}</Label>
        <input name="map" type="text" class="form-control @error('map') is-invalid @enderror" placeholder="map" value="{{ old('map') ?? $venue->map ?? ''}}" aria-label="map" aria-describedby="map" autocomplete="map">
        @error('map')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>

@if(! isset($vendor))
<div class="row">
    <div class="col-md-4">
        <label for="icon" class="form-label">{{ __('Icon') }}</label>
        <input type="text" name="icon" id="icon" class="form-control  @error('icon') is-invalid @enderror" value="{{ old('icon') ?? $venue->icon ?? '' }}" autocomplete="icon">
        @error('icon')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>


    <div class="col-md-2">
        <label for="status" class="form-label">{{__('Publish')}}</label>
        <input type="checkbox" name="status" id="status" class="form-checkbox" checked>
    </div>
</div>
@endif


<!-- guestphoto optional -->
<div class="row mt-3">
    <div class="col-md-2">
        <div class="upload-cover">
            <label class="btn btn-upload btn-red">{{ __('Photo') }}<i class="fa fa-upload" aria-hidden="true"></i>
                <input hidden type="file" name="imageOne" class="@error('imageOne') is-invalid @enderror mb-4" accept="image/*" value="{{$venue->imageOne ?? asset('storage\defaultsv1').'\avatar.png' ??  '' }}" autocomplete="imageOne" aria-label="imageOne"></label>
            @error('imageOne')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror

            @if(isset($venue->imageOne) )
            <img src="{{asset('assets/venues\/').$venue->imageOne}}" alt="profilePhoto" id="imageOneTag" width="125px" height="auto">

            @else
            <img src="{{asset('assets/venues\/').'/venueDefault.png'}}" alt="profilePhoto" id="imageOneTag" width="125px" height="auto">
            @endif


        </div>
    </div>
</div>

@endif
--}}
<div class="row mt-3 text-center">
    <div class="col-2">
        <button type="submit" class="btn btn-sm wed-btn-main"> <span class="material-icons">save</span></button>
    </div>
</div>

