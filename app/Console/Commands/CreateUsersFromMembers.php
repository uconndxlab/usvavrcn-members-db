<?php

namespace App\Console\Commands;

use App\Models\Entity;
use App\Models\User;
use Illuminate\Console\Command;

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
            ->where('email', '!=', '')
            ->get(['id', 'email', 'name', 'entity_type']);

        $accountsCreated = 0;

        foreach ($members as $member) {

            $userExists = User::where('email', $member->email)->exists();

            $user = User::createForEntity($member);

            if (!$userExists && $user) {
                $this->info("Created user: {$user->email}");
                $accountsCreated++;
            }
        }

        $this->info("{$accountsCreated} accounts created");
    }
}
