<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $div = '<h3>Introduction</h3><p>VMS allows you to explore information that is overturning the perception of the world, history and life!<br>After many thousands of years, we finally reached back to a long-awaited mental Wake Time and information age. Partly due. Astronomical phenomena, but also due. Internet, which now makes that information flows more freely than ever and not only through the manipulated media and textbooks. There is a knowledge that few people are aware. Aseveral thousand years old advanced knowledge of cosmology (the laws of nature and functionality) which was previously the foundation of all the planet\'s civilizations.<br>
        This knowledge has formed the basis for nearly all mythologies and religions of the world and the closest you get this knowledge, the information which has survived since the last golden age of about 14,000 years ago. Global disasters have erased many of the traces of these earlier civilizations but science survived because it was made into a story told through the constellations, what we today know as astrology.<br>
        Astrology is a metaphor for the original cosmology which can also be translated into the logic of the universe . Most have no idea what astrology is really about because powerful bodies throughout history, and still today, do not want people to have access to the logic that can lead to information and independent thinking. The oldest interpretation of this knowledge can be found in the texts of Hermes Trismegistus (Thoth Egypt) and is the most precious knowledge that has survived the destruction of libraries in Alexandria.<br><br><br></p>
              <img class="img-responsive" src="http://dezynage.com/keyoflife/public/front/images/malteserkors.jpg" style="margin:auto;">
            <br><br><p>
        This identical knowledge of cosmology was used by civilizations across the globe right up to the pharaonic dynasties in Egypt. As forretningsimperierne began to take power from the pharaohs, was corrupted science and repackaged as Sun Worship (cultivation of the sun). Then began the modern power systems to take shape. The Holy Roman Empire wiped out most of this amazing knowledge and culture, and the remains were hidden behind metaphors that few could decipher, blah. in the Bible.<br>

        This knowledge also formed the foundation of the Knights Templar and ER Templars\' secret treasure.<br>

        Since the dissolution of the Holy Roman Empire has a closed network literally abused the saying "knowledge is power" to create a global system of power that surpasses all imagination, which has played the population mentally checkmate. What we regard as modern democracy and enlightenment society is just one of their historic strategies, which have given them almost unlimited control over the chessboard. Practically everything what we have learned is wrong!<br>

        This powerful elite has grown more powerful than ever before and they are working doggedly on their old dream to rule the world. Their biggest fear is come true, they have been rumbled, and now it\'s a race against time on how much they can manage to save before it goes up for the majority of the world population that they have been subject to social control and suppression of knowledge for millennia, to a degree most will find it difficult to comprehend!<br>
        It is recommended that you review the introduction before you move around the site!</p>';

        DB::table('users')->insert([
            [
                'user_name' => 'Super Admin',
                'email'     => 'admin@keyoflife.com',
                'password'  => bcrypt('admin'),
                'user_role_idFk' => 1
            ]
        ]);

        DB::table('pages')->insert([
            [
                'name' => 'Introduction',
                'desc'     => $div,
                'created_by'  => 1
            ]
        ]);
    }
}
