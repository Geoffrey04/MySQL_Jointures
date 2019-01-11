<?php
/**
 * Created by PhpStorm.
 * User: sstienface
 * Date: 04/12/2018
 * Time: 11:25
 */

// Premiere ligne




$servername = 'localhost' ;
$username = "root" ;
$password = '';
$dbname = "eleves_general";


// créer une nouvelle connexion :

$con = new mysqli($servername, $username, $password) ;

if($con -> connect_error) {

    die("Connection failed: " . $con->connect_error);


} else {

    $con -> select_db($dbname) ;

}


$dis = "select * from eleves_informations, eleves  where eleves_informations.eleves_id = eleves.id";

$connexion = $con -> query($dis) ;

while($row = $connexion-> fetch_assoc()) {

    echo "l'eleve n°" .' ' . $row['id'].' '. $row['prenom'] .' ' . $row['nom']. ' ' .
          'qui a '.' '. $row['age'].' '.'ans'.' '.'et qui utilise comme login'.' '.
           $row['login'] .' ' . 'et le mdp'.' '. $row['password'].'.'. 'Il/Elle habite à '.' '.$row['ville'].
           ' '. 'il utilise comme avatar :'.' '. $row['avatar'].'<br>';

}

echo '<br><br><br>' ;

$compet = "select * from eleves_competences, eleves , competences  where eleves_competences.eleves_id = eleves.id and eleves_competences.competences_id = competences.id";

$connexion = $con -> query($compet) ;

$string ="";
$sting = "";

while($row = $connexion-> fetch_assoc()) {

    $niveau = $row['niveau'] ;
    if($string!='')
    {
        $string.=",";
    }
    $string.= $niveau;
    global $niveau ;



    $auto = $row['niveau_ae'] ;

    if($sting !='')
    {
        $sting.=",";
    }
    $sting.= $auto ;
    global $auto ;




    echo "l'eleve" . ' ' . $row['prenom'] . ' ' .$row['nom'] .' '.'pour la compétence' . ' '. $row['titre'] . ' '. 'qui consiste à ' . ' '. $row['description']. ' '. 'à un niveau de' .' '. $row['niveau'].
        'et se donne en ae la note' . ' '.$row['niveau_ae'].'<br>';

}



?>




<!DOCTYPE html>
<html>
<head>
    <script src= "https://cdn.zingchart.com/zingchart.min.js"></script>
    <script> zingchart.MODULESDIR = "https://cdn.zingchart.com/modules/";
        ZC.LICENSE = ["569d52cefae586f634c54f86dc99e6a9","ee6b7db5b51705a13dc2339db3edaf6d"];</script></head>
<style>



    html, body {
        height:100%;
        width:100%;
    }
    #myChart {
        height:100%;
        width:100%;
        min-height:250px;
    }
    .zc-ref {
        display:none;
    }
    #legende{
        border : 1px solid black ;
        background-color: #6DA761;
    }
    #legend {
        border : 1px solid black ;
        background-color: #168EB8;
    }


</style>
<body>
<br><br>
<div>
    <span id="legend">Note de l'élève</span><br>
    <span id="legende">Note Auto-évaluation</span>
</div>
<div id='myChart'><a class="zc-ref" href="https://www.zingchart.com/">Powered by ZingChart</a></div>
<script>


    var myConfig = {
        type : 'radar',
        plot : {
            aspect : 'area',
            animation: {
                effect:3,
                sequence:1,
                speed:700
            }
        },
        scaleV : {
            visible : false
        },
        scaleK : {
            values : '0:3:0',
            labels : ['Jeux vidéo G','Sprint G', 'Jeux video Gal', 'Sprint Gal'],
            item : {
                fontColor : '#607D8B',
                backgroundColor : "white",
                borderColor : "#aeaeae",
                borderWidth : 1,
                padding : '5 10',
                borderRadius : 10
            },
            refLine : {
                lineColor : '#c10000'
            },
            tick : {
                lineColor : '#59869c',
                lineWidth : 2,
                lineStyle : 'dotted',
                size : 20
            },
            guide : {
                lineColor : "#607D8B",
                lineStyle : 'solid',
                alpha : 0.3,
                backgroundColor : "#c5c5c5 #718eb4"
            }
        },
        series : [
            {
                values : [<?= $string; ?>],
                text:'farm'
            },
            {
                values : [<?= $sting ; ?>],
                lineColor : '#53a534',
                backgroundColor : '#689F38'
            }
        ]
    };

    zingchart.render({
        id : 'myChart',
        data : myConfig,
        height: '100%',
        width: '100%'
    });


</script>
</body>


</html>





