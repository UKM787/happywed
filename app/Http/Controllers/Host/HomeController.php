<?php

namespace App\Http\Controllers\Host;

use Exception;
use App\Models\Host\Home;
use App\Models\Host\Host;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::check()) {
            $host = auth()->guard('host')->user();

            if ($host->home !== null) {
                $home = $host->home;
                return view('host.profile.index', compact('host', 'home'));
            } else {
                $home = new Home();
                return view('host.home.create', compact('host', 'home'));
            }
        } else {
            die('you are not loggedin yet!');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Host $host)  {
        $home = new Home();
        return view('host.home.create', compact('host', 'home'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Host $host, Request $request) {
        $data =  $this->requestValidate($request);
        if (auth()->guard('host')->check()) {
            try {
                $home = Home::create($data + ['host_id' => auth()->guard('host')->id(), 'slug' => (Str::slug($host->name.'-'.$request->district.'-'.$request->state.'-'.$request->pin))]);
                if ($home) {
                    return redirect()->back()
                        ->with([
                            'tab' => 'home',
                            'status' => 'success',
                            'message' => $host->name . ' home address noted'
                        ]);
                }
            } catch (Exception $e) {
                return redirect()->back()->with([
                    'status'  => 'failure',
                    'message' => $e->getMessage()
                ]);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Host $host, Home $home)  {
        return view('host.home.show', compact('host', 'home'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Host $host, Home $home)  {
        return view('host.home.edit', compact('host', 'home'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Host $host, Home $home, Request $request)  {
        //dd($this->requestValidate($request));
        if (auth()->guard('host')->check()) {
            try {
                $newhome = $home->update($this->requestValidate($request) + ['host_id' => auth()->guard('host')->id(), 'slug' => (Str::slug($host->name.'-'.$request->district .'-'.$request->state.'-'.$request->pin))]);
                if ($newhome) {
                    return redirect()->route('hostprofile.index', [$host, $home])
                        ->with([
                            'tab' => 'home',
                            'status' => 'success',
                            'message' => $host->name . ' homeaddress updated successfully'
                        ]);
                }
            } catch (Exception $e) {
                return redirect()->back()->with([
                    'status'  => 'failure',
                    'message' => $e->getMessage()
                ]);
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

    private function requestValidate($request)  {
        return $request->validate([
            'complexName' => ['required', 'string', 'min:3', 'max:100'],
            'floor' => ['required', 'string', 'min:3', 'max:100'],
            'doorNo' => ['required', 'string', 'min:1', 'max:50'],
            'streetNo' => ['required', 'string', 'min:1', 'max:50'],
            'area' => ['required', 'string', 'min:3', 'max:100'],
            'district' => ['required', 'string', 'min:3', 'max:25'],
            'state' => ['required', 'string', 'min:3', 'max:100'],
            'pin' => ['required', 'string', 'min:6', 'max:9'],
            'zone' => ['required', 'string', 'min:3', 'max:50'],
            'reachus' => ['required', 'string', 'min:3', 'max:255']
        ]);
    }
}
