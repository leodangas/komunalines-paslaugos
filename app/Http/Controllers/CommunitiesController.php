<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCommunity;
use App\Http\Requests\EditCommunity;
use App\Http\Requests\EditCommunityService;
use App\Models\Community;
use App\Models\CommunityService;
use App\Models\User;
use Illuminate\Http\Request;

class CommunitiesController extends Controller
{
    //

    public function showCommunitiesPage() {
        if (User::isAdmin()) {
            return view('communities');
        } else {
            $managerId = auth()->user()->id;
            $communities = Community::whereHas('services', function ($query) use ($managerId) {
                $query->where('manager_id', $managerId);
            })->with('services')->get();

            return view('communities', [
                'communities' => $communities,
            ]);
        }
    }

    public function showCommunitiesHouses($id) {
        $community = Community::findOrFail($id);
        return view('communitiesHouses', [
            'community' => $community
        ]);
    }

    public function showCommunitiesServices($id) {
        $community = Community::findOrFail($id);
        if (User::isAdmin()) {
            return view('communitiesServices', [
                'community' => $community
            ]);
        } else {
            $managerId = auth()->user()->id;
            $services = $community->services->filter(function($service) use ($managerId) {
                return $service->manager_id === $managerId;
            })->pluck('id');

            $communityServices = CommunityService::whereIn('service_id', $services)->where('community_id', $community->id)->get();

            return view('communitiesServices', [
                'community' => $community,
                'services' => $communityServices
            ]);
        }

    }

    public function createCommunity(CreateCommunity $request) {
        $attributes = $request->validated();
        $services = $attributes['services'];
        unset($attributes['services']);
        $community = Community::create($attributes);
        if ($services) {
            foreach($services as $service) {
                $createdService = CommunityService::create([
                    'service_id' => $service,
                    'community_id' => $community->id
                ]);
            }
        }

        return redirect(route('communities.show'))->with('status', "Bendrija $community->name sėkmingai sukurta");
    }

    public function editCommunity(EditCommunity $request, $id) {
        $community = Community::findOrFail($id);
        $attributes = $request->validated();
        $services = $attributes['services'];
        unset($attributes['services']);

        $community->update($attributes);

        if ($services) {
            foreach($services as $service) {
                if (!in_array($service, $community->services->pluck('id')->toArray())) {
                    $createdService = CommunityService::create([
                        'service_id' => $service,
                        'community_id' => $community->id
                    ]);
                }
            }
            foreach($community->services as $service) {
                if (!in_array($service->id, $services)) {
                    CommunityService::where([
                        'service_id' => $service->id,
                        'community_id' => $community->id
                    ])->delete();
                }
            }
        }

        return redirect(route('communities.show'))->with('status', "Bendrija $community->name sėkmingai atnaujinta");
    }

    public function deleteCommunity($id) {
        $community = Community::findOrFail($id);

        $community->delete();

        return redirect()->back()->with('status', "Bendrija $community->name sėkmingai ištrinta");
    }

    public function editService(EditCommunityService $request, $id) {
        $communityService = CommunityService::findOrFail($id);
        $attributes = $request->validated();
        $communityService->update($attributes);

        return redirect()->back()->with('status', "Bendrijos paslauga " . $communityService->service->name . " sėkmingai atnaujinta");

    }
}
