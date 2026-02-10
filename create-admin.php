<?php

require '/var/www/vendor/autoload.php';
$app = require_once '/var/www/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;

$user = User::updateOrCreate(
    ['email' => 'admin@PMII.id'],
    [
        'name' => 'Admin PMII',
        'password' => bcrypt('password'),
        'role' => 'admin',
        'email_verified_at' => now(),
    ]
);

echo "✅ Admin user created successfully!\n";
echo "📧 Email: admin@PMII.id\n";
echo "🔑 Password: password\n";
echo "\n🌐 Login at: http://localhost/login\n";
