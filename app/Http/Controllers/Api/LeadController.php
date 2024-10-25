<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Mail\UserAddedMail;
use App\Models\Lead;
use App\Models\LeadDistribution;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Log;
use Mail;
use Str;
use Validator;

class LeadController extends Controller
{
    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
        ]);

        if ($validator->fails()) {
            return Helpers::failed(null, $validator->errors()->first(), 400);
        }
    
        $user = Auth::user();
        $role = $user->roles()->first();
    
        if (!$role || $role->name != "customerservice") {
            return Helpers::failed(null, 'Unauthorized', 401);
        }

        $userCS = User::where('email', $request->email)->where('role', 'client');

        if (!$userCS->exists()) {
            return Helpers::failed(null, 'Email tidak terdaftar', 404);
        }
    
        $lead = new Lead;
        $lead->name = $request->name;
        $lead->email = $request->email;
        $lead->phone = $request->phone;
        $lead->status = 'new_leads';
        $lead->notes = $request->notes;
        $lead->img = $request->img;
        $lead->salesperson_id = $userCS->first()->id;
        $lead->user_id = $user->id;
        $lead->save();

        $leadDistribution = new LeadDistribution;
        $leadDistribution->lead_id = $lead->id;
        $leadDistribution->salesperson_id = $userCS->first()->id;
        $leadDistribution->save();

        Redis::del("lead:{$lead->id}");
    
        return Helpers::success($lead, 'Pembuatan Leads Berhasil', 201);
    }

    public function updateStatus(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return Helpers::failed(null, $validator->errors()->first(), 400);
        }

        $userAuth = Auth::user();
        if ($userAuth->hasRole(['superadmin','customerservice']) && in_array($request->status, ["follow_up_leads", "follow_up_final"]) ) {
            $lead = Lead::find($id);
            if ($lead === null) {
                return Helpers::failed(null, 'Leads tidak valid', 400);
            }

            $lead->status = $request->status;
            $lead->save();

            return Helpers::success($request->all(), 'Update Status Leads Berhasil', 200);
        } elseif ($userAuth->hasRole(['superadmin','salesperson'])) {
            if (in_array($request->status, ["survey_request", "survey_rejected", "survey_approved"])) {
                $lead = Lead::find($id);
                if ($lead === null) {
                    return Helpers::failed(null, 'Leads tidak valid', 400);
                }
    
                $lead->status = $request->status;
                $lead->save();

                return Helpers::success($request->all(), 'Update Status Leads Berbayar', 200);
            } elseif ($request->status == "deal") {
                $lead = Lead::find($id);
                if ($lead === null) {
                    return Helpers::failed(null, 'Leads tidak valid', 400);
                }

                $user = User::create([
                    'name' => $lead->name,
                    'username' => Str::random(10),
                    'email' => $lead->email,
                    'password' => bcrypt(Str::random(8)),
                    'img' => $lead->img,
                ]);

                $user->assignRole('client');
                $user->save();
    
                $lead->status = $request->status;
                $lead->save();

                $data = [
                    'leads' => $lead,
                    'user' => $user,
                ];

                Mail::to($lead->email)->send(new UserAddedMail($user));
    
                return Helpers::success($data, 'Update Status Leads Berbayar', 200);
            
            }
        } 
        
        return Helpers::failed(null, 'Unauthorized', 401);
        
    }

    public function show($id) {
        $getData = Redis::get("lead:{$id}");
        if ($getData) {
            return Helpers::success(json_decode($getData), 'Get Data Leads Berhasil', 200);
        } else {
            $lead = Lead::find($id);
            Redis::set("lead:{$id}", json_encode($lead));
            return Helpers::success($lead, 'Get Data Leads Berhasil', 200);
        }
    }
}
