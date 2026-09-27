<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

protected $fillable = [
        'order_code',
        'service_id',
        'client_name',
        'client_campus',
        'client_whatsapp',
        'notes',
        'client_file_path',
        'result_file_path',
        'admin_note',
        'status',
        'price',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
