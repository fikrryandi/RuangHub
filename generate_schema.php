<?php
$migrations = glob(__DIR__ . '/database/migrations/*.php');

$schemas = [
    'create_departments_table' => "\$table->id();\n            \$table->string('name');\n            \$table->timestamps();",
    'create_users_table' => "\$table->id();
            \$table->string('nip')->nullable();
            \$table->string('name');
            \$table->string('email')->unique();
            \$table->timestamp('email_verified_at')->nullable();
            \$table->string('password');
            \$table->string('phone')->nullable();
            \$table->enum('gender', ['L', 'P'])->nullable();
            \$table->string('birth_place')->nullable();
            \$table->date('birth_date')->nullable();
            \$table->text('address')->nullable();
            \$table->foreignId('department_id')->nullable()->constrained('departments')->nullOnDelete();
            \$table->string('position')->nullable();
            \$table->enum('role', ['admin', 'approver', 'karyawan'])->default('karyawan');
            \$table->string('employment_status')->nullable();
            \$table->string('photo')->nullable();
            \$table->string('google_id')->nullable();
            \$table->boolean('is_active')->default(true);
            \$table->timestamp('last_login_at')->nullable();
            \$table->rememberToken();
            \$table->timestamps();
            \$table->softDeletes();",
    'create_rooms_table' => "\$table->id();
            \$table->string('code')->unique();
            \$table->string('name');
            \$table->string('location')->nullable();
            \$table->integer('capacity')->default(0);
            \$table->json('facilities')->nullable();
            \$table->string('photo')->nullable();
            \$table->enum('status', ['aktif', 'maintenance', 'nonaktif'])->default('aktif');
            \$table->timestamps();
            \$table->softDeletes();",
    'create_bookings_table' => "\$table->id();
            \$table->string('code')->unique(); // BK-YYYYMMDD-XXX
            \$table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            \$table->foreignId('room_id')->constrained('rooms')->cascadeOnDelete();
            \$table->date('date');
            \$table->time('start_time');
            \$table->time('end_time');
            \$table->string('purpose');
            \$table->text('notes')->nullable();
            \$table->enum('status', ['menunggu_approval', 'disetujui', 'ditolak', 'revisi', 'dibatalkan', 'selesai', 'kadaluarsa'])->default('menunggu_approval');
            \$table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            \$table->timestamp('approved_at')->nullable();
            \$table->text('rejection_reason')->nullable();
            \$table->timestamps();",
    'create_check_ins_table' => "\$table->id();
            \$table->foreignId('booking_id')->constrained('bookings')->cascadeOnDelete();
            \$table->timestamp('checkin_time')->nullable();
            \$table->enum('status', ['tepat_waktu', 'terlambat', 'tidak_checkin', 'belum'])->default('belum');
            \$table->timestamps();",
    'create_notifications_table' => "\$table->id();
            \$table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            \$table->enum('type', ['booking', 'approval', 'sistem', 'informasi'])->default('informasi');
            \$table->string('title');
            \$table->text('message');
            \$table->string('link')->nullable();
            \$table->boolean('is_read')->default(false);
            \$table->timestamps();",
    'create_settings_table' => "\$table->id();
            \$table->string('key')->unique();
            \$table->text('value')->nullable();
            \$table->timestamps();",
    'create_activity_logs_table' => "\$table->id();
            \$table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            \$table->string('action');
            \$table->text('description');
            \$table->timestamps();",
    'create_documents_table' => "\$table->id();
            \$table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            \$table->enum('type', ['ktp', 'npwp', 'bpjs_kesehatan', 'bpjs_ketenagakerjaan']);
            \$table->string('file_path');
            \$table->enum('status', ['terverifikasi', 'belum_verifikasi'])->default('belum_verifikasi');
            \$table->timestamps();"
];

foreach ($migrations as $file) {
    $content = file_get_contents($file);
    foreach ($schemas as $key => $schema) {
        if (strpos($file, $key) !== false) {
            preg_match("/Schema::create\('([^']+)'/", $content, $matches);
            if (isset($matches[1])) {
                $tableName = $matches[1];
                $replacement = "Schema::create('$tableName', function (Blueprint \$table) {\n            $schema\n        });";
                $content = preg_replace('/Schema::create\(.*?, function \(Blueprint \$table\) \{.*?\}\);/s', $replacement, $content);
                file_put_contents($file, $content);
                echo "Updated $file\n";
            }
        }
    }
}

$models = [
    'User.php' => "<?php\n\nnamespace App\Models;\n\nuse Illuminate\Database\Eloquent\Factories\HasFactory;\nuse Illuminate\Foundation\Auth\User as Authenticatable;\nuse Illuminate\Notifications\Notifiable;\nuse Illuminate\Database\Eloquent\SoftDeletes;\n\nclass User extends Authenticatable\n{\n    use HasFactory, Notifiable, SoftDeletes;\n\n    protected \$guarded = ['id'];\n\n    protected \$hidden = [\n        'password',\n        'remember_token',\n    ];\n\n    protected function casts(): array\n    {\n        return [\n            'email_verified_at' => 'datetime',\n            'password' => 'hashed',\n            'is_active' => 'boolean',\n            'last_login_at' => 'datetime',\n            'birth_date' => 'date',\n        ];\n    }\n\n    public function department()\n    {\n        return \$this->belongsTo(Department::class);\n    }\n\n    public function notifications()\n    {\n        return \$this->hasMany(Notification::class);\n    }\n\n    public function documents()\n    {\n        return \$this->hasMany(Document::class);\n    }\n}\n",
    'Department.php' => "<?php\nnamespace App\Models;\nuse Illuminate\Database\Eloquent\Model;\nclass Department extends Model { protected \$guarded = ['id']; }\n",
    'Room.php' => "<?php\nnamespace App\Models;\nuse Illuminate\Database\Eloquent\Model;\nuse Illuminate\Database\Eloquent\SoftDeletes;\nclass Room extends Model {\n    use SoftDeletes;\n    protected \$guarded = ['id'];\n    protected function casts(): array {\n        return [\n            'facilities' => 'array',\n        ];\n    }\n}\n",
    'Booking.php' => "<?php\nnamespace App\Models;\nuse Illuminate\Database\Eloquent\Model;\nclass Booking extends Model {\n    protected \$guarded = ['id'];\n    protected function casts(): array {\n        return [\n            'date' => 'date',\n            'start_time' => 'datetime:H:i',\n            'end_time' => 'datetime:H:i',\n            'approved_at' => 'datetime',\n        ];\n    }\n    public function user() { return \$this->belongsTo(User::class); }\n    public function room() { return \$this->belongsTo(Room::class); }\n    public function approvedBy() { return \$this->belongsTo(User::class, 'approved_by'); }\n    public function checkIn() { return \$this->hasOne(CheckIn::class); }\n}\n",
    'CheckIn.php' => "<?php\nnamespace App\Models;\nuse Illuminate\Database\Eloquent\Model;\nclass CheckIn extends Model {\n    protected \$guarded = ['id'];\n    protected function casts(): array {\n        return [\n            'checkin_time' => 'datetime',\n        ];\n    }\n    public function booking() { return \$this->belongsTo(Booking::class); }\n}\n",
    'Notification.php' => "<?php\nnamespace App\Models;\nuse Illuminate\Database\Eloquent\Model;\nclass Notification extends Model {\n    protected \$guarded = ['id'];\n    protected function casts(): array {\n        return [\n            'is_read' => 'boolean',\n        ];\n    }\n    public function user() { return \$this->belongsTo(User::class); }\n}\n",
    'Setting.php' => "<?php\nnamespace App\Models;\nuse Illuminate\Database\Eloquent\Model;\nclass Setting extends Model { protected \$guarded = ['id']; }\n",
    'ActivityLog.php' => "<?php\nnamespace App\Models;\nuse Illuminate\Database\Eloquent\Model;\nclass ActivityLog extends Model {\n    protected \$guarded = ['id'];\n    public function user() { return \$this->belongsTo(User::class); }\n}\n",
    'Document.php' => "<?php\nnamespace App\Models;\nuse Illuminate\Database\Eloquent\Model;\nclass Document extends Model {\n    protected \$guarded = ['id'];\n    public function user() { return \$this->belongsTo(User::class); }\n}\n"
];

foreach ($models as $filename => $content) {
    file_put_contents(__DIR__ . '/app/Models/' . $filename, $content);
    echo "Written Model $filename\n";
}
