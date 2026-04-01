<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RoleUserRequestCreate;
use App\Http\Requests\Admin\RoleUserRequestUpdate;
use App\Policies\AccessManagementPolicy;
use App\Services\Contracts\Admin\RoleServiceInterface;
use App\Services\Contracts\Admin\RoleUserServiceInterface;
use App\Traits\Alert;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class UserRoleController extends Controller
{
    use Alert;

    public function __construct(
        protected RoleUserServiceInterface $roleUserService,
        protected RoleServiceInterface $roleService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admins = $this->roleUserService->getAllRoleUsers();
        // dd($roleUsers->toArray());
        return view('admin.role-user.index', compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = $this->roleService->getAllRole();
        // dd($roles->toArray());

        return view('admin.role-user.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleUserRequestCreate $request)
    {
        // dd($request->all());

        try {
            $user = $this->roleUserService->addNewRoleUser($request->validated());

            $this->created('Role user created successfully');
            return redirect()->route('admin.role-user.index');
        } catch (\Exception $e) {
            // handle exception
            $this->failed('An error occurred: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $admin = $this->roleUserService->getUser((int) $id);
        $roles = $this->roleService->getAllRole();
        return view('admin.role-user.edit', compact('admin', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoleUserRequestUpdate $request, string $id)
    {
        try {
            $user = $this->roleUserService->updateExistingUser((int) $id, $request->validated());

            $this->updated('Role user updated successfully');
            return redirect()->route('admin.role-user.index');
        } catch (\Exception $e) {
            // handle exception
            $this->failed('An error occurred: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $this->roleUserService->deleteUser((int) $id);

            return response()->json(['message' => 'Role user deleted successfully', 'status' => 'success']);
        } catch (\Exception $e) {
            // handle exception
            logger()->error('Failed to delete role user: ' . $e->getMessage());
            return response()->json(['message' => 'An error occurred while deleting the role user', 'status' => 'error'], 500);
        }
    }

    public function resendMail(int $id)
    {
        try {
            $this->roleUserService->resendMail($id);

            return response()->json(['message' => 'Email resent successfully', 'status' => 'success']);
        } catch (\Exception $e) {
            logger()->error('Failed to send email: ' . $e->getMessage());
            return response()->json(['message' => 'Failed to resend email: ' . $e->getMessage(), 'status' => 'error'], 500);
        }
    }
}
