<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Student;
use App\Models\Landlord;
use App\Models\Property;
use App\Models\PropertyImage;
use App\Models\Review;
use App\Models\RentalApplication;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin
        User::create([
            'username' => 'admin',
            'name' => 'Admin User',
            'email' => 'admin@uthm.edu.my',
            'phone' => '0123456789',
            'password' => Hash::make('password123'),
            'user_type' => 'admin',
            'status' => 'active'
        ]);

        // Create 10 Landlords with Properties
        for ($i = 1; $i <= 10; $i++) {
            $user = User::create([
                'username' => "landlord{$i}",
                'name' => "Landlord $i",
                'email' => "landlord{$i}@example.com",
                'phone' => "01234{$i}6789",
                'password' => Hash::make('password123'),
                'user_type' => 'landlord',
                'status' => 'active'
            ]);

            $landlord = Landlord::create([
                'user_id' => $user->user_id, // Changed from $user->id
                'bank_account' => "1234567890{$i}",
                'ic_number' => "900101{$i}5678"
            ]);

            // Create 2 properties for each landlord
            for ($j = 1; $j <= 2; $j++) {
                $property = Property::create([
                    'landlord_id' => $landlord->landlord_id,
                    'title' => "Property {$j} of Landlord {$i}",
                    'description' => "A beautiful property for rent",
                    'address' => "Address {$j}, Parit Raja",
                    'monthly_rent' => rand(300, 1000),
                    'distance_from_uthm' => rand(1, 10),
                    'bedrooms' => rand(1, 4),
                    'bathrooms' => rand(1, 3),
                    'listed_date' => now(),
                    'status' => 'available',
                    'preferred_gender' => ['any', 'male', 'female'][rand(0, 2)],
                    'property_type' => ['whole house', 'room'][rand(0, 1)]
                ]);

                // Add images for each property
                for ($k = 1; $k <= 3; $k++) {
                    PropertyImage::create([
                        'property_id' => $property->property_id,
                        'image_url' => "property_{$property->property_id}_image_{$k}.jpg",
                        'display_order' => $k
                    ]);
                }
            }
        }

        // Create 10 Students with Applications and Reviews
        for ($i = 1; $i <= 10; $i++) {
            $user = User::create([
                'username' => "student{$i}",
                'name' => "Student $i",
                'email' => "student{$i}@uthm.edu.my",
                'phone' => "0123{$i}56789",
                'password' => Hash::make('password123'),
                'user_type' => 'student',
                'status' => 'active'
            ]);

            $student = Student::create([
                'user_id' => $user->user_id, // Changed from $user->id
                'matric_number' => "A{$i}0123456",
                'faculty' => "Faculty of Engineering {$i}",
                'course' => "Bachelor of Engineering {$i}",
                'semester' => rand(1, 8)
            ]);

            // Create rental applications for each student
            $properties = Property::inRandomOrder()->limit(2)->get();
            foreach ($properties as $property) {
                RentalApplication::create([
                    'property_id' => $property->property_id,
                    'student_id' => $student->student_id,
                    'application_date' => now(),
                    'status' => ['pending', 'approved', 'rejected'][rand(0, 2)],
                    'message' => "I'm interested in renting this property"
                ]);

                // Add reviews for some properties
                if (rand(0, 1)) {
                    Review::create([
                        'property_id' => $property->property_id,
                        'student_id' => $student->student_id,
                        'rating' => rand(1, 5),
                        'comment' => "This is a review for property {$property->property_id}",
                        'review_date' => now()
                    ]);
                }
            }
        }
    }
}
