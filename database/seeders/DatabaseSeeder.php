<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // Create permissions
        $permissions = [
            'manage posts',
            'publish posts',
            'delete posts',
            'manage categories',
            'manage tags',
            'manage media',
            'manage users',
            'manage settings',
            'view dashboard',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles and assign permissions
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $admin->syncPermissions($permissions);

        $editor = Role::firstOrCreate(['name' => 'editor']);
        $editor->syncPermissions([
            'manage posts',
            'publish posts',
            'manage categories',
            'manage tags',
            'manage media',
            'view dashboard',
        ]);

        // Create admin user
        $adminUser = User::create([
            'name' => 'Admin',
            'email' => 'admin@alfida-cms.local',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $adminUser->assignRole('admin');

        // Create editor user
        $editorUser = User::create([
            'name' => 'Editor',
            'email' => 'editor@alfida-cms.local',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $editorUser->assignRole('editor');

        // Create default categories
        $berita = Category::create(['name' => 'Berita', 'slug' => 'berita', 'description' => 'Berita terkini seputar sekolah']);
        Category::create(['name' => 'Berita Sekolah', 'slug' => 'berita-sekolah', 'parent_id' => $berita->id]);
        Category::create(['name' => 'Berita Pendidikan', 'slug' => 'berita-pendidikan', 'parent_id' => $berita->id]);

        $pendidikan = Category::create(['name' => 'Pendidikan', 'slug' => 'pendidikan', 'description' => 'Artikel seputar pendidikan']);
        Category::create(['name' => 'Kurikulum', 'slug' => 'kurikulum', 'parent_id' => $pendidikan->id]);
        Category::create(['name' => 'Metode Belajar', 'slug' => 'metode-belajar', 'parent_id' => $pendidikan->id]);

        Category::create(['name' => 'Sains', 'slug' => 'sains', 'description' => 'Artikel sains dan teknologi']);
        Category::create(['name' => 'Kegiatan', 'slug' => 'kegiatan', 'description' => 'Kegiatan sekolah']);
        Category::create(['name' => 'Pengumuman', 'slug' => 'pengumuman', 'description' => 'Pengumuman resmi sekolah']);
    }
}
