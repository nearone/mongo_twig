<?php
//in terminal --> mongod

// Connecting to MongoDB database server at localhost port 27017:
$connection = new Mongo();

//Connecting to a remote host with optional custom port:
//$connection = new Mongo("172.20.10.8:65018" );

$db = $connection->selectDB('test'); 
// test = db name
// OR $db = $connection->dbname;

$addresses = $db->addresses;
// create collection "addresses"
// OR $addresses = $connection->dbname->addresses;

//drop collection
$db->numbers->drop();


// Creating a Document
$address = array(
    'first_name' => 'Peter',
    'last_name' => 'Parker',
    'address' => '175 Fifth Ave',
    'city' => 'New York',
    'state' => 'NY',
    'zip' => '10010'
 );

//$addresses->insert($address);

/*
 * Alternatively, we could use the save method. The save method works just like the
 * insert method, except that if an _id value is specified and exists, save will update
 * instead of insert the array. In practice, I nearly always use save as it leads to much more
 * reusable code in most circumstances.
 */

// The insert method itself will add the about-to-be-created _id to the array (or object) passed in.
//$oId = $address['_id'];
//var_dump($oId);
/*
 * MongoDB will automatically create a primary
 * key for each document. In MongoDB, these are called ObjectIds. ObjectIds in MongoDB
 * are not strings or integers, but objects.
 * As an object, it has methods that you can run.
 */
//var_dump($oId->getTimestamp());





//Reading a Document

$oId = new MongoId('5598e6b30051705805b7acd9');
$pp = $addresses->findone(array('_id' => $oId ) );

//Unlike a key value store, you can access the document by any other key:
$pp = $addresses->findone(array(
    'first_name' => 'Peter',
    'last_name' => 'Parker'
));
var_dump($pp);


//Retrieving Select Values

/*
 * By default, MongoDB will return the entire document (or set of documents) rather than
 * a set of values. The find and findone methods accept a second parameter that is an
 * array of the fields to return:
 */
$pw = $db->addresses->findOne(array('first_name' => 'Peter'), array('city'));
var_dump($pw);


//Updating a Document

/*
 * Changing a Value
 */
$addresses->update(
    array('_id' => $oId),
    array('$set' => array('first_name' => 'hello' ) )
);


//Adding a Value
$addresses->update(
    array('first_name' => 'Peter', 'last_name' => 'Parker'),
    array('$set' => array(
        'superpowers' => array(
            'agility', 'stamina', 'spidey sense', 'web shooters', 'super human strength', 'super human intelligence' 
            )                        
        )
    )
);

//Appending a Value to an Array
$addresses->update(
    array(
        'first_name' => 'Peter', 
        'last_name' => 'Parker'
    ),
    array(
        '$push' => array(
            'superpowers' => 'wall crawling' 
        )
    )
);

/*
 * Upsert and Multiple
 * Two of the options are worthy of note here.
 * Upsert changes the behavior so that if the criteria provided doesn’t exist, it will create
 * a new document with that criteria.
 * Multiple enables the method to update more than one document.
 */

$addresses->update(
    array(
        'first_name' => 'Peter', 
        'last_name' => 'Parker'),
    array(
        '$push' => array(
            'superpowers' => 'wall crawling' 
        )
    ),
    array(
        'upsert' => true,
        'multiple' => true
    )       
);


//Saving a Document
/*
 * Save is simply a wrapper for insert and update. If an _id is provided, it will update;
 * otherwise, it will insert.
 */

/*class Hero {}

$hero = new Hero();
$hero->first_name = 'Eliot';
$hero->last_name = 'Horowitz';
$hero->address = '134 Fifth Ave';
$hero->city = 'New York';
$hero->state = 'NY';
$hero->zip = '10010';
$hero->superpowers = array( 'agility', 'super human intelligence', 'wall crawling' );

$addresses->save($hero);*/

//Deleting a Document
$criteria = array('_id'=> new MongoId('4ba667b0a90578631c9caea1'));
$addresses->remove($criteria, array("justOne" => true) );

//Finding Data in MongoDB
$results = $db->addresses->find()->limit(2);

foreach($results as $result){
    var_dump($result);
}

//Pagination with the Cursor
$db->numbers->find()->limit(2)->skip(20)->sort(array('num'=> -1));
//skip = offset

//Ranges

/*
 * MongoDB has a set of operators to handle range operations. 
 * $gt, $lt, $gte, $lte, 
 * greater than, less than, greater than or equal, less than or equal.
 */

//Let’s say you want all numbers under 15.
$results = $db->numbers->find( array( 'num' => array( '$lt' => 15 )));

//Finding a Value in an Array
$set = $addresses->find(
    array( 'superpowers' => 'agility')
 );
/*
 * This query will match any document
 * that has a key superpowers set to the value agility or to an array that contains the value
 * agility.
 */

//in array $in
$set = $addresses->find(
    array( 
        'state' => array(
            '$in' => array(
                'NY', 
                'CA'
            )
        )
    )
);

//not in array $nin

/* $all works similar to $in. It permits you to query against an array, but unlike $in, it
 * will return only documents whose array contains all of the values provided.
 */

//retrieve a section of array: $slice
/*
 * $slice can either take a single value or an array. The single
 * value returns that number of elements, in which the array takes two parameters, of
 * which the first parameter is skip and the second is how many to return.
 */
$addresses->find(array(),array('superpowers' => array('$slice' => 2)));
$addresses->find(array(),array('superpowers' => array('$slice' => array(2, 3))));

/*
 * If you want to retrieve only the slice itself and not the entire document, you can come
 * pretty close by retrieving the _id and the slice:
 */
$addresses->findone(
    array(
        'first_name' => 'Peter', 
        'last_name' => 'Parker'
    ),array(
        '_id' => 1, 
        'superpowers' => array(
            '$slice' => 2
        )
    )
);


/*
 * $elemMatch lets you specify that you want all of the provided conditions to
 * exist in the same element of an array.
 */
$set = $db->company->find(array(
        'locations' => array(
            '$elemMatch' => array(
                'state' => 'NY', 
                'city' => 'New York'
                )
            )
        )
    );


//Using Dot Notation
$db->company->find(array('locations.zip' => '10011'));

//Conditionals
$set = $addresses->find(
    array( 
        '$and' => array(
            array(
                '$or' => array(
                    array('state' => 'NY'),
                    array('city' => 'New York')
                )  
            ),
            array(
                '$or' => array(
                    array('first_name' => 'Eliot'),
                    array('last_name' => 'Parker')
                )
            )
        )
    )
);

//findAndModify
/*
 * The findAndModify command lets you atomically update and return a document in a
 * single operation.
 */
$result = $this->db->command(array(
    'findAndModify' => 'collectionName',
    'query' => array('fieldname' => 'userid'),
    'update' => array('$inc' => array('value' => 1)),
    'upsert' => 1,
    'new' => 1)
);

//distinct
$addresses->distinct('firstname');