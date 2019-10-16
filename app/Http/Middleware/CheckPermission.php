<?php

namespace App\Http\Middleware;

use App\Group;
use App\Models\AdminSidebar;
use App\Models\Permission;
use App\SidebarItem;
use App\User;
use Closure;
 use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use MongoDB\BSON\ObjectId;

class CheckPermission
{

    public function handle($request, Closure $next, $guard = null )
    {
        $function = Request::route()->getActionMethod();

        $path = $request->path();

        $this->user = Auth::user();

        if(!$this->user){
            return Auth::logout();
        }

        $userId = $this->user->id;

        if($this->user->isSuperadmin){
            $permIds = $this->refreshRolePerms(-1,$userId);
        }
        else {
            $userGroupId = $this->user->groupId;
            $permIds = $this->refreshRolePerms($userGroupId, $userId);
        }

        $permList = [];
        $permissions = \App\Permission::get();
        foreach ($permissions as $permission){
            array_push($permList,$permission->slug);
        }
        $permList = array_unique($permList);
        /*$rolePermissions = getRolePerms($this->user->roleid,null);
        $userPermissions = getUserPerms($this->user->id,null);
        $permIds = array_merge($rolePermissions,$userPermissions);*/

        $checkSidebarItem = SidebarItem::where('url','like',$path)->first();

        //dd($checkSidebarItem);

        if($checkSidebarItem){
            if(!in_array($checkSidebarItem->permId,$permIds)){
                return response(view('errors.403'), 403);
            }
        }

        //dd($permList);
        if(in_array($function,$permList) && !in_array($function,session('permSlugs'))){
            return response(view('errors.403'), 403);
        }

        return $next($request);
    }

    function refreshRolePerms($userGroupId,$userId)
    {
        $rolePerm = [];
        if($userGroupId !== -1){
            $role = Group::where('id',$userGroupId)->first();
            if(isset($role->roleHasPerms)) {
                $rolePerm = $role->roleHasPerms;
            }
        }

        $userPerm = [];
        $user = User::where('id',$userId)->first();

        if(isset($user->userHasPerms)) {
            $userPerm = $user->userHasPerms;
        }

        $allPerms = array_merge($rolePerm, $userPerm);

        $permissionsIds = \App\Permission::whereIn('id',$allPerms)->where('slug','=','-')->pluck('id')->toArray();
        $permissionsSlugs = \App\Permission::whereIn('id',$allPerms)->where('slug','!=','-')->pluck('slug')->toArray();

        $permissions = [];
        foreach ($permissionsIds as $item){
            $item = new ObjectId($item);
            array_push($permissions,$item);
        }

        $permissionsSlugs = array_unique($permissionsSlugs);
        Session::put('perms',$permissions);
        Session::put('permSlugs',$permissionsSlugs);

        //dd($permissions);
        return $permissions;
    }
}
