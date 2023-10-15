<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';

    protected $fillable = [
        'user_id',
        'tanggal_transaksi',
        'kategori_id',
        'description',
        'nominal'
    ];

    public function kategori(): HasOne
    {

        return $this->hasOne(KategoriTransaksi::class, 'id', 'kategori_id');
    }
    public function user(): HasOne
    {

        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
