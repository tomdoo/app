<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use App\User;
use App\Club;
use App\ClubType;
use App\Country;
use App\ClubPhoto;
use App\AnonymousUser;

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
            return redirect()
                ->route('clubs.view', [$club->id])
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
        $club = $user->administratedClubs()->find($clubId);
        if (empty($club)) {
            return redirect()
                ->route('clubs')
                ->with('status', 'Accès interdit');
        }

        if ($request->isMethod('post')) {
            $this->validate($request, [
                'name' => 'bail|required',
                'club_type_id' => 'bail|required|numeric',
                'description' => 'bail|nullable',
                'owner_alias' => 'bail|nullable',
                'address' => 'bail|nullable',
                'postcode' => 'bail|nullable',
                'city' => 'bail|nullable',
                'country_id' => 'bail|nullable',
                'phone' => 'bail|nullable|numeric',
                'access_code' => 'bail|nullable|alpha_num',
            ]);
            $club->name = $request->input('name');
            $club->club_type_id = $request->input('club_type_id');
            $club->description = $request->input('description');
            $club->owner_alias = $request->input('owner_alias');
            $club->address = $request->input('address');
            $club->postcode = $request->input('postcode');
            $club->city = $request->input('city');
            $club->country_id = $request->input('country_id');
            $club->phone = $request->input('phone');
            $club->access_code = $request->input('access_code');
            $club->save();
            return redirect()
                ->route('clubs.view', [$club->id])
                ->with('status', 'Club créé');
        }

        $clubTypes = ClubType::all();
        $countries = Country::all();
        return view('clubs/edit', [
            'club' => $club,
            'clubTypes' => $clubTypes,
            'countries' => $countries,
        ]);
    }

    public function addPhoto($clubId, Request $request)
    {
        $user = User::find(Auth::user()->id);
        $club = $user->administratedClubs()->find($clubId);
        if (empty($club)) {
            return redirect()
                ->route('clubs')
                ->with('status', 'Accès interdit');
        }

        if ($request->isMethod('post')) {
            $this->validate($request, [
                'file' => 'bail|image|required', // todo : validate file size
            ]);
            if ($request->file('file')->isValid()) {
                $clubPhoto = new ClubPhoto();
                $clubPhoto->club_id = $club->id;
                $clubPhoto->file = $request->file('file')->store('clubPhotos');
                $clubPhoto->save();
                return redirect()
                    ->route('clubs.view', [$club->id])
                    ->with('status', 'Photo ajoutée');
            }
        }
        return redirect()
            ->route('clubs.view', [$club->id])
            ->with('status', 'Erreur lors de l\'ajout de la photo');
    }

    public function deletePhoto($photoId, Request $request)
    {
        $clubPhoto = ClubPhoto::find($photoId);
        $user = User::find(Auth::user()->id);
        $club = $user->administratedClubs()->find($clubPhoto->club_id);
        if (empty($club)) {
            return redirect()
                ->route('clubs')
                ->with('status', 'Accès interdit');
        }
        $clubPhoto->delete();
        return redirect()
            ->route('clubs.view', [$club->id])
            ->with('status', 'Erreur lors de l\'ajout de la photo');
    }

    public function setPrimaryPhoto($primaryClubPhotoId, Request $request)
    {
        $clubPhoto = ClubPhoto::find($primaryClubPhotoId);
        $user = User::find(Auth::user()->id);
        $club = $user->administratedClubs()->find($clubPhoto->club_id);
        if (empty($club)) {
            return redirect()
                ->route('clubs')
                ->with('status', 'Accès interdit');
        }

        $clubPhotos = ClubPhoto::where(['club_id' => $club->id])->get();
        foreach ($clubPhotos as $clubPhoto) {
            if ($clubPhoto->id != $primaryClubPhotoId && $clubPhoto->primary) {
                $clubPhoto->primary = false;
            } elseif ($clubPhoto->id == $primaryClubPhotoId) {
                $clubPhoto->primary = true;
            } else {
                continue;
            }
            $clubPhoto->save();
        }
        return redirect()
            ->route('clubs.view', [$club->id]);
    }

    public function getPhoto($clubPhotoId, Request $request)
    {
        $clubPhoto = ClubPhoto::find($clubPhotoId);
        $user = User::find(Auth::user()->id);
        $club = $user->memberedClubs()->find($clubPhoto->club_id);
        if (empty($club)) {
            return redirect()
                ->route('clubs')
                ->with('status', 'Accès interdit');
        }
        if (!empty($clubPhoto)) {
            return response()->file(Storage::path($clubPhoto->file));
        }
    }

    public function addAdministrator($clubId, Request $request)
    {
        $user = User::find(Auth::user()->id);
        $club = $user->ownedClubs()->find($clubId);
        if (empty($club)) {
            return redirect()
                ->route('clubs')
                ->with('status', 'Accès interdit');
        }

        if ($request->isMethod('post')) {
            $this->validate($request, [
                'user_id' => 'bail|numeric|required',
            ]);
            if (empty($club->administrators()->find($request->input('user_id')))) {
                $club->users()->attach($request->input('user_id'), ['role' => 'administrator']);
                return redirect()
                    ->route('clubs.view', [$club->id])
                    ->with('status', 'Administrateur ajouté');
            } else {
                return redirect()
                    ->route('clubs.view', [$club->id])
                    ->with('status', 'Déjà administrateur');
            }
        }
        return redirect()
            ->route('clubs.view', [$club->id])
            ->with('status', 'Erreur lors de l\'ajout de la photo');
    }

    public function delete($clubId)
    {
        $user = User::find(Auth::user()->id);
        $club = $user->ownedClubs()->find($clubId);
        $club->delete();
        return redirect()
            ->route('clubs')
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
                if (empty($club->members()->find($user->id))) {
                    $club->users()->attach($user->id, ['role' => 'member']);
                    return redirect()
                        ->route('clubs.view', [$club->id])
                        ->with('status', 'Bienvenue au club "'.$club->name.'"');
                } else {
                    return redirect()
                        ->route('clubs.view', [$club->id])
                        ->with('status', 'Déjà membre du club "'.$club->name.'"');
                }
            } else {
                return redirect()
                    ->route('clubs')
                    ->with('status', 'Aucun club n\'a été trouvé');
            }
        }
        return redirect()
            ->route('clubs.member');
    }

    public function addAnonymousMember($clubId, Request $request)
    {
        $user = User::find(Auth::user()->id);
        $club = $user->administratedClubs()->find($clubId);
        if (empty($club)) {
            return redirect()
                ->route('clubs')
                ->with('status', 'Accès interdit');
        }

        if ($request->isMethod('post')) {
            $this->validate($request, [
                'firstname' => 'bail|required',
                'lastname' => 'bail|required',
                'phone' => 'bail|nullable|min:10',
                'email' => 'bail|nullable|email',
            ]);
            $anonymousUser = new AnonymousUser();
            $anonymousUser->firstname = $request->input('firstname');
            $anonymousUser->lastname = $request->input('lastname');
            $anonymousUser->phone = $request->input('phone');
            $anonymousUser->email = $request->input('email');
            $anonymousUser->club_id = $club->id;
            $anonymousUser->save();
            return redirect()
                ->route('clubs.view', ['clubId' => $club->id])
                ->with('status', 'Membre non enregistré ajouté');
        }

        return view('clubs/addAnonymousMember', [
            'club' => $club,
        ]);
    }
}
