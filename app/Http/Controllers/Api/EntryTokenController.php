<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\EntryToken;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Validator;
use Illuminate\Support\Facades\DB;

class EntryTokenController extends Controller
{
    public function search($id)
    {
        $date = Carbon::now();

        $entryToken = DB::table('entry_token')
            ->join('user', 'user.id_user', '=', 'entry_token.id_user')
            ->select('entry_token.*', 'user.*')
            ->where('entry_token.id_user', '=', $id)
            ->where('entry_token.status_token', '=', 'Active')
            ->first();

        if(!is_null($entryToken))
        {
            return response([
                'message' => 'Entry Token Has Been Retrieved',
                'data' => $entryToken
            ], 200);
        }

        return response([
            'message' => 'Entry Token Cannot Be Retrieved',
            'data' => null
        ], 404);
    }

    public function add(Request $request)
    {
        $updateData = $request->all();

        $User = User::find($updateData['id_user']);

        if(is_null($User))
        {
            return response([
                'message' => 'User Not Found',
                'data' => null
            ], 404);
        }

        $date = Carbon::now();

        $entryTokens = DB::table('entry_token')
            ->join('user', 'user.id_user', '=', 'entry_token.id_user')
            ->select('entry_token.*', 'user.*')
            ->where('user.id_user', '=', $updateData['id_user'])
            ->where('entry_token.status_token', '=', 'Active')
            ->first();

        DB::table('entry_token')
            ->where('id_user', '=', $updateData['id_user'])
            ->where('status_token', '=', 'Active')
            ->update(['status_token' => 'Inactive']);

        $storeData = [
            'id_user' => $updateData['id_user'],
            'tanggal_pembuatan_token' => Carbon::now(),
            'entry_code' =>  Str::random(64),
            'status_token' => 'Active',
        ];

        $entryToken = EntryToken::create($storeData);
        
        return response
        (
            [
                'message' => 'Entry Token Added Successfully',
                'data' => $entryToken,
            ], 200);
    }
}