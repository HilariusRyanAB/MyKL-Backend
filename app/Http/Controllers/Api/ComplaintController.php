<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Complaint;
use App\Billing;
use App\Properti;
use Validator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ComplaintController extends Controller
{
    //Mobile App
    public function read($id)
    {
        $complaints = DB::table('complaint')
        ->join('user', 'user.id_user', '=', 'complaint.id_user')
        ->join('properti', 'properti.id_properti', '=', 'complaint.id_properti')
        ->select('complaint.*', 'user.*', 'properti.*')
        ->where('complaint.id_user', '=', $id)
        ->where('complaint.status_complaint', '<>', 'Deleted')
        ->get();

        if(count($complaints) > 0)
        {
            return response
            (
                [
                    'message' => 'All Complaint Has Been Retrieved',
                    'data' => $complaints
                ], 200); 
        }

        return response
        (
            [
                'message' => 'All Complaint Cannot Be Retrieved',
                'data' => null
            ], 404);
    }

    public function search($id)
    {
        $complaint = DB::table('complaint')
        ->join('user', 'user.id_user', '=', 'complaint.id_user')
        ->join('properti', 'properti.id_properti', '=', 'complaint.id_properti')
        ->select('complaint.*', 'user.*', 'properti.*')
        ->where('complaint.id_complaint', '=', $id)
        ->first();

        if(!is_null($complaint))
        {
            return response
            (
                [
                    'message' => 'Complaint Has Been Retrieved',
                    'data' => $complaint
                ], 200); 
        }

        return response
        (
            [
                'message' => 'Complaint Cannot Be Retrieved',
                'data' => null
            ], 404);
    }

    public function add(Request $request)
    {
        $storeData = $request->all();
        $validate = Validator::make($storeData,
        [
            'id_user' => 'required',
            'id_properti' => 'required',
            'topic_complaint' => 'required|string',
            'detail_complaint' => 'required',
            'tanggal_complaint' => 'required|string',
            'status_complaint' => 'required',
        ]);

        if($validate->fails())
        {
            return response(['message' => $validate->errors()], 400);
        }
        
        $property = Properti::find($storeData['id_properti']);
        
        if($property->jumlah_denda > 0)
        {
            return response
            (
                [
                    'message' => 'Complaint Cannot Be Added, Please Pay the Bill First',
                    'data' => null
                ], 404);
        }
        
        $complaint = Complaint::create($storeData);
        return response
        (
            [
                'message' => 'Complaint Added Successfully',
                'data' => $complaint,
            ], 200);
    }

    public function edit(Request $request, $id)
    {
        $complaint = Complaint::find($id);

        if(is_null($complaint))
        {
            return response([
                'message' => 'Complaint Not Found',
                'data' => null
            ], 404);
        }
        
        $property = Properti::find($complaint->id_properti);
        
        if($property->jumlah_denda == 0)
        {
            $updateData = $request->all();
            $validate = Validator::make($updateData,
            [
                'topic_complaint' => 'required|string',
                'detail_complaint' => 'required',
            ]);
    
            if($validate->fails())
            {
                return response(['message' => $validate->errors()], 400);
            }
    
            $complaint->topic_complaint = $updateData['topic_complaint'];
            $complaint->detail_complaint = $updateData['detail_complaint'];
    
            if($complaint->save())
            {
                return response(
                    [
                        'message' => 'Complaint Has Been Updated',
                        'data' => $complaint,
                    ], 200);
            }
    
            return response(
                [
                    'message' => 'Complaint Cannot Be Updated',
                    'data' => null,
                ], 400);
        }
        
        return response
        (
            [
                'message' => 'Complaint Cannot Be Updated, Please Pay the Bill First',
                'data' => null
            ], 404);
    }
    
    public function delete($id)
    {
        $complaint = Complaint::find($id);

        if(is_null($complaint))
        {
            return response([
                'message' => 'Complaint Not Found',
                'data' => null
            ], 404);
        }

        $complaint->status_complaint = 'Deleted';

        if($complaint->save())
        {
            return response(
                [
                    'message' => 'Complaint Has Been Deleted',
                    'data' => $complaint,
                ], 200);
        }

        return response(
            [
                'message' => 'Complaint Cannot Be Deleted',
                'data' => null,
            ], 400);
    }
}