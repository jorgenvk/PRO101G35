<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Bedrift;
use App\Kategori;
use App\Ratings;
use Storage;

class BedriftController extends Controller
{

    public function pageLeggTilBedrift()
    {
    	// Henter alle kategorier;
    	$kategorier = Kategori::all();

    	return view ('bedrift.ny', compact('kategorier'));
    }

    public function listBedrifter() 
    {

    	$bedrifter = Bedrift::all();

        $kategorier = Kategori::all();



    	return view ('bedrift.list', compact('bedrifter', 'kategorier'));
    }

    public function postNyBedrift(Request $request)
    {
    	// TO-DO legge til Validator, sørge for at form-data er gyldig, osv.
        if ($request->hasFile('fil'))
            {
                if ($s3upload = Storage::disk('s3')->putFile('', $request->file('fil'), 'public'))
                    {
                        // Profilbildet *ble* laset opp, opprett bedrift;
                        $bedrift = New Bedrift;
                        $bedrift->Bedrift_navn  = $request->Navn;
                        $bedrift->Kategori_id   = $request->Kategori;
                        $bedrift->Adresse       = $request->Adresse;
                        $bedrift->Telefon       = $request->Telefon;
                        $bedrift->Beskrivelse   = $request->Beskrivelse;
                        $bedrift->Åpningstider  = $request->Åpningstider;
                        $bedrift->Nettside      = $request->Nettside;
                        $bedrift->Bilde         = Storage::disk('s3')->url($s3upload);

                        $bedrift->save();                        
                    }
                else
                    {
                        // Profilbildet ble IKKE lastet opp
                        return "Feil ved opplasting av bilde til server :-(";
                    }
            }
        else
            {
                // Mangler bilde!
                return "Men kjære deg... du må laste opp et bilde av bedriften din!";
            }

        //Tilbakemelding på at bedrift ble lagt til?
		return redirect()->back();
    }


    // Sorteringsfunksjon. sorterer på kategori 
    public function sort($filter) 
    {
        if($filter == 'Uteliv') {
            $bedrifter = Bedrift::where('Kategori_id', '=', '1')->get();
        }
        else if($filter == 'Butikker') {
            $bedrifter = Bedrift::where('Kategori_id', '=', '2')->get();
        }
        else if($filter == 'Kollektiv') {
            $bedrifter = Bedrift::where('Kategori_id', '=', '3')->get();
        }
        else if($filter == 'Helse') {
            $bedrifter = Bedrift::where('Kategori_id', '=', '4')->get();
        }
        else if($filter == 'Trening') {
            $bedrifter = Bedrift::where('Kategori_id', '=', '5')->get();
        }

        $kategorier = Kategori::all();

        return view ('bedrift.list', compact('bedrifter', 'kategorier'));
    }

    public function admin() 
    {

        $bedrifter = Bedrift::all();

        $kategorier = Kategori::all();



        return view ('bedrift.adminlist', compact('bedrifter', 'kategorier'));
    }

    public function delete($id) 
    {
        Ratings::where('bedriftid', $id)->delete();
        Bedrift::where('id', $id)->delete();


        return redirect()->back();
    }

}
