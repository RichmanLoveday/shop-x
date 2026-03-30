<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RoleRequestCreate;
use App\Http\Requests\Admin\RoleRequestUpdate;
use App\Services\Contracts\Admin\RoleServiceInterface;
use App\Traits\Alert;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    use Alert;

    public function __construct(
        protected RoleServiceInterface $roleService
    ) {}

    public function index()
    {
        $roles = $this->roleService->getAllRole();
        // dd($roles->toArray());
        return view('admin.access-management.index', compact('roles'));
    }

    public function create()
    {
        $permissions = $this->roleService->getPermissions();
        // dd($permissions->toArray());
        return view('admin.access-management.create', compact('permissions'));
    }

    public function store(RoleRequestCreate $request)
    {
        $role = $this->roleService->addNewRole($request->validated(), 'admin');
        if ($role) {
            $this->created('Role created successfully');
            return redirect()->route('admin.role.index');
        }

        // handle failure
        $this->failed('Failed to create role');
        return redirect()->back();
    }

    public function edit(int $id)
    {
        // get the role by id
        try {
            $role = $this->roleService->getSingleRole($id, 'admin');

            if (!$role) {
                $this->failed('Role not found');
                return redirect()->route('admin.role.index');
            }

            $permissions = $this->roleService->getPermissions();

            return view('admin.access-management.edit', compact('role', 'permissions'));
        } catch (\Exception $e) {
            logger()->error('Error fetching role: ' . $e->getMessage());
            $this->failed('An error occurred while fetching the role');
            return redirect()->route('admin.role.index');
        }
    }

    public function update(RoleRequestUpdate $request, int $id)
    {
        // dd($request->validated());
        // update the role by id
        try {
            $updatedRole = $this->roleService->updateRole($id, $request->all());

            if ($updatedRole) {
                $this->updated('Role updated successfully');
                return redirect()->route('admin.role.index');
            }
            // handle failure
            $this->failed('Failed to update role');
            return redirect()->back();
        } catch (\Exception $e) {
            logger()->error('Error updating role: ' . $e->getMessage());
            $this->failed('An error occurred while updating the role');
            return redirect()->route('admin.role.index');
        }
    }

    public function destroy(int $id)
    {
        // dd($id);
        try {
            $deleted = $this->roleService->deleteRole($id);

            if ($deleted) {
                return response()->json(['message' => 'Role deleted successfully', 'error' => 'success']);
            }

            return response()->json(['message' => 'Failed to delete role', 'status' => 'error'], 500);
        } catch (\Exception $e) {
            logger()->error('Error deleting role: ' . $e->getMessage());

            return response()->json(['message' => 'An error occurred while deleting the role', 'status' => 'error'], 500);
        }
    }
}
