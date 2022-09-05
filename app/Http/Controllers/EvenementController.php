<?php

namespace App\Http\Controllers;

use App\Models\Evenement;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
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
        return Inertia::render('Evenement/Index', [
            'filters' => Request::all('search', 'trashed'),
            'evenements' => Evenement::all()
                ->orderBy('titre')
                ->filter(Request::only('search', 'trashed'))
                ->paginate(10)
                ->withQueryString()
                ->through(fn ($evenement) => [
                    'id' => $evenement->id,
                    'titre' => $evenement->titre,
                    'date_heure' => $evenement->date_heure,
                ]),
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
        Evenement::create(
            Request::validate([
                'titre' => ['required', 'max:100'],
                'date_heure' => ['nullable', 'max:50', 'email'],
            ])
        );

        return Redirect::route('evenements')->with('success', 'Evenement crée.');
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
        $evenement->update(
            Request::validate([
                'titre' => ['required', 'max:100'],
                'date_heure' => ['required', 'timestamp'],
            ])
        );

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
