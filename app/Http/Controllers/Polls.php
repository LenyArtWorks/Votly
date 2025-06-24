<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Poll;
use App\Models\User;
use App\Models\Category;
use App\Models\Option;
use App\Models\Vote;
use DateTime;
use Exception;
use Log;

class Polls extends Controller
{
    public function get(Request $request) {
        $searchStr = $request->input('search-text');
        $getPolls = Poll::with('options')->where('title', 'LIKE', "%$searchStr%")->get();
        $polls = [];
        $status = $request->input('status') ?? "";
        $now = new DateTime('now');
        $user = auth()->user();
        $votes = empty($user) ? [] : Vote::where('user_id', $user['id'])->get();

        foreach ($getPolls as $poll) {
            $pollDate = new DateTime($poll['created_at']);
            $interval = $now->diff($pollDate);

            if ($interval->format('%m') >= 1 || $interval->format('%y') >= 1) {
                $poll['status'] = 'Завершён';
                $poll->save();
            }

            $polls[] = [
                'title' => $poll['title'],
                'author' => User::find($poll['user_id'])['login'],
                'options' => $poll->options,
                'id' => $poll['id'],
                'status' => $poll['status'],
                'category' => Category::find($poll['category_id'])['name']
            ];
        }

        return Inertia::render('Polls', [
            'polls' => $polls,
            'searchStr' => $searchStr ?? "",
            'status' => $status,
            'user' => $user,
            'votes' => $votes
        ]);
    }

    public function add(Request $request) {
        try {
            $options = $request->options;
            $title = $request->title;
            $categoryName = $request->category;
            $user = auth()->user()['id'];
            $newPoll = Poll::create([
                'title' => $title,
                'user_id' => $user,
                'status' => 'Активен',
                'category_id' => Category::where('name', $categoryName)->first()['id']
            ]);

            foreach ($options as $option) {
                Option::create([
                    'text' => $option['text'],
                    'poll_id' => $newPoll->id
                ]);
            }

            $user['polls'] += 1;

            return redirect('/polls');
        }
        catch (Exception $e) {
            Log::alert("error", [
                'message' => $e->getMessage()
            ]);
        }
    }

    function vote(Request $request) {
        try {
            $user = User::find(auth()->user()['id']);

            $currentOption = Option::find($request->optionId);
            $currentPoll = Poll::find($currentOption['poll_id']);

            $options = Option::where('poll_id', $currentPoll['id'])->get();

            foreach ($options as $option) {
                $vote = Vote::where('option_id', $option['id'])->where('user_id', $user['id']);

                if (isset($vote)) {
                    $vote->delete();

                }
            }

            Vote::create([
                'user_id' => auth()->user()['id'],
                'option_id' => $request->optionId
            ]);

            $currentPoll['votes'] += 1;
            $currentPoll->save();
            $currentOption['votes'] += 1;
            $currentOption->save();
            $user['votes'] += 1;
            $user->save();
        }
        catch (Exception $e) {
            Log::alert('error', [
                'error' => $e->getMessage()
            ]);
        }
    }

    function getVotes() {
        return Vote::where('user_id', auth()->user()['id'])->get();
    }

    function getUserPolls() {
        $user = auth()->user();
        $userId = $user['id'];

        $polls = Poll::with('options')->where('user_id', $userId)->get();
        $votes = Vote::where('user_id', $userId);

        return Inertia::render('MyPolls', [
            'polls' => $polls,
            'votes' => $votes,
            'userLogin' => $user['login']
        ]);
    }

    function deletePoll(Request $request) {
        try {
            $poll = Poll::find($request->pollId);
            $options = Option::where('poll_id', $request->pollId)->pluck('id');
            $votes = Vote::where('user_id', auth()->user()['id'])->whereIn('option_id', $options)->get();
            foreach ($votes as $vote) {
                $vote->delete();
            }
            $poll->delete();
            return redirect('user-polls');
        }
        catch (Exception $e) {
            Log::alert('error', [
                'error' => $e->getMessage()
            ]);
        }
    }

    function pollResult(Request $request) {
        $poll = Poll::with('options')->find($request->pollId);
        $category = Category::find($poll['category_id'])['name'];
        return Inertia::render('PollResults', [
            'poll' => $poll,
            'category' => $category
        ]);
    }

    function latestPolls() {
        $polls = [];
        $latestPolls = Poll::latest()->take(2)->where('status', 'Активен')->get();
        $user = auth()->user();

        for ($i = 0; $i < 2; $i++) {
            $poll = $latestPolls[$i];
            $polls[$i] = $poll;
            $polls[$i]['options'] = Option::where('poll_id', $poll['id'])->get();
            $polls[$i]['author'] = User::where('id', $poll['user_id'])->first()['login'];
        }

        if ($user) {
            $votes = Vote::where('user_id', $user['id'])->get();

            return Inertia::render('Main', [
                'polls' => $polls,
                'user' => $user,
                'votes' => $votes
            ]);
        }
        else {
            return Inertia::render('Main', [
                'polls' => $polls,
                'user' => $user,
            ]);
        }

    }

    function history() {
        $user = auth()->user();
        $optionIds = Vote::select('option_id')->where('user_id', $user['id'])->get();
        $pollIds = Option::select('poll_id')->whereIn('id', $optionIds)->get();
        $polls = Poll::with('options')->whereIn('id', $pollIds)->get();
        $votes = Vote::where('user_id', $user['id'])->get();

        return Inertia::render('History', [
            'polls' => $polls,
            'votes' => $votes
        ]);
    }

    function createPoll() {
        return Inertia::render('CreatePoll', [
            'userLogin' => auth()->user()['login']
        ]);
    }
}
