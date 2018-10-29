<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Event;
use App\Club;
use App\Country;
use App\User;
use App\AnonymousUser;
use App\Notifications\EventSubscribeNotification;
use App\Notifications\EventUnsubscribeNotification;
use Illuminate\Support\Facades\Notification;

class EventsController extends Controller
{
    private $recurrences = [
        'weekly' => 'Hebdomadaire',
        'monthly' => 'Mensuel',
    ];
    private $intervals = [
        'weekly' => 'P#W',
        'monthly' => 'P#M',
    ];

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
            'user' => $user,
            'memberedClubsEvents' => $memberedClubsEvents,
            'administratedClubsEvents' => $administratedClubsEvents,
        ]);
    }

    public function view($eventId)
    {
        $event = Event::find($eventId);
        $user = User::find(Auth::user()->id);
        if (!$club = $user->memberedClubs()->find($event->club_id)) {
            return redirect()
                ->route('events')
                ->with('status', 'Accès interdit');
        }

        return view('events/view', [
            'event' => $event,
            'user' => $user,
        ]);
    }

    public function delete($eventId) {
        $user = User::find(Auth::user()->id);
        $event = Event::find($eventId);
        if (!$club = $user->administratedClubs()->find($event->club_id)) {
            return redirect()
                ->route('events.view', ['eventId' => $eventId])
                ->with('status', 'Accès interdit');
        }
        $event->delete();
        return redirect()
            ->route('events')
            ->with('status', 'Événement supprimé');
    }

    public function edit($eventId = null, Request $request)
    {
        $event = null;
        $club = null;
        $user = User::find(Auth::user()->id);
        if (!empty($eventId)) {
            $event = Event::find($eventId);
            if (empty($event) || !$club = $user->administratedClubs()->find($event->club_id)) {
                return redirect()
                    ->route('events.view', ['eventId' => $eventId])
                    ->with('status', 'Accès interdit');
            }
        } else {
            $event = new Event();
        }

        if ($request->isMethod('post')) {
            $clubIds = $user->administratedClubs()->pluck('id')->toArray();
            $this->validate($request, [
                'club_id' => 'bail|in:'.implode(',', $clubIds).'|required',
                'name' => 'bail|required',
                'start_date' => 'bail|required|date_format:Y-m-d H:i',
                'end_date' => 'bail|required|date_format:Y-m-d H:i',
                'recurrence' => 'bail|in:'.implode(',', array_keys($this->recurrences)),
                'recurrence_end_date' => 'bail|required_with:recurrence|date_format:Y-m-d',
                'address' => 'bail|required',
                'postcode' => 'bail|required|max:10',
                'city' => 'bail|required',
                'country_id' => 'bail|required',
                'max_participants' => 'bail|numeric|required',
                'description' => 'bail|required',
                'price' => 'bail|numeric|required',
            ]);

            $event->name = $request->input('name');
            $oldStartDate = $event->exists ? $event->start_date : null;
            $oldEndDate = $event->exists ? $event->end_date : null;
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

            if (
                (!$event->exists && empty($request->input('recurrence')))
                || ($event->exists && empty($request->input('change_all_occurrences')))
            ) {
                $event->recurrence = null;
                $event->recurrence_hash = null;
                $event->recurrence_end_date = null;
                $event->save();
            } else {
                if (!$event->exists) {
                    $event->recurrence = $request->input('recurrence');
                    $event->recurrence_hash = str_random(64);
                    $event->recurrence_end_date = \DateTime::createFromFormat('Y-m-d', $request->input('recurrence_end_date'), new \DateTimeZone('Europe/Paris'));
                    $event->save();

                    $currentDate = $event->start_date->add(new \DateInterval(str_replace('#', 1, $this->intervals[$event->recurrence])));
                    $number = 1;
                    while ($currentDate <= $event->recurrence_end_date) {
                        $interval = new \DateInterval(str_replace('#', $number, $this->intervals[$event->recurrence]));
                        $recurrentEvent = $event->replicate();
                        $recurrentEvent->start_date = $recurrentEvent->start_date->add($interval);
                        $recurrentEvent->end_date = $recurrentEvent->end_date->add($interval);
                        $recurrentEvent->save();
                        $currentDate->add(new \DateInterval(str_replace('#', 1, $this->intervals[$event->recurrence])));
                        $number++;
                    }
                } else {
                    $recurrentEvents = Event::where('recurrence_hash', $event->recurrence_hash)
                        ->where('start_date', '>=', $oldStartDate)
                        ->get();
                    $startDateInterval = date_diff($oldStartDate, $event->start_date);
                    $endDateInterval = date_diff($oldEndDate, $event->end_date);
                    $recurrenceHash = str_random(64);
                    if ($recurrentEvents->count() > 0) {
                        foreach ($recurrentEvents as $recurrentEvent) {
                            $recurrentEvent->name = $event->name;
                            $recurrentEvent->start_date = $recurrentEvent->start_date->add($startDateInterval);
                            $recurrentEvent->end_date = $recurrentEvent->end_date->add($endDateInterval);
                            $recurrentEvent->address = $event->address;
                            $recurrentEvent->postcode = $event->postcode;
                            $recurrentEvent->city = $event->city;
                            $recurrentEvent->country_id = $event->country_id;
                            $recurrentEvent->max_participants = $event->max_participants;
                            $recurrentEvent->description = $event->description;
                            $recurrentEvent->price = $event->price;
                            $recurrentEvent->club_id = $event->club_id;
                            $recurrentEvent->timezone = 'Europe/Paris';
                            $recurrentEvent->recurrence_hash = $recurrenceHash;
                            $recurrentEvent->save();
                        }
                    }
                }
            }
            return redirect()
                ->route('events.view', ['eventId' => $event->id])
                ->with('status', 'Événement créé');
        }

        $countries = Country::all();
        return view('events/edit', [
            'club' => $club,
            'clubs' => $user->administratedClubs()->get(),
            'event' => $event,
            'countries' => $countries,
            'recurrences' => $this->recurrences,
        ]);
    }

    public function participate($eventId, $participate)
    {

        $event = Event::find($eventId);
        $user = User::find(Auth::user()->id);
        if (!$club = $user->memberedClubs()->find($event->club_id)) {
            return redirect()
                ->route('events')
                ->with('status', 'Accès interdit');
        }

        $participantsCount = $event->participants()->count() + $event->anonymousParticipants()->count();
        if ($participantsCount < $event->max_participants && !empty($participate) && !$event->participants->contains($user->id)) {
            $event->participants()->attach($user->id);
            Notification::send($club->administrators, new EventSubscribeNotification());
            return redirect()
                ->route('events.view', ['eventId' => $eventId])
                ->with('status', 'Vous participez à cet événement');
        } elseif (empty($participate) && $event->participants->contains($user->id)) {
            $event->participants()->detach($user->id);
            Notification::send($club->administrators, new EventUnsubscribeNotification());
        }
        return redirect()
            ->route('events.view', ['eventId' => $eventId])
            ->with('status', 'Vous ne participez plus à cet événement');
    }

    public function subscribeAnonymous($eventId, Request $request)
    {
        $event = Event::find($eventId);
        $user = User::find(Auth::user()->id);
        if (!$club = $user->administratedClubs()->find($event->club_id)) {
            return redirect()
                ->route('events')
                ->with('status', 'Accès interdit');
        }

        $anonymousParticipants = $event->anonymousParticipants()->pluck('id')->toArray();
        $anonymousUserIds = $club->anonymousMembers()->whereNotIn('id', $anonymousParticipants)->pluck('id')->toArray();
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'id' => 'bail|required|in:'.implode(',', $anonymousUserIds),
            ]);
            $event->anonymousParticipants()->attach($request->input('id'));
            return redirect()
                ->route('events.view', ['eventId' => $event->id])
                ->with('status', 'Vous avez ajouté un membre non enregistré à l\'événement');
        }

        return view('events/subscribeAnonymous', [
            'event' => $event,
            'anonymousUsers' => AnonymousUser::whereIn('id', $anonymousUserIds)->get(),
        ]);
    }

    public function unsubscribeAnonymous($eventId, $anonymousUserId, Request $request)
    {
        $event = Event::find($eventId);
        $user = User::find(Auth::user()->id);
        if (!$club = $user->administratedClubs()->find($event->club_id)) {
            return redirect()
                ->route('events')
                ->with('status', 'Accès interdit');
        }

        $event->anonymousParticipants()->detach($anonymousUserId);
        return redirect()
            ->route('events.view', ['eventId' => $event->id])
            ->with('status', 'Vous avez retiré un membre non enregistré de l\'événement');
    }
}
