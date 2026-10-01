const fs = require('fs');
const path = require('path');

const migrationsPath = path.join(__dirname, 'database', 'migrations');
const files = fs.readdirSync(migrationsPath);

// Define schema replacements
const schemas = {
  'create_departments_table': `$table->id();\n            $table->string('name');\n            $table->timestamps();`,
  'create_users_table': `$table->id();
            $table->string('nip')->nullable();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('phone')->nullable();
            $table->enum('gender', ['L', 'P'])->nullable();
            $table->string('birth_place')->nullable();
            $table->date('birth_date')->nullable();
            $table->text('address')->nullable();
            $table->foreignId('department_id')->nullable()->constrained('departments')->nullOnDelete();
            $table->string('position')->nullable();
            $table->enum('role', ['admin', 'approver', 'karyawan'])->default('karyawan');
            $table->string('employment_status')->nullable();
            $table->string('photo')->nullable();
            $table->string('google_id')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamp('last_login_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();`,
  'create_rooms_table': `$table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->string('location')->nullable();
            $table->integer('capacity')->default(0);
            $table->json('facilities')->nullable();
            $table->string('photo')->nullable();
            $table->enum('status', ['aktif', 'maintenance', 'nonaktif'])->default('aktif');
            $table->timestamps();
            $table->softDeletes();`,
  'create_bookings_table': `$table->id();
            $table->string('code')->unique(); // BK-YYYYMMDD-XXX
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('room_id')->constrained('rooms')->cascadeOnDelete();
            $table->date('date');
            $table->time('start_time');
            $table->time('end_time');
            $table->string('purpose');
            $table->text('notes')->nullable();
            $table->enum('status', ['menunggu_approval', 'disetujui', 'ditolak', 'revisi', 'dibatalkan', 'selesai', 'kadaluarsa'])->default('menunggu_approval');
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('approved_at')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->timestamps();`,
  'create_check_ins_table': `$table->id();
            $table->foreignId('booking_id')->constrained('bookings')->cascadeOnDelete();
            $table->timestamp('checkin_time')->nullable();
            $table->enum('status', ['tepat_waktu', 'terlambat', 'tidak_checkin', 'belum'])->default('belum');
            $table->timestamps();`,
  'create_notifications_table': `$table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->enum('type', ['booking', 'approval', 'sistem', 'informasi'])->default('informasi');
            $table->string('title');
            $table->text('message');
            $table->string('link')->nullable();
            $table->boolean('is_read')->default(false);
            $table->timestamps();`,
  'create_settings_table': `$table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();`,
  'create_activity_logs_table': `$table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('action');
            $table->text('description');
            $table->timestamps();`,
  'create_documents_table': `$table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->enum('type', ['ktp', 'npwp', 'bpjs_kesehatan', 'bpjs_ketenagakerjaan']);
            $table->string('file_path');
            $table->enum('status', ['terverifikasi', 'belum_verifikasi'])->default('belum_verifikasi');
            $table->timestamps();`
};

for (const file of files) {
  for (const key in schemas) {
    if (file.includes(key)) {
      const filePath = path.join(migrationsPath, file);
      let content = fs.readFileSync(filePath, 'utf8');
      
      // Basic replace for up() method
      content = content.replace(/Schema::create.*?, function \\(Blueprint \\$table\\) \\{[\\s\\S]*?\\}\\);/g, (match) => {
        const tableName = match.split("'")[1];
        if (!tableName) return match;
        return \`Schema::create('\${tableName}', function (Blueprint \\$table) {\\n            \${schemas[key]}\\n        });\`;
      });
      
      fs.writeFileSync(filePath, content);
      console.log('Updated ' + file);
    }
  }
}

// Write Models
const models = {
  'User.php': \`<?php

namespace App\\Models;

use Illuminate\\Database\\Eloquent\\Factories\\HasFactory;
use Illuminate\\Foundation\\Auth\\User as Authenticatable;
use Illuminate\\Notifications\\Notifiable;
use Illuminate\\Database\\Eloquent\\SoftDeletes;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $guarded = ['id'];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
            'last_login_at' => 'datetime',
            'birth_date' => 'date',
        ];
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }
}
\`,
  'Department.php': \`<?php
namespace App\\Models;
use Illuminate\\Database\\Eloquent\\Model;
class Department extends Model { protected $guarded = ['id']; }
\`,
  'Room.php': \`<?php
namespace App\\Models;
use Illuminate\\Database\\Eloquent\\Model;
use Illuminate\\Database\\Eloquent\\SoftDeletes;
class Room extends Model {
    use SoftDeletes;
    protected $guarded = ['id'];
    protected $casts = [
        'facilities' => 'array',
    ];
}
\`,
  'Booking.php': \`<?php
namespace App\\Models;
use Illuminate\\Database\\Eloquent\\Model;
class Booking extends Model {
    protected $guarded = ['id'];
    protected $casts = [
        'date' => 'date',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
        'approved_at' => 'datetime',
    ];
    public function user() { return $this->belongsTo(User::class); }
    public function room() { return $this->belongsTo(Room::class); }
    public function approvedBy() { return $this->belongsTo(User::class, 'approved_by'); }
    public function checkIn() { return $this->hasOne(CheckIn::class); }
}
\`,
  'CheckIn.php': \`<?php
namespace App\\Models;
use Illuminate\\Database\\Eloquent\\Model;
class CheckIn extends Model {
    protected $guarded = ['id'];
    protected $casts = [
        'checkin_time' => 'datetime',
    ];
    public function booking() { return $this->belongsTo(Booking::class); }
}
\`,
  'Notification.php': \`<?php
namespace App\\Models;
use Illuminate\\Database\\Eloquent\\Model;
class Notification extends Model {
    protected $guarded = ['id'];
    protected $casts = [
        'is_read' => 'boolean',
    ];
    public function user() { return $this->belongsTo(User::class); }
}
\`,
  'Setting.php': \`<?php
namespace App\\Models;
use Illuminate\\Database\\Eloquent\\Model;
class Setting extends Model { protected $guarded = ['id']; }
\`,
  'ActivityLog.php': \`<?php
namespace App\\Models;
use Illuminate\\Database\\Eloquent\\Model;
class ActivityLog extends Model {
    protected $guarded = ['id'];
    public function user() { return $this->belongsTo(User::class); }
}
\`,
  'Document.php': \`<?php
namespace App\\Models;
use Illuminate\\Database\\Eloquent\\Model;
class Document extends Model {
    protected $guarded = ['id'];
    public function user() { return $this->belongsTo(User::class); }
}
\`
};

for (const [filename, content] of Object.entries(models)) {
  fs.writeFileSync(path.join(__dirname, 'app', 'Models', filename), content);
  console.log('Written Model ' + filename);
}
