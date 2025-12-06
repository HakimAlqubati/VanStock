<?php

namespace Database\Seeders;

use App\Models\SalesRepresentative;
use App\Models\Store;
use App\Models\Vehicle;
use App\Models\VehicleAssignment;
use Illuminate\Database\Seeder;

class VehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $reps = SalesRepresentative::all();

        foreach ($reps as $index => $rep) {
            // 1. Create a Store for the Vehicle (Default Store)
            $store = Store::create([
                'name' => 'Van Store - ' . $rep->name,
                'location' => 'Mobile',
                'active' => true,
                'default_store' => true,
                'storekeeper_id' => $rep->user_id,
            ]);

            // 2. Create a Vehicle
            $vehicle = Vehicle::create([
                'store_id' => $store->id,
                'plate_number' => 'ABC-' . str_pad((string)($index + 1), 4, '0', STR_PAD_LEFT),
                'model' => 'Toyota Hilux',
                'chassis_number' => 'CH-' . str_pad((string)rand(0, 99999999), 8, '0', STR_PAD_LEFT),
                'status' => 'active',
                'max_load_capacity_kg' => 1000,
                'license_expiry_date' => now()->addYear(),
                'insurance_expiry_date' => now()->addYear(),
            ]);

            // 3. Assign Vehicle to Sales Representative
            $rep->update([
                'current_vehicle_id' => $vehicle->id,
            ]);

            // 4. Create Vehicle Assignment Record
            VehicleAssignment::create([
                'vehicle_id' => $vehicle->id,
                'sales_representative_id' => $rep->id,
                'assigned_at' => now(),
                'start_odometer' => 0,
                'notes' => 'Initial assignment',
            ]);
        }
    }
}
