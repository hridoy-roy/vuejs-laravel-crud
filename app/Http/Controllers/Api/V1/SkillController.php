<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\SkillCollection;
use App\Http\Resources\V1\SkillResource;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SkillController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
//        return SkillResource::collection(Skill::paginate(1));
        return new SkillCollection(Skill::paginate(1));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|min:3|max:20',
            'slug' => 'required|unique:skills,slug',
        ]);


        return Skill::create($validated)->toJson();
    }

    /**
     * Display the specified resource.
     */
    public function show(Skill $skill)
    {
        return new SkillResource($skill);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Skill $skill)
    {
        $validated = $request->validate([
            'name' => 'required|min:3|max:20',
//            'slug' => ['required', 'unique:skills,slug,' . $skill->id]
            'slug' => ['required', Rule::unique('skills')->ignore($skill)],
        ]);


        $skill->update($validated);
        return response()->json('Skill updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Skill $skill)
    {
        $skill->delete();
        return response()->json('Skill Deleted');
    }
}
