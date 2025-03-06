<?php

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Project;
use App\Models\Timesheet;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $testUser = User::factory()->create([
            'first_name' => 'Test',
            'last_name' => 'User',
            'email' => 'testuser@example.com',
            'password' => bcrypt('Test@1234'),
        ]);

        $users = User::factory(9)->create();

        $project = Project::factory()->create([
            'name' => 'Test Project',
        ]);

        $project->users()->attach($testUser, [
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $additionalProjects = Project::factory(4)->create();

        foreach ($additionalProjects as $additionalProject) {
            $additionalProject->users()->attach($users->random(rand(1, 5)), [
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $attributes = [
            ['name' => 'department', 'type' => 'text'],
            ['name' => 'start_date', 'type' => 'date'],
            ['name' => 'end_date', 'type' => 'date'],
            ['name' => 'budget', 'type' => 'number'],
            ['name' => 'priority', 'type' => 'select'],
        ];

        foreach ($attributes as $attribute) {
            Attribute::create($attribute);
        }

        AttributeValue::factory()->create([
            'attribute_id' => 1,
            'value' => 'Test Department',
        ]);

        Timesheet::factory()->create([
            'user_id' => $testUser->id,
            'project_id' => $project->id,
            'hours' => 8,
            'date' => now()->format('Y-m-d'),
        ]);
    }
}
