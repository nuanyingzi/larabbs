<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Handlers\ImageUploadHandler;

class UsersController extends Controller
{
    public function __construct()
    {
        // 除 show 方法外，其他方法都需要登录
        $this->middleware('auth', ['except' => ['show']]);
    }

    /**
     * 显示指定资源。
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    /**
     * 显示编辑资源的表单。
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        // 检查用户是否有权限编辑当前用户
        $this->authorize('update', $user);

        return view('users.edit', compact('user'));
    }

    /**
     * 更新指定资源。
     *
     * @param  \App\Http\Requests\UserRequest  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, ImageUploadHandler $imageUploadHandler, User $user)
    {
        // 检查用户是否有权限更新当前用户
        $this->authorize('update', $user);

        $data = $request->all();
        if ($request->avatar) {
            $result  = $imageUploadHandler->save($request->avatar, 'avatar', $user->id, 400);
            if (!$result) {
                return redirect()->back()->with('danger', '图片上传失败');
            }
            $data['avatar'] = $result['path'];
        }
        $user->update($data);
        return redirect()->route('users.show', $user->id)->with('success', '个人信息更新成功');
    }
}
