<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CityRequestCreate;
use App\Http\Requests\Admin\CityRequestUpdate;
use App\Services\Contracts\CitiesServiceInterface;
use App\Services\Contracts\StatesServiceInterface;
use App\Traits\Alert;

class CitiesController extends Controller
{
    use Alert;

    public function __construct(
        protected CitiesServiceInterface $citiesService,
        protected StatesServiceInterface $stateService,
    ) {}

    /**
     * Display a listing of cities.
     */
    public function index()
    {
        $cities = $this->citiesService->getCities();

        return view('admin.city.index', compact('cities'));
    }

    /**
     * Show create form.
     */
    public function create()
    {
        $states = $this->stateService->getStates();
        return view('admin.city.create', compact('states'));
    }

    /*
     * y
     * Store new city.
     */
    public function store(CityRequestCreate $request)
    {
        try {
            $this->citiesService->createCity($request->validated());

            $this->created('City created successfully!');
            return to_route('admin.cities.index');
        } catch (\Exception $e) {
            logger()->error('City create error: ' . $e->getMessage());

            $this->failed('Failed to create city');
            return back();
        }
    }

    /**
     * Edit city form.
     */
    public function edit(string $id)
    {
        try {
            $city = $this->citiesService->getCity($id);
            $states = $this->stateService->getStates();

            return view('admin.city.edit', compact('city', 'states'));
        } catch (\Exception $e) {
            logger()->error('City fetch error: ' . $e->getMessage());

            $this->failed('Failed to fetch city');
            return back();
        }
    }

    /**
     * Update city.
     */
    public function update(CityRequestUpdate $request, string $id)
    {
        try {
            $this->citiesService->updateCity($request->validated(), $id);

            $this->updated('City updated successfully!');
            return to_route('admin.cities.index');
        } catch (\Exception $e) {
            logger()->error('City update error: ' . $e->getMessage());

            $this->failed('Failed to update city');
            return back();
        }
    }

    /**
     * Delete city.
     */
    public function destroy(string $id)
    {
        try {
            $this->citiesService->destroy($id);

            return response()->json([
                'status' => true,
                'message' => 'City deleted successfully'
            ]);
        } catch (\Exception $e) {
            logger()->error('City delete error: ' . $e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Failed to delete city'
            ]);
        }
    }
}
