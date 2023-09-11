<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaksi extends Model
{

    protected $table = 'transaksi';
    public static function generateRandomId()
    {
        $timestamp = now()->format('dm');

        // Generate a random number with 7 digits and left-pad with zeros if necessary
        $randomNumber = str_pad(rand(1, 999999), 6, '0', STR_PAD_LEFT);

        // Combine timestamp, random number, and a separator (for example, '-')
        $randomId = $timestamp . $randomNumber;

        return $randomId;
    }

    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama',
        'phone_number',
        'id_paket',
        'id_produk',
        'total_harga',
        'id_transaksi',
        'penjemputan',
        'tgl_berangkat',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */


    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
