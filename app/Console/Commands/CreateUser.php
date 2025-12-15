<?php

namespace App\Console\Commands;

use App\Models\Entity;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create 
                            {--name= : The name of the user}
                            {--email= : The email address of the user}
                            {--password= : The password for the user}
                            {--entity= : The entity ID to associate with the user}
                            {--admin : Make the user an administrator}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new user account';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Get name
        $name = $this->option('name') ?: $this->ask('Name');
        
        // Get email
        $email = $this->option('email') ?: $this->ask('Email');
        
        // Validate email
        $validator = Validator::make(['email' => $email], [
            'email' => 'required|email|unique:users,email'
        ]);
        
        if ($validator->fails()) {
            $this->error($validator->errors()->first('email'));
            return Command::FAILURE;
        }
        
        // Get password
        $password = $this->option('password') ?: $this->secret('Password (leave blank for random)');
        
        if (empty($password)) {
            $password = \Illuminate\Support\Str::random(16);
            $this->info("Generated random password: {$password}");
        }
        
        // Get entity ID if not provided
        $entityId = $this->option('entity');
        
        if (!$entityId && $this->confirm('Associate with an entity?', false)) {
            $entityEmail = $this->ask('Enter entity email or leave blank to search by name');
            
            if ($entityEmail) {
                $entity = Entity::where('email', $entityEmail)->first();
            } else {
                $entityName = $this->ask('Enter entity name');
                $entities = Entity::where('name', 'like', "%{$entityName}%")->get();
                
                if ($entities->isEmpty()) {
                    $this->warn('No entities found matching that name.');
                } elseif ($entities->count() === 1) {
                    $entity = $entities->first();
                    $this->info("Found entity: {$entity->name}");
                } else {
                    $this->info('Multiple entities found:');
                    foreach ($entities as $index => $ent) {
                        $this->line("  [{$index}] {$ent->name} ({$ent->email})");
                    }
                    $selection = $this->ask('Select entity by number');
                    $entity = $entities->get($selection);
                }
            }
            
            if (isset($entity)) {
                $entityId = $entity->id;
            }
        }
        
        // Check admin flag
        $isAdmin = $this->option('admin') ?: $this->confirm('Make this user an administrator?', false);
        
        // Create the user
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'entity_id' => $entityId,
            'is_admin' => $isAdmin,
        ]);
        
        $this->info('User created successfully!');
        $this->newLine();
        $this->table(
            ['Field', 'Value'],
            [
                ['Name', $user->name],
                ['Email', $user->email],
                ['Entity', $user->entity ? $user->entity->name : 'None'],
                ['Admin', $user->is_admin ? 'Yes' : 'No'],
            ]
        );
        
        return Command::SUCCESS;
    }
}
