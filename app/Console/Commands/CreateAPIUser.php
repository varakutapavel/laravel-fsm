<?php

namespace App\Console\Commands;

use App\Actions\Fortify\CreateNewUser;
use App\Models\User;
use Illuminate\Console\Command;

class CreateAPIUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-api-user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Создает произвольного пользователя и выпускает ему AccessToken';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $name = fake()->name;
        $email = fake()->unique()->email;
        $password = fake()->password;
        $action = new CreateNewUser();
        $user = $action->create([
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'password_confirmation' => $password,
        ]);
        $token = $user->createToken($email);
        $this->info('User created');
        $this->info(sprintf('ID# %d, email: %s, AccessToken:%s',
            $user->id,
            $user->email,
            $token->plainTextToken));
    }
}
