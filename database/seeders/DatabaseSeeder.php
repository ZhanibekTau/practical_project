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
        $users = User::factory(10)->create();
        $projects = Project::factory(5)->create();

        foreach ($projects as $project) {
            $project->users()->attach($users->random(rand(1, 5)), [
                'created_at' => now(),
                'updated_at' => now(),
            ]);;
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

        AttributeValue::factory(20)->create();

        Timesheet::factory(30)->create();
    }
}
