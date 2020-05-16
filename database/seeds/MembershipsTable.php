<?php

use Illuminate\Database\Seeder;
use App\Models\PhysicianMembershipMasterModel;

class MembershipsTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PhysicianMembershipMasterModel::create([
                'name' => 'IHK'
            ]);

        PhysicianMembershipMasterModel::create(
            [
                'name' => 'IHMA'
            ]);

        PhysicianMembershipMasterModel::create(
            [
                'name' => 'QPHA'
            ]);
    }
}
