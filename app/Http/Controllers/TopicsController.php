<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\TopicRequest;
use App\Models\Category;
use App\Handlers\ImageUploadHandler;
use Illuminate\Support\Facades\Auth;

class TopicsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

	public function index(Request $request, Topic $topic)
	{
		$topics = $topic->withOrder($request->order)
						->with(['user', 'category'])
						->paginate(20);
		return view('topics.index', compact('topics'));
	}

    public function show(Request $request, Topic $topic)
    {
		if (!empty($topic->slug) && $topic->slug != $request->slug) {
			return redirect($topic->link(), 301);
		}
        return view('topics.show', compact('topic'));
    }

	/**
	 * 显示创建资源表单。
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create(Topic $topic)
	{
		$categories = Category::all();
		return view('topics.create_and_edit', compact('topic', 'categories'));
	}

	/**
	 * 存储新创建的资源。
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(TopicRequest $request, Topic $topic)
	{
		$topic->fill($request->all());
		$topic->user_id = auth()->user()->id;
		$topic->save();
		return redirect($topic->link())->with('message', '帖子创建成功');
	}

	/**
	 * 显示编辑资源表单。
	 *
	 * @param  \App\Models\Topic  $topic
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Topic $topic)
	{
        $this->authorize('update', $topic);
		$categories = Category::all();
		return view('topics.create_and_edit', compact('topic', 'categories'));	
	}

	/**
	 * 更新指定资源。
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Models\Topic  $topic
	 * @return \Illuminate\Http\Response
	 */
	public function update(TopicRequest $request, Topic $topic)
	{
		$this->authorize('update', $topic);
		$topic->update($request->all());

		return redirect($topic->link())->with('message', '帖子更新成功');
	}

	public function destroy(Topic $topic)
	{
		$this->authorize('destroy', $topic);
		$topic->delete();

		return redirect()->route('topics.index')->with('message', 'Deleted successfully.');
	}

	/**
	 * 上传图片
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function uploadImage(Request $request, ImageUploadHandler $uploader)
	{
		$data = [
			'success' => false,
			'msg' => '上传失败',
			'file_path' => '',
		];

		if ($file = $request->upload_file) {
			$result = $uploader->save($file, 'topics', Auth::user()->id, 1024);
			if ($result) {
				$data['success'] = true;
				$data['msg'] = '上传成功';
				$data['file_path'] = $result['path'];
			}
		}

		return $data;
	}
		
}