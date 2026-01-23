<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountriesSeeder extends Seeder
{
    public function run(): void
    {
        $countries = [
            [
                'name' => 'United States',
                'code' => 'US',
                'flag' => '🇺🇸',
                'description' => 'Flexible higher education system',
                'description_ru' => 'Гибкая система высшего образования с широким выбором специальностей и университетов. Степень бакалавра — 4 года, магистратура — 1–2 года. Акцент на исследовательской работе, междисциплинарных программах и практическом опыте (стажировки, проекты). Вступительные требования: SAT/ACT, мотивационное письмо, рекомендации, TOEFL/IELTS/Duolingo.',
                'description_en' => 'The U.S. offers a highly flexible higher education system with an extensive range of universities and majors. A bachelor\'s degree typically takes four years, while master\'s programs last 1–2 years. U.S. institutions emphasize research, interdisciplinary learning, and real-world experience through internships and capstone projects. Admission requirements commonly include SAT/ACT (though many schools are now test-optional), a motivation letter, letters of recommendation, and proof of English proficiency (TOEFL, IELTS, or Duolingo).',
                'selling_points' => json_encode([
                    ['value' => 'Bachelor: 4 years, Master: 1–2 years'],
                    ['value' => 'Strong research and innovation ecosystem'],
                    ['value' => 'Internships and capstone projects'],
                    ['value' => 'Top global university rankings'],
                ]),
                'image' => 'countries/us.jpg',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'United Kingdom',
                'code' => 'GB',
                'flag' => '🇬🇧',
                'description' => 'Structured education system',
                'description_ru' => 'Структурированная система: бакалавриат — 3 года (4 года в Шотландии), магистратура — 1 год. Программы специализированные с первого курса без общих курсов. Требования: A-levels/IB или Foundation, IELTS UKVI, мотивационное письмо. Высокая академическая репутация, особенно у Russell Group университетов.',
                'description_en' => 'The UK follows a structured system: bachelor\'s degrees take three years (four in Scotland), and master\'s programs are typically completed in just one intensive year. Students apply to a specific major and begin specialized study from day one—there are no general education requirements. Entry usually requires A-levels, the IB Diploma, or a Foundation year, along with IELTS UKVI and a personal statement. Universities in the Russell Group are especially renowned for academic excellence.',
                'selling_points' => json_encode([
                    ['value' => 'Bachelor: 3 years (4 in Scotland)'],
                    ['value' => 'Master: 1 intensive year'],
                    ['value' => 'Specialization from first year'],
                    ['value' => 'Russell Group universities'],
                ]),
                'image' => 'countries/uk.jpg',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'European Union',
                'code' => 'EU',
                'flag' => '🇪🇺',
                'description' => 'Affordable or free education',
                'description_ru' => 'Многие страны предлагают бесплатное или недорогое обучение в государственных вузах. Программы на английском доступны, особенно на магистерском уровне. В ЕС широко применяется система ECTS, что упрощает обмен студентами и признание дипломов.',
                'description_en' => 'Many European countries offer tuition-free or low-cost education at public universities—even for international students. While bachelor\'s programs are often taught in the local language, a growing number of master\'s degrees are available entirely in English. The continent uses the European Credit Transfer and Accumulation System (ECTS), making it easy to transfer credits and have degrees recognized across borders.',
                'selling_points' => json_encode([
                    ['value' => 'Low or no tuition fees'],
                    ['value' => 'ECTS credit system'],
                    ['value' => 'Wide student mobility'],
                    ['value' => 'Cultural diversity'],
                ]),
                'image' => 'countries/eu.jpg',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Canada',
                'code' => 'CA',
                'flag' => '🇨🇦',
                'description' => 'High-quality education',
                'description_ru' => 'Высококачественное образование с фокусом на инклюзивность и безопасность. Бакалавриат — 3–4 года, магистратура — 1–2 года. Университеты часто предлагают кооперативные программы (работа + учёба). Требуется IELTS/TOEFL или мотивационное письмо.',
                'description_en' => 'Canadian universities are known for high academic standards, inclusivity, and safety. Bachelor\'s degrees last 3–4 years, and master\'s programs take 1–2 years. Many institutions offer cooperative (co-op) programs that integrate paid work terms with academic study. Admission typically requires proof of English proficiency (IELTS/TOEFL) and may include a motivation letter or academic portfolio.',
                'selling_points' => json_encode([
                    ['value' => 'Bachelor: 3–4 years'],
                    ['value' => 'Master: 1–2 years'],
                    ['value' => 'Co-op programs (study + work)'],
                    ['value' => 'High quality of life'],
                ]),
                'image' => 'countries/ca.jpg',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Australia & New Zealand',
                'code' => 'AU-NZ',
                'flag' => '🇦🇺🇳🇿',
                'description' => 'Career-oriented education',
                'description_ru' => 'Образование ориентировано на практику и карьеру. Бакалавриат — 3 года, магистратура — 1–2 года. Университеты входят в мировые рейтинги. Приём по академическим показателям и IELTS/TOEFL. Студенты могут работать во время учёбы.',
                'description_en' => 'Higher education in Australia and New Zealand is career-focused and globally respected, with most universities ranked internationally. Bachelor\'s degrees usually take three years, and master\'s programs last 1–2 years. Admission is based on academic records and English test scores (IELTS/TOEFL). International students are allowed to work part-time during their studies, gaining valuable local experience.',
                'selling_points' => json_encode([
                    ['value' => 'Bachelor: 3 years'],
                    ['value' => 'Master: 1–2 years'],
                    ['value' => 'Part-time work allowed'],
                    ['value' => 'Globally ranked universities'],
                ]),
                'image' => 'countries/au_nz.jpg',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'China',
                'code' => 'CN',
                'flag' => '🇨🇳',
                'description' => 'Rapidly developing system',
                'description_ru' => 'Быстро развивающаяся система высшего образования. Многие топовые университеты (Tsinghua, Peking) предлагают программы на английском. Стипендии (например, CSC) покрывают обучение и проживание. Интересен для изучения языка, культуры и технологий.',
                'description_en' => 'China\'s higher education system is rapidly developing, with many top-tier universities (Tsinghua, Peking) offering programs in English. Scholarships (such as CSC) cover tuition and living expenses. Ideal for studying language, culture, and technology.',
                'selling_points' => json_encode([
                    ['value' => 'Top universities (Tsinghua, Peking)'],
                    ['value' => 'English-taught programs'],
                    ['value' => 'CSC scholarships'],
                    ['value' => 'Strong tech and research focus'],
                ]),
                'image' => 'countries/cn.jpg',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'South Korea',
                'code' => 'KR',
                'flag' => '🇰🇷',
                'description' => 'Advanced education system',
                'description_ru' => 'Сильные программы в IT, инженерии, бизнесе и дизайне. Высокий уровень технологий и инфраструктуры. Некоторые университеты (Seoul National, KAIST) активно привлекают иностранных студентов. Требуется IELTS/TOEFL или знание корейского.',
                'description_en' => 'South Korea offers strong programs in IT, engineering, business, and design. High level of technology and infrastructure. Some universities (Seoul National, KAIST) actively attract international students. IELTS/TOEFL or Korean language proficiency required.',
                'selling_points' => json_encode([
                    ['value' => 'High-tech infrastructure'],
                    ['value' => 'Strong IT and engineering programs'],
                    ['value' => 'English-taught courses available'],
                    ['value' => 'Global companies and innovation'],
                ]),
                'image' => 'countries/kr.jpg',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Japan',
                'code' => 'JP',
                'flag' => '🇯🇵',
                'description' => 'Blend of tradition and innovation',
                'description_ru' => 'Уникальное сочетание традиций и инноваций. Престижные университеты (University of Tokyo, Kyoto University). Многие магистерские программы — на английском. Существуют стипендии от японского правительства (MEXT). Знание японского языка — не всегда обязательно, но желательно.',
                'description_en' => 'Japan offers a unique blend of tradition and innovation. Prestigious universities (University of Tokyo, Kyoto University). Many master\'s programs are in English. Government scholarships available (MEXT). Japanese language knowledge is not always required but recommended.',
                'selling_points' => json_encode([
                    ['value' => 'Top universities (Tokyo, Kyoto)'],
                    ['value' => 'English-taught master\'s programs'],
                    ['value' => 'MEXT scholarships'],
                    ['value' => 'Strong technology sector'],
                ]),
                'image' => 'countries/jp.jpg',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Malaysia & Singapore',
                'code' => 'MY-SG',
                'flag' => '🇲🇾🇸🇬',
                'description' => 'English-taught programs',
                'description_ru' => 'Англоязычные программы с британской или австралийской академической системой. Сингапурские университеты (NUS, NTU) входят в топ-20 мировых рейтингов. Малайзия — более бюджетный вариант с кампусами филиалов британских и австралийских вузов. Обе страны — мультикультурные, безопасные, с мягким климатом и английским в быту.',
                'description_en' => 'English-taught programs with British or Australian academic systems. Singaporean universities (NUS, NTU) rank in the top 20 globally. Malaysia offers a more budget-friendly option with branch campuses of British and Australian universities. Both countries are multicultural, safe, with a mild climate and English in daily life.',
                'selling_points' => json_encode([
                    ['value' => 'English used in daily life'],
                    ['value' => 'Top-ranked universities (NUS, NTU)'],
                    ['value' => 'Affordable options in Malaysia'],
                    ['value' => 'International branch campuses'],
                ]),
                'image' => 'countries/my_sg.jpg',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'UAE & Qatar',
                'code' => 'AE-QA',
                'flag' => '🇦🇪🇶🇦',
                'description' => 'Emerging education hubs',
                'description_ru' => 'Растущие образовательные хабы с кампусами ведущих западных университетов (например, Georgetown, Carnegie Mellon, Sorbonne). Обучение на английском, высокий уровень жизни, безопасность. Подходит для тех, кто хочет получить западный диплом на Ближнем Востоке.',
                'description_en' => 'Emerging education hubs hosting campuses of leading Western universities (e.g., Georgetown, Carnegie Mellon, Sorbonne). English-taught programs, high standard of living, safety. Ideal for those seeking a Western degree in the Middle East.',
                'selling_points' => json_encode([
                    ['value' => 'Western diplomas in the Middle East'],
                    ['value' => 'English-taught programs'],
                    ['value' => 'High safety and living standards'],
                    ['value' => 'Modern campuses'],
                ]),
                'image' => 'countries/ae_qa.jpg',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($countries as $country) {
            DB::table('countries')->updateOrInsert(
                ['code' => $country['code']],
                $country
            );
        }
    }
}
