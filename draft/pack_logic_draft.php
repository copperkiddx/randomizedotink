<?php

class CardRarity
{
    public $common = "Common";
    public $uncommon = "Uncommon";
    public $rare = "Rare";
    public $superRare = "Super Rare";
    public $legendary = "Legendary";
}
$cardRarity = new CardRarity();

//CardData Class -> Holds Card Information Similar to SQL Structure
class CardData
{
    public $setId = null;
    public $setCardId = null;
    public $name = null;
    public $inkType = null;
    public $rarity = null;
    public $image = null;
}

//Rarity Groupings; This Groups Cards By Rarity -> Commons, Uncommons, Rares, etc
//This Is Used In The cardsBySet Class
class CardsByRarity
{
    public $rarities = [];

    //Function To Distribute Cards Based On Rarity
    public function addCardByRarity($cardData)
    {
        $this->rarities[$cardData->rarity][] = $cardData;
    }
}

//Object To Hold All Cards For Sets; We Hold Them By Rarity & By Set
class cardsBySet
{
    public $setsAllCards = [];
    public $setsByRarity = [];

    //Make An Object For Each Set That Includes All Cards (Used For Selecting Random Foil)
    public function addCardToSetList($cardData)
    {
        $this->setsAllCards[$cardData->setId][] = $cardData;
    }

    //Make An Object For Each Set By Rarity (Used For Slots 1-11)
    public function __construct()
    {
        $this->setsByRarity["TFC"] = new CardsByRarity();
        $this->setsByRarity["ROTF"] = new CardsByRarity();
        $this->setsByRarity["ITI"] = new CardsByRarity();
    }

    //Function To Distribute Cards Based On Set (And Then Rarity By addCardByRarity Function)
    public function addCardBySet($cardData)
    {
        $this->setsByRarity[$cardData->setId]->addCardByRarity($cardData);
    }
}

//Booster Pack Object
class BoosterPack
{
    public $setNum = null;
    public $packNum = null;
    public $cardsInBooster = [];

    //Create Function To Distribute Cards Based On Rarity
    public function addCardToBooster($cardData)
    {
        $this->cardsInBooster[] = $cardData;
    }
}

//Pull Cards From SQL Database
function getCardList($conn)
{
    //Get Card List And Let SQL Sort It For Us Randomly Once (To Help Improve The Randomness)
    $sqlCommand =
        "SELECT `series` AS `setId`, `id` AS `setCardId`, `name`, `color` AS `inkType`, `rarity`, `image` FROM `lorcana_cards` ORDER BY RAND();";
    $sqlQuery = $conn->prepare($sqlCommand);
    $sqlQuery->execute();
    $result = $sqlQuery->get_result();

    //Create a cardsBySet Object To Hold All Our Cards, Grouped By Set And Also By Rarity
    $cardsBySet = new cardsBySet();

    while ($row = $result->fetch_assoc()) {
        //For Each Card, Create A New Instance Of The Card Class
        $cardData = new CardData();
        $cardData->setId = $row["setId"];
        $cardData->setCardId = $row["setCardId"];
        $cardData->name = $row["name"];
        $cardData->inkType = $row["inkType"];
        $cardData->rarity = $row["rarity"];
        $cardData->image = $row["image"];

        //We Have A Card, Put It Into Its Set By Rarity
        $cardsBySet->addCardBySet($cardData);

        //And Store It With All Cards Of The Set (Used For Pulling Foils In Slot 12)
        $cardsBySet->addCardToSetList($cardData);
    }

    //We Have Cards Sorted By Set And Rarity, And Also Just By Set
    //Inside Those Arrays The Cards Are Randomly Ordered (And That Order Is Constantly Randomzied)
    return $cardsBySet;
}

//Get Our Card List From DB
$cardsBySet = getCardList($conn);

//Pull Random Cards From A Given Set Based On Rarity (And Optionally By Ink Type)
function getRandomCardFromSet($cardsBySet, $setNum, $rarity, $inkType = null)
{
    if (!isset($cardsBySet->setsByRarity[$setNum])) {
        // Handle the error, for example:
        echo "Error: Invalid set number.";
        return null;
    }
    $selectedCard = null;

    //Shuffle The Array
    shuffle($cardsBySet->setsByRarity[$setNum]->rarities[$rarity]);

    //Find Card By Set, Rarity And Optionally By Ink Type
    foreach ($cardsBySet->setsByRarity[$setNum]->rarities[$rarity] as $card) {
    	// Skip cards with setCardId 160 and 208 - Te Ka cards (Pixelborn bug)
	    // if ($card -> setCardId == 160 || $card -> setCardId == 208) {
	    //    continue;
		//}
        if ($inkType != null) {
            //Loop Until We Find A Specific Ink Type; i.e. 1 of Each Ink Type For Commons, etc
            if ($card->inkType === $inkType) {
                $selectedCard = $card;
                //We Have Our Card, Exit For Loop
                break;
            }
        } else {
            //Ink Type Doesn't Matter, So We Have Our Card
            $selectedCard = $card;
            break;
        }
    }

    return $selectedCard;
}

//Loop Through Pack Checking For Duplicate Cards
function checkPackForDuplicateCards($boosterPack, $cardToCheck)
{
    //We Can Assume There Are No Dupliate Commons, But Its So Fast That We Can Just Check The Full Pack Each Time
    foreach ($boosterPack->cardsInBooster as $cardInPack) {
        //Duplicate Card Is Same setId And setCardId
        if (
            $cardInPack->setId === $cardToCheck->setId &&
            $cardInPack->setCardId === $cardToCheck->setCardId
        ) {
            //Duplicates Card Found, Return True
            return true;
        }
    }
    //No Duplicates Found, Return False
    return false;
}

//Create A Pack From A Given Set And Set Pack # (For Instance: Generating Set #1 - Pack #2)
function buildPackFromSet($cardsBySet, $cardRarity, $packSet, $packNum)
{
    //Create A New Instance Of The BoosterPack Class
    $boosterPack = new BoosterPack();
    $boosterPack->setNum = $packSet;
    $boosterPack->packNum = $packNum;

    //6 Commons Per Pack; 1 Per Ink Type
    $card = getRandomCardFromSet(
        $cardsBySet,
        $packSet,
        $cardRarity->common,
        "Amber"
    );
    $boosterPack->addCardToBooster($card);
    $card = getRandomCardFromSet(
        $cardsBySet,
        $packSet,
        $cardRarity->common,
        "Amethyst"
    );
    $boosterPack->addCardToBooster($card);
    $card = getRandomCardFromSet(
        $cardsBySet,
        $packSet,
        $cardRarity->common,
        "Emerald"
    );
    $boosterPack->addCardToBooster($card);
    $card = getRandomCardFromSet(
        $cardsBySet,
        $packSet,
        $cardRarity->common,
        "Ruby"
    );
    $boosterPack->addCardToBooster($card);
    $card = getRandomCardFromSet(
        $cardsBySet,
        $packSet,
        $cardRarity->common,
        "Sapphire"
    );
    $boosterPack->addCardToBooster($card);
    $card = getRandomCardFromSet(
        $cardsBySet,
        $packSet,
        $cardRarity->common,
        "Steel"
    );
    $boosterPack->addCardToBooster($card);

    //3 Uncommons Per Pack
    for ($i = 1; $i <= 3; $i++) {
        do {
            $card = getRandomCardFromSet(
                $cardsBySet,
                $packSet,
                $cardRarity->uncommon
            );
            //Make Sure Duplicate Wasn't Chosen
            $duplicateCardInPack = checkPackForDuplicateCards(
                $boosterPack,
                $card
            );
        } while ($duplicateCardInPack === true);
        //Add Unique Card To Pack
        //This Does Not Check If Multiple Uncommons Are The Same Ink Type
        $boosterPack->addCardToBooster($card);
    }

    //Slot 10:
    $slot10Cards = [];
    //1 Rare Or Higher Rarity Card
    //rare_cards appear = 4 * # of Rares In Set				-> For Set 1 = 31
    //super_rare_cards appear = 3 * # of SuperRares In Set	-> For Set 1 = 17
    //legendary_cards appear = 1 * # of Legendaries In Set	-> For Set 1 = 12
    for ($i = 1; $i <= 5; $i++) {
        for (
            $j = 1;
            $j <=
            count(
                $cardsBySet->setsByRarity[$packSet]->rarities[$cardRarity->rare]
            );
            $j++
        ) {
            array_push($slot10Cards, $cardRarity->rare);
        }
    }
    for ($i = 1; $i <= 3; $i++) {
        for (
            $j = 1;
            $j <=
            count(
                $cardsBySet->setsByRarity[$packSet]->rarities[
                    $cardRarity->superRare
                ]
            );
            $j++
        ) {
            array_push($slot10Cards, $cardRarity->superRare);
        }
    }
    for (
        $j = 1;
        $j <=
        count(
            $cardsBySet->setsByRarity[$packSet]->rarities[
                $cardRarity->legendary
            ]
        );
        $j++
    ) {
        array_push($slot10Cards, $cardRarity->legendary);
    }
    //Shuffle The slot10Cards Array
    shuffle($slot10Cards);
    $slot10Rarity = $slot10Cards[0];
    $card = getRandomCardFromSet($cardsBySet, $packSet, $slot10Rarity);
    //Add Card To Pack
    $boosterPack->addCardToBooster($card);

    //Slot 11:
    //Pull A Card With Rarity = Slot 10 Or Higher
    switch ($slot10Rarity) {
        case "Rare":
            //Slot 10 Is A Rare So We Can Pull Rare, SuperRare Or Legendary...Same Pull Rate As Slot 10 Card
            //Shuffle The slot10Cards Array
            shuffle($slot10Cards);
            $slot11Rarity = $slot10Cards[0];
            break;
        case "Super Rare":
            //Slot 10 Is A Super Rare, Must Redo Slot Options
            $slot11Cards = [];
            //super_rare_cards appear 2 times in this slot
            //legendary_cards appear 1 time in this slot
            for ($i = 1; $i <= 2; $i++) {
                for (
                    $j = 1;
                    $j <=
                    count(
                        $cardsBySet->setsByRarity[$packSet]->rarities[
                            $cardRarity->superRare
                        ]
                    );
                    $j++
                ) {
                    array_push($slot11Cards, $cardRarity->superRare);
                }
            }
            for (
                $j = 1;
                $j <=
                count(
                    $cardsBySet->setsByRarity[$packSet]->rarities[
                        $cardRarity->legendary
                    ]
                );
                $j++
            ) {
                array_push($slot11Cards, $cardRarity->legendary);
            }

            //Shuffle The slot11Cards Array
            shuffle($slot11Cards);
            $slot11Rarity = $slot11Cards[0];
            break;
        case "Legendary":
            //Slot 10 Is A Legendary, Slot 11 Must Also Be
            $slot11Rarity = $cardRarity->legendary;
            break;
        default:
            echo "Cannot Determine Slot 10 Rarity";
            break;
    }
    //Get Unique Slot 11 Pack Card Without Rerolling Its Rarity
    do {
        $card = getRandomCardFromSet($cardsBySet, $packSet, $slot11Rarity);
        //Make Sure Duplicate Wasn't Chosen
        $duplicateCardInPack = checkPackForDuplicateCards($boosterPack, $card);
    } while ($duplicateCardInPack === true);

    //Add Unique Card To Pack
    $boosterPack->addCardToBooster($card);

    //Slot 12, Foil Card, Can Be Any Card So We Use setsAllCards Object Property (Instead Of Typically Pulling By Rarity)
    //Shuffle The Array
    shuffle($cardsBySet->setsAllCards[$packSet]);
    $card = $cardsBySet->setsAllCards[$packSet][0];
    $boosterPack->addCardToBooster($card);

    return $boosterPack;
}

function generateMultiplePacks($numPacksPerPlayer, $cardsBySet, $cardRarity, $packSeries, $packNum) {
    $allCards = [];

    // Loop through the total number of packs per player
    for ($i = 0; $i < $numPacksPerPlayer; $i++) {
        // Use the $packSeries array to determine the series for each pack
        $seriesIndex = $i % count($packSeries); // Adjusted to cycle through all elements in $packSeries
        $boosterPack = buildPackFromSet($cardsBySet, $cardRarity, $packSeries[$seriesIndex], $packNum + $i); // $packNum + $i to ensure unique pack numbers

        if (is_object($boosterPack) && isset($boosterPack->cardsInBooster)) {
            $allCards = array_merge($allCards, $boosterPack->cardsInBooster);
        }
    }

    return $allCards;
}

?>
