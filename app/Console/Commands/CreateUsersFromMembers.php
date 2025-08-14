<?php

namespace App\Console\Commands;

use App\Models\Entity;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CreateUsersFromMembers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:create-from-members';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a User account for whichever members don\'t have one';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $members = Entity::where('entity_type', 'person')
            ->whereNotNull('email')
            ->get(['id', 'email', 'name']);

        $accountsCreated = 0;

        foreach ($members as $member) {

            $userExists = User::where('email', $member->email)->exists();

            $user = User::firstOrCreate([
                'email' => $member->email,
            ], [
                'name' => $member->name,
                'entity_id' => $member->id,
                'password' => Hash::make(Str::random(16)), // This line is very slow (Hash::make)
            ]);

            if (!$userExists) {
                $this->info("Created user: {$user->email}");
                $accountsCreated++;
            }
        }

        $this->info("{$accountsCreated} accounts created");
    }
}
