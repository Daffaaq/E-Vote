<?php

namespace App\Http\Controllers;

use App\Services\ProfileService;
use App\Http\Requests\UpdateProfileLogoRequest;
use App\Http\Requests\UpdateProfilePersonalRequest;
use App\Http\Requests\UpdateProfileSocialMediaRequest;

class ProfileController extends Controller
{
    protected $profileService;

    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    public function index()
    {
        $profiles = $this->profileService->getAllProfiles();
        return view('Superadmin.Profiles.index', ['profiles' => $profiles]);
    }

    public function show($uuid)
    {
        $profile = $this->profileService->getProfileByUuid($uuid);
        return view('profiles.show', compact('profile'));
    }

    public function editLogo($uuid)
    {
        $profile = $this->profileService->getProfileByUuid($uuid);
        return view('Superadmin.Profiles.edit-logo', compact('profile'));
    }

    public function updateLogo(UpdateProfileLogoRequest $request, $uuid)
    {
        $data = $request->validated();

        if ($request->hasFile('logo_profiles')) {
            $data['logo_profiles'] = $request->file('logo_profiles')->store('logos', 'public');
        }

        $profile = $this->profileService->updateProfile($uuid, $data);
        return redirect()->route('profiles.index')->with('success', 'Logo updated successfully.');
    }
    public function editPersonal($uuid)
    {
        $profile = $this->profileService->getProfileByUuid($uuid);
        return view('Superadmin.Profiles.edit-personal', compact('profile'));
    }

    public function updatePersonal(UpdateProfilePersonalRequest $request, $uuid)
    {
        $profile = $this->profileService->updateProfile($uuid, $request->validated());
        return redirect()->route('profiles.index')->with('success', 'Profile updated successfully.');
    }
    public function editSocialMedia($uuid)
    {
        $profile = $this->profileService->getProfileByUuid($uuid);
        return view('profiles.edit', compact('profile'));
    }

    public function updateSocialMedia(UpdateProfileSocialMediaRequest $request, $uuid)
    {
        $profile = $this->profileService->updateProfile($uuid, $request->validated());
        return redirect()->route('profiles.index')->with('success', 'Profile updated successfully.');
    }
}
