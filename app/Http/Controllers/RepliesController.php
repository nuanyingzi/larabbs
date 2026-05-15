<?php

namespace App\Http\Controllers;

use App\Models\Reply;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ReplyRequest;
use Illuminate\Support\Facades\Auth;

class RepliesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

	/**
	 * 回复话题
	 */
	public function store(ReplyRequest $request, Reply $reply)
	{
		$reply->content = clean($request->content, 'user_topic_body');
		$reply->user_id = Auth::user()->id;
		$reply->topic_id = $request->topic_id;
		$result = $reply->save();
		if (!$result) {
			return back()->with('danger', '回复失败');
		}
		
		return redirect()->to($reply->topic->link())->with('message', '回复成功');
	}

	/**
	 * 删除回复
	 */
	public function destroy(Reply $reply)
	{
		$this->authorize('destroy', $reply);
		$reply->delete();

		return redirect()->to($reply->topic->link())->with('success', '删除成功');
	}
}