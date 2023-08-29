<?php

namespace App\Http\Controllers;

use App\Models\Paket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PaketController extends Controller
{

    public function paket() {
        $data = Paket::get();
        return view('paket/paket', compact('data'));
    }

    public function create() {
        return view('paket/create');
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(),[
            'nama' => 'required',
        ]);

        if($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

        $data['name'] = $request->nama;

        Paket::create($data);

        return redirect()->route('admin.paket');

    }

    public function edit(Request $request,$id) {
        $data = Paket::find($id);

        return view('paket/edit', compact('data'));
    }

    public function update(Request $request,$id) {
        $validator = Validator::make($request->all(),[
            'nama' => 'required'
        ]);

        if($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

        $data['name'] = $request->nama;

        Paket::whereId($id)->update($data);

        return redirect()->route('admin.paket');
    }

    public function delete($id) {
        $data = Paket::find($id);

        if($data) {
            $data -> delete();
        }

        return redirect()->route('admin.paket');
    }
}
