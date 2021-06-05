<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use App\Http\Resources\ProfileResource;
use App\Models\Profile;

class ProfileController extends Controller
{
    /**
     * Display current user's profile.
     */
    public function index()
    {
        return new ProfileResource(auth()->user());
    }

    /**
     * Update current user's profile.
     */
    public function update(UpdateProfileRequest $request)
    {
        $updateData = $request->validated();
        if ($request->hasFile('avatar')) {
            $updateData['avatar'] = Profile::storeAvatarFile($request->file('avatar'));
            $request->user()->profile->deleteAvatarFile();
        }
        $request->user()->profile->update($updateData);
        return new ProfileResource($request->user());
    }
}
