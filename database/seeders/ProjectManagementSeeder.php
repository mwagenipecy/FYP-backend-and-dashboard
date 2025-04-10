<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use App\Models\Level;
use App\Models\Hub;
use App\Models\ProjectIdea;
use App\Models\Project;
use App\Models\ProjectPhase;
use App\Models\Stage;
use App\Models\StageSubmission;
use App\Models\Activity;
use Faker\Factory as Faker;

class ProjectManagementSeeder extends Seeder
{
    protected $faker;
    
    public function __construct()
    {
        $this->faker = Faker::create();
    }
    
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create default roles
        $this->createRoles();
        
        // Create permissions
        $this->createPermissions();
        
        // Create levels
        $this->createLevels();
        
        // Create hubs
        $this->createHubs();
        
        // Create users
        $this->createUsers();
        
        // Create project ideas
        $this->createProjectIdeas();
        
        // Create projects and related data
        $this->createProjects();
    }
    
    /**
     * Create roles
     */
    private function createRoles()
    {
        $roles = [
            ['name' => 'Admin'],
            ['name' => 'Supervisor'],
            ['name' => 'Member'],
            ['name' => 'Reviewer'],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
        
        // Create additional random roles
        for ($i = 0; $i < 3; $i++) {
            Role::create(['name' => $this->faker->unique()->jobTitle()]);
        }
        
        $this->command->info('Roles created successfully!');
    }
    
    /**
     * Create permissions
     */
    private function createPermissions()
    {
        $permissions = [
            ['name' => 'manage_users', 'status' => 'active'],
            ['name' => 'manage_projects', 'status' => 'active'],
            ['name' => 'review_ideas', 'status' => 'active'],
            ['name' => 'manage_phases', 'status' => 'active'],
            ['name' => 'manage_stages', 'status' => 'active'],
            ['name' => 'submit_work', 'status' => 'active'],
            ['name' => 'approve_submissions', 'status' => 'active'],
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
        
        // Create additional random permissions
        for ($i = 0; $i < 5; $i++) {
            Permission::create([
                'name' => $this->faker->unique()->word() . '_permission',
                'status' => $this->faker->randomElement(['active', 'inactive']),
            ]);
        }
        
        // Assign permissions to roles
        $admin = Role::where('name', 'Admin')->first();
        $supervisor = Role::where('name', 'Supervisor')->first();
        $member = Role::where('name', 'Member')->first();
        $reviewer = Role::where('name', 'Reviewer')->first();

        if ($admin) $admin->permissions()->attach(Permission::all());
        if ($supervisor) $supervisor->permissions()->attach(Permission::whereIn('name', ['manage_projects', 'manage_phases', 'manage_stages', 'approve_submissions'])->get());
        if ($member) $member->permissions()->attach(Permission::whereIn('name', ['submit_work'])->get());
        if ($reviewer) $reviewer->permissions()->attach(Permission::whereIn('name', ['review_ideas'])->get());
        
        $this->command->info('Permissions created and assigned successfully!');
    }
    
    /**
     * Create levels
     */
    private function createLevels()
    {
        $levels = [
            ['name' => 'Beginner', 'status' => 'active'],
            ['name' => 'Intermediate', 'status' => 'active'],
            ['name' => 'Advanced', 'status' => 'active'],
            ['name' => 'Expert', 'status' => 'active'],
        ];

        foreach ($levels as $level) {
            Level::create($level);
        }
        
        $this->command->info('Levels created successfully!');
    }
    
    /**
     * Create hubs
     */
    private function createHubs()
    {
        $hubs = [
            [
                'name' => 'Technology Hub',
                'address' => '123 Tech Street, Silicon Valley',
                'about' => 'A hub focused on technological innovation and development.'
            ],
            [
                'name' => 'Creative Hub',
                'address' => '456 Creative Avenue, Design District',
                'about' => 'A hub for creative minds and artistic projects.'
            ],
            [
                'name' => 'Research Hub',
                'address' => '789 Research Road, Academic Center',
                'about' => 'A hub dedicated to research and academic projects.'
            ],
            [
                'name' => 'Business Hub',
                'address' => '101 Business Boulevard, Commerce City',
                'about' => 'A hub for entrepreneurship and business development.'
            ],
        ];

        foreach ($hubs as $hub) {
            Hub::create($hub);
        }
        
        // Create additional random hubs
        for ($i = 0; $i < 3; $i++) {
            Hub::create([
                'name' => $this->faker->company() . ' Hub',
                'address' => $this->faker->address(),
                'about' => $this->faker->paragraph(),
            ]);
        }
        
        $this->command->info('Hubs created successfully!');
    }
    
    /**
     * Create users
     */
    private function createUsers()
    {
        // Get IDs for roles
        $adminRoleId = Role::where('name', 'Admin')->first()->id;
        $supervisorRoleId = Role::where('name', 'Supervisor')->first()->id;
        $memberRoleId = Role::where('name', 'Member')->first()->id;
        $reviewerRoleId = Role::where('name', 'Reviewer')->first()->id;
        
        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@43effdfxample.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        
            'regno' => '1234567890',
            ////'hub_id' => Hub::inRandomOrder()->first()->id,
            'role_id' => $adminRoleId,
            'level_id' => Level::inRandomOrder()->first()->id,
        ]);
        
        // Create supervisor user
        User::create([
            'name' => 'Supervisor User',
            'email' => 'supervisorfd@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
         
            'regno' => '2345678901',
            ////'hub_id' => Hub::inRandomOrder()->first()->id,
            'role_id' => $supervisorRoleId,
            'level_id' => Level::inRandomOrder()->first()->id,
        ]);
        
        // Create member user
        User::create([
            'name' => 'Member User',
            'email' => 'membedfr@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
         
            'regno' => '3456789012',
          //  //'hub_id' => Hub::inRandomOrder()->first()->id,
            'role_id' => $memberRoleId,
            'level_id' => Level::inRandomOrder()->first()->id,
        ]);
        
        // Create reviewer user
        User::create([
            'name' => 'Reviewer User',
            'email' => 'reviewerdf@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
           
            'regno' => '4567890123',
            //'hub_id' => Hub::inRandomOrder()->first()->id,
            'role_id' => $reviewerRoleId,
            'level_id' => Level::inRandomOrder()->first()->id,
        ]);
        
        // Create additional supervisors
        for ($i = 1; $i <= 4; $i++) {
            User::create([
                'name' => "Supervisor $i",
                'email' => "supervisor$i@example.com",
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
                //'fname' => "Super$i",
                //'lname' => "Visor",
                'regno' =>3455,
                //'hub_id' => Hub::inRandomOrder()->first()->id,
                'role_id' => $supervisorRoleId,
                'level_id' => Level::inRandomOrder()->first()->id,
            ]);
        }
        
        // Create additional members
        for ($i = 1; $i <= 10; $i++) {
            User::create([
                'name' => "Member $i",
                'email' => "member$i@example.com",
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
                //'fname' => $this->faker->firstName(),
                //'lname' => $this->faker->lastName(),
                'regno' =>3455,
                //'hub_id' => Hub::inRandomOrder()->first()->id,
                'role_id' => $memberRoleId,
                'level_id' => Level::inRandomOrder()->first()->id,
            ]);
        }
        
        // Create additional reviewers
        for ($i = 1; $i <= 2; $i++) {
            User::create([
                'name' => "Reviewer $i",
                'email' => "reviewer$i@example.com",
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
                //'fname' => $this->faker->firstName(),
                //'lname' => $this->faker->lastName(),
                'regno' =>3455,
                //'hub_id' => Hub::inRandomOrder()->first()->id,
                'role_id' => $reviewerRoleId,
                'level_id' => Level::inRandomOrder()->first()->id,
            ]);
        }
        
        $this->command->info('Users created successfully!');
    }
    
    /**
     * Create project ideas
     */
    private function createProjectIdeas()
    {
        // Get member and reviewer users
        $members = User::where('role_id', Role::where('name', 'Member')->first()->id)->get();
        $reviewers = User::where('role_id', Role::where('name', 'Reviewer')->first()->id)->get();
        
        // Create 25 random project ideas
        for ($i = 0; $i < 25; $i++) {
            $idea = ProjectIdea::create([
                'title' => $this->faker->sentence(4),
                'description' => $this->faker->paragraphs(3, true),
                'status' => $this->faker->randomElement(['submitted', 'under_review', 'needs_qualification', 'approved', 'rejected']),
                'user_id' => $members->random()->id,
            ]);
            
            // Create activity log for idea submission
            Activity::create([
                'name' => 'Project Idea Submitted',
                'description' => 'Submitted a new project idea: ' . $idea->title,
                'type' => 'project_idea',
                'user_id' => $idea->user_id,
                'issue_date' => now()->subDays(rand(1, 30)),
            ]);
        }
        
        $this->command->info('Project ideas created successfully!');
    }
    
    /**
     * Create projects and related data
     */
    private function createProjects()
    {
        // Get users by role
        $supervisors = User::where('role_id', Role::where('name', 'Supervisor')->first()->id)->get();
        $members = User::where('role_id', Role::where('name', 'Member')->first()->id)->get();
        
        // Create 15 projects
        for ($i = 0; $i < 15; $i++) {
            $project = Project::create([
                'title' => $this->faker->sentence(4),
                'description' => $this->faker->paragraphs(3, true),
                'status' => $this->faker->randomElement(['draft', 'in_progress', 'completed']),
                'stage' => $this->faker->randomElement(['planning', 'development', 'testing', 'deployment']),
                //'hub_id' => Hub::inRandomOrder()->first()->id,
            ]);
            
            // Assign creator
            $creator = $members->random();
            $project->users()->attach($creator->id, ['role' => 'creator']);
            
            // Assign supervisor
            $supervisor = $supervisors->random();
            $project->users()->attach($supervisor->id, ['role' => 'supervisor']);
            
            // Assign 2-5 random members
            $projectMembers = $members->where('id', '!=', $creator->id)->random(rand(2, min(5, $members->count() - 1)));
            foreach ($projectMembers as $member) {
                $project->users()->attach($member->id, ['role' => 'member']);
            }
            
            // Create phases for this project
            $phaseCount = rand(2, 5);
            for ($j = 1; $j <= $phaseCount; $j++) {
                $phase = ProjectPhase::create([
                    'name' => $this->faker->word() . ' Phase',
                    'description' => $this->faker->sentence(),
                    'order' => $j,
                    'project_id' => $project->id,
                ]);
                
                // Create stages for this phase
                $stageCount = rand(2, 4);
                for ($k = 1; $k <= $stageCount; $k++) {
                    $stage = Stage::create([
                        'name' => $this->faker->word() . ' Stage',
                        'status' => $this->faker->randomElement(['pending', 'in_progress', 'submitted', 'returned', 'approved']),
                        'description' => $this->faker->sentence(),
                        'project_id' => $project->id,
                        'phase_id' => $phase->id,
                        'order' => $k,
                    ]);
                    
                    // Create submissions for this stage
                    if (in_array($stage->status, ['submitted', 'returned', 'approved']) && $projectMembers->count() > 0) {
                        $submissionCount = rand(1, 3);
                        for ($l = 0; $l < $submissionCount; $l++) {
                            $submitter = $projectMembers->random();
                            
                            $submission = StageSubmission::create([
                                'stage_id' => $stage->id,
                                'user_id' => $submitter->id,
                                'content' => $this->faker->paragraphs(2, true),
                                'status' => $stage->status === 'submitted' ? 'submitted' : 
                                          ($stage->status === 'returned' ? 'returned' : 'approved'),
                                'feedback' => $stage->status === 'returned' ? $this->faker->paragraph() : null,
                            ]);
                            
                            // Create activity for the submission
                            Activity::create([
                                'name' => 'Stage Submission',
                                'description' => 'Submitted work for stage: ' . $stage->name,
                                'type' => 'stage',
                                'project_id' => $project->id,
                                'user_id' => $submitter->id,
                                'issue_date' => now()->subDays(rand(1, 14)),
                            ]);
                            
                            // If approved or returned, create supervisor activity
                            if (in_array($submission->status, ['approved', 'returned'])) {
                                Activity::create([
                                    'name' => $submission->status === 'approved' ? 'Stage Approved' : 'Stage Returned',
                                    'description' => $submission->status === 'approved' ? 
                                        'Approved stage: ' . $stage->name : 
                                        'Returned stage for updates: ' . $stage->name,
                                    'type' => 'stage',
                                    'project_id' => $project->id,
                                    'user_id' => $supervisor->id,
                                    'issue_date' => now()->subDays(rand(1, 7)),
                                ]);
                            }
                        }
                    }
                }
            }
            
            // Create project activities
            Activity::create([
                'name' => 'Project Created',
                'description' => 'Project created: ' . $project->title,
                'type' => 'project',
                'project_id' => $project->id,
                'user_id' => $creator->id,
                'issue_date' => now()->subDays(rand(30, 60)),
            ]);
            
            Activity::create([
                'name' => 'Supervisor Assigned',
                'description' => 'Supervisor assigned to project: ' . $project->title,
                'type' => 'project',
                'project_id' => $project->id,
                'user_id' => $supervisor->id,
                'issue_date' => now()->subDays(rand(25, 45)),
            ]);
        }
        
        // Create additional random activities
        for ($i = 0; $i < 20; $i++) {
            Activity::create([
                //'hub_id' => Hub::inRandomOrder()->first()->id,
                'name' => $this->faker->sentence(3),
                'description' => $this->faker->sentence(),
                'link' => $this->faker->optional(0.3)->url(),
                'issue_date' => $this->faker->dateTimeThisMonth(),
                'end_date' => $this->faker->optional(0.7)->dateTimeThisMonth('+30 days'),
                'created_by' => $this->faker->name(),
                'type' => $this->faker->randomElement(['project', 'stage', 'project_idea']),
                'user_id' => User::inRandomOrder()->first()->id,
                'project_id' => Project::inRandomOrder()->first()->id,
            ]);
        }
        
        $this->command->info('Projects, phases, stages, submissions, and activities created successfully!');
    }
}