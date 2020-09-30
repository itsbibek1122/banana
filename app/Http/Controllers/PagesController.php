<?php

namespace App\Http\Controllers;

use App\User;
use App\Message;

use App\Property;

use App\Mail\Contact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class PagesController extends Controller
{
    public function properties()
    {
        $cities     = Property::select('city', 'city_slug')->distinct('city_slug')->get();
        $properties = Property::latest()->with('rating')->withCount('comments')->paginate(12);

        return view('pages.properties.property', compact('properties', 'cities'));
    }

    public function propertieshow($slug)
    {
        $property = Property::with('features', 'gallery', 'user', 'comments')
            ->withCount('comments')
            ->where('slug', $slug)
            ->first();

        $relatedproperty = Property::latest()
            ->where('purpose', $property->purpose)
            ->where('type', $property->type)
            ->where('bedroom', $property->bedroom)
            ->where('bathroom', $property->bathroom)
            ->where('id', '!=', $property->id)
            ->take(5)->get();

        $videoembed = $this->convertYoutube($property->video, 560, 315);

        $cities = Property::select('city', 'city_slug')->distinct('city_slug')->get();

        return view('pages.properties.single', compact('property', 'rating', 'relatedproperty', 'videoembed', 'cities'));
    }


    // AGENT PAGE
    public function agents()
    {
        $agents = User::latest()->where('role_id', 2)->paginate(12);

        return view('pages.agents.index', compact('agents'));
    }

    public function agentshow($id)
    {
        $agent      = User::findOrFail($id);
        $properties = Property::latest()->where('agent_id', $id)->paginate(10);

        return view('pages.agents.single', compact('agent', 'properties'));
    }

    // MESSAGE TO AGENT (SINGLE AGENT PAGE)
    public function messageAgent(Request $request)
    {
        $request->validate([
            'agent_id'  => 'required',
            'name'      => 'required',
            'email'     => 'required',
            'phone'     => 'required',
            'message'   => 'required'
        ]);

        Message::create($request->all());

        if ($request->ajax()) {
            return response()->json(['message' => 'Message sent successfully.']);
        }
    }


    // CONATCT PAGE
    public function contact()
    {
        return view('pages.contact');
    }

    public function messageContact(Request $request)
    {
        $request->validate([
            'name'      => 'required',
            'email'     => 'required',
            'phone'     => 'required',
            'message'   => 'required'
        ]);

        $message  = $request->message;
        $mailfrom = $request->email;

        Message::create([
            'agent_id'  => 1,
            'name'      => $request->name,
            'email'     => $mailfrom,
            'phone'     => $request->phone,
            'message'   => $message
        ]);

        $adminname  = User::find(1)->name;
        $mailto     = $request->mailto;

        Mail::to($mailto)->send(new Contact($message, $adminname, $mailfrom));

        if ($request->ajax()) {
            return response()->json(['message' => 'Message send successfully.']);
        }
    }

    public function contactMail(Request $request)
    {
        return $request->all();
    }

    // PROPERTY CITIES
    public function propertyCities()
    {
        $cities     = Property::select('city', 'city_slug')->distinct('city_slug')->get();
        $properties = Property::latest()->with('rating')->withCount('comments')
            ->where('city_slug', request('cityslug'))
            ->paginate(12);

        return view('pages.properties.property', compact('properties', 'cities'));
    }


    // YOUTUBE LINK TO EMBED CODE
    private function convertYoutube($youtubelink, $w = 250, $h = 140)
    {
        return preg_replace(
            "/\s*[a-zA-Z\/\/:\.]*youtu(be.com\/watch\?v=|.be\/)([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i",
            "<iframe width=\"$w\" height=\"$h\" src=\"//www.youtube.com/embed/$2\" frameborder=\"0\" allowfullscreen></iframe>",
            $youtubelink
        );
    }
}
