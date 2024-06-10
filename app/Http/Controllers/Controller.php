<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

abstract class Controller
{
    public function can($action, $module){
      $can =  DB::table('roles')
            ->join('actions', 'actions.id', '=', 'roles.action_id')
            ->join('modules', 'modules.id', '=', 'roles.module_id')
            ->join('user_roles', 'user_roles.role_id', '=', 'roles.id')
            ->where('action_name', $action)
            ->where('module_name', $module)
            ->where('user_roles.user_id', auth()->user()->id)
            ->count();

            if ( $can >= 1){
                return 'can';
            }else{
                return 'denied';
            }
    }
}
