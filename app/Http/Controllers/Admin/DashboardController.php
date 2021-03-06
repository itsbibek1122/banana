<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Message;
use App\Setting;

use App\Property;

use Carbon\Carbon;
use App\Mail\Contact;
use Illuminate\Http\Request;

use Yoeunes\Toastr\Facades\Toastr;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function index()
    {
        $propertycount = Property::count();
        $usercount     = User::count();

        $properties    = Property::latest()->with('user')->take(5)->get();
        $users         = User::with('role')->get();

        return view('admin.dashboard', compact(
            'propertycount',
            'usercount',
            'properties',
            'users',
        ));
    }


    public function settings()
    {
        $settings = Setting::first();

        return view('admin.settings.setting', compact('settings'));
    }

    public function settingStore(Request $request)
    {

        $this->validate($request, [
            'name'      => 'required',
            'email'     => 'required',
            'phone'     => 'required',
            'address'   => 'required',
            'footer'    => 'required',
            'aboutus'   => 'required',
            'facebook'  => 'required|url',
            'twitter'   => 'required|url',
            'linkedin'  => 'required|url',
        ]);

        Setting::updateOrCreate(
            ['id'       => 1],
            [
                'name'     => $request->name,
                'email'    => $request->email,
                'phone'    => $request->phone,
                'address'  => $request->address,
                'footer'   => $request->footer,
                'aboutus'  => $request->aboutus,
                'facebook' => $request->facebook,
                'twitter'  => $request->twitter,
                'linkedin' => $request->linkedin
            ]
        );

        $settings = Setting::first();

        Toastr::success('message', 'Updated successfully.');
        return back();
    }

    public function profile()
    {
        $profile = Auth::user();

        return view('admin.settings.profile', compact('profile'));
    }

    public function profileUpdate(Request $request)
    {
        $request->validate([
            'name'      => 'required',
            'username'  => 'required',
            'email'     => 'required|email',
            'image'     => 'image|mimes:jpeg,jpg,png',
            'about'     => 'max:250'
        ]);

        $user = User::find(Auth::id());

        $image = $request->file('image');
        $slug  = Str::slug($request->name);

        if (isset($image)) {
            $currentDate = Carbon::now()->toDateString();
            $imagename = $slug . '-admin-' . Auth::id() . '-' . $currentDate . '.' . $image->getClientOriginalExtension();

            if (!Storage::disk('public')->exists('users')) {
                Storage::disk('public')->makeDirectory('users');
            }
            if (Storage::disk('public')->exists('users/' . $user->image) && $user->image != 'default.png') {
                Storage::disk('public')->delete('users/' . $user->image);
            }
            $userimage = Image::make($image)->stream();
            Storage::disk('public')->put('users/' . $imagename, $userimage);
        } else {
            $imagename = $user->image;
        }

        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->image = $imagename;
        $user->about = $request->about;

        $user->save();

        return back();
    }


    // MESSAGE
    public function message()
    {
        $messages = Message::latest()->where('agent_id', Auth::id())->get();

        return view('admin.settings.messages.index', compact('messages'));
    }

    public function messageRead($id)
    {
        $message = Message::findOrFail($id);

        return view('admin.settings.messages.readmessage', compact('message'));
    }

    public function messageReplay($id)
    {
        $message = Message::findOrFail($id);

        return view('admin.settings.messages.replaymessage', compact('message'));
    }

    public function messageSend(Request $request)
    {
        $request->validate([
            'agent_id'  => 'required',
            'user_id'   => 'required',
            'name'      => 'required',
            'email'     => 'required',
            'phone'     => 'required',
            'message'   => 'required'
        ]);

        Message::create($request->all());

        Toastr::success('message', 'Message send successfully.');
        return back();
    }

    public function messageReadUnread(Request $request)
    {
        $status = $request->status;
        $msgid  = $request->messageid;

        if ($status) {
            $status = 0;
        } else {
            $status = 1;
        }

        $message = Message::findOrFail($msgid);
        $message->status = $status;
        $message->save();

        return redirect()->route('admin.message');
    }

    public function messageDelete($id)
    {
        $message = Message::findOrFail($id);
        $message->delete();

        Toastr::success('message', 'Message deleted successfully.');
        return back();
    }

    public function contactMail(Request $request)
    {
        $message  = $request->message;
        $name     = $request->name;
        $mailfrom = $request->mailfrom;

        Mail::to($request->email)->send(new Contact($message, $name, $mailfrom));

        Toastr::success('message', 'Mail send successfully.');
        return back();
    }
}
