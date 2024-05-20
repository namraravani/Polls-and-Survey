<?php

namespace App\Http\Controllers\pages;
use App\Http\Requests\CreatePollRequest;
use App\Http\Requests\UpdatePollRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Poll;
use App\Http\Requests\VoteRequest;
use App\Models\Option;
use App\Enums\PollStatus;
use App\Models\Vote;


class PollController extends Controller
{
    public function store(CreatePollRequest $request)
    {
        $poll = auth()->user()->polls()->create($request->safe()->except('options'));

        $options = [];

        $poll->options()->createMany($request->options);

        return back();
    }

    public function index()
    {
        $polls = auth()->user()->polls()->select('title','status','id')->paginate(10);

        return view('polls.list', compact('polls'));
    }

    public function edit(Poll $poll)
    {
        // abort_if(auth()->user()->isNot($poll->user), 403);
        // abort_if($poll->status != PollStatus::PENDING->value, 404);

        $poll = $poll->load('options');
        return view('polls.update', compact('poll'));
    }

    public function update(UpdatePollRequest $request, Poll $poll)
    {

        $data = $request->safe()->except('options');

        $poll->update($data);

        $poll->options()->delete();

        $poll->options()->createMany($request->options);

        return to_route('poll.index');
    }

    public function delete(Poll $poll)
    {
        // if ($poll->status != PollStatus::PENDING->value) {
        //     abort(404,'No Pending poll');
        // }

        $poll->options()->delete();

        $poll->delete();

        return back();
    }

    public function show(Poll $poll)
    {
        $poll = $poll->load('options');

        $selectedOption = $poll->votes()->where('user_id', auth()->id())->first()?->option_id;

        if ($poll->user->is(auth()->user())) {
            return view('polls.show', compact('poll' ,'selectedOption'));
        }

        abort_if($poll->status != PollStatus::STARTED->value, 404);


        return view('polls.show', compact('poll', 'selectedOption'));
    }

    public function vote(VoteRequest $request, Poll $poll)
    {

        abort_if($poll->status != PollStatus::STARTED->value, 404);
        $poll->votes()->updateOrCreate(['user_id'=>auth()->id()],['option_id'=>$request->option_id]);
        $selectedOption = $poll->votes()->where('user_id', auth()->id())->first()->option;

        $newOption =  Option::find($request->option_id);

        $newOption->increment('votes_count');


        // if ($selectedOption) {
        //     $selectedOption->decrement('votes_count');
        // }

        $selectedOption = $newOption;
        return back();
    }


}
