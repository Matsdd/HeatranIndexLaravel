<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Card;
use Illuminate\Support\Facades\Storage;

class CardController extends Controller
{
    function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'Rarity' => 'required|string|max:50',
            'Era' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'Language' => 'required|string|max:255',
            'Stamped' => 'required|string|max:255',
            'CardMarketLink' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',  // Image validation
        ]);

        $path = $request->file('image')->store('cards', 'public'); // Store the image

        $card = new Card();
        $card->name = $request->name;
        $card->Rarity = $request->Rarity;
        $card->Era = $request->Era;
        $card->type = $request->type;
        $card->Language = $request->Language;
        $card->Stamped = $request->Stamped;
        $card->CardMarketLink = $request->CardMarketLink;
        $card->image_path = $path;
        $card->user_id = auth()->id();  // Associate card with the logged-in user
        $card->save();

        return redirect()->route('cards.discover')->with('success', 'Card created successfully!');
    }

    function favorite(Card $card)
    {
        auth()->user()->favoriteCards()->attach($card->id);
        return back()->with('success', 'Card added to your favorites!');
    }

    function unfavorite(Card $card)
    {
        auth()->user()->favoriteCards()->detach($card->id);
        return back()->with('success', 'Card removed from your favorites.');
    }

    public function create()
    {
        return view('cards.create');
    }

    public function discover(Request $request)
    {
        // Get the filter values if they exist
        $type = $request->input('type');
        $rarity = $request->input('rarity');
        $language = $request->input('language');
        $set = $request->input('set'); // Assuming this corresponds to the 'Era' column
        $stamped = $request->input('stamped'); // For the Stamped filter

        // Start building the query
        $query = Card::query();

        // Apply filters if they exist
        if ($type) {
            $query->where('type', 'like', '%' . $type . '%');
        }

        if ($rarity) {
            $query->where('Rarity', 'like', '%' . $rarity . '%');
        }

        if ($language) {
            $query->where('Language', 'like', '%' . $language . '%');
        }

        if ($set) {
            $query->where('Era', 'like', '%' . $set . '%'); // Adjust 'Era' to match your database column name
        }

        if ($stamped) {
            // Assuming the Stamped field is a string like 'Yes' or 'No', adjust if it's a boolean or a different format
            $query->where('Stamped', 'Yes'); // Change 'Yes' to whatever value represents a stamped card
        }

        // Get the filtered cards
        $cards = $query->get();

        // Fetch unique values for filters
        $types = Card::distinct()->pluck('type');
        $rarities = Card::distinct()->pluck('Rarity');
        $languages = Card::distinct()->pluck('Language');
        $sets = Card::distinct()->pluck('Era');

        // Pass the cards and filter options to the view
        return view('cards.discover', compact('cards', 'types', 'rarities', 'languages', 'sets'));
    }

    public function show($id)
    {
        $card = Card::findOrFail($id);
        return response()->json($card);
    }

}
