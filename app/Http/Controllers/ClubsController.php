<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\User;
use App\Club;
use App\ClubType;

class ClubsController extends Controller
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
        $memberedClubs = $user->memberedClubs()->get();
        $ownedClubs = $user->ownedClubs()->get();
        return view('clubs/index', [
            'memberedClubs' => $memberedClubs,
            'ownedClubs' => $ownedClubs,
        ]);
    }

    public function view($clubId)
    {
        $user = User::find(Auth::user()->id);
        $club = $user->clubs()->find($clubId);
        return view('clubs/view', [
            'club' => $club,
            'user' => $user,
        ]);
    }

    public function create(Request $request)
    {
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'name' => 'bail|required',
                'club_type_id' => 'bail|required|numeric',
            ]);
            $user = User::find(Auth::user()->id);
            $club = new Club();
            $club->name = $request->input('name');
            $club->club_type_id = $request->input('club_type_id');
            $club->save();
            $club->users()->attach($user->id, ['role' => 'owner']);
            return redirect('clubs/view/'.$club->id)
                ->with('status', 'Club créé');
        }

        $clubTypes = ClubType::all();
        return view('clubs/create', [
            'clubTypes' => $clubTypes,
        ]);
    }

    public function edit($clubId, Request $request)
    {
        $user = User::find(Auth::user()->id);
        $club = $user->ownedClubs()->find($clubId);

        if ($request->isMethod('post')) {
            $this->validate($request, [
                'name' => 'bail|required',
                'access_code' => 'bail|nullable|alpha_num',
                'club_type_id' => 'bail|required|numeric',
            ]);
            $club->name = $request->input('name');
            $club->access_code = $request->input('access_code');
            $club->club_type_id = $request->input('club_type_id');
            $club->save();
            return redirect('clubs/view/'.$club->id)
                ->with('status', 'Club créé');
        }

        $clubTypes = ClubType::all();
        return view('clubs/edit', [
            'club' => $club,
            'clubTypes' => $clubTypes,
        ]);
    }

    public function delete($clubId)
    {
        $user = User::find(Auth::user()->id);
        $club = $user->ownedClubs()->find($clubId);
        $club->delete();
        return redirect('clubs')
            ->with('status', 'Club supprimé');
    }

    public function member(Request $request)
    {
        $user = User::find(Auth::user()->id);
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'access_code' => 'bail|required|alpha_num',
            ]);
            $club = Club::where('access_code', $request->input('access_code'))
                ->first();
            if (!empty($club)) {
                $club->users()->attach($user->id, ['role' => 'member']);
                return redirect('clubs')
                    ->with('status', 'Bienvenue au club "'.$club->name.'"');
            } else {
                return redirect('clubs')
                    ->with('status', 'Aucun club n\'a été trouvé');
            }
        }
        return view('clubs/member');
    }
}
