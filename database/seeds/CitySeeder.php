<?php

use Illuminate\Database\Seeder;
use App\Models\CityModel;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CityModel::truncate();
        CityModel::insert([
            ['name' => "Adimaly",'state_id' => 19],
            ['name' => "Adoor",'state_id' => 19],
            ['name' => "Adur",'state_id' => 19],
            ['name' => "Akathiyur",'state_id' => 19],
            ['name' => "Alangad",'state_id' => 19],
            ['name' => "Alappuzha",'state_id' => 19],
            ['name' => "Aluva",'state_id' => 19],
            ['name' => "Ancharakandy",'state_id' => 19],
            ['name' => "Angamaly",'state_id' => 19],
            ['name' => "Aroor",'state_id' => 19],
            ['name' => "Arukutti",'state_id' => 19],
            ['name' => "Attingal",'state_id' => 19],
            ['name' => "Avinissery",'state_id' => 19],
            ['name' => "Azhikode North",'state_id' => 19],
            ['name' => "Azhikode South",'state_id' => 19],
            ['name' => "Azhiyur",'state_id' => 19],
            ['name' => "Balussery",'state_id' => 19],
            ['name' => "Bangramanjeshwar",'state_id' => 19],
            ['name' => "Beypur",'state_id' => 19],
            ['name' => "Brahmakulam",'state_id' => 19],
            ['name' => "Chala",'state_id' => 19],
            ['name' => "Chalakudi",'state_id' => 19],
            ['name' => "Changanacheri",'state_id' => 19],
            ['name' => "Chauwara",'state_id' => 19],
            ['name' => "Chavakkad",'state_id' => 19],
            ['name' => "Chelakkara",'state_id' => 19],
            ['name' => "Chelora",'state_id' => 19],
            ['name' => "Chendamangalam",'state_id' => 19],
            ['name' => "Chengamanad",'state_id' => 19],
            ['name' => "Chengannur",'state_id' => 19],
            ['name' => "Cheranallur",'state_id' => 19],
            ['name' => "Cheriyakadavu",'state_id' => 19],
            ['name' => "Cherthala",'state_id' => 19],
            ['name' => "Cherukunnu",'state_id' => 19],
            ['name' => "Cheruthazham",'state_id' => 19],
            ['name' => "Cheruvannur",'state_id' => 19],
            ['name' => "Cheruvattur",'state_id' => 19],
            ['name' => "Chevvur",'state_id' => 19],
            ['name' => "Chirakkal",'state_id' => 19],
            ['name' => "Chittur",'state_id' => 19],
            ['name' => "Chockli",'state_id' => 19],
            ['name' => "Churnikkara",'state_id' => 19],
            ['name' => "Dharmadam",'state_id' => 19],
            ['name' => "Edappal",'state_id' => 19],
            ['name' => "Edathala",'state_id' => 19],
            ['name' => "Elayavur",'state_id' => 19],
            ['name' => "Elur",'state_id' => 19],
            ['name' => "Eranholi",'state_id' => 19],
            ['name' => "Erattupetta",'state_id' => 19],
            ['name' => "Ernakulam",'state_id' => 19],
            ['name' => "Eruvatti",'state_id' => 19],
            ['name' => "Ettumanoor",'state_id' => 19],
            ['name' => "Feroke",'state_id' => 19],
            ['name' => "Guruvayur",'state_id' => 19],
            ['name' => "Haripad",'state_id' => 19],
            ['name' => "Hosabettu",'state_id' => 19],
            ['name' => "Idukki",'state_id' => 19],
            ['name' => "Iringaprom",'state_id' => 19],
            ['name' => "Irinjalakuda",'state_id' => 19],
            ['name' => "Iriveri",'state_id' => 19],
            ['name' => "Kadachira",'state_id' => 19],
            ['name' => "Kadalundi",'state_id' => 19],
            ['name' => "Kadamakkudy",'state_id' => 19],
            ['name' => "Kadirur",'state_id' => 19],
            ['name' => "Kadungallur",'state_id' => 19],
            ['name' => "Kakkodi",'state_id' => 19],
            ['name' => "Kalady",'state_id' => 19],
            ['name' => "Kalamassery",'state_id' => 19],
            ['name' => "Kalliasseri",'state_id' => 19],
            ['name' => "Kalpetta",'state_id' => 19],
            ['name' => "Kanhangad",'state_id' => 19],
            ['name' => "Kanhirode",'state_id' => 19],
            ['name' => "Kanjikkuzhi",'state_id' => 19],
            ['name' => "Kanjikode",'state_id' => 19],
            ['name' => "Kanjirappalli",'state_id' => 19],
            ['name' => "Kannadiparamba",'state_id' => 19],
            ['name' => "Kannangad",'state_id' => 19],
            ['name' => "Kannapuram",'state_id' => 19],
            ['name' => "Kannur",'state_id' => 19],
            ['name' => "Kannur Cantonment",'state_id' => 19],
            ['name' => "Karunagappally",'state_id' => 19],
            ['name' => "Karuvamyhuruthy",'state_id' => 19],
            ['name' => "Kasaragod",'state_id' => 19],
            ['name' => "Kasargod",'state_id' => 19],
            ['name' => "Kattappana",'state_id' => 19],
            ['name' => "Kayamkulam",'state_id' => 19],
            ['name' => "Kedamangalam",'state_id' => 19],
            ['name' => "Kochi",'state_id' => 19],
            ['name' => "Kodamthuruthu",'state_id' => 19],
            ['name' => "Kodungallur",'state_id' => 19],
            ['name' => "Koduvally",'state_id' => 19],
            ['name' => "Koduvayur",'state_id' => 19],
            ['name' => "Kokkothamangalam",'state_id' => 19],
            ['name' => "Kolazhy",'state_id' => 19],
            ['name' => "Kollam",'state_id' => 19],
            ['name' => "Komalapuram",'state_id' => 19],
            ['name' => "Koothattukulam",'state_id' => 19],
            ['name' => "Koratty",'state_id' => 19],
            ['name' => "Kothamangalam",'state_id' => 19],
            ['name' => "Kottarakkara",'state_id' => 19],
            ['name' => "Kottayam",'state_id' => 19],
            ['name' => "Kottayam Malabar",'state_id' => 19],
            ['name' => "Kottuvally",'state_id' => 19],
            ['name' => "Koyilandi",'state_id' => 19],
            ['name' => "Kozhikode",'state_id' => 19],
            ['name' => "Kudappanakunnu",'state_id' => 19],
            ['name' => "Kudlu",'state_id' => 19],
            ['name' => "Kumarakom",'state_id' => 19],
            ['name' => "Kumily",'state_id' => 19],
            ['name' => "Kunnamangalam",'state_id' => 19],
            ['name' => "Kunnamkulam",'state_id' => 19],
            ['name' => "Kurikkad",'state_id' => 19],
            ['name' => "Kurkkanchery",'state_id' => 19],
            ['name' => "Kuthuparamba",'state_id' => 19],
            ['name' => "Kuttakulam",'state_id' => 19],
            ['name' => "Kuttikkattur",'state_id' => 19],
            ['name' => "Kuttur",'state_id' => 19],
            ['name' => "Malappuram",'state_id' => 19],
            ['name' => "Mallappally",'state_id' => 19],
            ['name' => "Manjeri",'state_id' => 19],
            ['name' => "Manjeshwar",'state_id' => 19],
            ['name' => "Mannancherry",'state_id' => 19],
            ['name' => "Mannar",'state_id' => 19],
            ['name' => "Mannarakkat",'state_id' => 19],
            ['name' => "Maradu",'state_id' => 19],
            ['name' => "Marathakkara",'state_id' => 19],
            ['name' => "Marutharod",'state_id' => 19],
            ['name' => "Mattannur",'state_id' => 19],
            ['name' => "Mavelikara",'state_id' => 19],
            ['name' => "Mavilayi",'state_id' => 19],
            ['name' => "Mavur",'state_id' => 19],
            ['name' => "Methala",'state_id' => 19],
            ['name' => "Muhamma",'state_id' => 19],
            ['name' => "Mulavukad",'state_id' => 19],
            ['name' => "Mundakayam",'state_id' => 19],
            ['name' => "Munderi",'state_id' => 19],
            ['name' => "Munnar",'state_id' => 19],
            ['name' => "Muthakunnam",'state_id' => 19],
            ['name' => "Muvattupuzha",'state_id' => 19],
            ['name' => "Muzhappilangad",'state_id' => 19],
            ['name' => "Nadapuram",'state_id' => 19],
            ['name' => "Nadathara",'state_id' => 19],
            ['name' => "Narath",'state_id' => 19],
            ['name' => "Nattakam",'state_id' => 19],
            ['name' => "Nedumangad",'state_id' => 19],
            ['name' => "Nenmenikkara",'state_id' => 19],
            ['name' => "New Mahe",'state_id' => 19],
            ['name' => "Neyyattinkara",'state_id' => 19],
            ['name' => "Nileshwar",'state_id' => 19],
            ['name' => "Olavanna",'state_id' => 19],
            ['name' => "Ottapalam",'state_id' => 19],
            ['name' => "Ottappalam",'state_id' => 19],
            ['name' => "Paduvilayi",'state_id' => 19],
            ['name' => "Palai",'state_id' => 19],
            ['name' => "Palakkad",'state_id' => 19],
            ['name' => "Palayad",'state_id' => 19],
            ['name' => "Palissery",'state_id' => 19],
            ['name' => "Pallikkunnu",'state_id' => 19],
            ['name' => "Paluvai",'state_id' => 19],
            ['name' => "Panniyannur",'state_id' => 19],
            ['name' => "Pantalam",'state_id' => 19],
            ['name' => "Panthiramkavu",'state_id' => 19],
            ['name' => "Panur",'state_id' => 19],
            ['name' => "Pappinisseri",'state_id' => 19],
            ['name' => "Parassala",'state_id' => 19],
            ['name' => "Paravur",'state_id' => 19],
            ['name' => "Pathanamthitta",'state_id' => 19],
            ['name' => "Pathanapuram",'state_id' => 19],
            ['name' => "Pathiriyad",'state_id' => 19],
            ['name' => "Pattambi",'state_id' => 19],
            ['name' => "Pattiom",'state_id' => 19],
            ['name' => "Pavaratty",'state_id' => 19],
            ['name' => "Payyannur",'state_id' => 19],
            ['name' => "Peermade",'state_id' => 19],
            ['name' => "Perakam",'state_id' => 19],
            ['name' => "Peralasseri",'state_id' => 19],
            ['name' => "Peringathur",'state_id' => 19],
            ['name' => "Perinthalmanna",'state_id' => 19],
            ['name' => "Perole",'state_id' => 19],
            ['name' => "Perumanna",'state_id' => 19],
            ['name' => "Perumbaikadu",'state_id' => 19],
            ['name' => "Perumbavoor",'state_id' => 19],
            ['name' => "Pinarayi",'state_id' => 19],
            ['name' => "Piravam",'state_id' => 19],
            ['name' => "Ponnani",'state_id' => 19],
            ['name' => "Pottore",'state_id' => 19],
            ['name' => "Pudukad",'state_id' => 19],
            ['name' => "Punalur",'state_id' => 19],
            ['name' => "Puranattukara",'state_id' => 19],
            ['name' => "Puthunagaram",'state_id' => 19],
            ['name' => "Puthuppariyaram",'state_id' => 19],
            ['name' => "Puzhathi",'state_id' => 19],
            ['name' => "Ramanattukara",'state_id' => 19],
            ['name' => "Shoranur",'state_id' => 19],
            ['name' => "Sultans Battery",'state_id' => 19],
            ['name' => "Sulthan Bathery",'state_id' => 19],
            ['name' => "Talipparamba",'state_id' => 19],
            ['name' => "Thaikkad",'state_id' => 19],
            ['name' => "Thalassery",'state_id' => 19],
            ['name' => "Thannirmukkam",'state_id' => 19],
            ['name' => "Theyyalingal",'state_id' => 19],
            ['name' => "Thiruvalla",'state_id' => 19],
            ['name' => "Thiruvananthapuram",'state_id' => 19],
            ['name' => "Thiruvankulam",'state_id' => 19],
            ['name' => "Thodupuzha",'state_id' => 19],
            ['name' => "Thottada",'state_id' => 19],
            ['name' => "Thrippunithura",'state_id' => 19],
            ['name' => "Thrissur",'state_id' => 19],
            ['name' => "Tirur",'state_id' => 19],
            ['name' => "Udma",'state_id' => 19],
            ['name' => "Vadakara",'state_id' => 19],
            ['name' => "Vaikam",'state_id' => 19],
            ['name' => "Valapattam",'state_id' => 19],
            ['name' => "Vallachira",'state_id' => 19],
            ['name' => "Varam",'state_id' => 19],
            ['name' => "Varappuzha",'state_id' => 19],
            ['name' => "Varkala",'state_id' => 19],
            ['name' => "Vayalar",'state_id' => 19],
            ['name' => "Vazhakkala",'state_id' => 19],
            ['name' => "Venmanad",'state_id' => 19],
            ['name' => "Villiappally",'state_id' => 19],
            ['name' => "Wayanad",'state_id' => 19],
        ]);
    }
}
