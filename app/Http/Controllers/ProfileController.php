<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\Division;
use App\Models\Profile;
use App\Models\Thana;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    final public function index(): Application|Factory|View
    {
        $divisions = Division::pluck('name', 'id');
        $profile = Profile::where('user_id', Auth::id())->first();
        return view('backend.modules.profile.profile', compact('divisions', 'profile'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'phone' => 'required',
            'gender' => 'required',
            'division_id' => 'required',
            'district_id' => 'required',
            'thana_id' => 'required',
        ]);
        $profile_data = $request->all();
        $profile_data['user_id'] = Auth::id();

        $existing_profile = Profile::where('user_id', Auth::id())->first();
        if ($existing_profile) {
            $existing_profile->update($profile_data);
        } else {
            Profile::create($profile_data);
        }
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Profile $profile
     * @return Response
     */
    public function show(Profile $profile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Profile $profile
     * @return Response
     */
    public function edit(Profile $profile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param \App\Models\Profile $profile
     * @return Response
     */
    public function update(Request $request, Profile $profile)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Profile $profile
     * @return Response
     */
    public function destroy(Profile $profile)
    {
        //
    }

    /**
     * @param int $division_id
     * @return JsonResponse
     */
    final public function getDistrict(int $division_id): JsonResponse
    {
        $districts = District::select('id', 'name')->where('division_id', $division_id)->get();
        return response()->json($districts);
    }

    /**
     * @param int $district_id
     * @return JsonResponse
     */
    final public function getThana(int $district_id): JsonResponse
    {
        $thanas = Thana::select('id', 'name')->where('district_id', $district_id)->get();
        return response()->json($thanas);
    }


    /**
     * @param Request $request
     * @return JsonResponse
     */
    final public function upload_photo(Request $request): JsonResponse
    {

        $file = $request->input('photo');
        $name = Str::slug(Auth::user()->name . Carbon::now());
        $height = 200;
        $width = 200;
        $path = 'image/user/';
        $profile = Profile::where('user_id', Auth::id())->first();
        if ($profile?->photo) {
            PhotoUploadController::imageUnlink($path, $profile->photo);
        }

        $image_name = PhotoUploadController::imageUpload($name, $height, $width, $path, $file);

        $profile_data['photo'] = $image_name;

        if ($profile) {
            $profile->update($profile_data);
            return response()->json([
                'msg' => 'Profile photo updated successfully',
                'cls' => 'success',
                'photo' => url($path . $profile->photo)
            ]);
        }
        return response()->json([
            'msg' => 'Please update profile first',
            'cls' => 'warning',
        ]);

    }
}
