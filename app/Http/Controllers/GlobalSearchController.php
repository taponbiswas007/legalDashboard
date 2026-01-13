<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Models\Addclient;
use App\Models\Addcase;

class GlobalSearchController extends Controller
{
  


public function Search(Request $request)
{
    $query = $request->get('q');
    
    $clients = Addclient::where('name', 'LIKE', "%{$query}%")
        ->get()
        ->map(function($client) {
            return [
                'id' => $client->id,
                'encrypted_id' => Crypt::encrypt($client->id), // ✅ Encrypt ID
                'name' => $client->name
            ];
        });

    $cases = Addcase::where('file_number', 'LIKE', "%{$query}%")
        ->orWhere('case_number', 'LIKE', "%{$query}%")
        ->orWhere('name_of_parties', 'LIKE', "%{$query}%")
        ->get()
        ->map(function($case) {
            return [
                'id' => $case->id,
                'encrypted_id' => Crypt::encrypt($case->id), // ✅ Encrypt ID
                'file_number' => $case->file_number,
                'case_number' => $case->case_number,
                'name_of_parties' => $case->name_of_parties
            ];
        });

    return response()->json([
        'clients' => $clients,
        'cases' => $cases
    ]);
}

}
