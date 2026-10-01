<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class CheckIn extends Model {
    protected $guarded = ['id'];
    protected function casts(): array {
        return [
            'checkin_time' => 'datetime',
        ];
    }
    public function booking() { return $this->belongsTo(Booking::class); }
}
