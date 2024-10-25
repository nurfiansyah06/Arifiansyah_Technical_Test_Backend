<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\Penalties;
use App\Models\User;
use Illuminate\Http\Request;
use Validator;

class SalesPersonController extends Controller
{
    public function updateSalesperson(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'salesperson_id' => 'required',
        ]);

        if ($validator->fails()) {
            return Helpers::failed(null, $validator->errors()->first(), 400);
        }

        $lead = Lead::find($id);
        if ($lead === null) {
            return Helpers::failed(null, 'Leads tidak valid', 400);
        }
         
        $sales = User::find($request->salesperson_id);
        if (!$sales->hasRole('salesperson')) {
            return Helpers::failed(null, 'User harus menjadi salesperson', 400);
        }

        $penalty = Penalties::where('salesperson_id', $request->salesperson_id)->where('is_exists', true)->first();
        if ($penalty !== null) {
            return Helpers::failed(null, 'User masih mendapatkan penalti', 400);
        }

        $lead->salesperson_id = $request->salesperson_id;
        $lead->save();
    
        return Helpers::success($request->all(), 'Update Salesperson Leads Berhasil', 200);
    }

    public function assignPenaltyToSalesperson(Request $request) {
        $validator = Validator::make($request->all(), [
            'end_date' => 'required|date|after:start_date',
            'salesperson_id' => 'required',
        ]);
    
        if ($validator->fails()) {
            return Helpers::failed(null, $validator->errors()->first(), 400);
        }

        $sales = User::find($request->salesperson_id);
        if (!$sales->hasRole('salesperson')) {
            return Helpers::failed(null, 'User harus menjadi salesperson', 400);
        }

        $penalty = new Penalties;
        $penalty->start_date = now();
        $penalty->end_date = $request->end_date;
        $penalty->salesperson_id = $request->salesperson_id;
        $penalty->reason = $request->reason;
        $penalty->is_exists = true;
        $penalty->save();
    
        return Helpers::success($request->all(), 'Assign Penalty Salesperson Berhasil', 200);
    }

    public function removePenaltyFromSalesperson($id) {
        $penalty = Penalties::find($id);
        if ($penalty === null) {
            return Helpers::failed(null, 'Penalty tidak valid', 400);
        }
    
        $penalty->is_exists = false;
        $penalty->save();
    
        return Helpers::success(null, 'Remove Penalty Salesperson Berhasil', 200);
    }

    public function allSalesperson() {
        $salespersons = User::role('salesperson')->get();

        return Helpers::success($salespersons, 'Get Salesperson Berhasil', 200);
    }
}
