<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Event;
use App\Club;
use App\Country;
use App\User;

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
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::find(Auth::user()->id);

        $memberedClubsEvents = [];
        $memberedClubs = $user->memberedClubs();
        if ($memberedClubs->count()) {
            foreach ($memberedClubs->get() as $club) {
                $events = $club->events();
                if ($events->count()) {
                    foreach ($club->events()->get() as $event) {
                        array_push($memberedClubsEvents, $event);
                    }
                }
            }
        }

        $administratedClubsEvents = [];
        $administratedClubs = $user->administratedClubs();
        if ($administratedClubs->count()) {
            foreach ($administratedClubs->get() as $club) {
                $events = $club->events();
                if ($events->count()) {
                    foreach ($club->events()->get() as $event) {
                        array_push($administratedClubsEvents, $event);
                    }
                }
            }
        }

        return view('events/index', [
            'memberedClubsEvents' => $memberedClubsEvents,
            'administratedClubsEvents' => $administratedClubsEvents,
        ]);
    }

    public function create($clubId = null, Request $request)
    {
        $club = null;
        $event = new Event();
        $user = User::find(Auth::user()->id);
        if (!empty($clubId)) {
            $club = $user->administratedClubs()->find($clubId);
            if (empty($club)) {
                return redirect('clubs')
                    ->with('status', 'Accès interdit');
            }
            $event->club_id = $club->id;
        }

        if ($request->isMethod('post')) {
            $clubIds = $user->administratedClubs()->pluck('id')->toArray();
            $this->validate($request, [
                'club_id' => 'bail|in:'.implode(',', $clubIds).'|required',
                'name' => 'bail|required',
                'start_date' => 'bail|required|date_format:Y-m-d H:i',
                'end_date' => 'bail|required|date_format:Y-m-d H:i',
                'address' => 'bail|required',
                'postcode' => 'bail|required',
                'city' => 'bail|required',
                'country_id' => 'bail|required',
                'max_participants' => 'bail|numeric|required',
                'description' => 'bail|required',
                'price' => 'bail|numeric|required',
            ]);
            $event->name = $request->input('name');
            $event->start_date = \DateTime::createFromFormat('Y-m-d H:i', $request->input('start_date'), new \DateTimeZone('Europe/Paris'));
            $event->end_date = \DateTime::createFromFormat('Y-m-d H:i', $request->input('end_date'), new \DateTimeZone('Europe/Paris'));
            $event->address = $request->input('address');
            $event->postcode = $request->input('postcode');
            $event->city = $request->input('city');
            $event->country_id = $request->input('country_id');
            $event->max_participants = $request->input('max_participants');
            $event->description = $request->input('description');
            $event->price = $request->input('price');
            $event->club_id = $request->input('club_id');
            $event->timezone = 'Europe/Paris'; // todo : définir le fuseau en fonction du client
            $event->save();
            return redirect('events/view/'.$event->id)
                ->with('status', 'Événement créé');
        }

        $countries = Country::all();
        return view('events/create', [
            'club' => $club,
            'clubs' => $user->administratedClubs()->get(),
            'event' => $event,
            'countries' => $countries,
        ]);
    }
}
