<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RedeemController extends Controller
{
    public function index()
    {
        $vouchers = [
            [
                'id'       => 1,
                'brand'    => 'Alfamart',
                'title'    => 'Diskon 30% Belanja',
                'desc'     => 'Dapatkan potongan 30% untuk pembelian produk pilihan di seluruh gerai Alfamart. Maks. diskon Rp15.000.',
                'points'   => 15,
                'bg'       => 'bg-red-600',
                'logo_url' => asset('images/vouchers/alfamart.jpg'),
            ],
            [
                'id'       => 2,
                'brand'    => 'Indomaret',
                'title'    => 'Voucher Belanja Rp10.000',
                'desc'     => 'Gunakan voucher ini untuk potongan belanja Rp10.000 di seluruh gerai Indomaret seluruh Indonesia.',
                'points'   => 15,
                'bg'       => 'bg-blue-600',
                'logo_url' => asset('images/vouchers/indomaret.png'),
            ],
            [
                'id'       => 3,
                'brand'    => 'Starbucks',
                'title'    => 'Buy 1 Get 1 Free',
                'desc'     => 'Beli 1 minuman ukuran apapun dan dapatkan 1 gratis! Berlaku untuk semua menu di seluruh gerai Starbucks Indonesia.',
                'points'   => 20,
                'bg'       => 'bg-green-700',
                'logo_url' => asset('images/vouchers/starbucks.png'),
            ],
            [
                'id'       => 4,
                'brand'    => 'GrabFood',
                'title'    => 'Gratis Ongkir + Diskon 25%',
                'desc'     => 'Nikmati gratis ongkos kirim dan tambahan diskon 25% untuk order GrabFood. Min. order Rp30.000.',
                'points'   => 20,
                'bg'       => 'bg-green-500',
                'logo_url' => asset('images/vouchers/grab.png'),
            ],
            [
                'id'       => 5,
                'brand'    => 'Google Play',
                'title'    => 'Gift Card Rp25.000',
                'desc'     => 'Gunakan untuk membeli aplikasi, game, film, atau musik di Google Play Store.',
                'points'   => 25,
                'bg'       => 'bg-indigo-500',
                'logo_url' => asset('images/vouchers/GooglePlay.png'),
            ],
            [
                'id'       => 6,
                'brand'    => 'FamilyMart',
                'title'    => 'Diskon 20% Semua Menu',
                'desc'     => 'Hemat 20% untuk semua pembelian makanan dan minuman ready-to-eat di seluruh gerai FamilyMart Indonesia.',
                'points'   => 15,
                'bg'       => 'bg-blue-400',
                'logo_url' => asset('images/vouchers/FamilyMart.png'),
            ],
        ];

        return view('reward.redeem', compact('vouchers'));
    }

    public function redeem($id)
    {
        $user = auth()->user();

        $costs = [1 => 15, 2 => 15, 3 => 20, 4 => 20, 5 => 25, 6 => 15];
        $names = [1 => 'Alfamart', 2 => 'Indomaret', 3 => 'Starbucks', 4 => 'GrabFood', 5 => 'Google Play', 6 => 'FamilyMart'];

        $voucherCost = $costs[$id] ?? 15;
        $voucherName = $names[$id] ?? 'Voucher';

        if ($user->points < $voucherCost) {
            return back()->with('error', 'Poin kamu belum cukup untuk menukar voucher ini 😢');
        }

        $user->decrement('points', $voucherCost);

        return back()->with('success', "Voucher {$voucherName} berhasil diklaim! Cek email kamu untuk kode voucher 🎉");
    }
}