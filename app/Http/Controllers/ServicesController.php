<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateService;
use App\Http\Requests\EditService;
use App\Models\CommunityService;
use App\Models\Service;
use App\Models\User;

class ServicesController extends Controller
{
    //

    public function showServicesPage() {
        if (User::isManager()) {
            return redirect()->route('communities.show');
        }
        else if (User::isAdmin()) {
            return view('services');
        } else {
            $userCommunity = auth()->user()->community;
            $services = CommunityService::where([
                'community_id' => $userCommunity->id
            ])->get();

            return view('communitiesServices', ['services' => $services, 'community' => $userCommunity, 'regularUser' => true]);
        }
    }

    public function createService(CreateService $request) {
        $attributes = $request->validated();

        $service = Service::create($attributes);

        return redirect()->back()->with('status', "Paslauga $service->name sėkmingai sukurtas");
    }

    public function editService(EditService $request, $id) {
        $service = Service::findOrFail($id);
        $attributes = $request->validated();

        $service->update($attributes);

        return redirect()->back()->with('status', "Paslauga $service->name sėkmingai atnaujinta");
    }
}
