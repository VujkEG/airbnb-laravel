<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 0. Pravimo admin korisnika
        $user = User::updateOrCreate(
            ['email' => 'admin@airbnb.com'],
            [
                'name' => 'Admin Domaćin',
                'password' => Hash::make('password123'),
                'role' => 'host',                        
                'is_admin' => 1                          
            ]
        );

        // 1. Pravimo lokacije (Kategorije)
        $beograd = Category::updateOrCreate(
            ['name' => 'Beograd'],
            [
                'desc' => 'Glavni grad i centar zbivanja.',
                'created_by' => $user->id,
                'updated_by' => $user->id
            ]
        );
        
        $zlatibor = Category::updateOrCreate(
            ['name' => 'Zlatibor'],
            [
                'desc' => 'Prelepa planina i odmor u prirodi.',
                'created_by' => $user->id,
                'updated_by' => $user->id
            ]
        );
        
        $kopaonik = Category::updateOrCreate(
            ['name' => 'Kopaonik'],
            [
                'desc' => 'Najveći skijaški centar u regionu.',
                'created_by' => $user->id,
                'updated_by' => $user->id
            ]
        );
        
        $noviSad = Category::updateOrCreate(
            ['name' => 'Novi Sad'],
            [
                'desc' => 'Evropska prestonica kulture i Exit festivala.',
                'created_by' => $user->id,
                'updated_by' => $user->id
            ]
        );

        // Proveravamo kako se tačno zove kolona u tvojoj bazi (description ili desc)
        $descriptionField = Schema::hasColumn('products', 'description') ? 'description' : 'desc';

        // Pomoćna funkcija da bezbedno dodamo Airbnb polja ako postoje u tabeli
        $addAirbnbFields = function($array) {
            if (Schema::hasColumn('products', 'max_guests')) { $array['max_guests'] = rand(2, 6); }
            if (Schema::hasColumn('products', 'bedrooms'))   { $array['bedrooms'] = rand(1, 3); }
            if (Schema::hasColumn('products', 'bathrooms'))  { $array['bathrooms'] = rand(1, 2); }
            if (Schema::hasColumn('products', 'amenities'))  { $array['amenities'] = json_encode(['Wi-Fi', 'Klimatizovano', 'Besplatan Parking']); }
            return $array;
        };

        // 2. Pravimo apartmane (Proizvode)
        $p1 = [
            'name' => 'Moderni Stan u Centru Grada',
            $descriptionField => 'Luksuzan apartman sa pogledom na trg, potpuno opremljen sa brzim internetom i king-size krevetom.',
            'price' => 5500.00,
            'image' => null,
            'category_id' => $beograd->id,
            'created_by' => $user->id,
            'updated_by' => $user->id
        ];
        if (Schema::hasColumn('products', 'location')) { $p1['location'] = 'Beograd'; }
        Product::create($addAirbnbFields($p1));

        $p2 = [
            'name' => 'Planinska Brvnara sa SPA Zonom',
            $descriptionField => 'Idilična brvnara okružena borovom šumom. Poseduje privatni jacuzzi i kamin za savršene zimske večeri.',
            'price' => 9200.00,
            'image' => null,
            'category_id' => $zlatibor->id,
            'created_by' => $user->id,
            'updated_by' => $user->id
        ];
        if (Schema::hasColumn('products', 'location')) { $p2['location'] = 'Zlatibor'; }
        Product::create($addAirbnbFields($p2));

        $p3 = [
            'name' => 'Ski-In / Ski-Out Apartman',
            $descriptionField => 'Nalazi se direktno na stazi Karaman Greben. Idealan za strastvene skijaše i zimske odmore.',
            'price' => 12000.00,
            'image' => null,
            'category_id' => $kopaonik->id,
            'created_by' => $user->id,
            'updated_by' => $user->id
        ];
        if (Schema::hasColumn('products', 'location')) { $p3['location'] = 'Kopaonik'; }
        Product::create($addAirbnbFields($p3));

        $p4 = [
            'name' => 'Dunavski Dragulj Apartman',
            $descriptionField => 'Prelep stan sa pogledom na Petrovaradinsku tvrđavu. Na pešačkoj udaljenosti od centra grada.',
            'price' => 4800.00,
            'image' => null,
            'category_id' => $noviSad->id,
            'created_by' => $user->id,
            'updated_by' => $user->id
        ];
        if (Schema::hasColumn('products', 'location')) { $p4['location'] = 'Novi Sad'; }
        Product::create($addAirbnbFields($p4));
    }
}