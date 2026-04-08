<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Contracts\Admin\TagServiceInterface;
use App\Traits\Alert;
use Illuminate\Http\Request;

class TagsController extends Controller
{
    use Alert;

    public function __construct(
        protected TagServiceInterface $tagService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tags = $this->tagService->allTags();

        return view('admin.tags.index', compact('tags'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.tags.create');
    }


    public function search(Request $request)
    {
        try {
            $tags = $this->tagService->findTag($request->input('name'));
            return response()->json([
                'tags' => $tags,
                'status' => true,
                'message' => 'Tags retrieved successfully',
            ]);
        } catch (\Exception $e) {
            logger()->error('Failed to fetch tags: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while fetching tags',
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:tags,name']
        ]);

        try {
            $tags = $this->tagService->addNewTag($request->all());
            $this->created('Tag created successfully!');
            return redirect()->route('admin.tags.index');
        } catch (\Exception $e) {
            logger()->error('Failed to update tag: ' . $e->getMessage());
            $this->failed('Unable to create tag');

            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $tag = $this->tagService->getTag($id);
            return view('admin.tags.edit', compact('tag'));
        } catch (\Exception $e) {
            logger()->error('Failed to get tag: ' . $e->getMessage());
            $this->failed('Unable to fetch tag');

            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:tags,name,' . $id]
        ]);

        try {
            $tag = $this->tagService->updateTag($id, $validated);
            $this->updated('Tag updated successfully!');
            return redirect()->route('admin.tags.index');
        } catch (\Exception $e) {
            logger()->error('Failed to update tag: ' . $e->getMessage());
            $this->failed('An error occurred while updating tag');

            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $this->tagService->delete($id);
            return response()->json([
                'message' => 'Tag deleted successfully',
                'status' => true,
            ], 200);
        } catch (\Exception $e) {
            logger()->error('Failed to delete tag: ' . $e->getMessage());

            return response()->json([
                'message' => "An error occurred while deleting tag!",
                'status' => false,
            ], 500);
        }
    }
}