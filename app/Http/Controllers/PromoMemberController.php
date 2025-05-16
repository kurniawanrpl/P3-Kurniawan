<?php

namespace App\Http\Controllers;

use App\Models\PromoMember;
use App\Models\Outlet;
use App\Models\Member;
use Illuminate\Http\Request;

class PromoMemberController extends Controller
{
    public function index()
    {
        $promos = PromoMember::with('member')->get();
        $temp_promos = session()->get('promo_member', []);
        $members = Member::all();

        return view('promo.member', compact('promos', 'temp_promos', 'members'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_promo' => 'required|string|max:255',
            'diskon_persen' => 'required|numeric|min:1|max:100',
            'mulai' => 'required|date',
            'selesai' => 'required|date|after_or_equal:mulai',
            'member_id' => 'required|exists:members,id',
        ]);
    
        $promo = [
            'nama_promo' => $validated['nama_promo'],
            'diskon_persen' => $validated['diskon_persen'],
            'mulai' => $validated['mulai'],
            'selesai' => $validated['selesai'],
            'member_id' => $validated['member_id'],
        ];
    
        // Simpan ke session
        $temp = session()->get('temp_promos', []);
        $temp[] = $promo;
        session()->put('temp_promos', $temp);
    
        return redirect()->back()->with('success', 'Promo berhasil ditambahkan ke daftar sementara.');
    }

    public function simpan()
    {
        $temp = session()->get('promo_member', []);
        foreach ($temp as $promo) {
            PromoMember::create($promo);
        }
        session()->forget('promo_member');

        return redirect()->route('promo.member')->with('success', 'Semua promo berhasil disimpan.');
    }

    public function edit($id)
    {
        $edit = PromoMember::findOrFail($id);
        $promos = PromoMember::with('member')->get();
        $temp_promos = session()->get('promo_member', []);
        $members = Member::all();

        return view('promo.member', compact('promos', 'temp_promos', 'edit', 'members'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_promo' => 'required',
            'diskon_persen' => 'required|numeric|min:0|max:100',
            'member_id' => 'required|exists:members,id',
            'mulai' => 'required|date',
            'selesai' => 'required|date|after_or_equal:mulai',
        ]);

        $promo = PromoMember::findOrFail($id);
        $promo->update([
            'nama_promo' => $request->nama_promo,
            'diskon_persen' => $request->diskon_persen,
            'member_id' => $request->member_id,
            'mulai' => $request->mulai,
            'selesai' => $request->selesai,
        ]);

        return redirect()->route('promo.member')->with('success', 'Promo berhasil diupdate.');
    }

    public function destroy($id)
    {
        PromoMember::findOrFail($id)->delete();
        return redirect()->route('promo.member')->with('success', 'Promo berhasil dihapus.');
    }

    public function deleteTemp($index)
    {
        $temp = session()->get('promo_member', []);
        if (isset($temp[$index])) {
            unset($temp[$index]);
            session()->put('promo_member', array_values($temp));
        }

        return redirect()->route('promo.member')->with('success', 'Promo sementara berhasil dihapus.');
    }
}
