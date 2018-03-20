<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserRoleTableSeeder::class);
        $this->call(AdminUserTableSeeder::class);
        $this->call(InfoUserTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(BlogPostTableSeeder::class);
        $this->call(ClientPostedRequestTableSeeder::class);
        $this->call(ProfessionalServicesTable::class);
        $this->call(ClientAppointmentsTable::class);
        $this->call(PaymentHistoryTable::class);
        $this->call(PaymentInfoTable::class);
        $this->call(OwnersHelpRequestsTableSeeder::class);
        $this->call(OwnersSpaceRentalsTableSeeder::class);
        $this->call(ReviewsTableSeeder::class);
    }
}
