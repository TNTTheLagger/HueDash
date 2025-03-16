<?php
namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\Topic;
use Illuminate\Http\Request;

class CardController extends Controller
{
    public function index(Request $request)
    {
        $query = Card::query();

        if ($request->has('topic')) {
            $topicName = $request->query('topic');
            $topic     = Topic::where('name', $topicName)->first();
            if ($topic) {
                $query->where('topic_id', $topic->id);
            } else {
                return response()->json([], 200); // Return empty array if topic not found
            }
        }

        $cards = $query->get();
        return response()->json($cards);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title'    => 'required|string|max:255',
            'body'     => 'required|string',
            'urgency'  => 'nullable|string|in:high,medium,low',
            'topic_id' => 'nullable|exists:topics,id', // Add topic_id validation
        ]);

        $card = Card::create($validatedData);
        return response()->json($card, 201);
    }

    public function destroy($id)
    {
        $card = Card::findOrFail($id);
        $card->delete();
        return response()->json(null, 204);
    }

    public function indexByTopic($topic)
    {
        $topic = Topic::where('name', $topic)->firstOrFail();
        $cards = Card::where('topic_id', $topic->id)->get();
        return response()->json($cards);
    }

    public function getTopics()
    {
        $topics = Topic::all();
        return response()->json($topics);
    }

    public function storeTopic(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:topics',
        ]);

        $topic = Topic::create($validatedData);
        return response()->json($topic, 201);
    }

    public function destroyTopic($id)
    {
        $topic = Topic::findOrFail($id);
        $topic->delete();
        return response()->json(null, 204);
    }
}
