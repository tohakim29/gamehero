
<?php
/////////////////////////////////
interface IBeing{
    public function getName();
    public function downXp($value);
    public function ISLive();
}
/////////////////////////////////
class Being implements IBeing{
    private $name;        //name
    private $hp;          //health points hp:100
    private $shield;      //shield 1
    
   
   
                                
  
    public function __construct($name, $hp, $shield){
        $this->name = $name;
        $this->hp = $hp;     
        $this->shield = $shield;  
           
    }

    public function hp(){
        if($this->hp  >  0){
               return $this->hp;
        }else{ 
               return $this->hp  = 0;
        }
    }
    public function ISLive(){
        return $this->hp > 0;
    }

    public function getName(){
        return $this->name;
       
    }
    //down health points after hit
    public function downXp($value){
        return $this->hp -= $value;      //hp =hp-value    ex: 2=100-98     
    }
   
  
    //////////////Shield//////////////////
    public function shield(){
        return $this->shield;
    }
   
    public function ISshield_active(){
        return $this->shield > 0;
    }
    //Using shield allows to up your Health points
    public function upXp($value){
        return $this->hp += $value;      //hp =hp+value    ex: 2=100-98     
    }
    //Using shield allows to reduce Health points of opponent
    public function use_shield($value){
        return $this->hp -= $value;
    }
    //inativates your shield, because you have only one shield
    public function down_use_shield($val_damage){
        return $this->shield -= $val_damage;
    }
   
    //////////////////////////////////
    
}





/////////////////////////////////
interface IBattle{
    public function addFighter(IBeing $being);
    public function selected();

}
/////////////////////////////////
class Battle implements IBattle{
    public $beings = [];                //array that may consits of many knights
    
   

    public function addFighter(IBeing $being){
        return $this->beings[] = $being;            //{ ["name":"Being":private]=> string(7) "Vitalik" ["hp":"Being":private]=> int(100) } 
    }


 

    

    //Selection Process from start to end
    public function selected(){
        $con = count($this->beings);   //number of fighters ex:4
        //echo 'Number of fighter in a round - </br>' .$con;
        if($con == 1){                 //if number of fighters is 1, yes i have won
            echo ' <div id="win"></br>!!!!!!!' . (array_pop($this->beings)->getName()).' - is a WINNER !!!!!</br></div>------------------</br>'; // we  delete the last element of an array
            return true;
        }else if($con==0){
            echo '<div id="win">!!!no winner!!!</div></br>------------------</br>';
            return true;   
        }
        
       
        
        
     
        //randoomly choose attacker
        $attacher_id = array_rand($this->beings);      // 0 (vitalik) or 1....N number of participats , give a key        
        $attaker   =  $this->beings[$attacher_id];     //random attacker object
        
        
   

        //randoomly choose looser
        do{
           $loser_id =  array_rand($this->beings);  // 0 
        }while($loser_id == $attacher_id);           //0 ==0        
        $loozer  =  $this->beings[$loser_id]; //another random unique object
     
        
        
        $this->fight($attaker,$loozer);   //repeats this method

       

    }
    

    //Fight function between attacker and looser
    private function fight($attaker,$loozer)    {
        echo " <div id='vs'>    " .$attaker->getName().' ('. $attaker->hp(). ')  vs   '. $loozer->getName() .' (' .$loozer->hp(). ') </div>   ';
        
        $hp=rand(1, 6);         //dice has 6; randomly choose looser health points       
        $loozer->downXp($hp);   //decreasing looser health points
       

        $hp1=rand(1, 6);         //dice has 6; randomly choose attacker health points       
        $attaker->downXp($hp1);

        echo $attaker->getName().'   hits -    '. $loozer->getName().' ( '. $loozer->getName().' losing '. $hp.'  points, remained '.$loozer->hp(). 'points)'."</br>";
        echo $loozer->getName().'    hits -    '. $attaker->getName().' ( '. $attaker->getName().' losing '. $hp1.' points, remained '.$attaker->hp(). ' points)'."</br>";

        if(!$loozer->ISshield_active() ){
                    echo $loozer->getName().' - You have already used shield!'."</br> ";
        }else{
                    $shield=rand(1,0);
                    $loozer->down_use_shield($shield);
                    if($shield == 1){
                        echo '<div id="message"> '.$loozer->getName().' - is using shield!<span id="shield"></span></div>'." ".$loozer->getName()." $hp life point restored   and damaged redirected to the opponent</br>";
                        $loozer->upXp($hp);
                        $attaker->downXp($hp);
                    }
        }        
        
        
        echo $loozer->getName()." health status ".$loozer->hp()." </br>";
        echo $attaker->getName()." health status ".$attaker->hp()." </br></br>";
       
       
       


        //If looser/attacker health points is 0 or less, we remove him from Array,from tournament
        if (!$loozer->ISLive()   ){
            unset($this->beings[ array_search($loozer,$this->beings)]);  //ex: $this->beings[3]
            sort($this->beings);
            echo $loozer->getName().' - is DEAD!'."</br></br>";
        }
        if (!$attaker->ISLive()   ){
            unset($this->beings[ array_search($attaker,$this->beings)]);  //ex: $this->beings[3]
            sort($this->beings);
            echo $attaker->getName().' - is DEAD!'."</br></br>";
        }


        //repeats this selected() method
        $this->selected(); 



    }

}




$attendant = $_SESSION['person']; //Your entered name for play


//first tournament 
//we could use of course objects from database, also
$being = new Being($attendant,100, 1); // 1 It is you!
$being1= new Being('Aleksandr',100, 1); // 2nd  Bot, health points, 1 shield
$being2= new Being('Pasha',100, 1);     // 3rd  Bot, health points, 1 shield 
$being3= new Being('Boris',100, 1);     // 4th  Bot, health points, 1 shield 
$being4= new Being('John',100, 1);      // 5th  Bot, health points, 1 shield 
//var_dump($being);

$battle = new Battle();
$battle->addFighter($being);
$battle->addFighter($being1);
$battle->addFighter($being2);
$battle->addFighter($being3);
$battle->addFighter($being4);
$battle->selected();




?> 

