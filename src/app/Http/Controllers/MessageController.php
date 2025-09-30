<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Http\Requests\MessageRequest;

class MessageController extends Controller
{
    // チャット本文を一時保存
public function saveDraft(Request $request, $listingId)
{
    $request->validate([
        'content' => 'nullable|string|max:1000',
    ]);

    // セッションに保存
    session()->put("chat_content_{$listingId}", $request->input('content'));

    return response()->json(['status' => 'ok']);
}


    public function store(MessageRequest $request, $listingId) {

        $path = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('messages', 'public');
        }

        Message::create ([
            'listing_id' => $listingId,
            'user_id' => auth()->id(),
            'content' => $request->input('content'),
            'image' => $path,
        ]);

        session()->forget("chat_content_{$listingId}");

        return back();

    }

    public function update(Request $request, $id) {
        $message = Message::findOrfail($id);

        $message->update([
            'content' => $request->input('content'),
        ]);

        return redirect()->route('transaction.show', $message->listing_id);
    }

    public function destroy($id) {
        $message = Message::findOrfail($id);
        
        if ($message->user_id !== auth()->id()) {
            abort(403);
        }

        $listingId = $message->listing_id;
        $message->delete();

        return redirect()->route('transaction.show', $listingId);
    }

    
}