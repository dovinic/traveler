<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller {
    public function user() {

        $data = User::get();

        return view('admin.user.user', compact('data'));
    }

    public function create() {
        return view('admin.user.create');
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(),[
            'nama' => 'required',
            'password' => 'required',
        ]);

        if($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

        $data['name'] = $request->nama;
        $data['password'] = Hash::make($request->password);

        User::create($data);

        return redirect()->route('admin.user');

    }

    public function edit(Request $request,$id) {
        $data = User::find($id);

        return view('admin.user.edit', compact('data'));
    }

    public function update(Request $request,$id) {
        $validator = Validator::make($request->all(),[
            'nama' => 'required',
            'password' => 'nullable',
        ]);

        if($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

        $data['name'] = $request->nama;

        if($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        User::whereId($id)->update($data);

        return redirect()->route('admin.user');
    }

    public function delete($id) {
        $data = User::find($id);

        if($data) {
            $data -> delete();
        }

        return redirect()->route('admin.user');
    }
}
