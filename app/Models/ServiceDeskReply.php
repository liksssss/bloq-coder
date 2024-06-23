<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceDeskReply extends Model
{
    use HasFactory;

    protected $fillable = ['email', 'reply', 'service_desk_id'];

    public function serviceDesk()
    {
        return $this->belongsTo(ServiceDesk::class);
    }
}
