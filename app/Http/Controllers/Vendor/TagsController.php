<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Services\Contracts\Vendor\TagServiceInterface;
use App\Traits\Alert;
use Illuminate\Http\Request;

class TagsController extends Controller
{
    use Alert;

    public function __construct(
        protected TagServiceInterface $tagService
    ) {}

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
}
