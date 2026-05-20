<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StateRequestCreate;
use App\Http\Requests\Admin\StateRequestUpdate;
use App\Http\Requests\Admin\StatesRequestCreate;
use App\Http\Requests\Admin\StatesRequestUpdate;
use App\Services\Contracts\StatesServiceInterface;
use App\Traits\Alert;
use Illuminate\Http\Request;

class StatesController extends Controller
{
    use Alert;

    public function __construct(
        protected StatesServiceInterface $statesService
    ) {}

    public function index()
    {
        $states = $this->statesService->getStates();
        return view('admin.states.index', compact('states'));
    }

    public function create()
    {
        return view('admin.states.create');
    }

    public function store(StatesRequestCreate $request)
    {
        try {
            $this->statesService->createState($request->validated());

            $this->created('State created successfully!');
            return to_route('admin.states.index');
        } catch (\Exception $e) {
            logger()->error($e->getMessage());
            $this->failed('Failed to create state');
            return back();
        }
    }

    public function edit(string $id)
    {
        try {
            $state = $this->statesService->getState($id);
            // dd($state);
            return view('admin.states.edit', compact('state'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());
            $this->failed('Failed to fetch state');
            return back();
        }
    }

    public function update(StatesRequestUpdate $request, string $id)
    {
        try {
            $this->statesService->updateState($request->validated(), $id);

            $this->updated('State updated successfully!');
            return to_route('admin.states.index');
        } catch (\Exception $e) {
            logger()->error($e->getMessage());
            $this->failed('Failed to update state');
            return back();
        }
    }

    public function destroy(string $id)
    {
        try {
            $this->statesService->destroy($id);

            return response()->json([
                'status' => true,
                'message' => 'State deleted successfully'
            ]);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Failed to delete state'
            ]);
        }
    }

    public function getCities(int $id)
    {
        try {
            $state = $this->statesService->getState($id);

            return response()->json([
                'status' => true,
                'state_cities' => $state,
                'message' => 'Cities retrived successfully'
            ]);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Failed to delete state'
            ]);
        }
    }
}
