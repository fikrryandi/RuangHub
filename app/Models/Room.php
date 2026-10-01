<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Room extends Model {
    use SoftDeletes;
    protected $guarded = ['id'];
    protected function casts(): array {
        return [
            'facilities' => 'array',
        ];
    }
    public function bookings() {
        return $this->hasMany(Booking::class);
    }
}
