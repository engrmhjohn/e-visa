<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

require_once app_path('Helper/image.php');

class AdminController extends Controller
{
    public function manageAdmin()
    {
        return view('backend.admin.index', [
            'users' => User::get()
        ]);
    }

    public function role($id, $newRole)
    {
        $user = User::find($id);
        $user->role = $newRole;
        $user->save();
        return back()->with('message', 'Role changed successfully!');
    }

    public function pendingUser()
    {
        return view('backend.admin.pending_user', [
            'pending_user' => User::where('role', '0')->get()
        ]);
    }
    public function adminUser()
    {
        return view('backend.admin.admin_user', [
            'admin_user' => User::where('role', '1')->get()
        ]);
    }
    public function superAdminUser()
    {
        return view('backend.admin.super_admin_user', [
            'super_admin_user' => User::where('role', '2')->get()
        ]);
    }

    public function editAdmin($id)
    {
        $user = User::find($id);
        return view('backend.admin.edit', [
            'user' => $user,
        ]);
    }

    public function adminProfile()
    {
        return view('backend.admin.profile');
    }

    public function updateUserName(Request $request)
    {
        $user_info               = User::find($request->id);
        $user_info->name = $request->name;
        $user_info->save();
        return redirect(route('admin.profile_admin'))->with('message', 'User Name Successfully Updated!');
    }

    public function updateUserEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|string|unique:users,email',
        ]);

        $user_info               = User::find($request->id);
        $user_info->email = $request->email;
        $user_info->save();
        return redirect(route('admin.profile_admin'))->with('message', 'User Email Successfully Updated!');
    }

    public function updateUserPhoto(Request $request)
    {
        $user_info               = User::find($request->id);
        if ($request->file('profile_photo_path')) {
            if (isset($user_info)) {
                delete_image($user_info->profile_photo_path);
                $user_info->delete();
            }
            $user_info->profile_photo_path = image_upload($request->profile_photo_path);
        }
        $user_info->save();
        return redirect(route('admin.profile_admin'))->with('message', 'Profile Photo Successfully Updated!');
    }

    public function updateUserPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed', // Ensure password and password_confirmation match
        ]);

        $user_info = User::find($request->id);
        $user_info->password = Hash::make($request->password);
        $user_info->save();

        return redirect(route('admin.profile_admin'))->with('message', 'Password successfully updated!');
    }

    public function deleteAdmin($id)
    {
        $admin = User::findOrFail($id);

        $admin->delete();

        return redirect()->route('admin.manage_admin')->with('message', 'Successfully Deleted!');
    }

    // Admin information change by super admin 
    public function updateUserNameByAdmin(Request $request)
    {
        // Validation rules
        $validator = Validator::make($request->all(), [
            'name' => 'nullable|string|max:255',
        ], [
            'name.max' => 'The name must not be larger than 255 Characters.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $user_info               = User::find($request->id);
        $user_info->name = $request->name;
        $user_info->save();
        return redirect()->back()->with('success', 'User Name Successfully Updated!');
    }

    public function updateUserEmailByAdmin(Request $request)
    {
        // Validation rules
        $validator = Validator::make($request->all(), [
            'email' => 'nullable|email|max:255',
        ], [
            'email.max' => 'The email must not be longer than 255 characters.',
            'email.email' => 'Please enter a valid email address.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $request->validate([
            'email' => 'required|string|unique:users,email',
        ]);

        $user_info               = User::find($request->id);
        $user_info->email = $request->email;
        $user_info->save();
        return redirect()->back()->with('success', 'User Email Successfully Updated!');
    }

    public function updateUserPhotoByAdmin(Request $request)
    {
        // Validation rules
        $validator = Validator::make($request->all(), [
            'profile_photo_path' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:1024',
        ], [
            'profile_photo_path.required' => 'The profile picture image is required.',
            'profile_photo_path.image' => 'The file must be a valid image.',
            'profile_photo_path.mimes' => 'The profile picture must be in jpeg, png, jpg, gif, or webp format.',
            'profile_photo_path.max' => 'The profile picture image must not be larger than 1MB.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user_info               = User::find($request->id);
        if ($request->file('profile_photo_path')) {
            if (isset($user_info)) {
                delete_image($user_info->profile_photo_path);
                $user_info->delete();
            }
            $user_info->profile_photo_path = image_upload($request->profile_photo_path);
        }
        $user_info->save();
        return redirect()->back()->with('success', 'Profile Photo Successfully Updated!');
    }

    public function updateUserPasswordByAdmin(Request $request)
    {
        // Validation rules
        $validator = Validator::make($request->all(), [
            'password' => 'required|string|min:8|confirmed',
        ], [
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 8 characters.',
            'password.confirmed' => 'Password confirmation does not match.',
        ]);        

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user_info = User::find($request->id);
        $user_info->password = Hash::make($request->password);
        $user_info->save();

        return redirect()->back()->with('success', 'Password successfully updated!');
    }


    public function updateUserPhoneByAdmin(Request $request)
    {
        // Validation rules
        $validator = Validator::make($request->all(), [
            'phone' => 'nullable|string|max:20',
        ], [
            'phone.max' => 'The phone number must not be longer than 20 characters.',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $user_info               = User::find($request->id);
        $user_info->phone = $request->phone;
        $user_info->save();
        return redirect()->back()->with('success', 'User Phone Successfully Updated!');
    }
}
