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
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $path = $request->file('image')->store('cards', 'public');

        $card = new Card();
        $card->name = $request->name;
        $card->Rarity = $request->Rarity;
        $card->Era = $request->Era;
        $card->type = $request->type;
        $card->Language = $request->Language;
        $card->Stamped = $request->Stamped;
        $card->CardMarketLink = $request->CardMarketLink;
        $card->image_path = $path;
        $card->user_id = auth()->id();
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
        $user = auth()->user();

        if (!$user->profile_picture) {
            return redirect()->route('profile')->with('error', 'You must upload a profile picture to create a card.');
        }

        return view('cards.create');
    }

    public function edit(Card $card)
    {
        // Allow access if the user is an admin or the owner of the card
        if (auth()->user()->role !== 'admin' && auth()->id() !== $card->user_id) {
            abort(403, 'Unauthorized action.');
        }

        return view('cards.edit', compact('card'));
    }

    public function update(Request $request, Card $card)
    {
        // Allow update if the user is an admin or the owner of the card
        if (auth()->user()->role !== 'admin' && auth()->id() !== $card->user_id) {
            abort(403, 'Unauthorized action.');
        }

        // Validation for the card fields
        $request->validate([
            'name' => 'required|string|max:255',
            'Rarity' => 'required|string|max:50',
            'Era' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'Language' => 'required|string|max:255',
            'Stamped' => 'required|string|max:255',
            'CardMarketLink' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',  // Image is optional on update
        ]);

        // Update card fields
        $card->name = $request->name;
        $card->Rarity = $request->Rarity;
        $card->Era = $request->Era;
        $card->type = $request->type;
        $card->Language = $request->Language;
        $card->Stamped = $request->Stamped;
        $card->CardMarketLink = $request->CardMarketLink;

        // Handle new image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($card->image_path) {
                Storage::disk('public')->delete($card->image_path);
            }

            // Store new image
            $path = $request->file('image')->store('cards', 'public');
            $card->image_path = $path;
        }

        $card->save();

        return redirect()->route('cards.discover')->with('success', 'Card updated successfully!');
    }


    public function discover(Request $request)
    {
        $type = $request->input('type');
        $rarity = $request->input('rarity');
        $language = $request->input('language');
        $set = $request->input('set');
        $stamped = $request->input('stamped');

        $query = Card::query();

        if ($type) $query->where('type', 'like', '%' . $type . '%');
        if ($rarity) $query->where('Rarity', 'like', '%' . $rarity . '%');
        if ($language) $query->where('Language', 'like', '%' . $language . '%');
        if ($set) $query->where('Era', 'like', '%' . $set . '%');
        if ($stamped) $query->where('Stamped', 'Yes');

        $cards = $query->get();

        $types = Card::distinct()->pluck('type');
        $rarities = Card::distinct()->pluck('Rarity');
        $languages = Card::distinct()->pluck('Language');
        $sets = Card::distinct()->pluck('Era');

        return view('cards.discover', compact('cards', 'types', 'rarities', 'languages', 'sets'));
    }

    public function show($id)
    {
        $card = Card::findOrFail($id);
        return response()->json($card);
    }

    public function destroy(Card $card)
    {
        // Check if the current user is the owner or has an admin role
        if (auth()->id() !== $card->user_id && auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        // Delete the card image from storage
        if ($card->image_path) {
            Storage::disk('public')->delete($card->image_path);
        }

        // Delete the card record
        $card->delete();

        return response()->json(['success' => 'Card deleted successfully.']);
    }

}
