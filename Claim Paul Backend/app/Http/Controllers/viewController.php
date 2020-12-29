<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class viewController extends Controller
{
    public function driverHistoryShow()
    {
        
        return DB::table('policy_holders')
         ->join('vehicles','vehicles.policyPid','policy_holders.pId')
         ->join('reports','reports.vehicleNumber','vehicles.vehicleNumber')
         ->select('policy_holders.pId','policy_holders.NIC','policy_holders.fName','policy_holders.lName',
         'policy_holders.pAddress','policy_holders.pDOB','policy_holders.pContactNo',
         'vehicles.vehicleNumber','reports.rId','reports.rDescription','reports.rCost','reports.rDate',
         'reports.place','reports.adminId','reports.agId','reports.isAccepted')->where('policy_holders.isDeleted','=','0')->get();
    }

    public function policyHolderShow()
    {
        return DB::table('policy_holders')->join(
            'vehicles','vehicles.policyPid','policy_holders.pId')
            ->select('policy_holders.pId','policy_holders.NIC','policy_holders.fName','policy_holders.lName',
            'policy_holders.pAddress','policy_holders.pDOB','policy_holders.pContactNo','policy_holders.isDeleted',
            'vehicles.vehicleNumber')->where('policy_holders.isDeleted','=','0')->get();
    }
   
    public function agentsShow()
    {
        return DB::table('agents')->select('agents.agId','agents.fName','agents.lName','agents.agAddress','agents.agDob',
        'agents.agContactNo','agents.email','agents.agBranch')->where('agents.isDeleted','=','0')->get();
    }
    
    public function getHistory($email)
    {
        return  $vehicle = DB::table('vehicles')->where('vId', '=', $id)->get();

            return response()->json(['vehicle'=>$vehicle],200);

    }
    //get vehicle numbers according to nic
    public function getVehicleNumbers($nic)
    {
        $item=$item=DB::table('policy_holders')->where('NIC', $nic)->exists();
        if(!$item)
        {
            return response()->json(['msg'=>'this record is not found'],404);
        }
        else
        {
            $record = DB::table('policy_holders')->join(
                'vehicles','vehicles.policyPid','policy_holders.pId')
                ->select('vehicles.vehicleNumber')->where('policy_holders.NIC','=',$nic)->get();

            return response()->json(['vehicle'=>$record],200);

        }
    }

    public function aAgentShow($email)
    {
        return DB::table('agents')->select('agents.*')->where('agents.email', '=', $email)->get();

    }
    public function aAdminShow($email)
    {
        return DB::table('admins')->select('admins.*')->where('admins.adminEmail', '=', $email)->get();

    }

    public function aPolicyholderShow($email)
    {
        return DB::table('policy_holders')->select('policy_holders.*')->where('policy_holders.policyholder_email', '=', $email)->get();

    }
    
}
