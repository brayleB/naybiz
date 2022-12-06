<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run($hoa_id = 0)
    {
        DB::table('questions')->insert([

            [
                'hoa_id' => $hoa_id,
                'type' => 'true_false',
                'question' => 'The HOA can issue fines if you fail to maintain the front yard.',
                'options' => '["True","False"]',               
                'answer' => 1,
                'description' => 'The Homeowner`s Association regularly inspects the front yards of homes in the community. If your yard is not properly maintained, the HOA may issue a monetary fine. So, you should keep the grass mowed, bushes trimmed and the area free of weeds',
                'status' => 'active',
            ],
            [
                'hoa_id' => $hoa_id,
                'type' => 'multiple',
                'question' => 'For which of the following would you need to get prior approval from the Design Review Committee?',
                'options' => '["A.  Painting the outside of your home","B.  Pouring a driveway extension","C.  Installing a jungle gym in your back yard", "D.  All of the above"]',
                'answer' => 3,
                'description' => 'Any type of change or modification to the exterior of your home that is visible from neighboring property must be approved by the Design Review Committee before any work starts.',
                'status' => 'active',
            ],
            [
                'hoa_id' => $hoa_id,
                'type' => 'multiple',
                'question' => 'A home-based business:',
                'options' => '["A.  Cannot cause traffic congestion","B.  Cannot accept large deliveries of goods","C.  Cannot involve multi-level marketing","D.  Both 1 and 2 "]',
                'answer' => 3,
                'description' => 'Homeowners may conduct a business activity in the home so long as: (a) the operation of the business is not apparent by sight, sound or smell from outside the home; (b) the business activity is a legal activity and conforms to all applicable zoning ordinances; (c) the business does not involve persons coming to the Lot to purchase goods or services or the door-to-door solicitation of Owners; (d) business is conducted by the homeowner with no outside employees; (e) the business does not cause traffic congestion; (f) the business does not utilize flammable liquids or hazardous materials in quantities not customary to a residential use.',
                'status' => 'active',
            ],
            [
                'hoa_id' => $hoa_id,
                'type' => 'multiple',
                'question' => 'You should stop paying your dues and assessments to protest actions or conduct of the HOA Board you disagree with.',
                'options' => '["A.  Carry plastic bags to clean up after your pet","B.  Leave the dog poop for others to clean up"]',
                'answer' => $hoa_id,
                'description' => 'Few things will draw the ire of your neighbors more than intentionally leaving your dog`s poop in the common area for others to deal with.',
                'status' => 'active',
            ],
            [
                'hoa_id' => $hoa_id,
                'type' => 'true_false',
                'question' => 'You should stop paying your dues and assessments to protest actions or conduct of the HOA Board you disagree with.',
                'options' => '["True","False"]',
                'answer' => $hoa_id,
                'description' => 'While attempting to resolve disputes with the HOA Board, you should continue to pay your dues and assessments. Unpaid assessments will accrue interest and if they remain unpaid over time, the HOA Board may force your house to be sold to pay the debt.',
                'status' => 'active',
            ],
            [
                'hoa_id' => $hoa_id,
                'type' => 'true_false',
                'question' => 'I should use my garage and driveway before parking on the street.',
                'options' => '["True","False"]',
                'answer' => $hoa_id,
                'description' => 'The goal of the community is to reduce street parking to prevent traffic congestion and to make room for emergency vehicles.',
                'status' => 'active',
            ],
            [
                'hoa_id' => $hoa_id,
                'type' => 'multiple',
                'question' => 'I can store my boat or RV at the house',
                'options' => '["A.  If it is behind a fence","B.  As long as it is on the street","C.  None of the above "]',
                'answer' => 2,
                'description' => 'No boats, RVs, trailers or campers may be kept on any lot if they are visible above the fence line.',
                'status' => 'active',
            ],
            [
                'hoa_id' => $hoa_id,
                'type' => 'true_false',
                'question' => 'I should take my garbage cans off of the street and put them behind my fence as soon as possible after the garbage is picked up.',
                'options' => '["True","False"]',
                'answer' => $hoa_id,
                'description' => 'Garbage cans should only be out on the curb for the shortest time reasonably necessary for collection on trash collection day.',
                'status' => 'active',
            ],
            [
                'hoa_id' => $hoa_id,
                'type' => 'true_false',
                'question' => 'I do not need HOA Board approval before installing playground equipment in the backyard.',
                'options' => '["True","False"]',
                'answer' => 1,
                'description' => 'HOA Board approval is required to install any playground equipment in the backyard if it is visible above the fence line.',
                'status' => 'active',
            ],
            [
                'hoa_id' => $hoa_id,
                'type' => 'multiple',
                'question' => 'All new tenants in the community must register with the HOA:',
                'options' => '["A.  For emergency purposes","b.  So the HOA can include tenants on important communications about the community","C.  To prevent the tenant`s vehicles from being towed by accident","D.  All of the above"]',
                'answer' => 3,
                'description' => 'It is important for the HOA to have tenants` contact information and license plate numbers so 1) the HOA knows who to contact in case of an emergency, 2) the HOA can include the tenants in important communication about the community, and 3) the HOA knows the tenant`s vehicles are legally parked in the community.',
                'status' => 'active',
            ],
        ]);
    }
}
