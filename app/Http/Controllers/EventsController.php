<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Event;

class EventsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = Event::orderBy('created_at', 'desc')->paginate(3);
        return view('events.index')->with('events', $events);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('events.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'event_image' => 'image|nullable|max:1999'
        ]);
        
        //Handle File Upload
        if($request->hasFile('event_image')){
            //Get filename with the extension
            $filenameWithExt = $request->file('event_image')->getClientOriginalName();
            //Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            //Get just ext
            $extension = $request->file('event_image')->getClientOriginalExtension();
            //Filename to Store
            $filenameToStore = $filename.'_'.time().'.'.$extension;
            //Upload Image
            $path = $request->file('event_image')->storeAs('public/event_images', $filenameToStore);
        } else{
            $fileNameToStore = 'noimage.jpg';
        }

        //Create Event
        $event = new Event();
        $event->name = $request->input('name');
        $event->description = $request->input('description');
        $event->user_id = auth()->user()->id;
        $event->event_image = $filenameToStore;
        $event->save();

        return redirect('/events')->with('success', 'Event Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $event = Event::find($id);
        return view('events.show')->with('event', $event);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $event = Event::find($id);

        if(auth()->user()->id !==$event->user_id){
            return redirect('/events')->with('error', 'Unauthorized Page');
        }

        return view('events.edit')->with('event', $event);
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
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required'
        ]);

        //Handle File Upload
        if($request->hasFile('event_image')){
            //Get filename with the extension
            $filenameWithExt = $request->file('event_image')->getClientOriginalName();
            //Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            //Get just ext
            $extension = $request->file('event_image')->getClientOriginalExtension();
            //Filename to Store
            $filenameToStore = $filename.'_'.time().'.'.$extension;
            //Upload Image
            $path = $request->file('event_image')->storeAs('public/event_images', $filenameToStore);
        }

        $event = Event::find($id);
        $event->name = $request->input('name');
        $event->description = $request->input('description');
        if($request->hasFile('event_image')){
            Storage::delete('public/event_images/' . $event->event_image);
            $event->event_image = $filenameToStore;
            
        }
        $event->save();

        return redirect('/events')->with('success', 'Event Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $event = Event::find($id);
        
        if(auth()->user()->id !==$event->user_id){
            return redirect('/events')->with('error', 'Unauthorized Page');
        }

        if($event->event_image != 'noimage.jpg'){
            //Delete Image
            Storage::delete('public/event_images/'.$event->event_image);
        }
    
        $event->delete();
        return redirect('/events')->with('success', 'Event Removed');
    }
}