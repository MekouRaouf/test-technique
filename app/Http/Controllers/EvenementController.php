<?php

namespace App\Http\Controllers;

use App\Models\Evenement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class EvenementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $evenements = Evenement::orderBy("date_heure", 'desc')->get();

        return Inertia::render('Evenement/Index', [
            'evenements' => $evenements
        ]);
    }

    public function filter(Request $request){
        if($request->date_debut && !$request->date_fin)
        {
            $evenements = Evenement::where('date_heure', '>=', $request->date_debut)
                            ->orderBy("date_heure", 'desc')
                            ->get();
        }
        elseif(!$request->date_debut && $request->date_fin)
        {
            $evenements = Evenement::where('date_heure', '<=', $request->date_fin)
                            ->orderBy("date_heure", 'desc')
                            ->get();
        }
        elseif($request->date_debut && $request->date_fin)
        {
            $evenements = Evenement::where('date_heure', '>=', $request->date_debut)
                            ->where('date_heure', '<=', $request->date_fin)
                            ->orderBy("date_heure", 'desc')
                            ->get();
        }
        else
        {
            $evenements = Evenement::orderBy("date_heure", 'desc')->get();
        }

        return Inertia::render('Evenement/Index', [
            'evenements' => $evenements
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Evenement::create([
            'titre' => $request->titre,
            'date_heure' => $request->date_heure
        ]);

        return Redirect::route('evenements')->with('message', 'Evenement crée.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Evenement  $evenement
     * @return \Illuminate\Http\Response
     */
    public function show(Evenement $evenement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Evenement  $evenement
     * @return \Illuminate\Http\Response
     */
    public function edit(Evenement $evenement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Evenement  $evenement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Evenement $evenement)
    {
        $evenement = Evenement::find($evenement->id)->update([
            'titre' => $request->titre,
            'date_heure' => $request->date_heure
        ]);

        return Redirect::back()->with('success', 'Evenement modifié.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Evenement  $evenement
     * @return \Illuminate\Http\Response
     */
    public function destroy(Evenement $evenement)
    {
        $evenement->delete();

        return Redirect::back()->with('success', 'Evenement supprimé.');
    }

    public function restore(Evenement $evenement)
    {
        $evenement->restore();

        return Redirect::back()->with('success', 'Evenement restauré.');
    }
}
