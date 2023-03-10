<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddressUpdateRequest;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): Response
    {
        return Inertia::render('Profile/Edit', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
        ]);
    }

    public function editAddress()
    {
        $address = Auth::user()->address;
        $address = explode(', ', $address);
        return Inertia::render('Customer/Address',[
            'address' => $address,
        ]);
    }

    public function updateAddress(AddressUpdateRequest $request)
    {
        $address = $request->address . ', ' . $request->city . ', ' . $request->state . ', ' . $request->zip . ', ' . $request->country;
        $request->user()->update([
            'address' => $address,
        ]);

        return Redirect::route('address')->with('status', 'address-updated');
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current-password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function showReviews()
    {
        $reviews = Auth::user()->reviews()->with(['product:id,name'=>[
            'media'
        ]])->paginate(10);
        return Inertia::render('Customer/Reviews',[
            'reviews' => $reviews,
        ]);
    }

    public function editPassword()
    {
        return Inertia::render('Customer/Password');
    }
}
