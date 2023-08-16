<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    function EventPage() {
        return view('pages.dashboard.event-page');
    }

    function EventList(Request $request){
        $user_id=$request->header('id');
        return Event::where('user_id',$user_id)->get();
    }

    function EventCreate(Request $request) {
        $user_id=$request->header('id');
        return Event::create([
            'title' =>$request->input('title'),
            'description' =>$request->input('description'),
            'date' =>$request->input('date'),
            'time' =>$request->input('time'),
            'location' =>$request->input('location'),
            'user_id' => $user_id
        ]);
    }

    function EventDelete(Request $request) {
        $event_id = $request->input('id');
        $user_id=$request->header('id');
        return Event::where('id', $event_id)
        ->where('user_id', $user_id)
        ->delete();
    }

    function EventById(Request $request) {
        $event_id = $request->input('id');
        $user_id=$request->header('id');
        return Event::where('id', $event_id)
        ->where('user_id', $user_id)
        ->first();
    }

    function EventUpdate(Request $request) {
        $event_id = $request->input('id');
        $user_id=$request->header('id');
        return Event::where('id', $event_id)
        ->where('user_id', $user_id)
        ->update([
            'title' =>$request->input('title'),
            'description' =>$request->input('description'),
            'date' =>$request->input('date'),
            'time' =>$request->input('time'),
            'location' =>$request->input('location')
        ]);
    }
}
