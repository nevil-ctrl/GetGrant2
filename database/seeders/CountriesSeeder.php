<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountriesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('countries')->insert([
            [
                'name' => 'United States',
                'code' => 'US',
                'flag' => '🇺🇸',
                'description' => 'Flexible higher education system with a wide range of universities and majors. Strong focus on research, interdisciplinary learning, and practical experience through internships and projects.',
                'selling_points' => json_encode([
                    'Bachelor: 4 years, Master: 1–2 years',
                    'Strong research and innovation ecosystem',
                    'Internships and capstone projects',
                    'Top global university rankings',
                ]),
                'image' => 'countries/us.jpg',
                'is_active' => true,
            ],
            [
                'name' => 'United Kingdom',
                'code' => 'GB',
                'flag' => '🇬🇧',
                'description' => 'Structured education system with early specialization. Known for academic excellence and globally respected degrees.',
                'selling_points' => json_encode([
                    'Bachelor: 3 years (4 in Scotland)',
                    'Master: 1 intensive year',
                    'Specialization from first year',
                    'Russell Group universities',
                ]),
                'image' => 'countries/uk.jpg',
                'is_active' => true,
            ],
            [
                'name' => 'European Union',
                'code' => 'EU',
                'flag' => '🇪🇺',
                'description' => 'Affordable or free education in many public universities. Wide availability of English-taught master’s programs and easy credit recognition across countries.',
                'selling_points' => json_encode([
                    'Low or no tuition fees',
                    'ECTS credit system',
                    'Wide student mobility',
                    'Cultural diversity',
                ]),
                'image' => 'countries/eu.jpg',
                'is_active' => true,
            ],
            [
                'name' => 'Canada',
                'code' => 'CA',
                'flag' => '🇨🇦',
                'description' => 'High-quality and inclusive education system with strong emphasis on safety and employability.',
                'selling_points' => json_encode([
                    'Bachelor: 3–4 years',
                    'Master: 1–2 years',
                    'Co-op programs (study + work)',
                    'High quality of life',
                ]),
                'image' => 'countries/ca.jpg',
                'is_active' => true,
            ],
            [
                'name' => 'Australia & New Zealand',
                'code' => 'AU-NZ',
                'flag' => '🇦🇺🇳🇿',
                'description' => 'Career-oriented education with strong global rankings and practical focus.',
                'selling_points' => json_encode([
                    'Bachelor: 3 years',
                    'Master: 1–2 years',
                    'Part-time work allowed',
                    'Globally ranked universities',
                ]),
                'image' => 'countries/au_nz.jpg',
                'is_active' => true,
            ],
            [
                'name' => 'China',
                'code' => 'CN',
                'flag' => '🇨🇳',
                'description' => 'Rapidly developing higher education system with strong government support and generous scholarships.',
                'selling_points' => json_encode([
                    'Top universities (Tsinghua, Peking)',
                    'English-taught programs',
                    'CSC scholarships',
                    'Strong tech and research focus',
                ]),
                'image' => 'countries/cn.jpg',
                'is_active' => true,
            ],
            [
                'name' => 'South Korea',
                'code' => 'KR',
                'flag' => '🇰🇷',
                'description' => 'Advanced education system with strengths in IT, engineering, and business.',
                'selling_points' => json_encode([
                    'High-tech infrastructure',
                    'Strong IT and engineering programs',
                    'English-taught courses available',
                    'Global companies and innovation',
                ]),
                'image' => 'countries/kr.jpg',
                'is_active' => true,
            ],
            [
                'name' => 'Japan',
                'code' => 'JP',
                'flag' => '🇯🇵',
                'description' => 'Blend of tradition and innovation with prestigious universities and strong research culture.',
                'selling_points' => json_encode([
                    'Top universities (Tokyo, Kyoto)',
                    'English-taught master’s programs',
                    'MEXT scholarships',
                    'Strong technology sector',
                ]),
                'image' => 'countries/jp.jpg',
                'is_active' => true,
            ],
            [
                'name' => 'Malaysia & Singapore',
                'code' => 'MY-SG',
                'flag' => '🇲🇾🇸🇬',
                'description' => 'English-taught programs with British or Australian academic models in a safe, multicultural environment.',
                'selling_points' => json_encode([
                    'English used in daily life',
                    'Top-ranked universities (NUS, NTU)',
                    'Affordable options in Malaysia',
                    'International branch campuses',
                ]),
                'image' => 'countries/my_sg.jpg',
                'is_active' => true,
            ],
            [
                'name' => 'UAE & Qatar',
                'code' => 'AE-QA',
                'flag' => '🇦🇪🇶🇦',
                'description' => 'Emerging education hubs hosting campuses of leading Western universities.',
                'selling_points' => json_encode([
                    'Western diplomas in the Middle East',
                    'English-taught programs',
                    'High safety and living standards',
                    'Modern campuses',
                ]),
                'image' => 'countries/ae_qa.jpg',
                'is_active' => true,
            ],
        ]);
    }
}
