<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Category;
use Database\Factories\CategoryFactory;
use App\Models\Product;

class ProductCategoryApiTest extends TestCase
{
    use RefreshDatabase; // Ensure the database is refreshed for each test

    /**
     * A basic feature test example.
     */
    public function test_creating_categories_and_products(): void
    {
        $products_count=0;
        $categories = [
            'Smartphones' => ['iPhone 15', 'Samsung Galaxy S23', 'Google Pixel 7 Pro', 'OnePlus 11', 'Xiaomi 13 Pro', 'iPhone 14', 'Samsung Galaxy S22', 'Google Pixel 6', 'OnePlus 10', 'Xiaomi 12'],
            'Laptops' => ['MacBook Pro 16', 'Dell XPS 13', 'HP Spectre x360', 'Lenovo ThinkPad X1','ASUS ROG Zephyrus', 'Acer Predator Helios', 'Razer Blade 15', 'Microsoft Surface Laptop', 'HP Envy x360', 'Samsung Galaxy Book Pro'],
            'Cameras' => ['Sony Alpha A7 IV','Canon EOS R5', 'Nikon Z9', 'Fujifilm X-T5','Panasonic Lumix GH6', 'Olympus OM-D E-M1 Mark III', 'Leica M10', 'Sony A6400', 'Canon EOS 90D', 'Nikon D850'],
            'Watches' => ['Rolex Submariner', 'Omega Speedmaster', 'TAG Heuer Carrera', 'Apple Watch Ultra', 'Garmin Fenix 7', 'Casio G-Shock', 'Patek Philippe Calatrava', 'Audemars Piguet Royal Oak', 'Seiko 5', 'Michael Kors Runway'],
            'Shoes & Bags' => ['Adidas Running Shoes', 'Nike Air Max', 'Puma Sneakers', 'Gucci Leather Bag', 'Louis Vuitton Backpack', 'Converse Chuck Taylor', 'Vans Old Skool', 'Nike Air Force 1', 'Dr. Martens Boots', 'Prada Shoulder Bag'],
            'Gaming Consoles'  => ['PlayStation 5', 'Xbox Series X', 'Nintendo Switch OLED', 'Steam Deck', 'ASUS ROG Ally', 'PlayStation 4 Pro', 'Xbox One X', 'Nintendo Switch Lite', 'PlayStation VR', 'Xbox Series S'],
            'Furniture'  => ['IKEA Sofa Set', 'Wooden Dining Table', 'King-Size Bed Frame','Office Ergonomic Chair', 'Bookshelf (5-Tier)', 'Leather Recliner', 'Office Desk', 'Dining Chairs', 'TV Stand', 'Coffee Table'],
            'Home Appliances' => ['Dyson Vacuum Cleaner', 'Samsung Smart Fridge', 'LG Washing Machine','Breville Espresso Machine', 'Philips Air Fryer', 'Robot Vacuum', 'Samsung Smart Washer', 'Instant Pot Pressure Cooker', 'Vitamix Blender', 'Keurig Coffee Maker'],
            'Beauty & Health' => ['Dyson Hair Dryer', 'Foreo Luna 3',"Kiehl\'s Face Moisturizer",'Chanel Perfume', 'Oral-B Electric Toothbrush', 'Estée Lauder Serum', 'Olay Regenerist Cream', 'Clarisonic Facial Brush', 'Sodium Chloride Facial Mist', 'Neutrogena Hydro Boost'],
            'Sports & Outdoors' => ['Trek Mountain Bike', 'Wilson Tennis Racket', 'Adidas Football','Garmin GPS Watch','Under Armour Gym Bag', 'Nike Running Shoes', 'Fitbit Charge 5', 'The North Face Jacket', 'GoPro HERO 10', 'Reebok Resistance Bands'],
            'Toys & Games' => ['LEGO Star Wars Set','Barbie Dreamhouse','Hot Wheels Track Set','Nerf Elite Blaster','Monopoly Board Game', 'Play-Doh Modeling Compound', 'LEGO City Set', 'Fisher-Price Trike', 'Rubik\'s Cube', 'Hot Wheels Cars'],
            'Automotive'  => ['Michelin Tires Set', 'Castrol Engine Oil', 'Bosch Car Battery', 'Pioneer Car Stereo', 'Thule Roof Rack', 'Bosch Windshield Wipers', 'Mobil 1 Motor Oil', 'Yokohama Tires', 'Honda Civic Floor Mats', 'Kenwood Car Audio'],
            'Books' => ['Atomic Habits', 'The Alchemist', 'Sapiens', 'Dune', '1984', 'The Catcher in the Rye', 'To Kill a Mockingbird', 'Pride and Prejudice', 'Moby Dick', 'The Great Gatsby'],
            'Music Instruments' => ['Fender Stratocaster Guitar','Yamaha Digital Piano','Roland Electronic Drum Set', 'Shure SM7B Microphone','Bose Studio Headphones', 'Gibson Les Paul Guitar', 'Tama Drum Kit', 'Korg Synthesizer', 'Piano Bench', 'Casio Keyboard'],
            'Grocery' => ['Organic Almond Milk', 'Whole Wheat Bread','Fresh Atlantic Salmon','Italian Olive Oil', 'Starbucks Coffee Beans', 'Organic Apples', 'Free-Range Eggs', 'Oatmeal', 'Almond Butter', 'Coconut Milk'],
            'Pet Supplies' => ["Pedigree Dog Food (10kg)", "Cat Scratching Post", "Aquarium Starter Kit", "Rabbit Cage", "Bird Feeder", "Pet Carrier", "Cat Litter Box", "Dog Leash", "Hamster Wheel", "Pet Shampoo"],
            'Baby Products' => ["Pampers Diapers (Size 3)", "Chicco Baby Stroller", "Baby Monitor(Wi-Fi)", "Organic Baby Food Pack", "Wooden Crib", "Avent Bottles", "Tommee Tippee Sterilizer", "Baby Sling Carrier", "Baby Pajamas", "Car Seat Protector"],
            'Office Supplies' => ["HP Laser Printer", "Logitech Wireless Mouse", "Herman Miller Office Chair", "Apple Magic Keyboard", "Moleskine Notebook", "Desk Organizer", "Printer Paper", "Stapler", "Shredder", "Whiteboard"],
            'Jewelry & Watches' => ["Tiffany Diamond Ring", "Cartier Love Bracelet", "Bulgari Serpenti Watch", "Pandora Charm Bracelet", "Tissot Classic Watch", "David Yurman Earrings", "Rolex Day-Date", "Omega Seamaster", "Cartier Necklace", "Gucci Bracelet"],
            'DIY & Tools' => ['Bosch Power Drill', 'Stanley Tool Set (100 pcs)', 'Makita Circular Saw', 'DeWalt Hammer Drill', 'Black+Decker Workbench', 'Kreg Jig Kit', 'Craftsman Toolbox', 'Milwaukee Cordless Drill', 'Ryobi Impact Driver', 'Hilti Hammer Drill'],
            'Garden' => ['Weber Gas Grill', 'Husqvarna Lawn Mower', 'Greenhouse Kit', 'Garden Hose (50ft)', 'Outdoor Solar Lights', 'Lawn Sprinkler', 'Patio Furniture Set', 'Garden Wheelbarrow', 'Garden Kneeler', 'Shed Storage Kit'],
            'Movies & TV' => ['Avengers:Endgame Blu-Ray', 'Stranger Things Season 1 DVD', 'The Godfather 4K', 'Disney+ Subscription Card', 'Netflix Gift Card', 'The Mandalorian Blu-Ray', 'The Office DVD Boxset', 'Friends Blu-Ray', 'Breaking Bad Box Set', 'Game of Thrones DVD'],
            'Video Games' => ['The Legend of Zelda: BOTW', 'Elden Ring', 'FIFA 24','Red Dead Redemption 2', 'Cyberpunk 2077', 'Call of Duty: Warzone', 'Minecraft', 'Gran Turismo 7', 'Super Mario Odyssey', 'Animal Crossing: New Horizons'],
            'Pharmacy' => ['Paracetamol (500mg)', 'Vitamin C Supplements', 'Insulin Pen', 'Pfizer COVID-19 Vaccine Dose', 'Band-Aid Pack(50 pcs)', 'Aspirin Tablets', 'Hydrocortisone Cream', 'Antibiotic Ointment', 'Ibuprofen (200mg)', 'Nasal Decongestant']
        ];
        
        foreach($categories as $categoryName => $products) {
            $category = Category::factory()->create(['name'=>$categoryName]);
            foreach($products as $productName ) {
                $price = rand(1000,250000);
                $stock = rand(5,200);

                Product::factory()->create([
                    'name'  => $productName,
                    'price' => $price,
                    'stock' => $stock,
                    'category_id' => $category->id,
                ]);
                $products_count+=1;
            }
        }
        $this->assertDatabaseCount('categories', count($categories));
        $this->assertDatabaseCount('products', $products_count);

        // $user = \App\Models\User::find(1); // Get the user with ID 1, or use any query that matches the user

        // // Generate the Bearer token for the user (make sure your app is set up to use Sanctum or Passport)
        // $token = $user->createToken('TestApp')->plainTextToken; // For Sanctum
    
        // Alternatively, if you're using Laravel Passport, you would do something like this:
        // $token = $user->createToken('TestApp')->accessToken; // For Passport
    
        // Make a request using the Bearer token
        $response = $this->getJson('/api/products', [
            'Authorization' => 'Bearer 2|2JJ0hGfxCeUrIU2x6FuPALgk1VUoMn70bJIFtExi6299c59c' 
        ]);
    
        // Assert the response status is OK (200)
        $response->assertStatus(200);
    
        // Assert the correct number of products in the response data
        $response->assertJsonCount($products_count, 'data');
    }
}
