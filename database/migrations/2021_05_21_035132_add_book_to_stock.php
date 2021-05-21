<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddBookToStock extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // DB::table('stock')->insert(array(
        //     'book_name' => '',
        //     'book_author' => '',
        //     'book_publication_date' => '',
        //     'book_isbn_no' => '',
        //     'book_description' => '',
        //     'book_trade_price' => '',
        //     'book_retail_price' => '',
        //     'book_quantity' => '',
        //     'created_at' => '',
        //     'updated_at' => '',
        //     'book_front_cover' => ''
        // ));

        DB::table('stock')->insert(array(
            'book_name' => 'To Kill a Mockingbird',
            'book_author' => 'Harper Lee',
            'book_publication_date' => '1988-10-11',
            'book_isbn_no' => '978-0446310789',
            'book_description' => 'The unforgettable novel of a childhood in a sleepy Southern town and the crisis of conscience that rocked it, To Kill A Mockingbird became both an instant bestseller and a critical success when it was first published in 1960. It went on to win the Pulitzer Prize in 1961 and was later made into an Academy Award-winning film, also a classic. Compassionate, dramatic, and deeply moving, To Kill A Mockingbird takes readers to the roots of human behavior - to innocence and experience, kindness and cruelty, love and hatred, humor and pathos. Now with over 18 million copies in print and translated into forty languages, this regional story by a young Alabama woman claims universal appeal. Harper Lee always considered her book to be a simple love story. Today it is regarded as a masterpiece of American literature.',
            'book_trade_price' => '56',
            'book_retail_price' => '66.25',
            'book_quantity' => '25',
            'created_at' => '2021-05-19 20:14:05',
            'updated_at' => '2021-05-19 20:14:05',
            'book_front_cover' => ''
            
        ));

        DB::table('stock')->insert(array(
            'book_name' => 'The Catcher in the Rye',
            'book_author' => 'J.D. Salinger',
            'book_publication_date' => '1991-05-01',
            'book_isbn_no' => '978-7543321724',
            'book_description' => 'The hero-narrator of The Catcher in the Rye is an ancient child of sixteen, a native New Yorker named Holden Caufield. Through circumstances that tend to preclude adult, secondhand description, he leaves his prep school in Pennsylvania and goes underground in New York City for three days.',
            'book_trade_price' => '40',
            'book_retail_price' => '49.59',
            'book_quantity' => '10',
            'created_at' => '2021-05-19 20:14:05',
            'updated_at' => '2021-05-19 20:14:05',
            'book_front_cover' => ''
        ));

        DB::table('stock')->insert(array(
            'book_name' => 'Of Mice and Men',
            'book_author' => 'John Steinbeck',
            'book_publication_date' => '1993-09-01',
            'book_isbn_no' => '978-0140177398',
            'book_description' => 'Laborers in California\'s dusty vegetable fields, they hustle work when they can, living a hand-to-mouth existence. For George and Lennie have a plan: to own an acre of land and a shack they can call their own. When they land jobs on a ranch in the Salinas Valley, the fulfillment of their dream seems to be within their grasp. But even George cannot guard Lennie from the provocations of a flirtatious woman, nor predict the consequences of Lennie\'s unswerving obedience to the things George taught him.',
            'book_trade_price' => '70',
            'book_retail_price' => '84.10',
            'book_quantity' => '5',
            'created_at' => '2021-05-19 20:14:05',
            'updated_at' => '2021-05-19 20:14:05',
            'book_front_cover' => ''
        ));

        DB::table('stock')->insert(array(
            'book_name' => 'The Grapes of Wrath',
            'book_author' => 'John Steinbeck',
            'book_publication_date' => '2006-03-28',
            'book_isbn_no' => '978-0143039433',
            'book_description' => 'First published in 1939, Steinbeck’s Pulitzer Prize-winning epic of the Great Depression chronicles the Dust Bowl migration of the 1930s and tells the story of one Oklahoma farm family, the Joads—driven from their homestead and forced to travel west to the promised land of California. Out of their trials and their repeated collisions against the hard realities of an America divided into Haves and Have-Nots evolves a drama that is intensely human yet majestic in its scale and moral vision, elemental yet plainspoken, tragic but ultimately stirring in its human dignity. A portrait of the conflict between the powerful and the powerless, of one man’s fierce reaction to injustice, and of one woman’s stoical strength, the novel captures the horrors of the Great Depression and probes into the very nature of equality and justice in America. At once a naturalistic epic, captivity narrative, road novel, and transcendental gospel, Steinbeck’s powerful landmark novel is perhaps the most American of American Classics. This Penguin Classics edition contains an introduction and notes by Steinbeck scholar Robert Demott. For more than seventy years, Penguin has been the leading publisher of classic literature in the English-speaking world. With more than 1,800 titles, Penguin Classics represents a global bookshelf of the best works throughout history and across genres and disciplines. Readers trust the series to provide authoritative texts enhanced by introductions and notes by distinguished scholars and contemporary authors, as well as up-to-date translations by award-winning translators.',
            'book_trade_price' => '50',
            'book_retail_price' => '57.20',
            'book_quantity' => '12',
            'created_at' => '2021-05-19 20:14:05',
            'updated_at' => '2021-05-19 20:14:05',
            'book_front_cover' => ''
        ));

        DB::table('stock')->insert(array(
            'book_name' => 'The Great Gatsby',
            'book_author' => 'F. Scott Fitzgerald',
            'book_publication_date' => '2004-09-30',
            'book_isbn_no' => '978-0743273565',
            'book_description' => 'The Great Gatsby, F. Scott Fitzgerald’s third book, stands as the supreme achievement of his career. First published in 1925, this quintessential novel of the Jazz Age has been acclaimed by generations of readers. The story of the mysteriously wealthy Jay Gatsby and his love for the beautiful Daisy Buchanan, of lavish parties on Long Island at a time when The New York Times noted “gin was the national drink and sex the national obsession,” it is an exquisitely crafted tale of America in the 1920s.',
            'book_trade_price' => '35',
            'book_retail_price' => '45.45',
            'book_quantity' => '10',
            'created_at' => '2021-05-19 20:14:05',
            'updated_at' => '2021-05-19 20:14:05',
            'book_front_cover' => ''
        ));

        DB::table('stock')->insert(array(
            'book_name' => 'Fahrenheit 451',
            'book_author' => 'Ray Bradbury',
            'book_publication_date' => '2012-01-10',
            'book_isbn_no' => '978-1451673319',
            'book_description' => 'Guy Montag is a fireman. His job is to destroy the most illegal of commodities, the printed book, along with the houses in which they are hidden. Montag never questions the destruction and ruin his actions produce, returning each day to his bland life and wife, Mildred, who spends all day with her television “family.” But when he meets an eccentric young neighbor, Clarisse, who introduces him to a past where people didn’t live in fear and to a present where one sees the world through the ideas in books instead of the mindless chatter of television, Montag begins to question everything he has ever known.',
            'book_trade_price' => '54',
            'book_retail_price' => '64.26',
            'book_quantity' => '9',
            'created_at' => '2021-05-19 20:14:05',
            'updated_at' => '2021-05-19 20:14:05',
            'book_front_cover' => ''
        ));

        DB::table('stock')->insert(array(
            'book_name' => 'Invisible Man',
            'book_author' => 'Ralph Ellison',
            'book_publication_date' => '1995-01-01',
            'book_isbn_no' => '978-0679732761',
            'book_description' => 'Originally published in 1952 as the first novel by a then unknown author, it remained on the bestseller list for sixteen weeks, won the National Book Award for fiction, and established Ralph Ellison as one of the key writers of the century. The book\'s nameless narrator describes growing up in a black community in the South, attending a Negro college from which he is expelled, moving to New York and becoming the chief spokesman of the Harlem branch of "the Brotherhood", before retreating amid violence and confusion to the basement lair of the Invisible Man he imagines himself to be. The book is a passionate and witty tour de force of style, strongly influenced by T.S. Eliot\'s The Waste Land, James Joyce, and Dostoevsky.',
            'book_trade_price' => '20',
            'book_retail_price' => '28.96',
            'book_quantity' => '11',
            'created_at' => '2021-05-19 20:14:05',
            'updated_at' => '2021-05-19 20:14:05',
            'book_front_cover' => ''
        ));

        DB::table('stock')->insert(array(
            'book_name' => 'The Scarlet Letter',
            'book_author' => 'Nathaniel Hawthorne',
            'book_publication_date' => '2015-11-20',
            'book_isbn_no' => '978-1519425591',
            'book_description' => 'The Scarlet Letter: A Romance is an 1850 work of fiction in a historical setting, written by Nathaniel Hawthorne, and is considered to be his best work. The story begins in seventeenth-century Salem, Massachusetts, then a Puritan settlement. A young woman, Hester Prynne, is led from the town prison with her infant daughter, Pearl, in her arms and the scarlet letter “A” on her breast. The scarlet letter "A" represents the act of adultery that she has committed; it is to be a symbol of her sin for all to see. She will not reveal her lover’s identity, however, and the scarlet letter, along with her public shaming, is her punishment for her sin and her secrecy.',
            'book_trade_price' => '17',
            'book_retail_price' => '24.82',
            'book_quantity' => '6',
            'created_at' => '2021-05-19 20:14:05',
            'updated_at' => '2021-05-19 20:14:05',
            'book_front_cover' => ''
        ));

        DB::table('stock')->insert(array(
            'book_name' => 'Romeo and Juliet',
            'book_author' => 'William Shakespeare',
            'book_publication_date' => '2020-07-19',
            'book_isbn_no' => '979-8666107379',
            'book_description' => 'Romeo and Juliet by William Shakespeare is one of the most influential works of world literature. Enjoy it again or for the very first time in this stylish new paperback edition.',
            'book_trade_price' => '55',
            'book_retail_price' => '62.10',
            'book_quantity' => '20',
            'created_at' => '2021-05-19 20:14:05',
            'updated_at' => '2021-05-19 20:14:05',
            'book_front_cover' => ''
        ));

        DB::table('stock')->insert(array(
            'book_name' => 'The Old Man and The Sea',
            'book_author' => 'Ernest Hemingway',
            'book_publication_date' => '1995-05-05',
            'book_isbn_no' => '978-0684801223',
            'book_description' => 'The Old Man and the Sea is one of Hemingway\'s most enduring works. Told in language of great simplicity and power, it is the story of an old Cuban fisherman, down on his luck, and his supreme ordeal -- a relentless, agonizing battle with a giant marlin far out in the Gulf Stream. Here Hemingway recasts, in strikingly contemporary style, the classic theme of courage in the face of defeat, of personal triumph won from loss. Written in 1952, this hugely successful novella confirmed his power and presence in the literary world and played a large part in his winning the 1954 Nobel Prize for Literature.',
            'book_trade_price' => '33',
            'book_retail_price' => '41.39',
            'book_quantity' => '17',
            'created_at' => '2021-05-19 20:14:05',
            'updated_at' => '2021-05-19 20:14:05',
            'book_front_cover' => ''
        ));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       //
    }
}
